@extends('cms.parent')

@section('title', 'سجل بيانات النازحين الشامل')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/individuals/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="container-fluid py-4 bg-light min-vh-100" style="font-family: 'Segoe UI', Tahoma, sans-serif;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0 fw-bold"><i class="fa-solid fa-people-group" style="color: #a67c52;"></i> سجل بيانات النازحين الشامل</h3>
        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 rounded shadow-sm">
            <i class="fa-solid fa-arrow-right mr-1"></i> العودة للوحة التحكم
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم الكامل</th>
                        <th>الجنس</th>
                        <th>تاريخ الميلاد</th>
                        <th>رقم الهوية</th>
                        <th>الحالة الاجتماعية</th>
                        <th>الحالة الصحية</th>
                        <th>رقم الخيمة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 1. عرض أرباب الأسر --}}
                    @foreach($familyHeads as $head)
                    <tr class="head-row">
                        <td>{{ $head->id }}</td>
                        <td><strong>{{ $head->head_name }}</strong> <small style="color: #a67c52;">(رب الأسرة)</small></td>
                        <td>ذكر</td>
                        <td>{{ $head->dob ?? 'يرجى التحديث' }}</td>
                        <td>{{ $head->id_number }}</td>
                        <td><span class="badge rounded-pill badge-social">متزوج</span></td>
                        <td><span class="badge rounded-pill badge-safe">سليم</span></td>
                        <td class="fw-bold text-primary"><i class="fa-solid fa-tent"></i> {{ $head->tent_id }}</td>
                        <td><button class="btn btn-sm btn-details rounded" onclick="showHeadDetails('{{ $head->head_name }}')">التفاصيل</button></td>
                    </tr>
                    @endforeach

                    {{-- 2. عرض الأفراد التابعين --}}
                    @forelse($individuals as $individual)
                    <tr>
                        <td>{{ $individual->id }}</td>
                        <td><strong>{{ $individual->full_name }}</strong></td>
                        <td>{{ ($individual->gender == 'male' || $individual->gender == 'ذكر') ? 'ذكر' : 'أنثى' }}</td>
                        <td>{{ $individual->dob ?? '---' }}</td>
                        <td>{{ $individual->id_number ?? '---' }}</td>
                        <td>
                            <span class="badge rounded-pill badge-social">
                                @php
                                    $rel = strtolower($individual->relation_to_head);
                                    $gen = $individual->gender;
                                @endphp
                                @if($rel == 'زوجة' || $rel == 'wife') متزوجة
                                @elseif($rel == 'زوج' || $rel == 'husband') متزوج
                                @elseif($rel == 'ابن' || $rel == 'son') أعزب
                                @elseif($rel == 'ابنة' || $rel == 'daughter') عزباء
                                @else {{ ($gen == 'female' || $gen == 'أنثى') ? 'عزباء' : 'أعزب' }}
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($individual->has_disability) <span class="badge rounded-pill badge-health">{{ $individual->disability_type }}</span> @endif
                            @if($individual->has_chronic_disease) <span class="badge rounded-pill badge-chronic">{{ $individual->chronic_disease_name }}</span> @endif
                            @if($individual->is_pregnant) <span class="badge rounded-pill badge-pregnant">حامل 🤰</span> @endif
                            @if($individual->is_breastfeeding) <span class="badge rounded-pill badge-breastfeeding">مرضع 🤱</span> @endif
                            
                            @if(!$individual->has_disability && !$individual->has_chronic_disease && !$individual->is_pregnant && !$individual->is_breastfeeding) 
                                <span class="badge rounded-pill badge-safe">سليم</span> 
                            @endif
                        </td>
                        <td class="fw-bold text-primary">{{ $individual->tent_id ?? ($individual->family->tent_id ?? '---') }}</td>
                        <td>
                            <button class="btn btn-sm btn-details rounded" onclick="showModal('{{ $individual->full_name }}', '{{ $individual->relation_to_head }}', '{{ $individual->medical_attachment ? 'يوجد مرفق' : 'لا يوجد' }}')">
                                عرض المزيد
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">لا يوجد بيانات أفراد مسجلة حالياً.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- النافذة المنبثقة (Modal) --}}
    <div id="detailsModal" class="custom-modal-overlay">
        <div class="custom-modal-box">
            <span class="close-custom-modal" onclick="closeModal()">&times;</span>
            <div class="border-bottom pb-2 mb-4">
                <h4 id="modalName" class="fw-bold text-dark m-0">اسم النازح</h4>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="text-primary fw-bold small mb-1">صلة القرابة:</label>
                    <p id="modalRelation" class="m-0">---</p>
                </div>
                <div class="col-6 mb-3">
                    <label class="text-primary fw-bold small mb-1">المرفق الطبي:</label>
                    <p id="modalMedical" class="m-0">---</p>
                </div>
                <div class="col-6">
                    <label class="text-primary fw-bold small mb-1">حالة البيانات:</label>
                    <p class="m-0">مكتملة ✅</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showModal(name, relation, medical) {
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalRelation').innerText = relation;
        document.getElementById('modalMedical').innerText = medical;
        document.getElementById('detailsModal').style.display = "block";
    }

    function showHeadDetails(name) {
        showModal(name, 'رب الأسرة', 'لا يوجد مرفقات خاصة');
    }

    function closeModal() {
        document.getElementById('detailsModal').style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('detailsModal')) {
            closeModal();
        }
    }
</script>
@endsection