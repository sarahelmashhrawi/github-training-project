<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة النازحين | نظام المخيم</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #fdfbf7; color: #3e2723; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-back { background: #a67c52; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; transition: 0.3s; }
        .btn-back:hover { background: #8d6e63; }
        .table-container { background: white; border-radius: 12px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; min-width: 1200px; }
        th { background: #3e2723; color: white; padding: 15px; text-align: right; white-space: nowrap; }
        td { padding: 12px 15px; border-bottom: 1px solid #f1f1f1; font-size: 14px; vertical-align: middle; }
        tr:hover { background-color: #fcf8f3; }
        .head-row { background-color: #fffaf0 !important; border-right: 4px solid #a67c52; }
        
        /* Badges */
        .badge { padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: bold; display: inline-block; margin: 2px; }
        .badge-health { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .badge-chronic { background: #fff3e0; color: #e65100; border: 1px solid #ffe0b2; }
        .badge-social { background: #e3f2fd; color: #1565c0; }
        .badge-safe { background: #e8f5e9; color: #2e7d32; }
        .tent-number { font-weight: bold; color: #a67c52; }

        /* زر التفاصيل */
        .btn-details { background: #e3f2fd; color: #1565c0; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; transition: 0.3s; }
        .btn-details:hover { background: #1565c0; color: white; }

        /* تنسيق النافذة المنبثقة (Modal) */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 10% auto; padding: 25px; border-radius: 15px; width: 40%; box-shadow: 0 5px 20px rgba(0,0,0,0.2); position: relative; }
        .close-modal { position: absolute; left: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #8d6e63; }
        .modal-header { border-bottom: 2px solid #fdfbf7; padding-bottom: 10px; margin-bottom: 20px; color: #3e2723; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item label { font-weight: bold; color: #a67c52; display: block; font-size: 13px; }
    </style>
</head>
<body>

    <div class="header">
        <h1><i class="fa-solid fa-people-group" style="color: #a67c52;"></i> سجل بيانات النازحين الشامل</h1>
        <a href="{{ route('dashboard') }}" class="btn-back"><i class="fa-solid fa-arrow-right"></i> العودة للوحة التحكم</a>
    </div>

    <div class="table-container">
        <table>
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
                    <td><span class="badge badge-social">متزوج</span></td>
                    <td><span class="badge badge-safe">سليم</span></td>
                    <td class="tent-number"><i class="fa-solid fa-tent"></i> {{ $head->tent_id }}</td>
                    <td><button class="btn-details" onclick="showHeadDetails('{{ $head->head_name }}')">التفاصيل</button></td>
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
                        <span class="badge badge-social">
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
                        @if($individual->has_disability) <span class="badge badge-health">{{ $individual->disability_type }}</span> @endif
                        @if($individual->has_chronic_disease) <span class="badge badge-chronic">{{ $individual->chronic_disease_name }}</span> @endif
                        @if($individual->is_pregnant) <span class="badge" style="background: #fce4ec; color: #ad1457;">حامل 🤰</span> @endif
                        @if($individual->is_breastfeeding) <span class="badge" style="background: #f3e5f5; color: #7b1fa2;">مرضع 🤱</span> @endif
                        @if(!$individual->has_disability && !$individual->has_chronic_disease && !$individual->is_pregnant) <span class="badge badge-safe">سليم</span> @endif
                    </td>
                    <td class="tent-number">{{ $individual->tent_id ?? ($individual->family->tent_id ?? '---') }}</td>
                    <td>
                        <button class="btn-details" onclick="showModal('{{ $individual->full_name }}', '{{ $individual->relation_to_head }}', '{{ $individual->medical_attachment ? 'يوجد مرفق' : 'لا يوجد' }}')">
                            عرض المزيد
                        </button>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2 id="modalName">اسم النازح</h2>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <label>صلة القرابة:</label>
                    <p id="modalRelation">---</p>
                </div>
                <div class="info-item">
                    <label>المرفق الطبي:</label>
                    <p id="modalMedical">---</p>
                </div>
                <div class="info-item">
                    <label>حالة البيانات:</label>
                    <p>مكتملة ✅</p>
                </div>
            </div>
        </div>
    </div>

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

</body>
</html>