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
        // 1. التحقق من البيانات (غيرنا الاسم لـ profile_image ليتطابق مع الـ JS)
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. جلب المستخدم 
        $user = User::find(Auth::id());

        // 3. معالجة وحفظ الصورة
        if ($request->hasFile('profile_image')) {
            // حذف الصورة القديمة إذا موجودة
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // حفظ الصورة الجديدة في مجلد storage/app/public/avatars
            $path = $request->file('profile_image')->store('avatars', 'public');
            
            // تحديث قاعدة البيانات
            $user->update([
                'avatar' => $path
            ]);

            // 4. إرجاع استجابة JSON بدلاً من back() لكي يفهمها كود الـ JS وتظهر السويت أليت
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الصورة الشخصية بنجاح! 🖼️'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الرفع'], 400);
 
        }

public function deleteAvatar()
    {
        $user = User::find(Auth::id());

        if ($user->avatar) {
            // حذف الصورة القديمة من مجلد storage
            Storage::disk('public')->delete($user->avatar);
            
            // تفريغ الحقل في قاعدة البيانات
            $user->update([
                'avatar' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصورة بنجاح'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'لا توجد صورة لحذفها'], 400);
    }
        }
