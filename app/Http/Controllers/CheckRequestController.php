<?php

namespace App\Http\Controllers;


use App\CheckRequest;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\RejectRequest;
use App\Notifications\RequestNotification;
use App\Downloads;
use App\Exports\ChecksExport;
use App\Exports\RequestExports;
use App\Exports\RejectedExports;
use App\Exports\RenewalsExport;
use App\Exports\SubscriptionExports;
use App\Mail\Cheque;
use App\Notifications\CardCollected;
use App\Notifications\NewRequestCNotification;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CheckRequestController extends Controller
{
    public function index()
    {
        $request = CheckRequest::all();
        return view('checkrequest.index')->with('request', $request);
    }
    public function index1()
    {

        if (auth()->user()->department == 'branchadmin') {
            $data = CheckRequest::where('approved', 0)->where('branch_id', auth()->user()->branch_id)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
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
                                <a class="dropdown-item  btn-delete" data-remote="/checkrequest/reject/' . $row->id . '">
                                Rejects </a>
                                <a class="validates dropdown-item "
                                data-remote="checkrequest/approve/' . $row->id . '">Approves</a>
                                <a class="track dropdown-item "  data-remote="check/track/' . $row->id . '">Track Account</a>
                            </div>


                 </td>
             ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('confirmed', 0)->where('rejected', 0)->where('approved', 1)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
                <td><a class="validates btn btn-outline-primary btn-sm"
                     data-remote="/checkrequest/confirm/' . $row->id . '">Approve<i class="nc-icon nc-check-2"
                         aria-hidden="true" style="color: black"></i></a></td>
                <a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/checkrequest/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject">Reject<i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>
              ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa') {
            $data = CheckRequest::where('approved', 0)->where('rejected', 0)->where('confirmed', 0)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->editColumn('account_type', function ($data) {
                    if ($data->account_type == 'moral') {
                        return 'Moral Entity';
                    } else {
                        return 'Individual Account';
                    }
                })

                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '
                        <td>
                        <div class="dropdown dropleft ">
                            <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">

                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                            <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                                <a class="dropdown-item " href="' . route('checkrequest.edit', $row->id) . '" >
                                Edit</a>
                                <a class="dropdown-item " href="' . route('checkrequest.destroy', $row->id) . '" >
                                Delete</a>
                                <a class="track dropdown-item "  data-remote="check/track/' . $row->id . '">Track Account</a>
                            </div>
                        </div>
                ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CheckRequest::where('confirmed', 1)->where('in_production', 1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
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


    public function production()
    {
        return view('checkrequest.production');
    }

    public function production1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('rejected', '0')->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
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
            $data = CheckRequest::where('branch_id', auth()->user()->branch_id)->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
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


    public function validated()
    {
        return view('checkrequest.validated');
    }

    public function validated1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('confirmed', '1')->where('approved', '1')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
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
            $data = CheckRequest::where('confirmed', '1')->where('approved', '1')->where('branch_id', auth()->user()->branch_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
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
        return view('checkrequest.rejected');
    }

    public function rejected1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('rejected', '1')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
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
            $data = CheckRequest::where('rejected', '1')->where('branch_id', auth()->user()->branch_id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('branch_id', function ($data) {

                    return $data->branch->name;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
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
        return view('checkrequest.create');
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
            'checks' => 'required',
            'account_number' => 'required',
            'branchcode' => 'required',
            'bankcode' => 'required',
            'RIB' => 'required',
            'accountname' => 'required',
            'number' => 'required',
            'requested_by' => 'required',
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'

        ]);
        try {
            CheckRequest::create($data);
            $users = User::where('branch_id', auth()->user()->branch_id)->where('department', 'branchadmin')->get();
            $request = CheckRequest::where('accountname', $request->accountname)->where('account_number', $request->account_number)->where('branch_id', $request->branch_id)->where('checks', $request->checks)->get()->first();
            foreach ($users as $user) {
                $user->notify(new RequestNotification($request));
            }
            return redirect()->route('checkrequest.index')->with('success', 'New Entry created succesfully');
        } catch (\Throwable $th) {
            $errorCode = $th->errorInfo[1];
            if ($errorCode == '1062') {
                Alert::alert('Error', 'This Entry Already Exist In the system ', 'error');
                return redirect()->route('checkrequest.create');
            } else {
                Alert::alert('Error', 'There is a problem with this entry ', 'error');
                return redirect()->route('checkrequest.create');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $request = CheckRequest::find($id);
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
        $request = CheckRequest::find($id);
        return view('checkrequest.edit', compact('request', 'id'));
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
            'checks' => 'required',
            'account_number' => 'required',
            'branchcode' => 'required',
            'bankcode' => 'required',
            'RIB' => 'required',
            'accountname' => 'required',
            'number' => 'required',
            'requested_by' => 'required',
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'


        ]);
        try {
            $req = CheckRequest::findorFail($id);
            $req->rejected = 0;
            $req->save();
            CheckRequest::whereId($id)->update($data);
        } catch (\Throwable $th) {
            $errorCode = $th->errorInfo[1];
            if ($errorCode == '1062') {
                Alert::alert('Error', 'This Entry Already Exist In the system ', 'error');
                return redirect()->back();
            } else {
                Alert::alert('Error', 'There is a problem with this entry ', 'error');
                return redirect()->back();
            }
        }

        return redirect('/checkrequest')->with('success', 'Request Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $req = CheckRequest::findorFail($id);
        CheckRequest::whereId($req['id'])->delete();
        return response(200);
    }

    // this function validates when the request has been confirmed by checks and checks
    public function fulfilled($id)
    {
        $req = CheckRequest::findorFail($id);
        $req->confirmed = 1;
        $req->in_production = 1;
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }
    // this function validates when the request has been confirmed by csa
    public function approved($id)
    {
        $req = CheckRequest::findorFail($id);
        $req->approved = 1;
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }

    public function activated($id)
    {
        $req = CheckRequest::findorFail($id);
        $req->is_activated = 1;
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }

    // this function validates when the request has been rejected by checks and checks
    public function denied(Request $request, $id)
    {
        $req = CheckRequest::findorFail($id);
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

    public function selectSearch(Request $request)
    {
        $query = [];

        if ($request->has('q')) {
            $search = $request->q;
            $query = CheckRequest::selectRaw('account_number,id, accountname,requested_by, checks, DATE_FORMAT(created_at, "%M %d %Y") as date')->where('account_number', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($query);
    }

    public function track($id)
    {
        $req = CheckRequest::findorFail($id);
        if ($req->approved == 1 && $req->confirmed == 1 && $req->rejected == 0 && $req->in_production == 1 && $req->distrubuted == 0) {
            $state = 'In The Production File';
            return response()->json($state);
        }
        if ($req->approved == 1 && $req->confirmed == 1 && $req->rejected == 0  && $req->in_production == 0) {
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
        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 1 && $req->distrubuted == 1) {
            $state = 'At  ' . $req->branch->name . ' Branch';
            return response()->json($state);
        } else  if ($req->approved == 1 && $req->confirmed == 0 && $req->rejected == 1 && $req->distrubuted == 1 && $req->collected == 1) {
            $state = 'Given to  Customer at ' . $req->branch->name . ' Branch';
            return response()->json($state);
        } else {
            $state = 'This Account does not exist in our system';
            return response()->json($state);
        }
    }

    public function newcardcount()
    {
        $data = CheckRequest::get()->where('confirmed', 0)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function newcardbranch()
    {
        $data = CheckRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function renew()
    {
        $data = CheckRequest::get()->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }

    public function validatedcount()
    {
        $data = CheckRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        return response($data, 200);
    }

    public function validatedcountit()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 1)->where('rejected', 0)->count();
        return response($data, 200);
    }

    public function groupvalidated()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CheckRequest::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 0)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->map->count();
        $result = $data->ToArray();;
        return response($result, 200);
    }



    public function rejectedcount()
    {
        $data = CheckRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 1)->count();
        return response($data, 200);
    }

    public function pendingcount()
    {
        $data = CHECKRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 0)->count();
        return response($data, 200);
    }







    public function markread()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response(200);
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

    public function exportchecks(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "Checks from " . $startdate . " to " . $enddate;

        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();

        ob_end_clean();
        ob_start();

        return (new ChecksExport($startdate, $enddate))->download($title . '.csv');
    }

    //  Distribution Pending

    public function collected($id)
    {
        $req = CheckRequest::findorFail($id);
        $req->collected = 1;
        $req->updated_at = now();
        $req->save();

        return response()->json(200);
    }

    public function distributionindex()
    {
        return view('distribution.check');
    }

    public function distributionindex1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '<td>
                 <a class="dropdown-item btn btn-danger-outline btn-delete  text-white" data-remote="' . route('checkrequest.destroy', $row->id) . '">
                        Delete </a>
                 </td>
                 ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa' || auth()->user()->department == 'branchadmin') {
            $data = CheckRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
                         <td><a class="validates btn btn-outline-primary btn-sm"
                         data-remote="/checkrequest/collected/' . $row->id . '">Collect<i class="nc-icon nc-check-2"
                             aria-hidden="true" style="color: black"></i></a></td>
                         ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CheckRequest::where('collected', 0)->where('in_production', 1)->where('distrubuted', 1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('age', function ($item) {
                    return $item->updated_at > now()->subMonth(3) ? 10 : 100;
                })
                ->make(true);
        }
    }


    // Distribution Collected
    // uplaod distrubutions and notify
    public function distribute(Request $request)
    {
        try {
            $data = $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            $distrubutions =  CheckRequest::where('notified', 0)->where('distrubuted', 0)->where('in_production', 1)->where('approved', 1)->where('confirmed', 1)->where('rejected', 0)->wherebetween('created_at', [$request->start_date, $request->end_date])->get();
            foreach ($distrubutions as $transmission) {
                // Mail::to($transmission->email)->send(new Cheque($transmission));
                $transmission->distrubuted = 1;
                $transmission->notified = 1;
                $transmission->save();
            }
            return redirect()->route('checkrequest.distribution')->with('success', 'Clients Notified');
        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with the file', 'error');
            return redirect()->back();
        }
    }

    public function distributioncollected()
    {
        return view('distribution.ccheck');
    }

    public function distributioncollected1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '<td>
                 <a class="dropdown-item btn btn-danger-outline btn-delete  text-white" data-remote="' . route('checkrequest.destroy', $row->id) . '">
                                Delete </a>
                 </td>
                 ';
                    return $actionBtn;
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'csa' || auth()->user()->department == 'branchadmin') {
            $data = CheckRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('branch_id', auth()->user()->branch_id)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
                         <td><a class="validates btn btn-outline-primary btn-sm"
                         data-remote="/cardrequest/collected/' . $row->id . '">Collect<i class="nc-icon nc-check-2"
                             aria-hidden="true" style="color: black"></i></a></td>
                         ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'dso') {
            $data = CheckRequest::where('collected', 1)->where('in_production', 1)->where('distrubuted', 1)->where('request_type', 'renew_card')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('checks', function ($data) {
                    return $data->cardtype->name;
                })
                ->addColumn('age', function ($item) {
                    return $item->updated_at > now()->subMonth(3) ? 10 : 100;
                })
                ->make(true);
        }
    }
}
