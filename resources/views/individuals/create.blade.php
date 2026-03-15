<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فرد جديد</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>👤</text></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; color: #333; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); background: #fff; margin-bottom: 20px; }
        .form-label { font-weight: bold; color: #495057; }
        .input-group-text { background-color: #e9ecef; border: none; color: #6c757d; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #ced4da; padding: 10px 15px; }
        .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25); }
        .btn-success { border-radius: 10px; padding: 10px 20px; font-weight: bold; transition: 0.3s; }
        .btn-success:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3); }
        .family-badge { background-color: #d1e7dd; color: #198754; padding: 10px 15px; border-radius: 10px; font-weight: bold; border: 1px dashed #198754;}
        
        /* تجميل أزرار التفعيل (الصح) الخاصة بالأمراض */
        .form-switch .form-check-input { width: 3em; height: 1.5em; cursor: pointer;}
        .form-switch .form-check-label { margin-right: 40px; padding-top: 5px; cursor: pointer;}
    </style>
</head>
<body>

<div class="container mt-5 mb-5" style="max-width: 800px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0"><i class="fas fa-user-plus text-success me-2"></i> إضافة فرد جديد</h3>
        <a href="{{ route('families.show', $family->id) }}" class="btn btn-secondary fw-bold px-4">
            <i class="fas fa-times me-1"></i> إلغاء
        </a>
    </div>

    <div class="card p-4 border-top border-success border-4">
        
        <div class="family-badge mb-4 text-center">
            <i class="fas fa-users me-2"></i> جاري إضافة فرد إلى عائلة: 
            <span class="text-dark">{{ $family->head_name }}</span>
        </div>

        <form action="{{ route('individuals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="family_id" value="{{ $family->id }}">

            <div class="row g-4">
                
                <div class="col-md-12">
                    <label class="form-label">الاسم الرباعي للفرد <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="full_name" class="form-control" placeholder="أدخل اسم الفرد كاملاً..." value="{{ old('full_name') }}" required>
                    </div>
                    @error('full_name') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">رقم الهوية <span class="text-muted">(9 أرقام)</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" name="id_number" class="form-control" placeholder="أدخل 9 أرقام..." 
                               value="{{ old('id_number') }}" 
                               maxlength="9" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);">
                    </div>
                    @error('id_number') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">صلة القرابة برب الأسرة <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                        <select name="relation_to_head" class="form-select" required>
                            <option value="" disabled selected>اختر صلة القرابة...</option>
                            <option value="زوجة" {{ old('relation_to_head') == 'زوجة' ? 'selected' : '' }}>زوجة</option>
                            <option value="زوج" {{ old('relation_to_head') == 'زوج' ? 'selected' : '' }}>زوج</option>
                            <option value="ابن" {{ old('relation_to_head') == 'ابن' ? 'selected' : '' }}>ابن</option>
                            <option value="ابنة" {{ old('relation_to_head') == 'ابنة' ? 'selected' : '' }}>ابنة</option>
                            <option value="أب" {{ old('relation_to_head') == 'أب' ? 'selected' : '' }}>أب</option>
                            <option value="أم" {{ old('relation_to_head') == 'أم' ? 'selected' : '' }}>أم</option>
                            <option value="أخ" {{ old('relation_to_head') == 'أخ' ? 'selected' : '' }}>أخ</option>
                            <option value="أخت" {{ old('relation_to_head') == 'أخت' ? 'selected' : '' }}>أخت</option>
                            <option value="حفيد" {{ old('relation_to_head') == 'حفيد' ? 'selected' : '' }}>حفيد</option>
                            <option value="حفيدة" {{ old('relation_to_head') == 'حفيدة' ? 'selected' : '' }}>حفيدة</option>
                            <option value="أخرى" {{ old('relation_to_head') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                        </select>
                    </div>
                    @error('relation_to_head') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">الجنس <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled selected>اختر الجنس...</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>
                    @error('gender') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">تاريخ الميلاد</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                    </div>
                    @error('dob') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                </div>

                <div id="female-options" class="col-12 mt-3 p-3 bg-light rounded border border-info" style="display: none;">
                    <h6 class="fw-bold text-info"><i class="fas fa-female"></i> بيانات خاصة بالزوجة / الإناث</h6>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="is_pregnant" name="is_pregnant" value="1" {{ old('is_pregnant') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_pregnant">هل هي حامل؟</label>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="is_breastfeeding" name="is_breastfeeding" value="1" {{ old('is_breastfeeding') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_breastfeeding">هل هي مرضع؟</label>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-notes-medical text-danger me-2"></i> الحالة الصحية</h5>
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input bg-danger border-danger" type="checkbox" id="has_disability" name="has_disability" value="1" {{ old('has_disability') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="has_disability">هل يعاني الفرد من أي إعاقات؟</label>
                    </div>
                    <div id="disability_section" class="mt-3" style="display: {{ old('has_disability') ? 'block' : 'none' }};">
                        <select name="disability_type" class="form-select border-danger">
                            <option value="" disabled selected>اختر نوع الإعاقة...</option>
                            @php $disabilities = ['حركية', 'بصرية', 'سمعية', 'ذهنية/نفسية', 'متعددة', 'أخرى']; @endphp
                            @foreach($disabilities as $type)
                                <option value="{{ $type }}" {{ old('disability_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('disability_type') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input bg-danger border-danger" type="checkbox" id="has_chronic_disease" name="has_chronic_disease" value="1" {{ old('has_chronic_disease') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="has_chronic_disease">هل يعاني الفرد من أمراض مزمنة؟</label>
                    </div>
                    <div id="chronic_disease_section" class="mt-3" style="display: {{ old('has_chronic_disease') ? 'block' : 'none' }};">
                        <input type="text" name="chronic_disease_name" class="form-control border-danger" placeholder="مثال: سكري، ضغط، قلب، ربو..." value="{{ old('chronic_disease_name') }}">
                        <label class="text-muted small mt-1">يرجى كتابة اسم المرض بدقة.</label>
                        <br>
                        @error('chronic_disease_name') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <label class="form-label fw-bold text-dark">
                        <i class="fas fa-file-medical text-danger me-1"></i> إرفاق تقرير طبي أو وثيقة إثبات 
                    </label>
                    <div class="input-group">
                        <input type="file" name="medical_attachment" id="medical_attachment" class="form-control border-danger" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div class="form-text text-muted small">الصيغ المسموحة: PDF, JPG, PNG (الحد الأقصى 10 ميجابايت).</div>
                    @error('medical_attachment') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success px-5">
                    <i class="fas fa-save me-1"></i> حفظ بيانات الفرد
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- سكربت الإعاقات والأمراض ---
        const disabilityCheckbox = document.getElementById('has_disability');
        const disabilitySection = document.getElementById('disability_section');
        if(disabilityCheckbox) {
            disabilityCheckbox.addEventListener('change', function() {
                if(this.checked) {
                    disabilitySection.style.display = 'block';
                } else {
                    disabilitySection.style.display = 'none';
                    disabilitySection.querySelector('select').selectedIndex = 0; 
                }
            });
        }

        const chronicCheckbox = document.getElementById('has_chronic_disease');
        const chronicSection = document.getElementById('chronic_disease_section');
        if(chronicCheckbox) {
            chronicCheckbox.addEventListener('change', function() {
                if(this.checked) {
                    chronicSection.style.display = 'block';
                } else {
                    chronicSection.style.display = 'none';
                    chronicSection.querySelector('input').value = ''; 
                }
            });
        }

        // --- سكربت ربط صلة القرابة بالجنس وإظهار بيانات الإناث ---
        const relationSelect = document.querySelector('select[name="relation_to_head"]');
        const genderSelect = document.querySelector('select[name="gender"]');
        const femaleOptionsDiv = document.getElementById('female-options');
        const isPregnantCheckbox = document.getElementById('is_pregnant');
        const isBreastfeedingCheckbox = document.getElementById('is_breastfeeding');

        const maleRelations = ['زوج', 'ابن', 'أب', 'أخ', 'حفيد'];
        const femaleRelations = ['زوجة', 'ابنة', 'أم', 'أخت', 'حفيدة'];

        function applyConstraints() {
            const selectedRelation = relationSelect.value;

            // تحديد الجنس بناءً على القرابة
            if (maleRelations.includes(selectedRelation)) {
                genderSelect.value = 'male';
                lockGenderSelect();
            } else if (femaleRelations.includes(selectedRelation)) {
                genderSelect.value = 'female';
                lockGenderSelect();
            } else {
                unlockGenderSelect(); 
            }

            // إظهار أو إخفاء خيارات الإناث
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

        // التشغيل عند التحديث أو التحميل لأول مرة
        applyConstraints();
    });
</script>
</body>
</html>