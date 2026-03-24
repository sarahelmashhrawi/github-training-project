<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنطقة | {{ $sector->name }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { border: none; padding: 20px; background: linear-gradient(45deg, #ffc107, #ff9800); }
        .form-control, .form-select { border-radius: 10px; border: 1px solid #ddd; padding: 12px; }
        .form-control:focus, .form-select:focus { box-shadow: 0 0 10px rgba(255, 193, 7, 0.2); border-color: #ffc107; }
        .btn-update { background: #ffc107; border: none; border-radius: 10px; padding: 10px 30px; font-weight: bold; color: #222; }
        .btn-update:hover { background: #e0a800; }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-dark text-center">
                        <h3 class="mb-0 fw-bold">⚙️ تعديل بيانات المنطقة</h3>
                        <small>أنتِ الآن تعدلين: <strong>{{ $sector->name }}</strong></small>
                    </div>
                    
                    <div class="card-body p-4 text-start">
                        <form id="editSectorForm" action="{{ route('sectors.update', $sector->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم المنطقة</label>
                                <select name="name" id="sectorName" class="form-select" required>
                                    <option value="" disabled>-- اختاري المنطقة --</option>
                                    <option value="محافظة شمال غزة" {{ $sector->name == 'محافظة شمال غزة' ? 'selected' : '' }}>محافظة شمال غزة</option>
                                    <option value="محافظة غزة" {{ $sector->name == 'محافظة غزة' ? 'selected' : '' }}>محافظة غزة</option>
                                    <option value="المحافظة الوسطى" {{ $sector->name == 'المحافظة الوسطى' ? 'selected' : '' }}>المحافظة الوسطى</option>
                                    <option value="محافظة خانيونس" {{ $sector->name == 'محافظة خانيونس' ? 'selected' : '' }}>محافظة خانيونس</option>
                                    <option value="محافظة رفح" {{ $sector->name == 'محافظة رفح' ? 'selected' : '' }}>محافظة رفح</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الموقع (الوصف)</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="أدخلي تفاصيل الموقع هنا...">{{ $sector->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">المشرف المسؤول</label>
                                <select name="supervisor_id" class="form-select">
                                    <option value="">-- اختر مشرفاً من القائمة --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $sector->supervisor_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - ({{ $user->phone ?? 'لا يوجد رقم' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4 d-flex gap-2">
                                <button type="button" id="submitBtn" class="btn btn-update">حفظ التعديلات</button>
                                <a href="{{ route('sectors.index') }}" class="btn btn-outline-secondary px-4 py-2 border-0">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // حركة ديناميكية عند الضغط على حفظ
            $('#submitBtn').on('click', function() {
                let name = $('#sectorName').val();

                if(!name || name.trim() === '') {
                    Swal.fire('خطأ!', 'الرجاء اختيار اسم المنطقة', 'error');
                    return;
                }

                Swal.fire({
                    title: 'هل تريدين حفظ التعديلات؟',
                    text: "سيتم تحديث البيانات فوراً",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'نعم، حفظ',
                    cancelButtonText: 'تراجع',
                    color: '#000',
                    background: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // إظهار لودينج بسيط قبل الإرسال
                        Swal.fire({
                            title: 'جاري الحفظ...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        $('#editSectorForm').submit();
                    }
                });
            });
        });
    </script>
</body>
</html>