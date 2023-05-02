<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'login');
        } else {
            $credentials = $request->only('email', 'password');

            $user = User::where('email', $request->email)->first();
            if($user->type == 'USER') {
                return redirect()->back()->with('login', 'Нет доступа!');
            } else {
                if (auth()->attempt($credentials, true)) {
                    return redirect()->intended(route('admin.index'));
                } else {
                    return redirect()->back()->with('login_failed', trans('auth.failed'));
                }
            }
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->away('login');
    }
}
