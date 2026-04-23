@extends('cms.parent')

@section('title', 'تعديل عملية استلام')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold" style="color: #334155;">تعديل عملية الاستلام</h2>
                <a href="{{ route('receivings.index') }}" class="btn btn-info text-white px-4 shadow-sm" style="background-color: #4dc4e1; border: none;">
                    العودة للجدول <i class="fas fa-arrow-left ms-1"></i>
                </a>
            </div>

            <form id="editForm" action="{{ route('receivings.update', $receiving->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">اسم رب الأسرة</label>
                        <input type="text" class="form-control border-0 bg-light" value="{{ $receiving->family->head_name }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم الهوية</label>
                        <input type="text" class="form-control border-0 bg-light" value="{{ $receiving->family->id_number }}" readonly>
                    </div>

                   <div class="col-md-4">
    <label class="form-label fw-bold">التصنيف (المساعدة)</label>
    <select name="campaign_id" class="form-select border-0 shadow-sm bg-light">
        @foreach($campaigns as $cp)
            <option value="{{ $cp->id }}" {{ $receiving->campaign_id == $cp->id ? 'selected' : '' }}>
                {{ $cp->title }} 
            </option>
        @endforeach
    </select>
</div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">المادة المستلمة</label>
                        <input type="text" class="form-control border-0 bg-light" value="{{ $receiving->inventory->item_name }}" readonly>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">الكمية</label>
                        <input type="number" name="quantity_received" class="form-control border-0 shadow-sm bg-light" value="{{ $receiving->quantity_received }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">تاريخ الاستلام</label>
                        <input type="date" class="form-control border-0 bg-light" value="{{ \Carbon\Carbon::parse($receiving->created_at)->format('Y-m-d') }}" readonly>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <button type="button" id="saveBtn" class="btn btn-primary px-5 fw-bold shadow-sm" style="background-color: #007bff; border: none; border-radius: 10px;">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('saveBtn').addEventListener('click', function() {
        let form = document.getElementById('editForm');
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST', // Laravel سيفهم أنها PUT بسبب @method('PUT') داخل الفورم
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.icon === 'success') {
                Swal.fire({
                    title: data.title,
                    icon: 'success',
                    confirmButtonText: 'موافق',
                }).then(() => {
                    window.location.href = "{{ route('receivings.index') }}";
                });
            } else {
                Swal.fire({
                    title: 'خطأ!',
                    text: data.title,
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            Swal.fire('خطأ!', 'حدث خطأ في السيرفر، تأكد من تعبئة البيانات بشكل صحيح', 'error');
        });
    });
</script>

<style>
    .form-control, .form-select { padding: 12px; border-radius: 8px; }
</style>
@endsection