<?php

namespace App\Http\Controllers;

use App\CardRequest;
use App\CheckRequest;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\RejectRequest;
use App\Notifications\RequestNotification;
use App\Downloads;
use App\Exports\RequestExports;
use App\Exports\RejectedExports;
use App\Exports\RenewalsExport;
use App\Exports\SubscriptionExports;
use App\Imports\CardRequestImports;
use App\Imports\CardSRequestImports;
use App\Mail\Cardmail;
use App\Notifications\CardCollected;
use App\Notifications\NewRequestCNotification;
use App\Upload;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CardRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Creation and continuation section

    public function index()
    {
        $request = CardRequest::all();
        return view('cardrequest.index')->with('request', $request);
    }
    public function index1()
    {

        if (auth()->user()->department == 'branchadmin') {
            $data = CardRequest::where('approved', 0)->where('branch_id', auth()->user()->branch_id)->get();

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
                        <div class="dropdown dropleft ">
                            <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">

                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                            <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                                <a class="dropdown-item  btn-delete" data-remote="/cardrequest/reject/' . $row->id . '">
                                Rejects </a>
                                <a class="validates dropdown-item "
                                data-remote="request/approve/' . $row->id . '">Approves</a>
                                <a class="track dropdown-item "  data-remote="card/track/' . $row->id . '">Track Account</a>
                            </div>
                        </div>



                 </td>
             ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'cards') {
            $data = CardRequest::where('confirmed', 0)->where('rejected', 0)->where('approved', 1)->get();

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
                     data-remote="/cardrequest/confirm/' . $row->id . '">Approve<i class="nc-icon nc-check-2"
                         aria-hidden="true" style="color: black"></i></a></td>
                <a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/cardrequest/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject">Reject<i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa') {
            $data = CardRequest::where('approved', 0)->where('rejected', 0)->where('confirmed', 0)->where('branch_id', auth()->user()->branch_id)->get();

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

                        $actionBtn =
                        '<td>

                        <div class="dropdown dropleft ">
                        <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                        <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                            <a class="dropdown-item btn btn-info text-white" href="' . route('cardrequest.edit', $row->id) . '">
                           Edit </a>
                            <a class="dropdown-item btn btn-danger btn-delete  text-white" data-remote="' . route('cardrequest.destroy', $row->id) . '">
                               Delete </a>
                            <a class="track dropdown-item "  data-remote="card/track/' . $row->id . '">Track Account</a>
                        </div>


          </td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CardRequest::where('confirmed', 1)->where('request_type', 'renew_card')->get();
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
                ->make(true);
        }
    }

    public function validated()
    {
        return view('cardrequest.validated');
    }

    public function validated1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('confirmed', '1')->where('approved', '1')->get();
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
        } else {
            $data = CardRequest::where('confirmed', '1')->where('approved', '1')->where('branch_id', auth()->user()->branch_id)->get();
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
    }

    public function rejected()
    {
        return view('cardrequest.rejected');
    }

    public function rejected1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('rejected', '1')->get();
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
                ->make(true);
        } else {
            $data = CardRequest::where('rejected', '1')->where('branch_id', auth()->user()->branch_id)->get();
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
        return view('cardrequest.create');
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

            'account_type' => 'required',
            'branch_id' => 'required',
            'cards' => 'required',
            'account_number' => 'required',
            'branchcode' => 'required',
            'bankcode' => 'required',
            'RIB' => 'required',
            'accountname' => 'required',
            'request_type' => 'required',
            'requested_by' => 'required',
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'

        ]);
        CardRequest::create($data);
        $users = User::where('branch_id', $request->branch_id)->where('department', 'branchadmin')->get();
        $request = CardRequest::where('accountname', $request->accountname)->where('account_number', $request->account_number)->where('branch_id', $request->branch_id)->where('cards', $request->cards)->get()->first();

        foreach ($users as $user) {
            $user->notify(new RequestNotification($request));
        }
        return redirect()->route('cardrequest.index')->with('success', 'New Entry created succesfully');
        try {
        } catch (\Illuminate\Database\QueryException $th) {
            $errorCode = $th->errorInfo[1] ;
            if($errorCode == '1062'){
                Alert::alert('Error', 'This Entry Already Exist In the system ', 'error');
            return redirect()->route('cardrequest.create');
            }else{
            Alert::alert('Error', 'There is a problem with this entry ', 'error');
            return redirect()->route('cardrequest.create');
        }}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = CardRequest::find($id);
        return view('cardrequest.edit', compact('request', 'id'));
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

            'account_type' => 'required',
            'branch_id' => 'required',
            'cards' => 'required',
            'account_number' => 'required',
            'branchcode' => 'required',
            'bankcode' => 'required',
            'RIB' => 'required',
            'accountname' => 'required',
            'request_type' => 'required',
            'requested_by' => 'required',
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'

        ]);
        try {
            $req = CardRequest::findorFail($id);
            $req->rejected = 0;
            $req->save();
            CardRequest::whereId($id)->update($data);
        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with this entry ', 'error');
            return redirect('/create');
        }

        return redirect('/cardrequest')->with('success', 'Request Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $req = CardRequest::findorFail($id);
        CardRequest::whereId($req['id'])->delete();
        return response(200);
    }


    // Non Functional small small things

    // this function validates when the request has been confirmed by cards and checks
    public function fulfilled($id)
    {
        $req = CardRequest::findorFail($id);
        $req->confirmed = 1;
        if ($req->request_type == 'new_card' || $req->request_type == 'renew_card') {
            $req->in_production = 1;
        }

        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }
    // this function validates when the request has been confirmed by csa
    public function approved($id)
    {
        $req = CardRequest::findorFail($id);
        $req->approved = 1;
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }

    public function track($id)
    {
        $req = CardRequest::findorFail($id);
        if ($req->approved == 1 && $req->confirmed == 1 && $req->rejected == 0 && $req->in_production == 1 && $req->distrubuted==0) {
            $state = 'In The Production File';
            return response()->json($state);
        }
        if ($req->approved == 1 && $req->confirmed == 1 && $req->rejected == 0 && $req->in_production == 0 && ($req->request_type != 'new_card' || $req->request_type != 'renew_card') ) {
            $state = 'Your Request Has Been Completed';
            return response()->json($state);
        } else  if ($req->approved == 0 && $req->confirmed == 0 && $req->rejected == 0) {
            $state = 'Pending Approval From Branch';
            return response()->json($state);
        } else  if ($req->approved == 0 && $req->confirmed == 0 && $req->rejected == 1) {
            $state = 'Rejected At  Branch';
            return response()->json($state);
        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 0) {
            $state = 'Pending Approval from Cards & Checks Office';
            return response()->json($state);
        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 1) {
            $state = 'Rejected at Cards & Checks Office';
            return response()->json($state);
        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 0 && $req->distrubuted == 1) {
            $state = 'At Your ' . $req->branch->name . ' Branch';
            return response()->json($state);
        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 0 && $req->distrubuted == 1 && $req->collected == 1) {
            $state = 'Given to  Customer at ' . $req->branch->name . ' Branch Pending Activation' ;
            return response()->json($state);

        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 0 && $req->distrubuted == 1 && $req->collected == 1 && $req->is_activated == 1) {
            $state = 'Activated';
            return response()->json($state);
        } else {
            $state = 'This Account does not exist in our system';
            return response()->json($state);
        }
    }


    public function activated($id)
    {
        $req = CardRequest::findorFail($id);
        $users = User::where('department', 'cards')->get();
        $req->is_activated = 1;
        $req->updated_at = now();
        $req->save();
        foreach ($users as $user) {
            $user->notify(new CardCollected($req));
        }
        return response()->json(200);
    }



    // this function validates when the request has been rejec_ted b_y cards and checks
    public function denied(Request $request, $id)
    {
        $req = CardRequest::findorFail($id);
        $users = User::where('branch_id', $req->branch_id)->get();
        $req->rejected = 1;
        $req->reason_rejected = $request->reason;
        $req->updated_at = now();
        $req->save();
        foreach ($users as $user) {
            $user->notify(new RejectRequest($req));
        }
        return response()->json(200);
    }

    // these are the count functions that display the count of the dataon the dashboard for request
    // /week
    public function newc()
    {
        $data = CardRequest::where('approved', 0)->where('rejected', 0)->where('branch_id', auth()->user()->branch_id)->count();
        // return $data;
        return response($data, 200);
    }
    public function newch()
    {
        $data = CheckRequest::where('approved', 0)->where('rejected', 0)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function rc()
    {
        $dat = CheckRequest::where('rejected', 1)->where('branch_id', auth()->user()->branch_id)->count();
        $data1 = CardRequest::where('rejected', 1)->where('branch_id', auth()->user()->branch_id)->count();
        $data = $dat+$data1;
        return response($data, 200);
    }
    public function tcc()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $dat = CheckRequest::wherebetween('created_at', [$start, $end])->where('branch_id', auth()->user()->branch_id)->count();
        $data1 = CardRequest::wherebetween('created_at', [$start, $end])->where('branch_id', auth()->user()->branch_id)->count();
        $data = $dat+$data1;
        return response($data, 200);
    }

    // cards fetch
    public function newca()
    {
        $data = CardRequest::where('confirmed', 0)->where('rejected', 0)->where('approved', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function newcha()
    {
        $data = CheckRequest::where('confirmed', 0)->where('rejected', 0)->where('approved', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function rca()
    {
        $dat = CheckRequest::where('rejected', 1)->count();
        $data1 = CardRequest::where('rejected', 1)->count();
        $data = $dat+$data1;
        return response($data, 200);
    }

    public function tcca()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $dat = CheckRequest::wherebetween('created_at', [$start, $end])->count();
        $data1 = CardRequest::wherebetween('created_at', [$start, $end])->count();
        $data = $dat+$data1;
        return response($data, 200);
    }


    public function cp()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 1)->where('in_production', 1)->where('distrubuted', 0)->where('approved', 1)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function ca()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 0)->where('distrubuted', 0)->where('approved', 1)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function chd()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 1)->where('approved', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }

    public function chp()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 1)->where('distrubuted', 0)->where('approved', 1)->where('confirmed', 1)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function cha()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 0)->where('distrubuted', 0)->where('approved', 1)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function cd()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('distrubuted', 1)->where('in_production', 1)->where('approved', 1)->where('branch_id', auth()->user()->branch_id)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }

    // cards statistics cards4
    public function cpa()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 1)->where('in_production', 1)->where('distrubuted', 0)->where('approved', 1)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function caa()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('distrubuted', 0)->where('approved', 1)->where('in_production', 0)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function chda()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 0)->where('distrubuted', 1)->where('approved', 1)->where('distrubuted', 1)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }

    public function chpa()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 1)->where('distrubuted', 0)->where('approved', 1)->where('confirmed', 1)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function chaa()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 0)->where('distrubuted', 0)->where('approved', 1)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }



    public function cda()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('in_production', 1)->where('distrubuted', 1)->where('approved', 1)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        return response($data, 200);
    }

    //end

    public function pendingcount()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('distrubuted', 0)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->count();
        $result = $data->ToArray();;
        return response($result, 200);
    }




    public function selectSearch(Request $request)
    {
        $query = [];

        if ($request->has('q')) {
            $search = $request->q;
            $query = CardRequest::selectRaw('account_number,id, accountname,requested_by, cards, DATE_FORMAT(created_at, "%M %d %Y") as date')->where('account_number', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($query);
    }


    public function markread()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response(200);
    }

    // Production Section

    public function rproduction()
    {
        return view('cardrequest.rproduction');
    }

    public function rproduction1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('rejected', '0')->where('request_type', 'renew_card')->where('confirmed', '1')->where('distrubuted', '0')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
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
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
                })
                ->make(true);
        } else {
            $data = CardRequest::where('branch_id', auth()->user()->branch_id)->where('rejected', '0')->where('distrubuted', '0')->where('confirmed', '0')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
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
                ->editColumn('accountname', function ($data) {
                    return $data->branchcode . ' ' . $data->accountname . ' ' . $data->RIB;
                })
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
                })

                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
    }

    public function sproduction()
    {
        return view('cardrequest.sproduction');
    }

    public function sproduction1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('rejected', '0')->where('request_type', 'new_card')->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->where('distrubuted', '0')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
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
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
                })
                ->make(true);
        } else {
            $data = CardRequest::where('branch_id', auth()->user()->branch_id)->where('distrubuted', '0')->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
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
                ->editColumn('accountname', function ($data) {
                    return $data->branchcode . ' ' . $data->accountname . ' ' . $data->RIB;
                })
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
                })

                ->make(true);
        }
    }

    public function export(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "New Cards from " . $startdate . " - " . $enddate;
        ob_end_clean();
        ob_start();

        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        return (new RequestExports($startdate, $enddate))->download($title . '.csv');
    }

    public function exportrejected(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "Rejected Request from " . $startdate . " to " . $enddate;

        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();

        ob_end_clean();
        ob_start();


        return (new RejectedExports($startdate, $enddate))->download($title . '.csv');
    }


    public function exportsubs(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "Cards Subscriptions from " . $startdate . " to " . $enddate;

        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();


        return (new SubscriptionExports($startdate, $enddate))->download($title . '.csv');
    }

    public function exportrenewals(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "Cards Renewals from " . $startdate . " to " . $enddate;

        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();


        return (new RenewalsExport($startdate, $enddate))->download($title . '.csv');
    }

    // Cards Distribution Section
    // upload renewal card numbers to system
    public function distribute(Request $request)
    {

        $request->validate([
            'file' => 'required|max:2048',
        ]);

        $title = "Subscription Distribution " . now()->format('d-m-Y');
        // Save details on the user who dowloaded
        $doneby = new Upload();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        $path1 = $request->file('file')->store('assets');
        $path = storage_path('app') . '/' . $path1;


        try {
            Excel::import(new CardRequestImports, $path);
            $transmissions = CardRequest::where('notified', 0)->get();

            foreach ($transmissions as $transmission) {
                Mail::to($transmission->email)->send(new Cardmail($transmission));
                $transmission->notified = 1;
                $transmission->save();
            }
            return redirect()->route('cardrequest.sdistribution')->with('success', 'Card Details Added');
        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with the file', 'error');
            return redirect()->back();
        }
    }

    // upload subscription card numbers to system
    public function rdistribute(Request $request)
    {

        $request->validate([
            'file' => 'required|max:2048',
        ]);
        $title = "Renewals Distribution " . now()->format('d-m-Y');
        // Save details on the user who dowloaded
        $doneby = new Upload();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        $path1 = $request->file('file')->store('assets');
        $path = storage_path('app') . '/' . $path1;
        try {
            Excel::import(new CardSRequestImports, $path);
            $transmissions = CardRequest::where('notified', 0)->get();

            foreach ($transmissions as $transmission) {
                Mail::to($transmission->email)->send(new Cardmail($transmission));
                $transmission->notified = 1;
                $transmission->save();
            }
            return redirect()->route('cardrequest.rdistribution')->with('success', 'Card Details Added');
        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with the file', 'error');
            return redirect()->back();
        }
    }
    //  Distribution Pending

    public function collected($id)
    {
        $req = CardRequest::findorFail($id);
        $req->collected = 1;
        $req->updated_at = now();
        $req->save();
        $css = User::where('department', 'cards')->get();
        foreach ($css as $cs) {
            $cs->notify(new CardCollected($req));
        }
        return response()->json(200);
    }

    public function distributionsindex()
    {
        return view('distribution.subscription');
    }

    public function distributionsindex1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'new_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '<td>
                <a class="dropdown-item btn btn-danger-outline btn-delete  text-white" data-remote="' . route('cardrequest.destroy', $row->id) . '">
                               Delete </a>
                </td>
                ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa' || auth()->user()->department == 'branchadmin') {
            $data = CardRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->where('request_type', 'new_card')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
                        <td><a class="validates btn btn-outline-primary btn-sm"
                        data-remote="/cardrequest/collected/' . $row->id . '">Approve<i class="nc-icon nc-check-2"
                            aria-hidden="true" style="color: black"></i></a></td>
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CardRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'new_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('age', function ($item) {
                    return $item->updated_at > now()->subMonth(3) ? 10 : 100;
                })
                ->make(true);
        }
    }

    public function distributionrindex()
    {
        return view('distribution.renewal');
    }

    public function distributionrindex1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'renew_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '<td>
                <a class="dropdown-item btn btn-danger-outline btn-delete  text-white" data-remote="' . route('cardrequest.destroy', $row->id) . '">
                               Delete </a>
                </td>
                ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa' || auth()->user()->department == 'branchadmin') {
            $data = CardRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->where('request_type', 'renew_card')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                    '
                    <td><a class="validates btn btn-outline-primary btn-sm"
                    data-remote="/cardrequest/collected/' . $row->id . '">Approve<i class="nc-icon nc-check-2"
                        aria-hidden="true" style="color: black"></i></a></td>
                    ';
                return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        elseif (auth()->user()->department == 'dso') {
            $data = CardRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'renew_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('age', function ($item) {
                    return $item->updated_at > now()->subMonth(3) ? 10 : 100;
                })
                ->make(true);
        }
    }
    // Distribution Collected
    public function distributionscollected()
    {
        return view('distribution.csubscription');
    }

    public function distributionscollected1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'new_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {



                        if ($row->is_activated== '1') {
                            $actionBtn =
                            '<td>
                            <td><a class=" btn btn-success btn-sm"
                            >Activated<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;
                        }
                        else{
                            $actionBtn =
                            '  <td> <a class="validates btn btn-outline-primary btn-sm"
                            data-remote="/cardrequest/activated/' . $row->id . '">Activate<i class="nc-icon nc-check-2"
                                aria-hidden="true" style="color: black"></i></a></td>
                            ';
                            return $actionBtn;
                        }





                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa' || auth()->user()->department == 'branchadmin') {
            $data = CardRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->where('request_type', 'new_card')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {

                    if($row->is_activated == '1'){
                        $actionBtn =
                            '<td>
                            <td><a class=" btn btn-outline-success btn-sm"
                            >Activated<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;
                        }
                        else{

                            $actionBtn =
                            '<td>
                            <td><a class=" btn btn-mute btn-sm"
                            >Unactivated.<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;

                        };


                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CardRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'new_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('age', function ($item) {
                    return $item->updated_at > now()->subMonth(3) ? 10 : 100;
                })
                ->make(true);
        }
    }

    public function distributionrcollected()
    {
        return view('distribution.crenewal');
    }

    public function distributionrcollected1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'renew_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    if( $row->collected  == '1'){

                        if ($row->is_activated== '1') {
                            $actionBtn =
                            '<td>
                            <td><a class=" btn btn-success btn-sm"
                            >Activated<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;
                        }
                        else{
                            $actionBtn =
                            '  <td> <a class="validates btn btn-outline-primary btn-sm"
                            data-remote="/cardrequest/activated/' . $row->id . '">Activate<i class="nc-icon nc-check-2"
                                aria-hidden="true" style="color: black"></i></a></td>
                            ';
                            return $actionBtn;
                        }

                        }
                        else{

                            $actionBtn =
                            '<td>
                            <td><a class=" btn btn-mute btn-sm"
                            >Pending<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;

                        };





                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa' || auth()->user()->department == 'branchadmin') {
            $data = CardRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->where('request_type', 'renew_card')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {
                    if($row->is_activated == '1'){
                        $actionBtn =
                            '<td>
                            <td><a class=" btn btn-outline-success btn-sm"
                            >Activated<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;
                        }
                        else{

                            $actionBtn =
                            '<td>
                            <td><a class=" btn btn-mute btn-sm"
                            >Unactivated.<i class="nc-icon nc-check-2"
                                 aria-hidden="true" "></i></a></td>
                            </td>
                            ';
                            return $actionBtn;

                        };

                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CardRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'renew_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('cards', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('age', function ($item) {
                    return $item->updated_at > now()->subMonth(3) ? 10 : 100;
                })
                ->make(true);
        }
    }
}
