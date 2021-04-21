<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use App\Notifications\Validated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('users.index');
    }
    public function index1()
    {

        if (auth()->user()->department == 'branchadmin') {
            $data = User::where('branch_id', auth()->user()->branch_id)->where('department', 'csa')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('department', function ($data) {
                    if ($data->department == 'cards') {
                        return 'Cards and Checks Office';
                    } elseif ($data->department == 'dso') {
                        return 'Digital Sales Officer';
                    } elseif ($data->department == 'csa') {
                        return 'Customer Service Assistant';
                    } elseif ($data->department == 'branchadmin') {
                        return 'Branch / Sales Manager';
                    } elseif ($data->department == 'superadmin') {
                        return 'Super Administrator';
                    }
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '
                        <td><a class="track btn btn-outline-warning btn-sm"
                        data-remote="user/deactivate/' . $row->id . '">Dectivate<i class="nc-icon nc-check-2"
                            aria-hidden="true" style="color: black"></i></a></td>
            ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'cards') {
            $data = User::where('department', 'branchadmin')->where('not_active', 0)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('department', function ($data) {
                    if ($data->department == 'cards') {
                        return 'Cards and Checks Office';
                    } elseif ($data->department == 'dso') {
                        return 'Digital Sales Officer';
                    } elseif ($data->department == 'csa') {
                        return 'Customer Service Assistant';
                    } elseif ($data->department == 'branchadmin') {
                        return 'Branch / Sales Manager';
                    } elseif ($data->department == 'superadmin') {
                        return 'Super Administrator';
                    }
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('action', function ($row) {
                    if ($row->not_active == 1) {
                        $actionBtn =

                        '
                    <td>
                    <div class="dropdown dropleft ">
                        <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                        <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                        <a class="denies dropdown-item"
                        data-remote="/user/role/' . $row->id . '" data-toggle="modal" data-target="#modelreject">Change Role</i></a>
                            <a class="validates dropdown-item "  data-remote="user/activate/' . $row->id . '">Activate</a>
                            <a class="dropdown-item btn-delete "   data-remote="' . route('user.destroy', $row->id) . '" >
                            Delete Account</a>
                        </div>
                    </div>
            ';
                    return $actionBtn;
                    }else{
                        $actionBtn =

                        '
                    <td>
                    <div class="dropdown dropleft ">
                        <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                        <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                        <a class="denies dropdown-item"
                        data-remote="/user/role/' . $row->id . '" data-toggle="modal" data-target="#modelreject">Change Role</i></a>
                            <a class="track dropdown-item "  data-remote="user/deactivate/' . $row->id . '">Deactivate</a>
                            <a class="dropdown-item btn-delete "   data-remote="' . route('user.destroy', $row->id) . '" >
                            Delete Account</a>
                        </div>
                    </div>
            ';
                    return $actionBtn;

                    }


                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'superadmin') {
            $data = User::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('department', function ($data) {
                    if ($data->department == 'cards') {
                        return 'Cards and Checks Office';
                    } elseif ($data->department == 'dso') {
                        return 'Digital Sales Officer';
                    } elseif ($data->department == 'csa') {
                        return 'Customer Service Assistant';
                    } elseif ($data->department == 'branchadmin') {
                        return 'Branch / Sales Manager';
                    } elseif ($data->department == 'superadmin') {
                        return 'Super Administrator';
                    }
                })
                ->addColumn('action', function ($row) {

                    if ($row->not_active == 1) {
                        $actionBtn =

                        '
                    <td>
                    <div class="dropdown dropleft ">
                        <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                        <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                        <a class="denies dropdown-item"
                        data-remote="/user/role/' . $row->id . '" data-toggle="modal" data-target="#modelreject">Change Role</i></a>
                            <a class="validates dropdown-item "  data-remote="user/activate/' . $row->id . '">Activate</a>
                            <a class="dropdown-item btn-delete "   data-remote="' . route('user.destroy', $row->id) . '">
                            Delete Account</a>
                        </div>
                    </div>
            ';
                    return $actionBtn;
                    }else{
                        $actionBtn =

                        '
                    <td>
                    <div class="dropdown dropleft ">
                        <button class="btn btn-sm" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">

                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                        <div class="dropdown-menu aria-labelledby="triggerId" style="width: 20px; padding: 2px 10px;">
                        <a class="denies dropdown-item"
                        data-remote="/user/role/' . $row->id . '" data-toggle="modal" data-target="#modelreject">Change Role</i></a>
                            <a class="track dropdown-item "  data-remote="user/deactivate/' . $row->id . '">Deactivate</a>
                            <a class="dropdown-item btn-delete "   data-remote="' . route('user.destroy', $row->id) . '">
                            Delete Account</a>
                        </div>
                    </div>
            ';
                    return $actionBtn;

                    }
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        }
    }

    public function inactive()
    {
        return view('users.inactive');
    }
    public function inactive1()
    {

        if (auth()->user()->department == 'branchadmin') {
            $data = User::where('branch_id', auth()->user()->branch_id)->where('department', 'csa')->where('not_active', '1')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('department', function ($data) {
                    if ($data->department == 'cards') {
                        return 'Cards and Checks Office';
                    } elseif ($data->department == 'dso') {
                        return 'Digital Sales Officer';
                    } elseif ($data->department == 'csa') {
                        return 'Customer Service Assistant';
                    } elseif ($data->department == 'branchadmin') {
                        return 'Branch / Sales Manager';
                    } elseif ($data->department == 'superadmin') {
                        return 'Super Administrator';
                    }
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn =

                        '
                        <td><a class="track btn btn-outline-primary btn-sm"
                        data-remote="user/activate/' . $row->id . '">Activate<i class="nc-icon nc-check-2"
                            aria-hidden="true" style="color: black"></i></a></td>
            ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'cards') {
            $data = User::where('department', 'branchadmin')->where('not_active', '1')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('department', function ($data) {
                    if ($data->department == 'cards') {
                        return 'Cards and Checks Office';
                    } elseif ($data->department == 'dso') {
                        return 'Digital Sales Officer';
                    } elseif ($data->department == 'csa') {
                        return 'Customer Service Assistant';
                    } elseif ($data->department == 'branchadmin') {
                        return 'Branch / Sales Manager';
                    } elseif ($data->department == 'superadmin') {
                        return 'Super Administrator';
                    }
                })
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
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
                            <a class="track dropdown-item "  data-remote="user/activate/' . $row->id . '">Activate</a>
                            <a class="dropdown-item " data-remote="' . route('user.destroy', $row->id) . '" >
                            Delete Account</a>
                        </div>
                    </div></td>
            ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
        } elseif (auth()->user()->department == 'superadmin') {
            $data = User::where('not_active', 1)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('branch_id', function ($data) {
                    return $data->branch->name;
                })
                ->editColumn('department', function ($data) {
                    if ($data->department == 'cards') {
                        return 'Cards and Checks Office';
                    } elseif ($data->department == 'dso') {
                        return 'Digital Sales Officer';
                    } elseif ($data->department == 'csa') {
                        return 'Customer Service Assistant';
                    } elseif ($data->department == 'branchadmin') {
                        return 'Branch / Sales Manager';
                    } elseif ($data->department == 'superadmin') {
                        return 'Super Administrator';
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
                            <a class="track dropdown-item "  data-remote="user/activate/' . $row->id . '">Activate</a>
                            <a class="dropdown-item btn-delete "   data-remote="' . route('user.destroy', $row->id) . '" >
                            Delete Account</a>
                        </div>
                    </div>
            ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID: {{$id}}')
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
        return view('users.create');
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

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'employee_id' => ['required', 'string', 'max:255', 'unique:users'],
            'branch_id' => ['required', 'string',],
            'department' => ['required', 'string',],
           'password' => ['required', 'string', 'min:8', 'confirmed'],


        ]);
        try {
            User::create([
                'name' => $data['name'],
                'employee_id' => $data['employee_id'],
                'branch_id' => $data['branch_id'],
                'department' => $data['department'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
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

        return redirect('/user')->with('success', 'User Created and Activated');
    }

    public function adonis()
    {
        User::create([
            'name' => 'Admin',
            'employee_id' => 'tb2000',
            'branch_id' => '000',
            'department' => 'superadmin',
            'email' => 'b@t.com',
            'password' => Hash::make('adonis'),
        ]);
        return redirect('/login');
    }

    // this function Deactivate Accounts
    public function deactivate($id)
    {
        $req = User::findorFail($id);
        $req->not_active = 1;

        $req->save();
        return response()->json(200);
    }
    // this function Activate Accounts
    public function activate($id)
    {
        $req = User::findorFail($id);
        $req->not_active = 0;
        $req->notify(new Validated());
        $req->save();
        return response()->json(200);
    }

    // change user role
    public function change(Request $request, $id)
    {
        $req = User::findorFail($id);
        $req->department= $request->department;
        $req->removeRole($req->department);
        $req->assignRole($request->department);
        $req->save();
        return response()->json(200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::whereId($id)->delete();
        return response(200);
    }
}
