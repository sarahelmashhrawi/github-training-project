@extends('cms.parent')

@section('title', '⚙️ تعديل بيانات المنطقة')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/sectors/edit.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-dark text-center">
                    <h3 class="mb-0 fw-bold">⚙️ تعديل بيانات المنطقة</h3>
                    <small>أنتِ الآن تعدلين: <strong>{{ $sector->name }}</strong></small>
                </div>
                
                <div class="card-body p-4 text-start text-dark">
                    <form id="editSectorForm">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">اسم المنطقة</label>
                            <select id="sectorName" class="form-select text-dark bg-white" required>
                                <option value="" disabled>-- اختاري المنطقة --</option>
                                <option value="محافظة شمال غزة" {{ $sector->name == 'محافظة شمال غزة' ? 'selected' : '' }}>محافظة شمال غزة</option>
                                <option value="محافظة غزة" {{ $sector->name == 'محافظة غزة' ? 'selected' : '' }}>محافظة غزة</option>
                                <option value="المحافظة الوسطى" {{ $sector->name == 'المحافظة الوسطى' ? 'selected' : '' }}>المحافظة الوسطى</option>
                                <option value="محافظة خانيونس" {{ $sector->name == 'محافظة خانيونس' ? 'selected' : '' }}>محافظة خانيونس</option>
                                <option value="محافظة رفح" {{ $sector->name == 'محافظة رفح' ? 'selected' : '' }}>محافظة رفح</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">اسم الموقع (الوصف)</label>
                            <textarea id="description" class="form-control text-dark bg-white" rows="3" placeholder="أدخلي تفاصيل الموقع هنا...">{{ $sector->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">المشرف المسؤول</label>
                            <select id="supervisor_id" class="form-select text-dark bg-white">
                                <option value="">-- اختر مشرفاً من القائمة --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $sector->supervisor_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - ({{ $user->phone ?? 'لا يوجد رقم' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="button" onclick="updateSector()" class="btn btn-update">حفظ التعديلات</button>
                            <a href="{{ route('sectors.index') }}" class="btn btn-outline-secondary px-4 py-2 border-0">إلغاء</a>
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
    function updateSector() {
        let data = {
            name: document.getElementById('sectorName').value,
            description: document.getElementById('description').value,
            supervisor_id: document.getElementById('supervisor_id').value
        };

        let url = "{{ route('sectors.update', $sector->id) }}";
        performUpdate(url, data);
    }
</script>
@endsection