<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $loginUrl = 'admin/login';

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }



    public function getLoginScreen(){
        return view('admin.login');
    }

    public function logout(){
        while(Auth::check()){
            Auth::logout();
        }

        return redirect('admin/login');
    }

    public function processLogin(Request $request){
        $this->validate($request, [
           'username' => 'required|exists:users,username',
            'password' => 'required|min:5'
        ]);


        $username = e($request->input('username'));
        $password = e($request->input('password'));

        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        if(Auth::attempt($credentials)){
            return redirect()->intended('admin/dashboard');
        }

        return back()->with('failure', 'Something went wrong. Please try again.');
    }
}
