<?php

namespace App\Http\Controllers;

Use Illuminate\Pagination\LengthAwarePaginator;
use App\Request;


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
    
}
