<?php

namespace App\Http\Controllers;

use App\CardRequest;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\RejectRequest;
use App\Notifications\NewRequestNotification;
use App\Downloads;
use App\Exports\RequestExports;
use App\Exports\RejectedExports;
use App\Exports\RenewalsExport;
use App\Exports\SubscriptionExports;
use App\Imports\CardRequestImports;
use App\Imports\CardSRequestImports;
use App\Upload;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CardRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = CardRequest::all();
        return view('cardrequest.index')->with('request', $request);
    }
    public function index1()
    {

        if (auth()->user()->department == 'branchadmin') {
            $data = CardRequest::where('approved', 0)->where('branch_id',auth()->user()->branch_id)->get();

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
            $data = CardRequest::where('approved', 0)->where('rejected', 0)->where('confirmed', 0)->where('branch_id',auth()->user()->branch_id)->get();

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
        }
        elseif (auth()->user()->department == 'dso') {
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

    public function rproduction()
    {
        return view('cardrequest.rproduction');
    }

    public function rproduction1()
    {
        if (auth()->user()->department == 'cards') {
            $data = CardRequest::where('rejected', '0')->where('request_type', 'renew_card')->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
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
                    if ($data->account_type=='moral') {
                        return 'Moral Entity';
                    }
                    else {
                        return 'Individual Account';
                    }
                })
                ->make(true);
        }
        else{
            $data = CardRequest::where('branch_id', auth()->user()->branch_id)->where('rejected', '0')->where('confirmed', '0')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
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
                return $data->branchcode.' '.$data->accountname.' '.$data->RIB;
            })
            ->editColumn('account_type', function ($data) {
                if ($data->account_type=='moral') {
                    return 'Moral Entity';
                }
                else {
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
            $data = CardRequest::where('rejected', '0')->where('request_type', 'new_card')->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
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
                    if ($data->account_type=='moral') {
                        return 'Moral Entity';
                    }
                    else {
                        return 'Individual Account';
                    }
                })
                ->make(true);
        }
        else{
            $data = CardRequest::where('branch_id', auth()->user()->branch_id)->where('confirmed', '1')->where('approved', '1')->where('in_production', '1')->whereBetween('updated_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
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
                return $data->branchcode.' '.$data->accountname.' '.$data->RIB;
            })
            ->editColumn('account_type', function ($data) {
                if ($data->account_type=='moral') {
                    return 'Moral Entity';
                }
                else {
                    return 'Individual Account';
                }
            })

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
            try {
            CardRequest::create($data);
            $users = User::where('branch_id',$request->branch_id)->where('department', 'css')->get();
            $request = CardRequest::where('accountname', $request->accountname)->where('account_number', $request->account_number)->where('branch_id', $request->branch_id)->where('cards', $request->cards)->get()->first();

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
    //     $request = CardRequest::find($id);
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

    // this function validates when the request has been confirmed by cards and checks
    public function fulfilled($id)
    {
        $req = CardRequest::findorFail($id);
        $req->confirmed = 1;
        if ($req->request_type=='new_card'||$req->request_type=='renew_card') {
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
       if( $req->approved == 1 && $req->confirmed == 1 && $req->rejected == 0 && $req->in_production == 1){
           $state = 'In The Production File';
           return response()->json($state);
       }
       if( $req->approved == 1 && $req->confirmed == 1 && $req->rejected == 0  ){
           $state = 'Your Request Has Been Completed';
           return response()->json($state);
       }
       else  if( $req->approved == 0 && $req->confirmed == 0 && $req->rejected == 0){
        $state = 'Pending Approval From Branch';
        return response()->json($state);
        }
        else  if( $req->approved == 0 && $req->confirmed == 0 && $req->rejected == 1){
            $state = 'Rejected At From Branch';
            return response()->json($state);
        }
        else  if( $req->approved == 1 && $req->confirmed == 0 && $req->rejected == 0){
            $state = 'Pending Approval from Cards & Checks Office';
            return response()->json($state);
        }
        else  if( $req->approved == 1 && $req->confirmed == 0 && $req->rejected == 1){
            $state = 'Rejected at Cards & Checks Office';
            return response()->json($state);
        }
        else  if( $req->approved == 1 && $req->confirmed == 0 && $req->rejected == 1&& $req->ditrubuted == 1){
            $state = 'Distrubuted at The Branch';
            return response()->json($state);
        }
        else  {
            $state = 'This Account does not exist in our system';
            return response()->json($state);
        }

    }


    public function activated($id)
    {
        $req = CardRequest::findorFail($id);
        $req->is_activated = 1;
        $req->updated_at = now();
        $req->save();
        return response()->json(200);
    }

    // this function validates when the request has been rejected by cards and checks
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
    public function newcardcount()
    {
        $data = CardRequest::get()->where('request_type', 'new_card')->where('confirmed', 0)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function newcardbranch()
    {
        $data = CardRequest::get()->where('request_type', 'new_card')->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }
    public function renew()
    {
        $data = CardRequest::get()->where('request_type', 'renew_card')->where('confirmed', 1)->where('rejected', 0)->count();
        // return $data;
        return response($data, 200);
    }

    public function validatedcount()
    {
        $data = CardRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 1)->where('rejected', 0)->count();
        return response($data, 200);
    }



    public function groupvalidated()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');
        $data = CardRequest::get()->wherebetween('created_at', [$start, $end])->where('confirmed', 0)->where('rejected', 0)->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d-m-Y'); // grouping by months
        })->map->count();
        $result = $data->ToArray();;
        return response($result, 200);
    }



    public function rejectedcount()
    {
        $data = CardRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 1)->count();
        return response($data, 200);
    }

    public function pendingcount()
    {
        $data = CardRequest::get()->where('branch_id', auth()->user()->branch_id)->where('confirmed', 0)->where('rejected', 0)->count();
        return response($data, 200);
    }




    public function selectSearch(Request $request)
    {
    	$query = [];

        if($request->has('q')){
            $search = $request->q;
            $query =CardRequest::selectRaw('account_number,id, accountname,requested_by, cards, DATE_FORMAT(created_at, "%M %d %Y") as date')->where('account_number', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($query);
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

    public function distrubute(Request $request)
    {

        $request->validate([
            'file' => 'required|max:2048',
        ]);
        $title = "Subscription Distrubution " . now()->format('d-m-Y');
        // Save details on the user who dowloaded
        $doneby = new Upload();
        $doneby->user = auth()->user()->name;
        $doneby->title=$title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        $path1 = $request->file('file')->store('assets');
        $path=storage_path('app').'/'.$path1;


        try {

                Excel::import(new CardRequestImports, $path);

                return redirect()->route('cardrequest.rdistrubution')->with( 'success','Card Details Added');

        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with the file', 'error');
            return redirect()->back();
        }
    }

    public function rdistrubute(Request $request)
    {

        $request->validate([
            'file' => 'required|max:2048',
        ]);
        $title = "Renewals Distrubution " . now()->format('d-m-Y');
        // Save details on the user who dowloaded
        $doneby = new Upload();
        $doneby->user = auth()->user()->name;
        $doneby->title=$title;
        $doneby->employee_id = auth()->user()->employee_id;
        $doneby->save();
        $path1 = $request->file('file')->store('assets');
        $path=storage_path('app').'/'.$path1;


        try {

                Excel::import(new CardSRequestImports, $path);

                return redirect()->route('cardrequest.sdistrubution')->with( 'success','Card Details Added');

        } catch (\Throwable $th) {
            Alert::alert('Error', 'There is a problem with the file', 'error');
            return redirect()->back();
        }
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

    // Cards Distrubution Section 


}
