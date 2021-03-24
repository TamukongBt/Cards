<?php

namespace App\Http\Controllers;


use App\CheckRequest;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\RejectRequest;
use App\Notifications\NewRequestNotification;
use App\Downloads;
use App\Exports\RequestExports;
use App\Exports\RejectedExports;
use App\Exports\ApprovedNewExports;
use App\Exports\ApprovedExports;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class CheckRequestController extends Controller
{
    public function index()
    {
        $request = CheckRequest::all();
        return view('cardrequest.index')->with('request', $request);
    }
    public function index1()
    {

        if (auth()->user()->department == 'css') {
            $data = CheckRequest::where('approved', 0)->where('branch_id',auth()->user()->branch_id)->get();

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
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '<td><a class="validates btn btn-outline-primary btn-sm"
                data-remote="cardrequest/approve/' . $row->id . '"><i class="nc-icon nc-check-2"
                    aria-hidden="true" style="color: black"></i></a></td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="' . route('cardrequest.destroy', $row->id) . '">
                <i class="nc-icon nc-simple-remove" aria-hidden="true"
                         style="color: black"></i></button>

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
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
                <td><a class="validates btn btn-outline-primary btn-sm"
                     data-remote="/cardrequest/confirm/' . $row->id . '"><i class="nc-icon nc-check-2"
                         aria-hidden="true" style="color: black"></i></a></td>
                <a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/cardrequest/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'it') {
            $data = CheckRequest::where('confirmed', 1)->where('request_type', 'new_card')->get();
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
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        $actionBtn =
                        '<td>
                        <a href="' . route('cardrequest.edit', $row->id) . '" class="edit btn btn-info btn-sm "><i class="nc-icon nc-alert-circle-i"></i></a>


            <a class="denies btn btn-outline-danger btn-sm"
                data-remote="/cardrequest/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-simple-remove"
                    aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        elseif (auth()->user()->department == 'dso') {
            $data = CheckRequest::where('confirmed', 1)->where('request_type', 'renew_card')->get();
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

    public function approves()
    {
        return view('cardrequest.approves');
    }

    public function approves1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CheckRequest::where('rejected', '0')->where('confirmed', '0')->where('approved', '1')->get();
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
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =
                        '
                <td><a class="validates btn btn-outline-primary btn-sm"
                     data-remote="/cardrequest/confirm/' . $row->id . '"><i class="nc-icon nc-check-2"
                         aria-hidden="true" style="color: black"></i></a></td>
                <a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/cardrequest/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        else{
            $data = CheckRequest::where('branch_id', auth()->user()->branch_id)->where('rejected', '0')->where('confirmed', '0')->where('approved', '1')->get();
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

    public function validated()
    {
        return view('cardrequest.validated');
    }

    public function validated1()
    {
        if (auth()->user()->department == 'it') {
            $data = CheckRequest::where('confirmed', '1')->where('request_type', 'new_card')->get();
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
        } elseif (auth()->user()->department == 'cards') {
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
                ->editColumn('request_type', function ($data) {
                    return $data->requesttype->name;
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
            'checks' => 'required',
            'account_number' => 'required',
            'branchcode' => 'required',
            'bankcode' => 'required',
            'RIB' => 'required',
            'account_name' => 'required',
            'request_type' => 'required',
            'requested_by' => 'required',
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'

        ]);

        try {
            CheckRequest::create($data);
            $users = User::where('branch_id', auth()->user()->branch_id)->where('department', 'css')->get();
            $request = CheckRequest::where('account_name', $request->account_name)->where('account_number', $request->account_number)->where('branch_id', $request->branch_id)->where('checks', $request->checks)->get()->first();
            foreach ($users as $user) {
                $user->notify(new NewRequestNotification($request));
            }
            return redirect()->route('cardrequest.index')->with('success', 'New Entry created succesfully');
        } catch (\Throwable $th) {

            Alert::alert('Error', 'There is a problem with this entry ', 'error');
            return redirect()->route('cardrequest.create');
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

            'account_type' => 'required|string',
            'branch_id' => 'required',
            'checks' => 'required',
            'account_number' => 'required|max:15',
            'account_name' => 'required|string',
            'request_type' => 'required|string',
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

        $req = CheckRequest::findorFail($id);
        CheckRequest::whereId($req['id'])->delete();
        return response(200);
    }

    // this function validates when the request has been confirmed by checks and checks
    public function fulfilled($id)
    {
        $req = CheckRequest::findorFail($id);
        $req->confirmed = 1;
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
    public function newcardcount()
    {
        $data = CheckRequest::get()->where('request_type', 'new_card')->where('confirmed', 0)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function newcardbranch()
    {
        $data = CheckRequest::get()->where('request_type', 'new_card')->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function renew()
    {
        $data = CheckRequest::get()->where('request_type', 'renew_card')->where('confirmed', 1)->where('rejected', 0)->count();
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
        $data = CardRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 0)->count();
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

    public function exportapproved(Request $request)
    {

        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $title = "Approved Request from " . $startdate . " to " . $enddate;
        $ittitle =  "New Card Request from " . $startdate . " to " . $enddate;

        // Save details on the user who dowloaded
        $doneby = new Downloads();
        $doneby->user = auth()->user()->name;
        $doneby->title = $title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();

        ob_end_clean();
        ob_start();

        if (auth()->user()->department == 'it') {
            return (new ApprovedNewExports($startdate, $enddate))->download($ittitle . '.csv');
        } else {
            return (new ApprovedExports($startdate, $enddate))->download($title . '.csv');
        }
    }
}
