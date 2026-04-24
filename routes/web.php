<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SectorController;
use App\Http\Controllers\TentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\EmergencyNeedController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;

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

    // لوحة التحكم (باستخدام الكنترولر فقط)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // الموارد (Resources) - تم ضبط أسماء المسارات لتطابق ما تستخدمه في صفحات الـ Blade
    Route::resource('tents', TentController::class);
    Route::resource('families', FamilyController::class);
    Route::resource('individuals', IndividualController::class);
    Route::resource('campaigns', CampaignController::class);
    Route::resource('receivings', ReceivingController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('camps', CampController::class);
    Route::resource('sectors', SectorController::class);

    // تعريف مسارات emergency-needs مع تحديد الأسماء (Names) لتعمل مع ملفات الـ Blade تلقائياً
    Route::resource('emergency-needs', EmergencyNeedController::class)->names([
        'index' => 'emergency_needs.index',
        'create' => 'emergency_needs.create',
        'store' => 'emergency_needs.store',
        'show' => 'emergency_needs.show',
        'edit' => 'emergency_needs.edit',
        'update' => 'emergency_needs.update',
        'destroy' => 'emergency_needs.destroy',
    ]);

    // مسارات إضافية خاصة بالمستخدم والملفات
    
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/update-avatar', [UserController::class, 'updateAvatar']);
    // Route::post('/individuals_update/{id}', [IndividualController::class, 'update'])->name('individuals_update');
// Route::post('/individuals_update/{individual}', [IndividualController::class, 'update'])->name('individuals_update');
Route::put('/individuals_update/{id}', [IndividualController::class, 'update'])->name('individuals_update');   
Route::delete('/delete-avatar', [UserController::class, 'deleteAvatar']);
    
    // مسارات مخصصة
    Route::get('/individuals-edit/{id}', [IndividualController::class, 'edit'])->name('individuals.edit');
    Route::get('sectors/trashed', [SectorController::class, 'trashed'])->name('sectors-trashed');
    Route::get('sectors-restore/{id}', [SectorController::class, 'restore'])->name('sectors-force');
    Route::get('sectors-force/{id}', [SectorController::class, 'restore'])->name('sectors-restore');
    Route::get('cms/gallery', [GalleryController::class, 'index']);
    Route::put('/emergency-needs/{id}', [EmergencyNeedController::class, 'update'])->name('emergency-needs.update');
});