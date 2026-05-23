@extends('cms.parent')
@section('title', 'إضافة صنف للمخزن')

@section('content')
<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">            
            <div class="card custom-card shadow">
                <div class="card-header custom-card-header text-center bg-primary text-white">
                    <h3 class="mb-0 font-weight-bold"><i class="fas fa-boxes mr-2"></i> إضافة صنف جديد للمخزن</h3>
                </div>
                <div class="card-body p-4 text-right">
                    <form id="create_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">اسم الصنف</label>
                                <input type="text" id="item_name" class="form-control" placeholder="مثال: طرد غذائي">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">نوع الصنف (Type)</label>
                                <select id="type" class="form-control">
                                    <option value="physical">عيني (Physical)</option>
                                    <option value="cash">نقدي (Cash)</option>
                                    <option value="medical">طبي (Medical)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">التصنيف (Category)</label>
                                <input type="text" id="category" class="form-control" placeholder="مثال: أدوات، طعام..">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">الحالة (Condition)</label>
                                <select id="condition" class="form-control">
                                    <option value="جديد">جديد</option>
                                    <option value="مستعمل">مستعمل</option>
                                    <option value="يحتاج صيانة">يحتاج صيانة</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">الكمية الكلية</label>
                                <input type="number" id="total_quantity" class="form-control" value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">الكمية المتوفرة حالياً</label>
                                <input type="number" id="quantity_available" class="form-control" value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">مكان  المستودع</label>
                                <input type="text" id="storage_location" class="form-control" placeholder="مثال: رف A1">
                            </div>
                        </div>

                        <div class="mt-4 text-left">
                            <button type="button" onclick="storeInventory()" class="btn btn-success px-5">
                                <i class="fas fa-save mr-1"></i> حفظ البيانات
                            </button>
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
    function storeInventory() {
        let formData = new FormData();//تجميع البيانات من الحقول ووضعها داخل formData
        formData.append('item_name', document.getElementById('item_name').value);
        formData.append('type', document.getElementById('type').value);
        formData.append('category', document.getElementById('category').value);
        formData.append('condition', document.getElementById('condition').value);
        formData.append('total_quantity', document.getElementById('total_quantity').value);
        formData.append('quantity_available', document.getElementById('quantity_available').value);
        formData.append('storage_location', document.getElementById('storage_location').value);

        performStore(`{{ route('inventories.store') }}`, formData);
    }
</script>
@endsection