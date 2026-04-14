@extends('cms.parent')

@section('title', 'إضافة منطقة جديدة')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/sectors/create.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h3 class="card-title mb-0 fw-bold"><i class="fas fa-map-marked-alt me-2"></i> إضافة منطقة جديدة</h3>
        </div>
        
        <div class="card-body p-4 text-dark">
            <form id="create-form">
                @csrf
                
                <div class="mb-3 text-start">
                    <label class="form-label fw-bold text-dark">اسم المحافظة/المنطقة</label>
                    <select id="name" class="form-select shadow-sm text-dark bg-white" required>
                        <option value="" disabled selected>-- اختر المنطقة --</option>
                        <option value="محافظة شمال غزة">محافظة شمال غزة</option>
                        <option value="محافظة غزة">محافظة غزة</option>
                        <option value="المحافظة الوسطى">المحافظة الوسطى</option>
                        <option value="محافظة خانيونس">محافظة خانيونس</option>
                        <option value="محافظة رفح">محافظة رفح</option>
                    </select>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label fw-bold text-dark">العنوان أو الوصف</label>
                    <textarea id="description" class="form-control shadow-sm text-dark bg-white" rows="3" placeholder="اكتب العنوان بالتفصيل أو أقرب معلم"></textarea>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label fw-bold text-dark">المشرف المسؤول</label>
                    <select id="supervisor_id" class="form-select shadow-sm text-dark bg-white">
                        <option value="">-- اختر مشرفاً من القائمة --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - ({{ $user->phone ?? 'لا يوجد رقم' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 text-start">
                    <button type="button" onclick="storeSector()" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> حفظ البيانات
                    </button>
                    <a href="{{ route('sectors.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function storeSector() {
        let formData = new FormData(); 
        
        formData.append('name', document.getElementById('name').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('supervisor_id', document.getElementById('supervisor_id').value);

        let url = "{{ route('sectors.store') }}"; 
        
        performStore(url, formData); 
    }
</script>
@endsection