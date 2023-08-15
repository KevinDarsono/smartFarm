<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function loginCheck(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard');
            }else{
                return redirect()->route('home');
            }
        }
        return redirect()->back()->with('error', 'Email or Password is incorrect');
    }

    public function registerCheck(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);
        try{
           User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password)
           ]);
            return redirect()->route('auth.login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
