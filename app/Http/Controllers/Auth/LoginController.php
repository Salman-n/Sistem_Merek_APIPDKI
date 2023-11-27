<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Attempt to authenticate the user with "Remember Me"
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            // The user has been authenticated

            // Check if "Remember Me" is selected
            if ($request->filled('remember')) {
                // Remember the user using cookies
                Cookie::queue('useremail', $request->email, 1440);
                Cookie::queue('userpwd', $request->password, 1440);
            }

            // Get the authenticated user object
            $user = Auth::user();

            // Handle different user levels
            if ($user->level == "belumverifikasi") {
                // Logout the user
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors(["email" => 'Akun anda belum diverifikasi, silahkan hubungi admin']);
            } else if ($user->level == "ditolak") {
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors(["email" => 'Maaf. anda tidak dapat menggunakan situs ini karena proses verifikasi ditolak, silahkan hubungi admin']);
            } else if ($user->level == "admin") {
                Auth::guard('web')->logout();
                return redirect()->back()->withErrors(["email" => 'Silahkan login lewat login khusus admin']);
            }

            // Redirect to the intended page
            return $this->sendLoginResponse($request);
        }

        // Authentication failed, add a custom error message
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        // Forget "Remember Me" cookies
        Cookie::queue(Cookie::forget('useremail'));
        Cookie::queue(Cookie::forget('userpwd'));

        // Logout using the default behavior
        $this->guard()->logout();
        $request->session()->invalidate();

        // Redirect the user after logout
        return $this->loggedOut($request) ?: redirect('/');
    }
}
