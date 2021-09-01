<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

    // Socialite Github
    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        // Check if Exists
        $user = User::where('provider_id', $githubUser->getId())->first();

        if (!$user) {
            // Add User to DataBase
            $user = User::create([
                'email' => $githubUser->getEmail(),
                'name' => $githubUser->getName(),
                'provider_id' => $githubUser->getId(),
                'provider' => 'Github',
            ]);
        }
        // Login User with , Remeber Me
        Auth::login($user, true);

        return redirect()->route('home');
    }

    // Socialite Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('provider_id', $googleUser->id)->first();

        if (!$user) {

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider_id' => $googleUser->getId(),
                'provider' => 'Google',
            ]);
        }
        // Login User with , Remeber Me
        Auth::login($user, true);
        return redirect()->route('home');
    }

    // Socialite Facebook
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::where('provider_id', $facebookUser->id)->first();

        if (!$user) {

            $user = User::create([
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'provider_id' => $facebookUser->getId(),
                'provider' => 'Facebook',
            ]);
        }
        // Login User with , Remeber Me
        Auth::login($user, true);
        return redirect()->route('home');
    }
}
