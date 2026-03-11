<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات الخيمة</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>✏️</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { border: none; padding: 20px; background: linear-gradient(45deg, #198754, #20c997); color: white; }
        .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #ddd; }
        .btn-update { background: #198754; border: none; border-radius: 12px; padding: 12px 30px; font-weight: bold; color: white; transition: 0.3s; }
        .btn-update:hover { background: #146c43; transform: scale(1.02); }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="mb-0 fw-bold">⚙️ تعديل بيانات الخيمة</h3>
                    <p class="mb-0">تعديل الخيمة رقم: <strong>{{ $tent->tent_number }}</strong></p>
                </div>
                
                <div class="card-body p-4 text-start">
                    <form id="editTentForm" action="{{ route('tents.update', $tent->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">رقم الخيمة</label>
                                <input type="text" name="tent_number" id="tentNumber" class="form-control" value="{{ $tent->tent_number }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">السعة (أفراد)</label>
                                <input type="number" name="capacity" class="form-control" value="{{ $tent->capacity }}" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">المنطقة التابعة لها</label>
                            <select name="sector_id" class="form-select" required>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" {{ $tent->sector_id == $sector->id ? 'selected' : '' }}>
                                        {{ $sector->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">حالة الخيمة</label>
                            <select name="condition" class="form-select" required>
                                <option value="good" {{ $tent->condition == 'good' ? 'selected' : '' }}>ممتازة (Good)</option>
                                <option value="worn" {{ $tent->condition == 'worn' ? 'selected' : '' }}>مهترئة (Worn)</option>
                                <option value="needs_shade" {{ $tent->condition == 'needs_shade' ? 'selected' : '' }}>تحتاج شوادر (Needs Shade)</option>
                                <option value="flooded" {{ $tent->condition == 'flooded' ? 'selected' : '' }}>غارقة (Flooded)</option>
                            </select>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="button" id="submitBtn" class="btn btn-update">حفظ التغييرات</button>
                            <a href="{{ route('tents.index') }}" class="btn btn-outline-secondary px-4 py-2 border-0">تراجع</a>
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
        $('#submitBtn').on('click', function() {
            Swal.fire({
                title: 'تأكيد التعديل؟',
                text: "سيتم تحديث حالة الخيمة في النظام",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'نعم، حفظ',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'جاري المعالجة...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                    $('#editTentForm').submit();
                }
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'عذراً، هناك خطأ!',
            text: "{{ $errors->first() }}",
            confirmButtonColor: '#d33',
            confirmButtonText: 'حسناً، سأقوم بالتعديل'
        });
    </script>
    @endif
</body>
</html>