<?php

namespace App\Http\Controllers;

Use Illuminate\Pagination\LengthAwarePaginator;
use DataTables;
use Carbon\Carbon;
use App\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('branch.index');
    }

    public function index1()
    {
        $data=Branch::all();
        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('branch.destroy',$row->id). '">
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
        return view('branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate ([
            'name' => 'required',
            'branch_code' => 'required',
        ]);
       
        Branch::create($data);
         return redirect()->route('branch.index')->with('success','New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Branch  $Branch
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate( [
            'name' => 'required',
            'branch_code' => 'required',
        ]);
        Branch::whereId($id)->update($data);
        return redirect('branch.index')->with('success', 'Updated!!');
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
        return response(200);
    }
}
