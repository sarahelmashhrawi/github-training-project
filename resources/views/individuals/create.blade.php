@extends('cms.parent')

@section('title', 'إضافة فرد جديد')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('css/individuals/create.css') }}?v={{ time() }}"> -->
@endsection

@section('content')
<div class="container-fluid mt-4 mb-5" style="max-width: 900px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0 fw-bold"><i class="fas fa-user-plus text-success mr-2"></i> إضافة فرد جديد</h3>
        <a href="{{ route('families.show', $family->id) }}" class="btn btn-secondary px-4 rounded shadow-sm">
            <i class="fas fa-times mr-1"></i> إلغاء والعودة
        </a>
    </div>

    <div class="card p-4 border-0 shadow-sm rounded-lg">
        
        <div class="alert alert-light text-center mb-4">
            <i class="fas fa-users mr-2"></i> جاري إضافة فرد إلى عائلة: <strong>{{ $family->head_name }}</strong>
        </div>

        <form id="create-form" onsubmit="event.preventDefault(); storeIndividual();">
            @csrf
            <input type="hidden" name="family_id" value="{{ $family->id }}">

            <div class="row">
                
                <div class="col-md-12 mb-3">
                    <label class="form-label">الاسم الرباعي <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input type="text" name="full_name" class="form-control" placeholder="أدخل اسم الفرد كاملاً..." required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم الهوية <small class="text-muted">(9 أرقام)</small></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-card"></i></span></div>
                        <input type="text" name="id_number" class="form-control" placeholder="أدخل 9 أرقام..." maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">صلة القرابة <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-link"></i></span></div>
                        <select name="relation_to_head" class="form-select" required>
                            <option value="" disabled selected>اختر صلة القرابة...</option>
                            <option value="زوجة">زوجة</option>
                            <option value="زوج">زوج</option>
                            <option value="ابن">ابن</option>
                            <option value="ابنة">ابنة</option>
                            <option value="أب">أب</option>
                            <option value="أم">أم</option>
                            <option value="أخ">أخ</option>
                            <option value="أخت">أخت</option>
                            <option value="حفيد">حفيد</option>
                            <option value="حفيدة">حفيدة</option>
                            <option value="أخرى">أخرى</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">الجنس <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-venus-mars"></i></span></div>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled selected>اختر الجنس...</option>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">تاريخ الميلاد</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        <input type="date" name="dob" class="form-control">
                    </div>
                </div>

                <div id="female-options" class="col-12 mt-2 mb-3 p-3 bg-light rounded border border-info" style="display: none;">
                    <h6 class="text-info fw-bold mb-3"><i class="fas fa-female"></i> بيانات خاصة بالزوجة / الإناث</h6>
                    
                    <div class="form-check d-flex align-items-center mb-2" style="gap: 10px;">
                        <input type="checkbox" class="form-check-input m-0" id="is_pregnant" name="is_pregnant" value="1">
                        <label class="form-check-label m-0" for="is_pregnant">هل هي حامل؟</label>
                    </div>
                    
                    <div class="form-check d-flex align-items-center" style="gap: 10px;">
                        <input type="checkbox" class="form-check-input m-0" id="is_breastfeeding" name="is_breastfeeding" value="1">
                        <label class="form-check-label m-0" for="is_breastfeeding">هل هي مرضع؟</label>
                    </div>
                </div>

                <div class="col-12 mt-4 mb-3 border-bottom pb-2">
                    <h5 class="fw-bold"><i class="fas fa-notes-medical text-danger mr-2"></i> الحالة الصحية</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check d-flex align-items-center mb-2" style="gap: 10px;">
                        <input type="checkbox" class="form-check-input m-0" id="has_disability" name="has_disability" value="1">
                        <label class="form-check-label m-0 fw-bold" for="has_disability">هل يعاني الفرد من أي إعاقات؟</label>
                    </div>
                    
                    <div id="disability_section" class="mt-2" style="display: none;">
                        <select name="disability_type" class="form-select border-danger">
                            <option value="" disabled selected>اختر نوع الإعاقة...</option>
                            <option value="حركية">حركية</option>
                            <option value="بصرية">بصرية</option>
                            <option value="سمعية">سمعية</option>
                            <option value="ذهنية/نفسية">ذهنية/نفسية</option>
                            <option value="متعددة">متعددة</option>
                            <option value="أخرى">أخرى</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check d-flex align-items-center mb-2" style="gap: 10px;">
                        <input type="checkbox" class="form-check-input m-0" id="has_chronic_disease" name="has_chronic_disease" value="1">
                        <label class="form-check-label m-0 fw-bold" for="has_chronic_disease">هل يعاني الفرد من أمراض مزمنة؟</label>
                    </div>
                    
                    <div id="chronic_disease_section" class="mt-2" style="display: none;">
                        <input type="text" name="chronic_disease_name" class="form-control border-danger" placeholder="مثال: سكري، ضغط، قلب، ربو...">
                        <small class="text-muted mt-1 d-block">يرجى كتابة اسم المرض بدقة.</small>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-file-medical text-danger mr-1"></i> إرفاق تقرير طبي أو وثيقة (اختياري)
                    </label>
                    <input type="file" name="medical_attachment" id="medical_attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted mt-1 d-block">الصيغ المسموحة: PDF, JPG, PNG (الحد الأقصى 10 ميجابايت).</small>
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-5 rounded">
                    <i class="fas fa-save mr-1"></i> حفظ بيانات الفرد
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // تبديل إظهار حقول الإعاقة
        const disabilityCheckbox = document.getElementById('has_disability');
        const disabilitySection = document.getElementById('disability_section');
        if(disabilityCheckbox) {
            disabilityCheckbox.addEventListener('change', function() {
                disabilitySection.style.display = this.checked ? 'block' : 'none';
                if(!this.checked) disabilitySection.querySelector('select').selectedIndex = 0; 
            });
        }

        // تبديل إظهار حقول الأمراض
        const chronicCheckbox = document.getElementById('has_chronic_disease');
        const chronicSection = document.getElementById('chronic_disease_section');
        if(chronicCheckbox) {
            chronicCheckbox.addEventListener('change', function() {
                chronicSection.style.display = this.checked ? 'block' : 'none';
                if(!this.checked) chronicSection.querySelector('input').value = ''; 
            });
        }

        // ربط صلة القرابة بالجنس وإظهار بيانات الإناث
        const relationSelect = document.querySelector('select[name="relation_to_head"]');
        const genderSelect = document.querySelector('select[name="gender"]');
        const femaleOptionsDiv = document.getElementById('female-options');
        const isPregnantCheckbox = document.getElementById('is_pregnant');
        const isBreastfeedingCheckbox = document.getElementById('is_breastfeeding');

        const maleRelations = ['زوج', 'ابن', 'أب', 'أخ', 'حفيد'];
        const femaleRelations = ['زوجة', 'ابنة', 'أم', 'أخت', 'حفيدة'];

        function applyConstraints() {
            const selectedRelation = relationSelect.value;

            if (maleRelations.includes(selectedRelation)) {
                genderSelect.value = 'male';
                lockGenderSelect();
            } else if (femaleRelations.includes(selectedRelation)) {
                genderSelect.value = 'female';
                lockGenderSelect();
            } else {
                unlockGenderSelect(); 
            }

            if (genderSelect.value === 'female') {
                femaleOptionsDiv.style.display = 'block';
            } else {
                femaleOptionsDiv.style.display = 'none';
                if(isPregnantCheckbox) isPregnantCheckbox.checked = false;
                if(isBreastfeedingCheckbox) isBreastfeedingCheckbox.checked = false;
            }
        }

        function lockGenderSelect() {
            genderSelect.style.pointerEvents = 'none';
            genderSelect.style.backgroundColor = '#e9ecef';
        }

        function unlockGenderSelect() {
            genderSelect.style.pointerEvents = 'auto';
            genderSelect.style.backgroundColor = '#fff';
        }

        if(relationSelect) relationSelect.addEventListener('change', applyConstraints);
        if(genderSelect) genderSelect.addEventListener('change', applyConstraints);

        applyConstraints();
    });

function storeIndividual() {
    let form = document.getElementById('create-form');
    let formData = new FormData(form);
    let family_id = form.querySelector('input[name="family_id"]').value;
    
    performStore('/individuals', formData, '/families/' + family_id); 
}

 
</script>
</script>
@endsection