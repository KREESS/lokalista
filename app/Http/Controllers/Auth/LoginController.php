<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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

    public function login(Request $request)
{
    $input = $request->all();

    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Cek apakah email ada
    $user = \App\Models\User::where('email', $input['email'])->first();

    if ($user) {
        if (!$user->is_active) {
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.');
        }

        // Login jika aktif
        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (auth()->user()->type == 'super admin') {
                return redirect()->route('superadmin.dashboard');
            } elseif (auth()->user()->type == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        }
    }

    return redirect()->route('login')
        ->with('error', 'Email atau Password Salah, Mohon Coba Lagi.');
}

}
