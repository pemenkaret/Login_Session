<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);
    
        // Proses login
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard'); 
        }
    
        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

 
        // Auth::login($user);

        return redirect()->route('login'); //dashboard jika ingin login otomatis
    }

    public function logout()
    {
        //logout
        Auth::logout(); //menghapus sesi pengguna yang sedang aktif dan mengarahkan pengguna kembali ke halaman login.
        return redirect('login');
    }
}
