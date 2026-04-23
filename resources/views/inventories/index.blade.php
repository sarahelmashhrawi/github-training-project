@extends('cms.parent')
@section('title', 'عرض المخزن')

@section('content')
<div class="container-fluid mt-4">
    <div class="card p-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0"><i class="fas fa-warehouse text-primary me-2"></i> مستودع المساعدات</h3>
            <a href="{{ route('inventories.create') }}" class="btn btn-primary fw-bold text-white px-4 shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> إضافة صنف جديد
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-right border">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th>الصنف</th>
                        <th>النوع / التصنيف</th>
                        <th>الكمية (متوفر/كلي)</th>
                        <th>الحالة</th>
                        <th>موقع التخزين</th>
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
@forelse($items as $item)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->item_name }}</div>
                            <small class="text-muted">أضيف في: {{ $item->created_at->format('Y-m-d') }}</small>
                        </td>
                        
                        <td>
                            <span class="badge bg-info-soft text-info border px-2 py-1">{{ $item->type }}</span>
                            <div class="small text-muted">{{ $item->category }}</div>
                        </td>

                        <td>
                            <span class="text-success fw-bold">{{ $item->quantity_available }}</span> 
                            <span class="text-muted">/ {{ $item->total_quantity }}</span>
                            <div class="progress mt-1" style="height: 5px; width: 100px;">
    @php 
        $percent = ($item->total_quantity > 0) ? ($item->quantity_available/ $item->total_quantity) * 100 : 0;
    @endphp
    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent; ?>%"></div>
</div>
                        </td>

                        <td>
                            <span class="badge {{ $item->condition == 'جديد' ? 'bg-success' : 'bg-warning' }} px-2 py-1">
                                {{ $item->condition }}
                            </span>
                        </td>

                        <td>
                            <i class="fas fa-map-marker-alt text-danger me-1 small"></i> {{ $item->storage_location ?? 'غير محدد' }}
                        </td>

                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('inventories.edit', $item->id) }}" class="btn btn-sm btn-outline-warning mx-1" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" onclick="confirmDestroy(`{{ route('inventories.destroy', $item->id) }}`, this)" class="btn btn-sm btn-outline-danger mx-1" title="حذف">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 d-block text-light"></i>
                            لا توجد أصناف في المخزن حالياً
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection