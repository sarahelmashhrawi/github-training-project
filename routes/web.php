<?php

use Illuminate\Support\Facades\Route;

// استدعاء جميع المتحكمات التي قمنا بإنشائها
use App\Http\Controllers\SectorController;
use App\Http\Controllers\TentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\EmergencyNeedController;
use App\Http\Controllers\InventoryController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('sectors', SectorController::class);
Route::resource('tents', TentController::class);
Route::resource('families', FamilyController::class);
Route::resource('individuals', IndividualController::class);
Route::resource('campaigns', CampaignController::class);
Route::resource('receivings', ReceivingController::class);
Route::resource('emergency-needs', EmergencyNeedController::class);
Route::resource('inventories', InventoryController::class);

