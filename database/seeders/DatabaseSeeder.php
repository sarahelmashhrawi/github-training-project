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
                'name' => 'المدير', 
                'password' => Hash::make('12345678'), 
            ]
        );

User::create([
    'name' => 'Hind Rakha',
    'email' => 'hind@admin.com',
    'password' => Hash::make('12345678'), // ضروري جداً استخدام Hash::make
]);
    
    User::create([
    'name' => 'Sara AL_mashharawi',
    'email' => 'sara@admin.com',
    'password' => Hash::make('12345678'), 
]);
    }
}