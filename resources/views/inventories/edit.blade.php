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
    function performUpdate() {
        let data = {
            item_name: document.getElementById('item_name').value,
            category: document.getElementById('category').value,
            type: document.getElementById('type').value,
            condition: document.getElementById('condition').value,
            total_quantity: document.getElementById('total_quantity').value,
            quantity_available: document.getElementById('quantity_available').value,
            storage_location: document.getElementById('storage_location').value,
            _method: 'PUT' 
        };

        axios.post('/inventories/{{ $inventory->id }}', data)
            .then(function (response) {
    Swal.fire({
        icon: 'success',
        title: 'تم بنجاح',
        text: response.data.text,
        showConfirmButton: false, 
        timer: 2000 
    });

    setTimeout(function() {
        window.location.href = "/inventories";
    }, 2000); 
})
            
            .catch(function (error) {
                // فشل
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: error.response.data.message || 'حدث خطأ أثناء التعديل'
                });
            });
    }
</script>
@endsection