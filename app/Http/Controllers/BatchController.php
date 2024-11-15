<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Notifications\BatchNotify;
use App\User;
use App\Requested;
use DataTables;
use Carbon\Carbon;
use Illuminate\Validation\Rule;



use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('batch.index');
    }

    public function index1()
    {
        if (auth()->user()->department == 'it') {
            $data=Batch::all();
        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>

                <a href="'.route('batch.view',$row->id).'" class="edit btn btn-info btn-sm ">View Accounts</i></a>


                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('batch.destroy',$row->id). '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                         style="color: black"></i></button>

                 </td>
             ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif(auth()->user()->department == 'cards') {
            $data=Batch::all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($data) {
                        return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                    })
                    ->addColumn('action', function ($row) {

                    $actionBtn =

                    '<td>


                    <a href="'.route('batch.view',$row->id).'" class="edit btn btn-info btn-sm ">View Accounts</i></a>




                     </td>
                 ';
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
        return view('batch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $batch= new Batch();


       $start=Requested::where('account_number',$request->start_acct)->where('request_type','new_card')->where('cards',$request->start_cards)->where('confirmed',1)->where('rejected',0)->latest()->first();
       $end=Requested::where('account_number',$request->end_acct)->where('request_type','new_card') ->where('cards',$request->end_cards)->where('confirmed',1)->where('rejected',0)->latest()->first();

       $reqstart=$start->id;
   $reqend=$end->id;
   $batchnumber = 'N'.$reqstart.$reqend.now()->format('mdY');
   $batch->batch_number=$batchnumber;
   $batch->done_by=auth()->user()->name;
   $batch->start_acct=$request->start_acct;
   $batch->end_acct=$request->end_acct;
   $batch->start_id=$reqstart;
   $batch->end_id=$reqend;
   $batch->save();
   $user= User::where('department','cards')->get();

   foreach ($user as $card) {
       $card->notify(new BatchNotify($batch));
   }
       try {

         return redirect()->route('batch.index')->with('success','New Entry created succesfully');


    } catch (\Throwable $th) {
        Alert::alert('Error', 'The accounts doesnt exist in the system', 'error');
           return  view('batch.create');
        };
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch= Batch::find($id);
        return view('pages.reqview')->with('batch', $batch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $batch= Batch::find($id);
        return view('batch.edit', compact('batch','id'));
    }

     // dashboard Count display for slots data
     public function batch1()
     {
         try {
            $data = Batch::get()->last()->value('batch_number');
         } catch (\Throwable $th) {
            return response("None Available",200);}

         return response($data,200);
         // return $data;

     }

     public function view($id)
    {
        $batch=Batch::find($id);
        $accounts=Requested::whereBetween('id',[$batch->start_id,$batch->end_id])->where('request_type','new_card')->where('confirmed',1)->get();
        return view('batch.view')->with('accounts', $accounts);
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
        $batch= new Batch();
        $data = $this->validate ($request, [
            'start_acct' => 'required|string|max:50',
            'end_acct' => 'required|string|max:50',
        ]);
        $start=Requested::where('account_number',$request->start_acct)->where('cards',$request->start_cards)->where('confirmed',1)->where('rejected',0)->latest()->first();
        $end=Requested::where('account_number',$request->end_acct)->where('cards',$request->end_cards)->where('confirmed',1)->where('rejected',0)->latest()->first();
        $reqstart=$start->account_number;
        $reqend=$end->account_number;
        $batchnumber = 'N'.substr($reqstart, 0, 2).substr($reqend, 0, 2).now()->format('mdY');
        $description= $request->gold.' Gold.'.$request->silver.' Silver.'.$request->sapphire.' Sapphire';
        $batch->batch_number=$batchnumber;
        $batch->done_by=auth()->user()->name;
        $batch->start_acct=$request->start_acct;
        $batch->end_acct=$request->end_acct;
        $batch->description=$description;
        Batch::whereId($id)->update($data);
        $batch->save();
         return redirect()->route('batch.index')->with('success','New Entry created succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch = Batch::findorFail($id);
        Batch::whereId($batch['id'])->delete();
        return response(200);
    }

    public function selectSearch(Request $request)
    {
    	$query = [];

        if($request->has('q')){
            $search = $request->q;
            $query =Requested::selectRaw('account_number, accountname, cards, DATE_FORMAT(created_at, "%M %d %Y") as date')->where('account_number', 'LIKE', "%$search%")
            		->where('confirmed',1)->where('request_type','new_card')->get();
        }
        return response()->json($query);
    }
}
