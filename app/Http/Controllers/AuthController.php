<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController 
{
    // 1. عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        // إذا كان مسجل دخول أصلاً، بنحوله للوحة التحكم مباشرة
        if (Auth::check()) {
            return redirect()->route('dashboard'); 
        }
        return view('auth.login');
    }

    // 2. التحقق من البيانات وتسجيل الدخول
    public function login(Request $request)
    {
        // التحقق من الحقول
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'password.required' => 'يرجى إدخال كلمة المرور.'
        ]);

        // محاولة الدخول
        // دالة attempt تقارن كلمة المرور المدخلة مع الهاش (Bcrypt) المخزن في قاعدة البيانات تلقائياً
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // حماية من هجمات Session Fixation
            $request->session()->regenerate(); 
            
            // تحويله للمكان الذي كان يحاول الوصول إليه أو للداشبورد كخيار افتراضي
            return redirect()->intended(route('dashboard'));
        }

        // إذا البيانات خطأ، نرجعه مع رسالة تنبيه
        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    // 3. تسجيل الخروج
    public function logout(Request $request)
{
    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // التوجيه لصفحة الـ Welcome الأساسية (التي تفتح أول ما نفتح المشروع)
    return redirect('/'); 
}
}
