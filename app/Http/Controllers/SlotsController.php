<?php

namespace App\Http\Controllers;

use App\Slots;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\SlotNotify;
use App\User;

class SlotsController extends Controller
{
    public function index()
    {
        return view('slots.index');
    }


    public function index1()
    {
        if (auth()->user()->department == 'it') {
            $data = Slots::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '
         <td><a class="validates btn btn-outline-primary btn-sm"
         data-remote="/slots/confirm/' . $row->id . '"><i class="nc-icon nc-check-2"
             aria-hidden="true" style="color: black"></i></a></td>
        <td><a class="denies btn btn-outline-warning btn-sm"
        data-remote="/slots/reject/' . $row->id . '"><i class="nc-icon nc-simple-remove"
            aria-hidden="true" style="color: black"></i></a>
        <button  id="deletebutton" class="btn btn-outline-danger btn-sm btn-delete" data-remote="' . route('slots.destroy', $row->id) . '"> <i class="fa fa-trash" aria-hidden="true"></i></button>
            </td>


     ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        elseif (auth()->user()->department == 'cards') {
            $data = Slots::where('validated', 1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '<td class=" "><i class="nc-icon nc-check-2 alert-success btn-outline-success" aria-hidden="true" style="color: limegreen;" ></i></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slots = new Slots();
        $data = $this->validate($request, [
            'gold' => 'required|string|max:50',
            'silver' => 'required|string|max:50',
            'sapphire' => 'required|string|max:50',
        ]);
        $slots->done_by = auth()->user()->name;
        $slots->gold = $request->gold;
        $slots->silver = $request->gold;
        $slots->sapphire = $request->sapphire;
        $slots->validated = 0;
        $slots->rejected = 0;
        $slots->save();
        $users = User::where('department', 'it')->get();
        foreach ($users as $user) {
            $user->notify(new SlotNotify($slots));
        }
        return redirect()->route('slots.index')->with('success','New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slots = Slots::find($id);
        return view('pages.reqview')->with('slots', $slots);
    }

    // dashboard Count display for slots data
    public function slotso()
    {
        $data = Slots::where('validated',1)->count();


        // return $data;
        return response($data,200);
    }
    public function slotsed()
    {
        $data = Slots::get()->last();
        $gold=$data->gold;
        $silver=$data->silver;
        $sapphire=$data->sapphire;
        $count=$gold+$sapphire+$silver;
        // return $data;
        return response($count,200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slots = Slots::find($id);
        return view('slots.edit', compact('slots', 'id'));
    }

     // this function validates when the request has been confirmed by cards and checks
     public function fulfilled($id)
     {
         $req = Slots::findorFail($id);
         $req->validated = 1;
         $req->updated_at=now();
         $req->save();
         return response()->json(200);
     }

      // this function validates when the request has been rejected by cards and checks
      public function denied($id)
      {
          $req = Slots::findorFail($id);
          $req->rejected= 1;
          $req->updated_at=now();
          $req->save();
          return response()->json(200);
      }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slots = new Slots();
        $data = $this->validate($request, [
            'gold' => 'required|exists:requesteds|string|max:50',
            'silver' => 'required|exists:requesteds|string|max:50',
            'sapphire' => 'required|exists:requesteds|string|max:50',
        ]);
        $description = $request->gold . ' Gold.' . $request->silver . ' Silver.' . $request->sapphire . ' Sapphire';
        $slots->done_by = auth()->user()->name;
        $slots->description = $description;
        slots::whereId($id)->update($data);
        $slots->save();
        return redirect()->route('slots.index')->with('success','New Entry created succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slots = Slots::findorFail($id);
        Slots::whereId($slots['id'])->delete();
        return response(200);
    }
}
