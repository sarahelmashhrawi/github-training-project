@extends('cms.parent')

@section('title', 'إدارة الخيام')

@section('styles')
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h3 class="fw-bold m-0 text-dark"><i class="fas fa-campground text-success me-2"></i> إدارة الخيام</h3>
            <a href="{{ route('tents.create') }}" class="btn btn-success fw-bold text-white px-4 py-2">
                <i class="fas fa-plus-circle me-1"></i> إضافة خيمة
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>رقم الخيمة</th>
                        <th>المنطقة</th>
                        <th>الحالة</th>
                        <th>السعة</th>
                        <th>اسم المخيم  </th>
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tents as $tent)
                    <tr>
                        <td class="fw-bold text-success">{{ $tent->tent_number }}</td>
                    
                        <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $tent->sector->name ?? 'غير محددة' }}</td>
                        <td>
                            <span class="badge px-3 py-2 rounded-pill 
                                {{ $tent->condition == 'good' ? 'bg-success' : 
                                   ($tent->condition == 'worn' ? 'bg-warning' : 
                                   ($tent->condition == 'needs_shade' ? 'bg-primary' : 'bg-danger')) }}">
                                {{ $tent->condition == 'good' ? 'ممتازة' : 
                                   ($tent->condition == 'worn' ? 'مهترئة' : 
                                   ($tent->condition == 'needs_shade' ? 'تحتاج شادر' : 'غارقة')) }}
                            </span>
                        </td>
                        
                        <td><i class="fas fa-users me-1 text-secondary"></i> {{ $tent->capacity }}</td>
                    <td>{{ $tent->camp->name ?? 'لا يوجد مخيم' }}</td>
                        
                        <td class="text-center">
                            <div class="btn-group gap-2">
                                <a href="{{ route('tents.edit', $tent->id) }}" class="btn btn-sm btn-outline-warning border-0">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <button type="button" onclick="confirmDestroy('{{ route('tents.destroy', $tent->id) }}', this)" 
                                        class="btn btn-sm btn-outline-danger border-0">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">لا توجد خيام مسجلة حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection