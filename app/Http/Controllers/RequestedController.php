<?php

namespace App\Http\Controllers;

ob_start();

use App\Requested;
use App\User;
use Illuminate\Http\Request;
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
use Exception;
use Spatie\Permission\Traits\HasRoles;
use Swift_SmtpTransport;
use Swift_TransportException;

class RequestedController extends Controller
{
    /**
     * Display a listing of the request
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        if (auth()->user()->department == 'dso') {
            $request =  Requested::where('confirmed', 1)->where('request_type', 'new_card')->get();
            return view('request.index')->with('request', $request);
        }
        else{
        $request = Requested::all();}

        return view('request.index')->with('request', $request);
    }
    public function index1()
    {

        if (auth()->user()->department == 'css') {
            $data = Requested::where('approved', 0)->where('branch_id',auth()->user()->branch_id)->get();

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

                        '<td><a class="validates btn btn-outline-primary btn-sm"
                data-remote="request/approve/' . $row->id . '"><i class="nc-icon nc-check-2"
                    aria-hidden="true" style="color: black"></i></a></td>

                <button id="deletebutton" class="btn btn-sm btn-danger btn-delete" data-remote="' . route('request.destroy', $row->id) . '">
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
            $data = Requested::where('confirmed', 0)->where('rejected', 0)->where('approved', 1)->get();

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
                <a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/request/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } elseif (auth()->user()->department == 'it') {
            $data = Requested::where('confirmed', 1)->where('request_type', 'new_card')->get();
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
        } elseif (auth()->user()->department == 'csa') {
            $data = Requested::where('approved', 0)->where('rejected', 0)->where('confirmed', 0)->get();

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
                        <a href="' . route('request.edit', $row->id) . '" class="edit btn btn-info btn-sm "><i class="nc-icon nc-alert-circle-i"></i></a>


            <a class="denies btn btn-outline-danger btn-sm"
                data-remote="/request/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-simple-remove"
                    aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        elseif (auth()->user()->department == 'dso') {
            $data = Requested::where('confirmed', 1)->where('request_type', 'renew_card')->get();
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

    public function approves()
    {
        return view('request.approves');
    }

    public function approves1()
    {
        if (auth()->user()->department == 'cards') {
            $data = Requested::where('rejected', '0')->where('confirmed', '0')->where('approved', '1')->get();
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
                <a class="denies btn btn-outline-danger btn-sm"
                    data-remote="/request/reject/' . $row->id . '" data-toggle="modal" data-target="#modelreject"><i class="nc-icon nc-simple-remove"
                        aria-hidden="true" style="color: black"></i></a></td>  ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
        else{
            $data = Requested::where('branch_id', auth()->user()->branch_id)->where('rejected', '0')->where('confirmed', '0')->where('approved', '1')->get();
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

    public function validated()
    {
        return view('request.validated');
    }

    public function validated1()
    {
        if (auth()->user()->department == 'it') {
            $data = Requested::where('confirmed', '1')->where('request_type', 'new_card')->get();
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
        } elseif (auth()->user()->department == 'cards') {
            $data = Requested::where('confirmed', '1')->where('approved', '1')->get();
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
            $data = Requested::where('confirmed', '1')->where('approved', '1')->where('branch_id', auth()->user()->branch_id)->get();
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
        return view('request.rejected');
    }

    public function rejected1()
    {
        if (auth()->user()->department == 'cards') {
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
                ->make(true);
        } else {
            $data = Requested::where('rejected', '1')->where('branch_id', auth()->user()->branch_id)->get();
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

            'account_type' => 'required',
            'branch_id' => 'required',
            'cards' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'request_type' => 'required',
            'requested_by' => 'required',
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'

        ]);

        try {
            Requested::create($data);
            $users = User::where('branch_id', auth()->user()->branch_id)->where('department', 'css')->get();
            $request = Requested::where('account_name', $request->account_name)->where('account_number', $request->account_number)->where('branch_id', $request->branch_id)->where('cards', $request->cards)->get()->first();
            foreach ($users as $user) {
                $user->notify(new NewRequestNotification($request));
            }
            return redirect()->route('request.index')->with('success', 'New Entry created succesfully');
        } catch (\Throwable $th) {

            Alert::alert('Error', 'There is a problem with this entry ', 'error');
            return redirect()->route('request.create');
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
            'done_by' => 'required',
            'email' => 'required',
            'tel' => 'required'


        ]);
        try {
            $req = Requested::findorFail($id);
            $req->rejected = 0;
            $req->save();
            Requested::whereId($id)->update($data);
        } catch (\Throwable $th) {
            return redirect('/create');
        }

        return redirect('/request')->with('success', 'Request Updated!!');
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
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }
    // this function validates when the request has been confirmed by csa
    public function approved($id)
    {
        $req = Requested::findorFail($id);
        $req->approved = 1;
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }

    // this function validates when the request has been rejected by cards and checks
    public function denied(Request $request, $id)
    {
        $req = Requested::findorFail($id);
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
        $data = Requested::get()->where('request_type', 'new_card')->where('confirmed', 0)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function newcardbranch()
    {
        $data = Requested::get()->where('request_type', 'new_card')->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function renew()
    {
        $data = Requested::get()->where('request_type', 'renew_card')->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }

    public function validatedcount()
    {
        $data = Requested::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        return response($data, 200);
    }

    public function validatedcountit()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = Requested::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 1)->where('rejected', 0)->count();
        return response($data, 200);
    }

    public function groupvalidated()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = Requested::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 0)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->map->count();
        $result = $data->ToArray();;
        return response($result, 200);
    }



    public function rejectedcount()
    {
        $data = Requested::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 1)->count();
        return response($data, 200);
    }

    public function pendingcount()
    {
        $data = Requested::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 0)->count();
        return response($data, 200);
    }


    public function other()
    {
        $data = Requested::get()->where('request_type', '!=', 'new_card')->where('confirmed', 0)->where('rejected', 0)->count();
        // return $data;
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
