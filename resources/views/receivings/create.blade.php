@extends('cms.parent')
@section('title', 'تسجيل استلام مساعدات')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>تسجيل عملية استلام وتوزيع جديدة</h4>
        </div>
        <div class="card-body">
            <form id="receivingForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>العائلة المستلمة</label>
                        <select id="family_id" class="form-control">
                            <option value="">-- اختر العائلة --</option>
                            @foreach($families as $family)
                           <option value="{{ $family->id }}">{{ $family->head_name }}</option>                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>تابعة لحملة</label>
                        <select id="campaign_id" class="form-control">
                            <option value="">-- اختر الحملة --</option>
                            @foreach($campaigns as $campaign)
                                <option value="{{ $campaign->id }}">{{ $campaign->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>المادة / الصنف</label>
                        <select id="inventory_id" class="form-control">
                            <option value="">-- اختر الصنف --</option>
                            @foreach($inventories as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }} (المتوفر: {{ $item->quantity_available }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>الكمية المستلمة</label>
                        <input type="number" id="quantity_received" class="form-control" placeholder="أدخل الكمية">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" onclick="performStore()" class="btn btn-success btn-lg">إتمام التسجيل</button>
                    <a href="{{ route('receivings.index') }}" class="btn btn-secondary btn-lg">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function performStore() {
        let data = {
            family_id: document.getElementById('family_id').value,
            campaign_id: document.getElementById('campaign_id').value,
            inventory_id: document.getElementById('inventory_id').value,
            quantity_received: document.getElementById('quantity_received').value,
        };

        axios.post('{{ route("receivings.store") }}', data)
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: response.data.title,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '{{ route("receivings.index") }}';
            });
        })
        .catch(function (error) {
            let errorMsg = error.response.data.title || "تأكد من إدخال جميع البيانات بشكل صحيح";
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: errorMsg
            });
        });
    }
</script>
@endsection