@extends('cms.parent')

@section('title', 'إضافة خيمة جديدة')

@section('styles')
<style>
    .custom-card { border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 4px solid #198754; }
    .form-label { font-weight: bold; color: #333; margin-bottom: 8px; }
    
    .form-control, .form-select { 
        height: 48px; 
        border-radius: 10px !important; 
        border: 1px solid #ced4da; 
    }
    
    .input-group-text { border-radius: 10px 0 0 10px !important; background: #f8f9fa; }
    .input-group .form-control { border-radius: 0 10px 10px 0 !important; }
    
    .btn-save { background-color: #198754; color: white; padding: 12px; border-radius: 10px; font-weight: bold; width: 100%; border: none; }
    .btn-save:hover { background-color: #157347; color: white; }
</style>
@endsection
@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card custom-card p-4">
                <h3 class="mb-4 text-success fw-bold"><i class="fas fa-tent me-2"></i> إضافة خيمة جديدة</h3>
                
                {{-- تم تعديل الـ onsubmit لاستدعاء دالة performStore الموجودة في ملف الـ crud الخاص بك --}}
                <form id="create-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">المنطقة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <select name="sector_id" class="form-control" required>
                                    <option value="">-- اختر المنطقة --</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الخيمة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                <input type="text" name="tent_number" class="form-control" placeholder="مثال: T-10" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">عدد الأفراد</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                <input type="number" name="capacity" class="form-control" value="4" required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">حالة الخيمة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                <select name="condition" class="form-control" required>
                                    <option value="good">ممتازة</option>
                                    <option value="worn">مهترئة</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- الزر الآن يستدعي دالة JavaScript مباشرة --}}
                    <button type="button" onclick="sendData()" class="btn btn-save">
                        <i class="fas fa-save me-1"></i> حفظ بيانات الخيمة
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function sendData() {
        let formData = new FormData(document.getElementById('create-form'));
        
        performStore('/tents', formData);
    }
</script>
@endsection