@extends('cms.parent')

@section('title', 'إضافة مخيم')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/families/families.css') }}">
@endsection

@section('content')
<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">            
            <div class="card custom-card">
                <div class="card-header custom-card-header text-center">
                    <h3 class="mb-0 font-weight-bold"><i class="fas fa-campground mr-2"></i> تعريف مخيم جديد</h3>
                </div>
                
                <div class="card-body p-4 text-right">
                    <form id="create_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">رقم المخيم (كود)</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    </div>
                                    <input type="text" id="camp_number" class="form-control custom-input" placeholder="مثال: CAMP-001">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">اسم المخيم</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                    </div>
                                    <input type="text" id="name" class="form-control custom-input" placeholder="اسم المخيم">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">القطاع التابع له</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-chart-pie"></i></span>
                                    </div>
                                    <select id="sector_id" class="form-control custom-input">
                                        <option value="">-- اختر القطاع --</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">حالة المخيم</label>
                                <div class="input-group custom-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <select id="status" class="form-control custom-input">
                                        <option value="active">نشط</option>
                                        <option value="full">ممتلئ</option>
                                        <option value="under_construction">تحت الإنشاء</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">الموقع الجغرافي</label>
                            <div class="input-group custom-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                </div>
                                <input type="text" id="location" class="form-control custom-input" placeholder="مثال: جنوب رفح - بالقرب من المستشفى">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">السعة القصوى (عدد الخيام)</label>
                            <div class="input-group custom-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
                                </div>
                                <input type="number" id="max_capacity" class="form-control custom-input" placeholder="0">
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="button" onclick="storeCamp()" class="btn btn-success px-5 py-2 shadow-sm" style="border-radius: 8px; font-size: 16px; font-weight: bold;">
                                <i class="fas fa-save mr-1"></i> حفظ بيانات المخيم
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
    function storeCamp() {
        let formData = new FormData(); 
        formData.append('camp_number', document.getElementById('camp_number').value);
        formData.append('name', document.getElementById('name').value);
        formData.append('sector_id', document.getElementById('sector_id').value);
        formData.append('status', document.getElementById('status').value);
        formData.append('location', document.getElementById('location').value);
        formData.append('max_capacity', document.getElementById('max_capacity').value);

        performStore(`{{ route('camps.store') }}`, formData);
        
    }
</script>
@endsection