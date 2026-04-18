@extends('cms.parent')

@section('title', '⚙️ تعديل بيانات المنطقة')

@section('styles')
    {{-- ربط ملف التنسيق الجديد --}}
    <link rel="stylesheet" href="{{ asset('css/sectors/edit.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10"> {{-- عدلت الـ 20 لـ 10 لأن 20 خارج حدود بوتستراب --}}
            <div class="card edit-card">
                <div class="edit-header text-center">
                    <h3>⚙️ تعديل بيانات المنطقة</h3>
                    <small>أنتِ الآن تعدلين: <strong>{{ $sector->name }}</strong></small>
                </div>
                
                <div class="card-body p-4">
                    <form id="editSectorForm">
                        @csrf
                        
                        <div class="mb-4 text-start">
                            <label class="form-label-edit">اسم المنطقة</label>
                            <select id="sectorName" class="form-select edit-input" required>
                                <option value="" disabled>-- اختاري المنطقة --</option>
                                @php
                                    $regions = ['محافظة شمال غزة', 'محافظة غزة', 'المحافظة الوسطى', 'محافظة خانيونس', 'محافظة رفح'];
                                @endphp
                                @foreach($regions as $region)
                                    <option value="{{ $region }}" {{ $sector->name == $region ? 'selected' : '' }}>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 text-start">
                            <label class="form-label-edit">اسم الموقع (الوصف)</label>
                            <textarea id="description" class="form-control edit-input" rows="3" placeholder="أدخلي تفاصيل الموقع هنا...">{{ $sector->description }}</textarea>
                        </div>

                        <div class="mb-4 text-start">
                            <label class="form-label-edit">المشرف المسؤول</label>
                            <select id="supervisor_id" class="form-select edit-input">
                                <option value="">-- اختر مشرفاً من القائمة --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $sector->supervisor_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - ({{ $user->phone ?? 'لا يوجد رقم' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4 d-flex gap-2 justify-content-start">
                            <button type="button" onclick="updateSector()" class="btn btn-update shadow-sm">
                                <i class="fas fa-check-circle me-1"></i> حفظ التعديلات
                            </button>
                            <a href="{{ route('sectors.index') }}" class="btn btn-outline-secondary px-4 border-0">إلغاء</a>
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