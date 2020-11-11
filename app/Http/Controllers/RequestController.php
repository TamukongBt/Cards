<?php

namespace App\Http\Controllers;

Use Illuminate\Pagination\LengthAwarePaginator;
use App\Request;
use Carbon\Carbon;


class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request=Request::all();
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
        $req= new Request();
        $data = $this->validate ($request, [
        
            'account_type' => 'required|string',
            'employee_id' => 'required|string|max:50',
            'branch_id' => 'required',
            'number' =>'required|max:10',
            'request_type'=>'required'
        ]);
        $req = Request::create($data);
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
        $request= Request::find($id);
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
        $request= Request::find($id);
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
       
        $data = $this->validate ($request, [
        
            'account_type' => 'required|string',
            'employee_id' => 'required|string|max:50',
            'branch_id' => 'required',
            'number' =>'required|max:10',
            'request_type'=>'required'
        ]);
        Request::whereId($id)->update($data);
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
        $req = Request::findorFail($id);
        Request::whereId($req['id'])->delete();
        return redirect('/request')->with('success', 'Request has been deleted!!');  
    }

    public function fulfilled($id){
        $req=Request::findorFail($id);
        $req->confirmed=$id;    
         return response()->json( 200, $headers);
    }

    public function week(){
        $data=Request::get()->wherebetween('created_at',[
            now()->locale('en')->startOfWeek(),
            now()->locale('en')->endOfWeek(),]
        );
        // return $data;
        return redirect()->route('export', [$data]);
    }

    public function fordate(Request $request){
        $startdate=$request->startdate;
        $enddate=$request->enddate;
        $data=Request::get()->wherebetween('created_at',[$startdate,$enddate]);
        return response()->json($data, 200, $headers);
    }

    public function sortbranch($branch){
        $data=Request::select()->where('branch',$branch)->get();
        return response()->json($data, 200, $headers);
    }

    public function export($data) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=summary.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
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
