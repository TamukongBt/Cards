<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => Rule ::exists('users')->where(function ($query) {
                $query->where('not_active', 0);
            }),
            'password' => 'required|string'
        ],[
            $this->username() . '.exists' => 'This User is Inactive or the account has been disabled.'
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->employee_id = 'employee_id';
    }

    public function username()
    {
        return 'employee_id';
    }
}
