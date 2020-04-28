<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Carbon\Carbon;
use Modules\User\Entities\User;

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
  * Where to redirect users after login / registration.
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
    $this->middleware('guest', ['except' => 'logout']);
  }

  public function redirectToProviderGoogle()
  {
    return Socialite::driver('google')->redirect();
  }

  public function redirectToProviderFacebook()
  {
    return Socialite::driver('facebook')->redirect();
  }

  /**
  * Obtain the user information from Google.
  *
  * @return \Illuminate\Http\Response
  */
  public function handleProviderCallbackGoogle()
  {
    try {
      $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
      return redirect('/login');
    }

    $existingUser = User::where('email', $user->email)->first();
    if($existingUser){
      $existingUser->google_id       = $user->id;
      $existingUser->photo          = $user->avatar;
      $existingUser->save();
      // log them in
      auth()->login($existingUser, true);
    } else {
      // create a new user
      $newUser                  = new User;
      $newUser->nome            = $user->name;
      $newUser->email           = $user->email;
      $newUser->google_id       = $user->id;
      $newUser->email_verified_at = Carbon::now();
      $newUser->photo          = $user->avatar;
      // $newUser->avatar_original = $user->avatar_original;
      $newUser->save();
      auth()->login($newUser, true);
    }
    return redirect()->to('/home');
  }

  public function handleProviderCallbackFacebook()
  {
    try {
      $user = Socialite::driver('facebook')->user();
    } catch (\Exception $e) {
      return redirect('/login');
    }

    $existingUser = User::where('email', $user->email)->first();
    if($existingUser){
      $existingUser->facebook_id       = $user->id;
      $existingUser->photo          = $user->avatar;
      $existingUser->save();
      // log them in
      auth()->login($existingUser, true);
    } else {
      // create a new user
      $newUser                  = new User;
      $newUser->nome            = $user->name;
      $newUser->email           = $user->email;
      $newUser->facebook_id       = $user->id;
      $newUser->email_verified_at = Carbon::now();
      $newUser->photo          = $user->avatar;
      $newUser->save();
      auth()->login($newUser, true);
    }
    return redirect()->to('/home');
  }
}
