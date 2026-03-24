<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class UserController
{
    public function updateAvatar(Request $request)
    {
        // 1. التحقق من البيانات
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. جلب المستخدم 
        $user = User::find(Auth::id());

        // 3. معالجة وحفظ الصورة
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا موجودة
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // حفظ الصورة الجديدة
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // تحديث قاعدة البيانات
            $user->update([
                'avatar' => $path
            ]);
        }

        // 4. إعادة المستخدم للصفحة مع رسالة نجاح
        return back()->with('success', 'تم تحديث الصورة الشخصية بنجاح! 🖼️');
    }
}