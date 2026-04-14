@extends('cms.parent')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/families.css') }}">
    
@endsection

@section('content')
<div class="container-fluid mt-4 mb-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show font-weight-bold text-right" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 text-right">
        <h3 class="font-weight-bold m-0"><i class="fas fa-home text-primary mr-2"></i> الملف الشامل للعائلة</h3>
        <a href="{{ route('families.index') }}" class="btn btn-back font-weight-bold px-4 py-2">
            <i class="fas fa-arrow-right mr-1"></i> عودة للقائمة
        </a>
    </div>

    <div class="card custom-profile-card p-4 border-top border-primary text-right" style="border-top-width: 4px !important;">
        <h5 class="font-weight-bold mb-4 border-bottom pb-3"><i class="fas fa-info-circle mr-1"></i> البيانات الأساسية</h5>
        <div class="row">
            <div class="col-md-4 d-flex align-items-center mb-4">
                <div class="icon-box bg-light-primary"><i class="fas fa-user-tie"></i></div>
                <div>
                    <span class="info-label">اسم رب/ربة الأسرة</span>
                    <span class="info-value">{{ $family->head_name }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center mb-4">
                <div class="icon-box bg-light-success"><i class="fas fa-tent"></i></div>
                <div>
                    <span class="info-label">رقم الخيمة المخصصة</span>
                    <span class="info-value">خيمة {{ $family->tent->tent_number ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center mb-4">
                <div class="icon-box bg-light-warning"><i class="fas fa-id-card"></i></div>
                <div>
                    <span class="info-label">رقم الهوية</span>
                    <span class="info-value">{{ $family->id_number ?? 'غير مسجل' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center mb-4">
                <div class="icon-box bg-light-primary"><i class="fas fa-phone"></i></div>
                <div>
                    <span class="info-label">رقم الجوال</span>
                    <span class="info-value">{{ $family->phone ?? 'لا يوجد' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center mb-4">
                <div class="icon-box bg-light-success"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <span class="info-label">المنطقة الأصلية</span>
                    <span class="info-value">{{ $family->original_area ?? 'غير محدد' }}</span>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-center mb-4">
                <div class="icon-box bg-light-warning"><i class="fas fa-map-pin"></i></div>
                <div>
                    <span class="info-label">المنطقة الحالية</span>
                    <span class="info-value">{{ $family->current_area ?? 'غير محدد' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card custom-profile-card p-4 mt-4 border-top border-success text-right" style="border-top-width: 4px !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="font-weight-bold m-0"><i class="fas fa-users text-success mr-2"></i> أفراد العائلة ({{ $family->individuals->count() ?? 0 }})</h5>
            <a href="{{ route('individuals.create', ['family_id' => $family->id]) }}" class="btn btn-success font-weight-bold text-white px-4 py-2" style="border-radius: 10px;">
                <i class="fas fa-user-plus mr-1"></i> إضافة فرد
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
                        <th>الحالة الصحية</th>
                        <th>المرفقات</th>
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($family->individuals as $individual)
                    <tr>
                        <td class="font-weight-bold text-dark">{{ $individual->full_name }}</td>
                        <td><span class="badge badge-secondary p-2">{{ $individual->relation_to_head ?? 'غير محدد' }}</span></td>
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
                            @if($individual->has_disability)
                                <span class="badge badge-danger p-1 mb-1">إعاقة: {{ $individual->disability_type }}</span>
                                <br>
                            @endif

                            @if($individual->has_chronic_disease)
                                <span class="badge badge-warning text-dark p-1">مرض: {{ $individual->chronic_disease_name }}</span>
                            @endif

                            @if(!$individual->has_disability && !$individual->has_chronic_disease)
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if($individual->medical_attachment)
                                <a href="{{ asset('storage/' . $individual->medical_attachment) }}" target="_blank" class="btn btn-sm btn-outline-info" title="عرض المرفق">
                                    <i class="fas fa-file-medical"></i> عرض
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('individuals.edit', $individual->id) }}" class="btn btn-sm btn-outline-primary border-0" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                         <button type="button" onclick="confirmDestroy(`{{ route('individuals.destroy', $individual->id) }}`, this)" class="btn btn-sm btn-outline-danger border-0" title="حذف">
    <i class="fas fa-trash"></i>
</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-user-times fa-4x mb-3" style="opacity: 0.3;"></i>
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
@endsection

@section('scripts')
@endsection