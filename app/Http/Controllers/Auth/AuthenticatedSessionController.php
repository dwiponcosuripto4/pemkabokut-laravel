<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Generate simple math captcha
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $answer = $num1 + $num2;
        
        session([
            'captcha_question' => "$num1 + $num2",
            'captcha_answer' => $answer
        ]);

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate simple captcha
        $userAnswer = $request->input('captcha');
        $correctAnswer = session('captcha_answer');
        
        if ($userAnswer != $correctAnswer) {
            // Generate new captcha for retry
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            $answer = $num1 + $num2;
            
            session([
                'captcha_question' => "$num1 + $num2",
                'captcha_answer' => $answer
            ]);
            
            return back()->withErrors([
                'captcha' => 'Captcha salah. Silakan coba lagi.'
            ])->withInput();
        }

        $request->authenticate();

        $request->session()->regenerate();
        
        // Clear captcha from session after successful login
        session()->forget(['captcha_question', 'captcha_answer']);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
