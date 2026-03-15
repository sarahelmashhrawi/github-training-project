<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController
{
   // 1. عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        // إذا كان مسجل دخول أصلاً، بنحوله للوحة التحكم مباشرة عشان ما يرجع يسجل
        if (Auth::check()) {
            return redirect()->route('dashboard'); 
        }
        return view('auth.login'); // هاي الشاشة اللي صممناها قبل شوي
    }

    // 2. التحقق من البيانات وتسجيل الدخول
    public function login(Request $request)
    {
        // التحقق من الحقول
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'password.required' => 'يرجى إدخال كلمة المرور.'
        ]);

        // محاولة الدخول
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate(); // حماية إضافية (Session Fixation)
            
            // تحويله للوحة التحكم
            return redirect()->intended('dashboard');
        }

        // إذا الإيميل أو الباسورد غلط، بنرجعه لصفحة الدخول مع رسالة خطأ
        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    // 3. تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        
        // تنظيف الجلسة للحماية
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}