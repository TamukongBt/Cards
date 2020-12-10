<?php

namespace App\Http\Controllers;

use App\ChequeTransmissions;
use App\Imports\ChequeTransmissionsImport;
use App\Exports\CollectedCExports;
use DataTables;
use App\Downloads;
use Carbon\Carbon;
use App\Upload;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ChequeTransmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cheque.index');
    }

    public function index1()
    {
        if (auth()->user()->department == 'cards') {
            $data=ChequeTransmissions::all();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
            })
            ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('cheque.destroy',$row->id). '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                style="color: black"></i></button>

                </td>
                ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        elseif (auth()->user()->department == 'css') {
            $data = ChequeTransmissions::where('collected', null)->where('branchcode',auth()->user()->branch->name )->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })



                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
               <td> <a class="denies btn btn-outline-warning btn-sm"
                    data-remote="/cheque/collected/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-check-2"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }

        }




        // Fetch validated data
        public function collected()
        {
            return view('cheque.collected');
        }

        public function collected1()
        {
            if (auth()->user()->department == 'cards') {
                $data = ChequeTransmissions::where('collected', '1')->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->collected_at ? with(new Carbon($data->collected_at))->format('m/d/Y') : '';
                })

                    ->make(true);
                }
            else{
                $data = ChequeTransmissions::where('collected', '1')->where('branchcode',auth()->user()->branch->name )->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->collected_at ? with(new Carbon($data->collected_at))->format('m/d/Y') : '';
                })
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
        return view('cheque.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|max:2048',
        ]);
        $title = "Cheques Transmissions of " . now()->format('d-m-Y');
        // Save details on the user who dowloaded
        $doneby = new Upload();
        $doneby->user = auth()->user()->name;
        $doneby->title=$title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        $path1 = $request->file('file')->store('assets');
        $path=storage_path('app').'/'.$path1;

        Excel::import(new ChequeTransmissionsImport, $path);
        return redirect()->route('cheque.index')->with( 'success','New Entries added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transmissions  $transmissions
     * @return \Illuminate\Http\Response
     */
    public function show(ChequeTransmissions $transmissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transmissions  $transmissions
     * @return \Illuminate\Http\Response
     */
    public function edit(ChequeTransmissions $transmissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transmissions  $transmissions
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transmissions  $transmissions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transmission = ChequeTransmissions::findorFail($id);
        ChequeTransmissions::whereId($transmission['id'])->delete();
        return response(200);
    }

    // this function validates when the request has been confirmed by cards and checks
    public function collect(Request $request,$id)
    {
        $req = ChequeTransmissions::findorFail($id);
        $req->collected= 1;
        $req->collected_at = now();
        $req->collected_by=$request->collected_by;
        $req->save();
        return response()->json(200);
    }


    // Download list of collected cards
    public function exportccollected(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "Collected Cards from " . $startdate . " to " . $enddate;

         // Save details on the user who dowloaded
         $doneby = new Downloads();
         $doneby->user = auth()->user()->name;
         $doneby->title=$title;
         $doneby->employee_id = auth()->user()->employee_id;
         $doneby->save();

         ob_end_clean();
         ob_start();

            return (new CollectedCExports($startdate, $enddate))->download($title . '.csv');
         }



}
