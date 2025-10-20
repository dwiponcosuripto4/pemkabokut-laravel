<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
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

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate captcha first
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

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'unit' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'captcha' => ['required', 'numeric'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'unit' => $request->unit,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_verified' => false,
        ]);

        event(new Registered($user));
        
        // Clear captcha from session after successful registration
        session()->forget(['captcha_question', 'captcha_answer']);
        
        // Jangan login otomatis jika belum diverifikasi
        return redirect()->route('login')->with('status', 'Akun Anda menunggu verifikasi admin.');
    }
}
