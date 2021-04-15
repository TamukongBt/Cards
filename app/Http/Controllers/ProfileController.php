<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Notifications\Locationchange;
use App\Notifications\TransferApprove;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $colleagues = User::where('branch_id',auth()->user()->branch_id)->where('name','!=',auth()->user()->name)->get();
        return view('profile.edit')->with('colleagues',$colleagues);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    public function notify(Request $request)
    {
        User::where('id',auth()->user()->id)
                             ->update([
                                     'is_changed' => 1,
                                     'oldbranch' => $request->oldbranch,
                                     'newbranch' => $request->newbranch,

                               ]);

        if (auth()->user()->department == 'branchadmin') {
            $user =User::where('department','cards')->get();

        foreach($user as $card){
            $card->notify(new Locationchange());
        }
        return back()->withStatus(__('Your request has been made to the Cards And Check Office'));
        } else {
            $user =User::where('department','branchadmin')->where('branch_id',$request->newbranch)->get();

            foreach($user as $card){
                $card->notify(new Locationchange());
            }
            return back()->withStatus(__('Your request has been made to the Branch Manager'));
        }



    }

     // this function validates when the request has been confirmed by checks and checks
     public function approve($id)
     {
         $req = User::findorFail($id);
        User::where('id',$id)
        ->update([
                'is_changed' => 0,
                'oldbranch' => $req->branch_id,
                'branch_id' => $req->newbranch,
                'updated_at' => now(),

          ]);

         $req->notify(new TransferApprove());
         return response()->withStatus(__('Transfer Successful.'));
     }

    public function location(Request $request)
    {

        auth()->user()->update(['branch_id' => $request->get('branch_id')]);

        return back()->withStatus(__('Password successfully updated.'));
    }


    public function change()
    {

        if (auth()->user()->department == 'branchadmin'||auth()->user()->department == 'cards') {
        return view('location.index');}
        else{
            Alert::alert('Warning', 'You Do Not Have Access To This Page', 'error');
            return redirect()->back();
        }


    }

    public function change1()
    {

        if (auth()->user()->department == 'branchadmin') {
            $data = User::where('is_changed', '1')->where('newbranch',auth()->user()->branch->branch_code)->get();

            return DataTables::of($data)
            ->addIndexColumn()

            ->editColumn('branch_id', function ($data) {

                return $data->branch->name;
            })
            ->editColumn('oldbranch', function ($data) {
               $branch = Branch::where('branch_code',$data->oldbranch)->first();
            return $branch->name;
            })
            ->editColumn('newbranch', function ($data) {
                $branch = Branch::where('branch_code',$data->newbranch)->first();
                 return $branch->name;
             })

             ->addColumn('action', function ($row) {

                $actionBtn =
                    '
            <td><a class="validates btn btn-outline-primary btn-sm"
                 data-remote="/location/confirm/' . $row->id . '"><i class="nc-icon nc-check-2"
                     aria-hidden="true" style="color: black"></i>Approve</a></td>  ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
                ;

        } else  if (auth()->user()->department == 'cards') {
            $data = User::where('is_changed', '1')->where('department','branchadmin')->get();

            return DataTables::of($data)
            ->addIndexColumn()

            ->editColumn('branch_id', function ($data) {

                return $data->branch->name;
            })
            ->editColumn('oldbranch', function ($data) {
               $branch = Branch::where('branch_code',$data->oldbranch)->first();
            return $branch->name;
            })
            ->editColumn('newbranch', function ($data) {
                $branch = Branch::where('branch_code',$data->newbranch)->first();
                 return $branch->name;
             })

             ->addColumn('action', function ($row) {

                $actionBtn =
                    '
            <td><a class="validates btn btn-outline-primary btn-sm"
                 data-remote="/location/confirm/' . $row->id . '"><i class="nc-icon nc-check-2"
                     aria-hidden="true" style="color: black"></i>Approve</a></td>  ';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
                ;

        } else {
            Alert::alert('Warning', 'You Do Not Have Access To This Page', 'error');
            return redirect()->back();
        }



    }

}
