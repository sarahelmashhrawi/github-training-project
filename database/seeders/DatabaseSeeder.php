<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء حساب المدير العام
        User::updateOrCreate(
            ['email' => 'admin@admin.com'], // الإيميل
            [
                'name' => 'المدير', // الاسم الأول (أو firstname إذا كنتِ مسمياه هيك)
                'lastname' => 'العام', // 👈 هذا هو السطر اللي كان ناقصنا!
                'password' => Hash::make('12345678'), // الباسورد
            ]
        );
    }
}