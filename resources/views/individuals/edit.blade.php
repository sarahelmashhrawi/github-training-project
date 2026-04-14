@extends('cms.parent')

@section('title', 'تعديل بيانات الفرد')

@section('content')
<div class="container-fluid mt-4">
    <div class="mb-4 d-flex justify-content-between">
        <h3>تعديل بيانات: {{ $individual->full_name }}</h3>
        <a href="{{ route('families.show', $individual->family_id) }}" class="btn btn-secondary">إلغاء والعودة</a>
    </div>

    <div class="card p-4">
        <form id="edit-form" onsubmit="event.preventDefault(); updateIndividual('{{ $individual->id }}');">
            @csrf
            
            <div class="row">
                <div class="form-group col-md-12">
                    <label>الاسم الرباعي للفرد *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ $individual->full_name }}" required>
                </div>

                <div class="form-group col-md-6">
                    <label>رقم الهوية (9 أرقام)</label>
                    <input type="text" name="id_number" class="form-control" placeholder="أدخل 9 أرقام..." value="{{ $individual->id_number }}" maxlength="9">
                </div>

                <div class="form-group col-md-6">
                    <label>صلة القرابة برب الأسرة *</label>
                    <select name="relation_to_head" class="form-control" required>
                        @foreach(['زوجة', 'زوج', 'ابن', 'ابنة', 'أب', 'أم', 'أخ', 'أخت', 'حفيد', 'حفيدة', 'أخرى'] as $relation)
                            <option value="{{ $relation }}" {{ $individual->relation_to_head == $relation ? 'selected' : '' }}>{{ $relation }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>الجنس *</label>
                    <select name="gender" class="form-control" required>
                        <option value="male" {{ $individual->gender == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ $individual->gender == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="dob" class="form-control" value="{{ $individual->dob }}">
                </div>

                <div id="female-options" class="col-md-12 mb-3" style="display: none;">
                    <h6>بيانات خاصة بالزوجة / الإناث</h6>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_pregnant" name="is_pregnant" value="1" {{ $individual->is_pregnant ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_pregnant">هل هي حامل؟</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_breastfeeding" name="is_breastfeeding" value="1" {{ $individual->is_breastfeeding ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_breastfeeding">هل هي مرضع؟</label>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <hr>
                    <h5>الحالة الصحية</h5>
                </div>

<<div class="form-group col-md-6">
    <div class="form-check" style="display: flex !important; align-items: center !important; gap: 10px !important; padding-left: 0 !important; margin-bottom: 10px;">
        <input type="checkbox" class="form-check-input" id="has_disability" name="has_disability" value="1" {{ $individual->has_disability ? 'checked' : '' }} onchange="document.getElementById('disability_section').style.display = this.checked ? 'block' : 'none';" style="position: static !important; margin: 0 !important;">
        <label class="form-check-label" for="has_disability" style="margin: 0 !important; cursor: pointer; font-weight: bold;">هل يعاني الفرد من أي إعاقات؟</label>
    </div>
    <div id="disability_section" class="mt-2 p-2 border rounded bg-light" style="display: {{ $individual->has_disability ? 'block' : 'none' }};">
        <label class="form-label font-weight-bold text-primary small">نوع الإعاقة:</label>
        <select name="disability_type" class="form-select">
            <option value="" disabled {{ !$individual->disability_type ? 'selected' : '' }}>اختر نوع الإعاقة...</option>
            @foreach(['حركية', 'بصرية', 'سمعية', 'ذهنية/نفسية', 'متعددة', 'أخرى'] as $type)
                <option value="{{ $type }}" {{ $individual->disability_type == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group col-md-6">
    <div class="form-check mb-2" style="display: flex !important; align-items: center !important; gap: 10px !important; padding-left: 0 !important; margin-bottom: 10px;">
        <input type="checkbox" class="form-check-input" id="has_chronic_disease" name="has_chronic_disease" value="1" {{ $individual->has_chronic_disease ? 'checked' : '' }} onchange="document.getElementById('chronic_disease_section').style.display = this.checked ? 'block' : 'none';" style="position: static !important; margin: 0 !important;">
        <label class="form-check-label" for="has_chronic_disease" style="margin: 0 !important; cursor: pointer; font-weight: bold;">هل يعاني الفرد من أمراض مزمنة؟</label>
    </div>
    
    <div id="chronic_disease_section" class="mt-2 p-2 border rounded bg-light" style="display: {{ $individual->has_chronic_disease ? 'block' : 'none' }};">
        <label class="form-label font-weight-bold text-primary small">أدخل اسم المرض المزمن بالتحديد:</label>
        <input type="text" name="chronic_disease_name" class="form-control" placeholder="مثال: سكري، ضغط، قلب..." value="{{ $individual->chronic_disease_name }}">
    </div>
</div>
                <div class="form-group col-md-12">
                    <label>إرفاق تقرير طبي (اختياري)</label>
                    <input type="file" name="medical_attachment" id="medical_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    @if($individual->medical_attachment)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $individual->medical_attachment) }}" target="_blank" class="btn btn-sm btn-info">عرض المرفق الحالي</a>
                        </div>
                    @endif
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function updateIndividual(id) {
            let formData = new FormData(document.getElementById('edit-form'));
            
            let fileInput = document.getElementById('medical_attachment');
            if (!fileInput.files || fileInput.files.length === 0) {
                formData.delete('medical_attachment');
            }

            formData.append('_method', 'PUT');

            axios.post('/individuals/' + id, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            .then(function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم التعديل!',
                    text: response.data.message,
                    timer: 1500
                }).then(() => {
                    window.location.href = "{{ route('families.show', $individual->family_id) }}";
                });
            })
            .catch(function (error) {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'خطأ', 
                    text: error.response?.data?.message || 'حدث خطأ'
                });
            });
        }
    </script>
@endsection