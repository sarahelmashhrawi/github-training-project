@extends('cms.parent')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/families/create.css') }}">
@endsection

@section('content')
<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
<div class="col-12 col-lg-10">            
    <div class="card custom-card">
                <div class="card-header custom-card-header text-center">
                    <h3 class="mb-0 font-weight-bold"><i class="fas fa-users mr-2"></i> تسجيل عائلة جديدة في المخيم</h3>
                </div>
                
                <div class="card-body p-4 text-right">
                    <form id="create_form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">الخيمة المخصصة</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tent"></i></span>
                                    </div>
                                    <select id="tent_id" class="form-control custom-input">
                                        <option value="">-- اختر رقم الخيمة --</option>
                                        @foreach($tents as $tent)
                                            <option value="{{ $tent->id }}">خيمة {{ $tent->tent_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">تصنيف العائلة</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                    </div>
                                    <select id="family_type" class="form-control custom-input">
                                        <option value="normal">عائلة طبيعية</option>
                                        <option value="female_headed">تعيلها امرأة</option>
                                        <option value="orphans">أيتام</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">اسم رب / ربة الأسرة</label>
                            <div class="input-group custom-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                </div>
                                <input type="text" id="head_name" class="form-control custom-input" placeholder="الاسم الرباعي">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">تاريخ الميلاد</label>
                            <div class="input-group custom-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="dob" class="form-control custom-input">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الحالة الاجتماعية لرب الأسرة</label>
                            <select id="marital_status" class="form-control custom-input" style="border-radius: 12px !important;">
                                <option value="">اختر الحالة...</option>
                                <option value="متزوج">متزوج / متزوجة</option>
                                <option value="أعزب">أعزب / عزباء</option>
                                <option value="أرمل">أرمل / أرملة</option>
                                <option value="مطلق">مطلق / مطلقة</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label">رقم الهوية</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" id="id_number" class="form-control custom-input" placeholder="رقم الهوية">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <label class="form-label">رقم الجوال</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" id="phone" class="form-control custom-input" placeholder="05xxxxxxxxx">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label">المنطقة الأصلية</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                    </div>
                                    <input type="text" id="original_area" class="form-control custom-input" placeholder="مثال: غزة - الرمال">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">المنطقة الحالية</label>
                            <div class="input-group custom-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                </div>
                                <input type="text" id="current_area" class="form-control custom-input" placeholder="مثال: دير البلح - المواصي">
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="button" onclick="storeFamily()" class="btn btn-success px-5 py-2 shadow-sm" style="border-radius: 8px; font-size: 16px; font-weight: bold;">
                                <i class="fas fa-save mr-1"></i> حفظ بيانات العائلة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function storeFamily() {
        let formData = new FormData(); 
        
        formData.append('tent_id', document.getElementById('tent_id').value);
        formData.append('family_type', document.getElementById('family_type').value);
        formData.append('head_name', document.getElementById('head_name').value);
        formData.append('dob', document.getElementById('dob').value);
        formData.append('marital_status', document.getElementById('marital_status').value);
        formData.append('id_number', document.getElementById('id_number').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('original_area', document.getElementById('original_area').value);
        formData.append('current_area', document.getElementById('current_area').value);

        // 2. من الأفضل استخدام دالة route الخاصة بـ Laravel كما في الكود الأول لضمان صحة الرابط
performStore(`{{ route('families.store') }}`, formData);    }
</script> 
@endsection