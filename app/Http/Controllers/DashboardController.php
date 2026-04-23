<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Individual;
use App\Models\Tent;
use App\Models\Family;
use App\Models\Sector;   
use App\Models\Campaign; 
use Carbon\Carbon;

class DashboardController extends BaseController
{
    public function index()
    {
        // 1. الإحصائيات العامة للمربعات العلوية
        $individualsCount = Individual::count() + Family::count();
        $tentsCount = Tent::count();
        $familiesCount = Family::count();
        
        // إحصائيات جديدة
        $sectorsCount = Sector::count();    // حساب المناطق
        $campaignsCount = Campaign::count(); // حساب المساعدات (الحملات)

        // سنوات الفصل (بناءً على سنة 2026)
        $currentYear = 2026; 
        $childYearLimit = $currentYear - 18; // 2008
        $elderYearLimit = $currentYear - 60; // 1966

        // 2. تصنيف الفئات السكنية
        // أطفال: (من جدول الأفراد فقط)
        $childrenCount = Individual::whereYear('dob', '>', $childYearLimit)->count();

        // شباب (ذكور)
        $youthIndividuals = Individual::whereYear('dob', '>', $elderYearLimit)
                                    ->whereYear('dob', '<=', $childYearLimit)
                                    ->where('gender', 'male')->count();
        
        $youthHeads = Family::whereYear('dob', '>', $elderYearLimit)
                            ->whereYear('dob', '<=', $childYearLimit)->count(); 
        
        $youthCount = $youthIndividuals + $youthHeads;

        // نساء (إناث)
        $womenCount = Individual::whereYear('dob', '>', $elderYearLimit)
                                    ->whereYear('dob', '<=', $childYearLimit)
                                    ->where('gender', 'female')->count();

        // مسنين
        $eldersIndividuals = Individual::whereYear('dob', '<=', $elderYearLimit)->count();
        $eldersHeads = Family::whereYear('dob', '<=', $elderYearLimit)->count();
        
        $eldersCount = $eldersIndividuals + $eldersHeads;

        // إرجاع البيانات للملف (تم إضافة المتغيرات الجديدة هنا)
        return view('index', compact(
            'individualsCount', 'tentsCount', 'familiesCount', 
            'childrenCount', 'youthCount', 'womenCount', 'eldersCount',
            'sectorsCount', 'campaignsCount' 
        ));
    }
}