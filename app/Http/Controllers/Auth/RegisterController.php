<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }
    
    public function register(Request $request)
    {
        // Validation logic here...
    
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->level = "belumverifikasi";
        $user->save();
    
        // Authentication logic here...
    
        return redirect('/login');
    }
}
