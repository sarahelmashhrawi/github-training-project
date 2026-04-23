@extends('cms.parent')
@section('title', 'سجل الاحتياجات الطارئة')

@section('content')
<div class="container-fluid mt-4">
    <div class="card p-4 shadow-sm border-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0 text-danger">
                <i class="fas fa-exclamation-triangle me-2"></i> الاحتياجات الطارئة للمخيم
            </h3>
            <a href="{{ route('emergency_needs.create') }}" class="btn btn-danger fw-bold px-4 shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> تسجيل بلاغ جديد
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-right border">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th>رقم البلاغ</th>
                        <th>العائلة المتضررة</th>
                        <th>نوع الاحتياج</th>
                        <th>مستوى الخطورة</th>
                        <th>الحالة</th>
                        <th>تاريخ البلاغ</th>
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($needs as $need)
                    <tr>
                        <td><span class="badge bg-dark">#{{ $need->id }}</span></td>

                        {{-- تأكدي أن العلاقة في الموديل اسمها family والحقل في جدول العائلات هو head_name --}}
<td>
    {{ $need->family ? $need->family->head_name : 'غير محدد' }}
    <br>
    <small class="text-muted"><i class="fas fa-home"></i> {{ $need->family->tent->tent_number ?? '' }}</small>
</td>
                        
                        <td>
                            <span class="text-primary fw-bold">{{ $need->type_of_need }}</span>
                        </td>

                        <td>
                            @if($need->urgency_level == 'critical')
                                <span class="badge bg-danger px-3 py-2"><i class="fas fa-fire me-1"></i> حرِج جداً</span>
                            @elseif($need->urgency_level == 'high')
                                <span class="badge bg-warning text-dark px-3 py-2">مرتفع</span>
                            @elseif($need->urgency_level == 'medium')
                                <span class="badge bg-info text-white px-3 py-2">متوسط</span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">منخفض</span>
                            @endif
                        </td>

                        <td>
                            @if($need->status == 'pending')
                                <span class="text-danger small fw-bold"><i class="fas fa-clock me-1"></i> قيد الانتظار</span>
                            @elseif($need->status == 'in_progress')
                                <span class="text-primary small fw-bold"><i class="fas fa-spinner fa-spin me-1"></i> جاري المعالجة</span>
                            @else
                                <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> تم الحل</span>
                            @endif
                        </td>

                        <td class="small">
                            {{ $need->created_at->format('Y-m-d') }}
                            <div class="text-muted" style="font-size: 0.75rem;">{{ $need->created_at->diffForHumans() }}</div>
                        </td>

                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('emergency_needs.edit', $need->id) }}" class="btn btn-sm btn-outline-info">
    <i class="fas fa-edit"></i>
</a>
                                <button type="button" onclick="confirmDestroy(`{{ route('emergency_needs.destroy', $need->id) }}`, this)" class="btn btn-sm btn-outline-danger mx-1" title="حذف">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-list fa-3x mb-3 d-block text-light"></i>
                            لا توجد بلاغات احتياج مسجلة حالياً
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection