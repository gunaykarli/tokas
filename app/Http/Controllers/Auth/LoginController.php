<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Office;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // In order to login with user_name we override the username() function which exist in
    // "vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php"
    public function username()
    {
        return 'user_name';
    }

    /**
     * * Overridden...vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
     * Get the needed authorization credentials from the request */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['status'] = 'on';

        return $credentials;
    }

    /**
     * Overridden...vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // if the office where the user works is not active then user can not log in.
        if(Office::where('id', User::where('user_name', $request->user_name)->first()->office_id)->first()->status === "on"){
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        }
        else
            return $this->sendFailedLoginResponse($request);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

}
