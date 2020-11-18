<?php

namespace App\Http\Controllers;

use App\Requested;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Downloads;
use Carbon\Carbon;

class RequestedController extends Controller
{
    /**
     * Display a listing of the request
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $request=Requested::all();
        return view('request.index')->with('request',$request);
    }

    public function validated()
    {
        $request=Requested::where('confirmed','1')->get();
        return view('request.index')->with('request',$request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data= $request->validate( [

            'account_type' => 'required|string',
            'branch_id' => 'required',
            'cards'=>'required',
            'account_number' =>'required|max:15',
            'account_name' =>'required|string',
            'request_type'=>'required|string',
            'requested_by'=>'required',
            'done_by'=>'required'

        ]);

        Requested::create($data);
        return redirect()->route('request.index')->with('success','New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request= Requested::find($id);
        return view('request.view')->with('request', $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request= Requested::find($id);
        return view('request.edit', compact('request','id'));
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

        $data= $request->validate( [

            'account_type' => 'required|string',
            'branch_id' => 'required',
            'cards'=>'required',
            'account_number' =>'required|max:15',
            'account_name' =>'required|string',
            'request_type'=>'required|string',
            'requested_by'=>'required',
            'done_by'=>'required'

        ]);
        try {
            Requested::whereId($id)->update($data);
        } catch (\Throwable $th) {
            return redirect('/create');

        }

        return redirect('/request')->with('success', 'Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $req = Requested::findorFail($id);
        Requested::whereId($req['id'])->delete();
        return redirect('/request')->with('success', 'Request has been deleted!!');
    }

    // this function validates when the request has been confirmed by cards and checks
    public function fulfilled($id){
        $req=Requested::findorFail($id);
        $req->confirmed=$id;
         return response()->json( 200);
    }

    // these are the sorting functions that sort the data by date branch and by week

    public function week(){
        $data=Requested::get()->wherebetween('created_at',[
            now()->locale('en')->startOfWeek(),
            now()->locale('en')->endOfWeek(),]
        );
        // return $data;
        return redirect()->route('export', [$data]);
    }

    public function fordate(Request $request){
        $startdate=$request->startdate;
        $enddate=$request->enddate;
        $data=Requested::get()->wherebetween('created_at',[$startdate,$enddate]);
        return response()->json($data, 200);
    }

    public function sortbranch($branch){
        $data=Requested::select()->where('branch',$branch)->get();
        return response()->json($data, 200);
    }



    public function export( Request $request) {
        // Save details on the user who dowloaded
         $doneby=new Downloads();
        $doneby->user=auth()->user()->name;
        $doneby->employee_id=auth()->user()->employee_id;
        $doneby->save();


        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename='.'$request->startdate'.'to'.'$request->startdate'",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
         $startdate=$request->startdate;
        $enddate=$request->enddate;
        $data=Requested::get()->wherebetween('created_at',[$startdate,$enddate])->where('confirmed','1');
        $columns = array('Period', 'RevenueArea', 'Subs');

        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($data as $items) {
                fputcsv($file, array($items->PERIOD, $items->REVENUE_AREA, $items->SUBS));

            }
            fclose($file);
        };
    return Response::stream($callback, 200, $headers)->send();
    }

}
