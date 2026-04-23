@extends('cms.parent')
@section('title', 'تعديل بلاغ احتياج')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="mb-0 fs-5 font-weight-bold">تعديل البلاغ رقم #{{ $need->id }}</h3>
                </div>

                <div class="card-body p-4 text-right">
                    <form id="edit_form">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">العائلة المتضررة</label>
                                <select id="family_id" class="form-control">
                                    @foreach($families as $family)
                                        <option value="{{ $family->id }}" {{ $need->family_id == $family->id ? 'selected' : '' }}>
                                            {{ $family->head_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">نوع الاحتياج</label>
                                <input type="text" id="type_of_need" class="form-control" value="{{ $need->type_of_need }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">مستوى الخطورة</label>
                                <select id="urgency_level" class="form-control">
                                    <option value="critical" {{ $need->urgency_level == 'critical' ? 'selected' : '' }}>حرِج</option>
                                    <option value="high" {{ $need->urgency_level == 'high' ? 'selected' : '' }}>مرتفع</option>
                                    <option value="medium" {{ $need->urgency_level == 'medium' ? 'selected' : '' }}>متوسط</option>
                                    <option value="low" {{ $need->urgency_level == 'low' ? 'selected' : '' }}>منخفض</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">حالة البلاغ</label>
                                <select id="status" class="form-control">
                                    <option value="pending" {{ $need->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="in_progress" {{ $need->status == 'in_progress' ? 'selected' : '' }}>جاري المعالجة</option>
                                    <option value="resolved" {{ $need->status == 'resolved' ? 'selected' : '' }}>تمت الاستجابة</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">وصف الحالة</label>
                                <textarea id="description" class="form-control" rows="4">{{ $need->description }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                            <button type="button" onclick="performUpdate()" class="btn btn-primary px-5">حفظ التعديلات</button>
                            <a href="{{ route('emergency_needs.index') }}" class="btn btn-outline-secondary">رجوع</a>
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
    function performUpdate() {
        console.log("بدء محاولة التحديث...");

        let data = {
            family_id: document.getElementById('family_id').value,
            type_of_need: document.getElementById('type_of_need').value,
            urgency_level: document.getElementById('urgency_level').value,
            status: document.getElementById('status').value,
            description: document.getElementById('description').value,
            _method: 'PUT' 
        };

        axios.post('/emergency_needs/{{ $need->id }}', data)
            .then(function (response) {
                console.log("نجحنا! السيرفر رد بـ:", response.data);
                
                Swal.fire('تم التعديل', 'تم حفظ البيانات بنجاح', 'success');

                setTimeout(function() {
                    window.location.href = "{{ route('emergency_needs.index') }}";
                }, 1500);
            })
            .catch(function (error) {
                console.error("هنا المشكلة! خطأ من السيرفر:", error.response);
                alert("فشل التحديث: " + (error.response?.data?.text || "خطأ غير معروف"));
            });
    }
</script>
@endsection