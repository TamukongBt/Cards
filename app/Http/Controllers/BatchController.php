<?php

namespace App\Http\Controllers;
use App\Batch;
use App\User;


use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batch=Batch::all();
        return view('batch.index')->with('batch',$batch);
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
        $data = $this->validate ($request, [
            'start_acct' => 'required|string|max:50',
            'end_acct' => 'required|string|max:50',
            'batch_number' => 'required|string|max:50',
        ]);
        $batch->batch_number=$request->batch_number;
        $batch->done_by=auth()->user()->name;
        $batch->start_acct=$request->start_acct;
        $batch->end_acct=$request->end_acct;
        Batch::create($data);
        $batch->save();

         return redirect()->route('batch.index')->with('success','New Entry created succesfully');
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
            'batch_number' => 'required|string|max:50',
        ]);
        $batch->batch_number=$request->batch_number;
        $batch->done_by=auth()->user()->name;
        $batch->start_acct=$request->start_acct;
        $batch->end_acct=$request->end_acct;
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
        return redirect('batch.index')->with('success', 'Batch Number has been deleted!!');
    }
}
