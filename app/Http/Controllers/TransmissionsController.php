<?php

namespace App\Http\Controllers;

use App\Transmissions;
use App\Imports\TransmissionsImport;
use App\Notifications\CardCollected;
use App\Exports\CollectedExports;
use DataTables;
use App\Downloads;
use App\Imports\CardRequestImports;
use App\Mail\Cardmail;
use Carbon\Carbon;
use App\Upload;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;
use RealRashid\SweetAlert\Facades\Alert;

class TransmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transmissions.index');
    }

    public function index1()
    {
        if (auth()->user()->department == 'cards') {
            $data=Transmissions::where('collected', null)->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
            })
            ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('transmissions.destroy',$row->id). '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                style="color: black"></i></button>

                </td>
                ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        elseif (auth()->user()->department == 'csa'||auth()->user()->department == 'css') {
            $data = Transmissions::where('collected', null)->where('branchcode',auth()->user()->branch->name )->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
               <td> <a class="denies btn btn-outline-warning btn-sm"
                    data-remote="/transmissions/collected/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-check-2"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }

        elseif(auth()->user()->department == 'dso'){
            $data = Transmissions::where('collected', null)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
               ->addColumn('age', function ($item) {
                  return $item->created_at > now()->subMonth(3)? 10: 100;
                   })
                ->make(true);

        }

        }

        public function pinindex()
    {
        if (auth()->user()->department == 'css'||auth()->user()->department == 'cards') {
            return view('transmissions.pinindex');
        }
        else  if (auth()->user()->department == 'dso') {
            return view('transmissions.pinindex');
        }
        else{
            Alert::alert('Restriction', 'You do not have access to that page', 'error');
            return view('pages/dashboard');
        }

    }

    public function pinindex1()
    {
        if (auth()->user()->department == 'cards') {
            $data=Transmissions::where('collected', 1)->where('pin_collected', 0);
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
            })
            ->addColumn('action', function ($row) {

                $actionBtn =

                '<td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="'.route('transmissions.destroy',$row->id). '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                style="color: black"></i></button>

                </td>
                ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        elseif (auth()->user()->department == 'css'||auth()->user()->department == 'dso') {
            $data = Transmissions::where('collected', 1)->where('pin_collected', 0)->where('branchcode',auth()->user()->branch->name )->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })



                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
               <td> <a class="denies btn btn-outline-warning btn-sm"
                    data-remote="/transmissions/collectpin/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-check-2"
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
            return view('transmissions.collected');
        }


        public function collected1()
        {
            if (auth()->user()->department == 'cards') {
                $data = Transmissions::where('collected', '1')->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('collected_at', function ($data) {
                    return $data->collected_at ? with(new Carbon($data->collected_at))->format('m/d/Y') : '';
                })

                    ->make(true);
                }
            else{
                $data = Transmissions::where('collected', '1')->where('branchcode',auth()->user()->branch->name )->get();
                return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->collected_at ? with(new Carbon($data->collected_at))->format('m/d/Y') : '';
                })
                        ->make(true);
                    }
                }

          // Fetch validated data
          public function pin()
          {
              return view('transmissions.pincollected');
          }


          public function pin1()
          {

              if (auth()->user()->department == 'cards') {
                  $data = Transmissions::where('pin_collected', '1')->get();
                  return DataTables::of($data)
                  ->addIndexColumn()
                  ->editColumn('collected_at', function ($data) {
                    return $data->collected_at ? with(new Carbon($data->collected_at))->format('m/d/Y') : '';
                })
                      ->make(true);
                  }
              else{
                  $data = Transmissions::where('pin_collected', '1')->where('branchcode',auth()->user()->branch->name )->get();
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
        return view('transmissions.create');
    }

    public function alerts(){
        $transmissions = Transmissions::where('notified',0)->get;

        foreach($transmissions as $transmission) {
            // Nexmo::message()->send([
            //     'to'   => $transmission->phone_number,
            //     'from' => 'UBC. Plc',
            //     'text' => 'Dear customer your card is now available at the '.$transmission->branchcode.''
            // ]);
            Mail::to($transmission->email)->send(new Cardmail($transmission));

           $transmission->notified=1;
           $transmission->notified_on=now();
           $transmission->save();}
            return $transmissions;
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
        $title = "Cards Transmissions of " . now()->format('d-m-Y');
        // Save details on the user who dowloaded
        $doneby = new Upload();
        $doneby->user = auth()->user()->name;
        $doneby->title=$title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        $path1 = $request->file('file')->store('assets');
        $path=storage_path('app').'/'.$path1;



        Excel::import(new CardRequestImports , $path);

    return redirect()->route('transmissions.index')->with( 'success','New Entries added');
        try {

        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with the file', 'error');
            return redirect()->route('transmissions.create');
        }




    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Transmissions  $transmissions
     * @return \Illuminate\Http\Response
     */
    public function show(Transmissions $transmissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transmissions  $transmissions
     * @return \Illuminate\Http\Response
     */
    public function edit(Transmissions $transmissions)
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
        $transmissions = Transmissions::findorFail($id);
        Transmissions::whereId($transmissions['id'])->delete();
        return response(200);
    }

    // this function validates when the request has been confirmed by cards and checks
    public function collect(Request $request,$id)
    {

        $transmissions = Transmissions::findorFail($id);
        $transmissions->collected= 1;
        $transmissions->collected_at = now();
        $transmissions->collected_by=$request->collected_by;
        $transmissions->save();
        $css = User::where('department','css')->where('branch_id',auth()->user()->branch->branch_code)->get();
        foreach ($css as $cs) {
            $cs->notify(new CardCollected($transmissions));
        }
        return response()->json(200);
    }

    public function collectpin(Request $request,$id)
    {
        $req = Transmissions::findorFail($id);
        $req->pin_collected= 1;
        $req->collected_at = now();
        $req->NIC_number=$request->NIC_number;
        $req->save();
        return response()->json(200);
    }

    public function count()
    {
        $data = Transmissions::where('collected', 1)->count();
        return response($data, 200);
    }

    public function overdue()
    {
        $data = Transmissions::where('collected', 1)->where('created_at','>',now()->addMonths(3))->count();
        return response($data, 200);
    }




    // Download list of collected cards
    public function exportcollected(Request $request)
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

            return (new CollectedExports($startdate, $enddate))->download($title . '.csv');
         }

         // Fetch validated data
        public function notify()
        {
            return view('transmissions.collected');
        }


}
