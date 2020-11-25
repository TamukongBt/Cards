<?php

namespace App\Http\Controllers;

Use Illuminate\Pagination\LengthAwarePaginator;
use DataTables;
use Carbon\Carbon;
use App\Cards;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards=Cards::all();
        return view('cards.index')->with('cards',$cards);
    }

    public function index1()
    {
        $data=Cards::all();
        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('cards.destroy',$row->id). '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                         style="color: black"></i></button>

                 </td>
             ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Cards  $Cards
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate ( [
            'name' => 'required',
            'card_type'=>'required'
        ]);
       Cards::create($data);
         return redirect()->route('cards.index')->with('success','New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cards= Cards::findbyId($id);
        return view('cards.show')->with('cards', $cards);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cards= Cards::find($id);
        return view('cards.edit', compact('cards','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Cards  $Cards
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $this->validate ($request, [


            'cards' => 'required|string|max:50',

        ]);
        Cards::whereId($id)->update($data);
        return redirect('cards.index')->with('success', 'Updated!!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cards = Cards::findorFail($id);
        Cards::whereId($cards['id'])->delete();
        return response(200);
    }
}
