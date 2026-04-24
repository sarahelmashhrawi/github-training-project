@extends('cms.parent')

@section('title', 'تعديل صنف في المخزن')

@section('styles')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">تعديل بيانات الصنف: {{ $inventory->item_name }}</h3>
                    </div>
                    <form id="edit-inventory-form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="item_name">اسم الصنف</label>
                                        <input type="text" class="form-control" id="item_name" 
                                               value="{{ $inventory->item_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">الفئة</label>
                                        <input type="text" class="form-control" id="category" 
                                               value="{{ $inventory->category }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">النوع</label>
                                        <input type="text" class="form-control" id="type" 
                                               value="{{ $inventory->type }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="condition">الحالة</label>
                                        <input type="text" class="form-control" id="condition" 
                                               value="{{ $inventory->condition }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_quantity">الكمية الكلية</label>
                                        <input type="number" class="form-control" id="total_quantity" 
                                               value="{{ $inventory->total_quantity }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="quantity_available">الكمية المتوفرة</label>
                                        <input type="number" class="form-control" id="quantity_available" 
                                               value="{{ $inventory->quantity_available }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="storage_location">موقع التخزين</label>
                                <input type="text" class="form-control" id="storage_location" 
                                       value="{{ $inventory->storage_location }}">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" onclick="performUpdate()" class="btn btn-primary">حفظ التعديلات</button>
                            <a href="{{ route('inventories.index') }}" class="btn btn-default">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
  function updateIndividual(id) {
    // 1. تجهيز البيانات باستخدام FormData (لأن الكود يحتوي على ملفات)
    let formData = new FormData();

    formData.append('full_name', document.getElementById('full_name').value);
    formData.append('id_number', document.getElementById('id_number').value);
    formData.append('relation_to_head', document.getElementById('relation_to_head').value);
    formData.append('dob', document.getElementById('dob').value);
    formData.append('gender', document.getElementById('gender').value);

    // الحالة الصحية والإعاقة
    let hasDisability = document.getElementById('has_disability').checked ? 1 : 0;
    formData.append('has_disability', hasDisability);
    formData.append('disability_type', document.getElementById('disability_type').value);

    let hasChronicDisease = document.getElementById('has_chronic_disease').checked ? 1 : 0;
    formData.append('has_chronic_disease', hasChronicDisease);
    formData.append('chronic_disease_name', document.getElementById('chronic_disease_name').value);

    // الحوامل والمرضعات
    if (document.getElementById('is_pregnant')) {
        formData.append('is_pregnant', document.getElementById('is_pregnant').checked ? 1 : 0);
    }
    if (document.getElementById('is_breastfeeding')) {
        formData.append('is_breastfeeding', document.getElementById('is_breastfeeding').checked ? 1 : 0);
    }

    // المرفق الطبي
    let fileInput = document.getElementById('medical_attachment');
    if (fileInput && fileInput.files.length > 0) {
        formData.append('medical_attachment', fileInput.files[0]);
    }

    // إضافة Method Spoofing ليتعرف Laravel أنها عملية تحديث
    formData.append('_method', 'PUT');

    // 2. الإرسال باستخدام Axios
    axios.post('/individuals_update/' + id, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(function (response) {
        // نجاح العملية
        Swal.fire({
            icon: 'success',
            title: 'تم بنجاح',
            text: response.data.message || 'تم تحديث بيانات الفرد بنجاح',
            showConfirmButton: false,
            timer: 2000
        });

        // إعادة التوجيه بعد ثانيتين (نفس نظام الكود الأول)
        setTimeout(function() {
            window.location.href = "{{ route('families.show', $individual->family_id) }}";
        }, 2000);
    })
    .catch(function (error) {
        // فشل العملية
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: error.response.data.message || 'حدث خطأ أثناء التعديل'
        });
    });
}
</script>
@endsection