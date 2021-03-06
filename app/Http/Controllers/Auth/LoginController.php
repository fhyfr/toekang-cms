<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // return home after login
        return redirect()->route('home');
    }

    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);

        // return home after login
        return redirect()->route('home');
    }

    // Github
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // return home after login
        return redirect()->route('home');
    }

    // LinkedIn
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedinCallback()
    {
        $user = Socialite::driver('linkedin')->user();

        $this->_registerOrLoginUser($user);

        // return home after login
        return redirect()->route('home');
    }

    // Yahoo
    public function redirectToYahoo()
    {
        return Socialite::driver('yahoo')->redirect();
    }

    public function handleYahooCallback()
    {
        $user = Socialite::driver('yahoo')->user();

        $this->_registerOrLoginUser($user);

        // return home after login
        return redirect()->route('home');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();

        if(!$user)
        {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }
}
