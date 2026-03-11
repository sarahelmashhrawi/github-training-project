<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف العائلة</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>🏠</text></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; color: #333; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); background: #fff; margin-bottom: 20px; }
        .info-label { font-size: 0.85rem; color: #6c757d; font-weight: bold; margin-bottom: 5px; display: block; }
        .info-value { font-size: 1.1rem; font-weight: bold; color: #2b2b2b; }
        .icon-box { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-left: 15px; }
        
        .bg-light-primary { background-color: #e7f1ff; color: #0d6efd; }
        .bg-light-success { background-color: #d1e7dd; color: #198754; }
        .bg-light-warning { background-color: #fff3cd; color: #ffc107; }
        
        .btn-back { background-color: #6c757d; color: white; border-radius: 10px; transition: 0.3s; }
        .btn-back:hover { background-color: #5a6268; color: white; transform: translateX(-3px); }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show fw-bold" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0"><i class="fas fa-home text-primary me-2"></i> الملف الشامل للعائلة</h3>
        <a href="{{ route('families.index') }}" class="btn btn-back fw-bold px-4 py-2">
            <i class="fas fa-arrow-right me-1"></i> عودة للقائمة
        </a>
    </div>

    <div class="card p-4 border-top border-primary border-4">
        <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-info-circle me-1"></i> البيانات الأساسية</h5>
        <div class="row g-4">
            <div class="col-md-4 d-flex align-items-center">
                <div class="icon-box bg-light-primary"><i class="fas fa-user-tie"></i></div>
                <div>
                    <span class="info-label">اسم رب/ربة الأسرة</span>
                    <span class="info-value">{{ $family->head_name }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="icon-box bg-light-success"><i class="fas fa-tent"></i></div>
                <div>
                    <span class="info-label">رقم الخيمة المخصصة</span>
                    <span class="info-value">خيمة {{ $family->tent->tent_number ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="icon-box bg-light-warning"><i class="fas fa-id-card"></i></div>
                <div>
                    <span class="info-label">رقم الهوية</span>
                    <span class="info-value">{{ $family->id_number ?? 'غير مسجل' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="icon-box bg-light-primary"><i class="fas fa-phone"></i></div>
                <div>
                    <span class="info-label">رقم الجوال</span>
                    <span class="info-value">{{ $family->phone ?? 'لا يوجد' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="icon-box bg-light-success"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <span class="info-label">المنطقة الأصلية</span>
                    <span class="info-value">{{ $family->original_area ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center">
                <div class="icon-box bg-light-warning"><i class="fas fa-map-pin"></i></div>
                <div>
                    <span class="info-label">المنطقة الحالية</span>
                    <span class="info-value">{{ $family->current_area ?? 'غير محدد' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 mt-4 border-top border-success border-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0"><i class="fas fa-users text-success me-2"></i> أفراد العائلة ({{ $family->individuals->count() ?? 0 }})</h5>
            <a href="{{ route('individuals.create', ['family_id' => $family->id]) }}" class="btn btn-success fw-bold text-white px-4 py-2" style="border-radius: 10px;">
                <i class="fas fa-user-plus me-1"></i> إضافة فرد
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>الاسم الرباعي</th>
                        <th>صلة القرابة</th>
                        <th>رقم الهوية</th>
                        <th>الجنس</th>
                        <th>العمر</th>
                        <th>حالة خاصة</th>
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
               <tbody>
                    @forelse($family->individuals as $individual)
                    <tr>
                        <td class="fw-bold text-dark">{{ $individual->full_name }}</td>
                        <td><span class="badge bg-secondary">{{ $individual->relation_to_head ?? 'غير محدد' }}</span></td>
                        <td>{{ $individual->id_number ?? 'غير مدخل' }}</td>
                        <td>
                            @if($individual->gender == 'male') ذكر 👨
                            @elseif($individual->gender == 'female') أنثى 👩
                            @else غير محدد @endif
                        </td>
                        <td>
                            @if($individual->dob)
                                {{ \Carbon\Carbon::parse($individual->dob)->age }} سنة
                            @else
                                <span class="text-muted">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            @if($individual->special_status)
                                <span class="badge bg-danger px-2 py-1"><i class="fas fa-heartbeat me-1"></i> {{ $individual->special_status }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('individuals.edit', $individual->id) }}" class="btn btn-sm btn-outline-primary border-0" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('individuals.destroy', $individual->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفرد من العائلة بشكل نهائي؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-user-times fa-4x mb-3 opacity-25"></i>
                            <h5 class="mb-2">لا يوجد أفراد مسجلين لهذه العائلة حالياً.</h5>
                            <p class="small">اضغطي على زر "إضافة فرد" لتسجيل الزوجة أو الأبناء.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>