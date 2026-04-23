@extends('cms.parent')
@section('title', 'سجل استلام المساعدات')
@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <h2 class="mb-0 fw-bold" style="color: #334155;">إدارة الاستلامات</h2>
                    <span class="ms-2 fs-4 text-primary"><i class="fas fa-hand-holding-heart"></i></span>
                </div>
                
                <a href="{{ url('/dashboard') }}" class="btn btn-info text-white px-4 shadow-sm" style="background-color: #4dc4e1; border: none; border-radius: 8px;">
                     العودة للوحة التحكم <i class="fas fa-arrow-left ms-1"></i>
                </a>
            </div>

            <div class="d-flex align-items-center mb-4 gap-2">
                <div class="position-relative" style="width: 300px;">
                    <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                        <input type="text" class="form-control border-0 ps-3" placeholder="بحث عن عملية استلام...">
                        <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                </div>

                <a href="{{ route('receivings.create') }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" style="background-color: #007bff; border: none; border-radius: 8px;">
                    تسجيل عملية توزيع <i class="fas fa-plus-circle ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr style="color: #64748b; font-size: 0.95rem; background-color: #fcfcfc;">
                            <th class="border-0 p-3">اسم رب الأسرة</th>
                            <th class="border-0 p-3">رقم الهوية</th>
                            <th class="border-0 p-3">التصنيف (الحملة)</th>
                            <th class="border-0 p-3">المادة المستلمة</th>
                            <th class="border-0 p-3">الكمية</th>
                            <th class="border-0 p-3">تاريخ الاستلام</th>
                            <th class="border-0 p-3">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receivings as $receiving)
                        <tr id="row_{{ $receiving->id }}" style="border-bottom: 1px solid #f8f9fa;">
                            <td class="fw-bold">{{ $receiving->family->head_name ?? 'N/A' }}</td>
                            <td class="text-muted">{{ $receiving->family->id_number ?? '---' }}</td>
                            <td>
                                <span class="badge" style="background-color: #6c757d; color: white; padding: 6px 12px; border-radius: 6px;">
                                    {{ $receiving->campaign->name ?? 'عام' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge" style="background-color: #28a745; color: white; padding: 6px 12px; border-radius: 6px;">
                                    {{ $receiving->inventory->item_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td><span class="badge bg-primary px-2">{{ $receiving->quantity_received }}</span></td>
                            <td class="text-muted">{{ $receiving->created_at->format('Y-m-d') }}</td>
                            <td>
                                 <div class="d-flex justify-content-center gap-3">
<a href="{{ route('receivings.edit', $receiving->id) }}" class="text-warning me-3">
    <i class="fas fa-edit"></i>
</a>    
    {{-- زر الحذف مع تمرير المعرف (ID) للدالة --}}
<button type="button" onclick="confirmDelete({{ $receiving->id }})" class="btn p-0 border-0 text-danger shadow-none">
    <i class="fas fa-trash-alt"></i>
</button>
</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-5 text-muted">لا يوجد بيانات لعرضها</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لا يمكنك التراجع عن هذه الخطوة بسهولة!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف!',
            cancelButtonText: 'إلغاء',
            reverseButtons: true // لجعل زر الإلغاء على اليمين والحذف على اليسار
        }).then((result) => {
            if (result.isConfirmed) {
                // تنفيذ طلب الحذف الفعلي عبر AJAX
                deleteItem(id);
            }
        });
    }

    function deleteItem(id) {
        let url = "{{ route('receivings.destroy', ':id') }}".replace(':id', id);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: new URLSearchParams({
                '_method': 'DELETE'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.icon === 'success') {
                Swal.fire('تم الحذف!', data.title, 'success').then(() => {
                    // حذف السطر من الجدول مباشرة دون تحديث الصفحة
                    document.getElementById('row_' + id).remove();
                });
            } else {
                Swal.fire('خطأ!', 'فشل تنفيذ عملية الحذف', 'error');
            }
        });
    }
</script>
@endsection