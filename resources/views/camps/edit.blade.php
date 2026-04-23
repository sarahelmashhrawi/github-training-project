@extends('cms.parent')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/camps.css') }}"> 

@section('content')
<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card custom-card">
                <div class="card-header custom-card-header text-center">
                    <h3 class="mb-0 font-weight-bold"><i class="fas fa-edit mr-2"></i>تعديل بيانات المخيم</h3>
                </div>

                <div class="card-body p-4 text-right">
                    <form id="update_form" action="{{ route('camps.update', $camp->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- رقم المخيم --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">رقم المخيم</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input type="text" name="camp_number" value="{{ old('camp_number', $camp->camp_number) }}" 
                                           class="form-control" placeholder="مثلاً: CAMP-100">
                                </div>
                            </div>

                            {{-- اسم المخيم --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">اسم المخيم</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-campground"></i></span>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $camp->name) }}" 
                                           class="form-control" placeholder="اسم المخيم">
                                </div>
                            </div>

                            {{-- الموقع --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">الموقع الجغرافي</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" name="location" value="{{ old('location', $camp->location) }}" 
                                           class="form-control" placeholder="رابط خرائط أو وصف الموقع">
                                </div>
                            </div>

                            {{-- السعة القصوى --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">السعة القصوى (خيمة)</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    </div>
                                    <input type="number" name="max_capacity" value="{{ old('max_capacity', $camp->max_capacity) }}" 
                                           class="form-control">
                                </div>
                            </div>

                            {{-- الحالة --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">حالة المخيم</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <select name="status" class="form-control custom-select">
                                        <option value="active" {{ $camp->status == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="full" {{ $camp->status == 'full' ? 'selected' : '' }}>ممتلئ</option>
                                        <option value="under_construction" {{ $camp->status == 'under_construction' ? 'selected' : '' }}>قيد التجهيز</option>
                                    </select>
                                </div>
                            </div>

                            {{-- القطاع --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">القطاع</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-chart-pie"></i></span>
                                    </div>
                                    <select name="sector_id" class="form-control custom-select">
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}" {{ $camp->sector_id == $sector->id ? 'selected' : '' }}>
                                                {{ $sector->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- المساعدات المطلوبة --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">المساعدات المطلوبة</label>
                                <textarea name="needed_aid" class="form-control" rows="3" placeholder="اكتب الاحتياجات هنا...">{{ old('needed_aid', $camp->needed_aid) }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 mt-3">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-save mr-2"></i>حفظ التغييرات
                            </button>
                            <a href="{{ route('camps.index') }}" class="btn btn-light btn-lg px-5">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
