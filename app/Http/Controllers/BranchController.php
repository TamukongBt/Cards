<?php

namespace App\Http\Controllers;

Use Illuminate\Pagination\LengthAwarePaginator;
use App\Branch;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch=Branch::all();
        return view('pages.branch')->with('branch',$branch);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $req= new Branch();
        $data = $this->validate ($request, [
        
            
            'name' => 'required|string|max:50',
          
            
        ]);
        $req = Branch::create($data);
         return redirect()->route('branch.index')->with('success','New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch= Branch::findbyId($id);
        return view('pages.reqview')->with('branch', $branch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch= Branch::find($id);
        return view('branch.edit', compact('branch','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Branch  $Branch
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Branch $request, $id)
    {
       
        $data = $this->validate ($request, [
        
            
            'branch' => 'required|string|max:50',
            
        ]);
        Branch::whereId($id)->update($data);
        return redirect('pages.reqview')->with('success', 'Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::findorFail($id);
        Branch::whereId($branch['id'])->delete();
        return redirect('pages.branch')->with('success', 'Branch has been deleted!!');  
    }
}
