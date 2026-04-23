@extends('cms.parent')
@section('title', 'تسجيل احتياج طارئ')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white py-3">
                    <h3 class="mb-0 fs-5 font-weight-bold">
                        <i class="fas fa-plus-circle me-2"></i> تسجيل بلاغ احتياج طارئ جديد
                    </h3>
                </div>

                <div class="card-body p-4 text-right">
                    <form id="create_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold text-dark">العائلة المتضررة</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-users text-danger"></i></span>
                                    <select id="family_id" class="form-control shadow-sm">
                                        <option value="">-- اختر العائلة من القائمة --</option>
                                        @foreach($families as $family)
                                            <option value="{{ $family->id }}">{{ $family->head_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">نوع الاحتياج</label>
                                <input type="text" id="type_of_need" class="form-control shadow-sm" 
                                    placeholder="مثلاً: خيمة، دواء، طاقة شمسية">
                            </div>

                            <div class="col-md-6 mb-3 text-right">
                                <label class="form-label fw-bold text-dark">مستوى الخطورة</label>
                                <select id="urgency_level" class="form-control shadow-sm">
                                    <option value="critical" class="text-danger">حرِج (Critical)</option>
                                    <option value="high" class="text-warning">مرتفع (High)</option>
                                    <option value="medium" selected>متوسط (Medium)</option>
                                    <option value="low">منخفض (Low)</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3 text-right">
                                <label class="form-label fw-bold text-dark">وصف الحالة بالتفصيل</label>
                                <textarea id="description" class="form-control shadow-sm" rows="4" 
                                    placeholder="يرجى شرح الحالة بدقة لتسهيل عملية الاستجابة..."></textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" onclick="performStore()" class="btn btn-danger px-5 shadow fw-bold">
                                    <i class="fas fa-save me-1"></i> حفظ وإرسال البلاغ
                                </button>
                                <a href="{{ route('emergency_needs.index') }}" class="btn btn-outline-secondary px-4 mx-2">إلغاء</a>
                            </div>
                            
                            <small class="text-muted italic">سيتم تسجيل هذا البلاغ باسمك كمشرف مسؤول.</small>
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
    function performStore() {
        console.log("بدء عملية الحفظ..."); // للتأكد أن الدالة تعمل

        let data = {
            family_id: document.getElementById('family_id').value,
            type_of_need: document.getElementById('type_of_need').value,
            urgency_level: document.getElementById('urgency_level').value,
            description: document.getElementById('description').value
        };

        axios.post('{{ route("emergency_needs.store") }}', data)
            .then(function (response) {
                console.log("تم الإرسال بنجاح:", response);
                
                // إظهار رسالة النجاح باستخدام SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'تم بنجاح',
                    text: response.data.text || 'تم تسجيل البلاغ بنجاح',
                    showConfirmButton: false,
                    timer: 1500
                });

                // الانتقال لصفحة الجدول بعد ثانية ونصف
                setTimeout(function() {
                    window.location.href = "{{ route('emergency_needs.index') }}";
                }, 1500);
            })
            .catch(function (error) {
                console.error("حدث خطأ أثناء الإرسال:", error);
                
                // إظهار رسالة خطأ في حال فشل الإرسال
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: error.response?.data?.text || 'حدث خطأ غير متوقع'
                });
            });
    }
</script>
@endsection