<?php

namespace App\Http\Controllers;

use App\Requested;
use Illuminate\Http\Request;
use App\Exports\RequestExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;
use Yajra\DataTables\Services\DataTable;
use App\Downloads;
use App\Exports\RequestExports;
use DataTables;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;

class RequestedController extends Controller
{
    /**
     * Display a listing of the request
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $request = Requested::all();
        return view('request.index')->with('request', $request);
    }
    public function index1()
    {
        if (auth()->user()->department == 'css') {
            $data = Requested::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>
                <a href="'.route('request.edit',$row->id).'" class="edit btn btn-info btn-sm "><i class="nc-icon nc-alert-circle-i"></i></a>


                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('request.destroy',$row->id). '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                         style="color: black"></i></button>

                 </td>
             ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        elseif (auth()->user()->department == 'cards') {
            $data = Requested::where('confirmed',0)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                 $actionBtn =
                '
                <td><a class="validates btn btn-outline-primary btn-sm"
                     data-remote="/request/confirm/' . $row->id . '"><i class="nc-icon nc-check-2"
                         aria-hidden="true" style="color: black"></i></a></td>
                <td><a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/request/reject/' . $row->id . '"><i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);

        }
        elseif (auth()->user()->department == 'it') {
            $data = Requested::where('confirmed',1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                   '<td class=" "><i class="nc-icon nc-check-2 alert-success btn-outline-success" aria-hidden="true" style="color: red;" ></i></td>  ';
                       return $actionBtn;
                   })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);

        }

    }


    public function validated(){
        return view('request.validated');
    }

    public function validated1()
    {
        $data = Requested::where('confirmed', '1')->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                   '<td class=" "><i class="nc-icon nc-check-2 alert-success btn-outline-success" aria-hidden="true" style="color: limegreen;" ></i></td>  ';
                       return $actionBtn;
                   })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }

    public function rejected(){
        return view('request.rejected');
    }

    public function rejected1()
    {
        $data = Requested::where('rejected', '1')->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                   '<td class=" "><i class="nc-icon nc-remove-2 alert-success btn-outline-danger" aria-hidden="true" style="color: red;" ></i></td>  ';
                       return $actionBtn;
                   })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
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

        $data = $request->validate([

            'account_type' => 'required|string',
            'branch_id' => 'required',
            'cards' => 'required',
            'account_number' => 'required|max:15',
            'account_name' => 'required|string',
            'request_type' => 'required|string',
            'requested_by' => 'required',
            'done_by' => 'required'

        ]);

        Requested::create($data);
        return redirect()->route('request.index')->with('success', 'New Entry created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $request = Requested::find($id);
    //     return view('request.view')->with('request', $request);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = Requested::find($id);
        return view('request.edit', compact('request', 'id'));
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

        $data = $request->validate([

            'account_type' => 'required|string',
            'branch_id' => 'required',
            'cards' => 'required',
            'account_number' => 'required|max:15',
            'account_name' => 'required|string',
            'request_type' => 'required|string',
            'requested_by' => 'required',
            'done_by' => 'required'

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
        return response(200);
    }

    // this function validates when the request has been confirmed by cards and checks
    public function fulfilled($id)
    {
        $req = Requested::findorFail($id);
        $req->confirmed = 1;
        $req->updated_at=now();
        $req->save();
        return response()->json(200);
    }

     // this function validates when the request has been rejected by cards and checks
     public function denied($id)
     {
         $req = Requested::findorFail($id);
         $req->rejected= 1;
         $req->updated_at=now();
         $req->save();
         return response()->json(200);
     }

    // these are the sorting functions that sort the data by date branch and by week

    public function week()
    {
        $data = Requested::get()->wherebetween('created_at', [
            now()->locale('en')->startOfWeek(),
            now()->locale('en')->endOfWeek(),
        ]);
        // return $data;
        return redirect()->route('export', [$data]);
    }




    public function export(Request $request)
    {
        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title="New Cards from ". $startdate." - ".$enddate;
        return (new RequestExports($startdate,$enddate))->download($title.'.xls');
    }
}
