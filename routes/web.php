<?php

use Illuminate\Support\Facades\Route;

// استدعاء جميع المتحكمات والموديلات
use App\Http\Controllers\SectorController;
use App\Http\Controllers\TentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\EmergencyNeedController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Models\Individual;
use App\Models\Tent;
use App\Models\Family;

Route::get('/', function () {
    return view('welcome');
});

// ================= مسارات تسجيل الدخول (مفتوحة للكل) =================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// ================= مسارات النظام (محمية بقفل auth) =================
Route::middleware('auth')->group(function () {
    
    // مسار لوحة التحكم
    Route::get('/dashboard', function () {
        $individualsCount = Individual::count();
        $tentsCount = Tent::count();
        $familiesCount = Family::count();

        return view('dashboard', compact('individualsCount', 'tentsCount', 'familiesCount'));
    })->name('dashboard');

    // مسار تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 🚀 مسارات إدارة المخيم (كلها محمية وجاهزة للاستخدام)
    Route::resource('sectors', SectorController::class);
    Route::resource('tents', TentController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('individuals', IndividualController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::resource('receivings', ReceivingController::class);
    Route::resource('emergency-needs', EmergencyNeedController::class);
    Route::resource('inventories', InventoryController::class);
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });