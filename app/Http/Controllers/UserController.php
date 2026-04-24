<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController 
{
    // 1. تحديث الصورة الشخصية
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find(Auth::id());

        if ($request->hasFile('profile_image')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('profile_image')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث الصورة بنجاح!']);
    }

    // 2. تحديث البيانات الشخصية
    public function updateProfile(Request $request)
{
    // 1. التحقق من البيانات
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
    ]);

    // 2. جلب المستخدم الحالي 
    $user = Auth::user(); 

    // 3. تحديث القيم
    $user->name = $request->name;
    $user->email = $request->email;

    // 4. استدعاء أمر الحفظ الرسمي
    $isSaved = $user->save();

    // 5. الرجوع مع رسالة نجاح
    if ($isSaved) {
        return back()->with('success', 'تم تحديث بيانات الملف الشخصي بنجاح');
    } else {
        return back()->withErrors('حدث خطأ أثناء محاولة الحفظ');
    }
}
    // 3. تحديث كلمة المرور
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
    }

    // 4. حذف الصورة الشخصية
    public function deleteAvatar()
    {
        $user = User::find(Auth::id());
        if ($user && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        }
        return response()->json(['success' => false, 'message' => 'لا توجد صورة لحذفها'], 400);
    }
    public function create() 
{
    // وظيفة هذه الدالة فقط فتح الواجهة
    return view('Admins.create'); 
}

public function store(Request $request) 
{
    // 1. التأكد من البيانات
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    // 2. حفظ المشرف في قاعدة البيانات
    $user = new \App\Models\User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
    $user->save();

    // 3. الرجوع لصفحة الإضافة مع رسالة نجاح
    return back()->with('success', 'تم إضافة المشرف بنجاح!');
}
}