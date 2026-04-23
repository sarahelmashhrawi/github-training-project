@extends('cms.parent')

@section('title', 'معرض الصور - إدارة المخيمات')

@section('styles')
    <style>
        .gallery-title { position: absolute; bottom: 0; background: rgba(0,0,0,0.7); color: #fff; width: 100%; padding: 10px; text-align: center; font-weight: bold; }
        .img-wrapper { position: relative; overflow: hidden; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 6px 12px rgba(0,0,0,0.15); transition: 0.3s; }
        .img-wrapper:hover { transform: scale(1.02); }
        .img-wrapper img { width: 100%; height: 250px; object-fit: cover; }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>معرض صور المخيمات</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                
              
 <div class="col-lg-4 col-md-6">
                    <div class="img-wrapper">
                        <img src="{{ asset('images/food_distribution.png') }}"  alt="تكية">
                        <div class="gallery-title"> توزيع الطعام (تكية )</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="img-wrapper">
                        <img src="{{ asset('images/يوم ترفيهي.png') }}"  alt="أطفال">
                        <div class="gallery-title">أطفال في بيئة المخيم</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="img-wrapper">
                        <img src="{{ asset('images/خيمة تعليمية.png') }}"  alt="خيمة تعليمية">
                        <div class="gallery-title">المرافق التعليمية (خيمة تعليمية)</div>
                    </div>
                </div>

                <!-- <div class="col-lg-4 col-md-6">
                    <div class="img-wrapper">
                        <img src="https://images.unsplash.com/photo-1584982205569-42b71941e17d?q=80&w=600" alt="عيادة">
                        <div class="gallery-title">العيادة الطبية الميدانية</div>
                    </div>
                </div> -->

                <div class="col-lg-4 col-md-6">
                    <div class="img-wrapper">
                        <img src="{{ asset('images/توزيع مساعدات .png') }}" alt="مساعدات">
                        <div class="gallery-title">نقطة توزيع المساعدات</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="img-wrapper">
                        <img src="{{ asset('images/slider-3.jpg') }}"  alt="مرافق">
                        <div class="gallery-title">مرافق عامة وممرات المخيم</div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection