<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class LoginController extends Controller
{
    protected string $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return View|Factory|Application
     */
    public function showLoginForm(): View|Factory|Application
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            return redirect()->intended($this->redirectTo);
        }

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
