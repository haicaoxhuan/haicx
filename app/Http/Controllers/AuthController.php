<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\PasswordRequest;

class AuthController extends Controller
{
  


    /**
     * user register
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function register()
    {
        return view('user/register');
    }

    /**
     * register_action
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerAction(RegisterRequest $request)
    {

        $user = new User([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'fist_name' => $request->fist_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'status' => STATUS_ACTIVE,
            'reset_password' => Hash::make($request->password_confirm),
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        return redirect()->route('login');
    }

    /**
     * user login
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login()
    {
        return view('user/login');
    }

    /**
     * login_action user
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAction(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->to('home');
        } else {
            return redirect()->to('/login')->with('error', 'Đăng nhập thất bại');
        }
    }

    /**
     * user password
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function password()
    {
        return view('user/password');
    }

    /**
     * password_action user
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordAction(PasswordRequest $request)
    {

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return redirect()->to('/')->with('success', 'Password changed!');
    }

    /**
     * user logout
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
