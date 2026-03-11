<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة خيمة جديدة</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>🏕️</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { border: none; background: linear-gradient(45deg, #198754, #20c997); color: white; padding: 25px; }
        .form-label { font-weight: bold; color: #444; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #ddd; transition: 0.3s; }
        .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: 0 0 8px rgba(25, 135, 84, 0.2); }
        .btn-save { background: #198754; border: none; border-radius: 12px; padding: 12px; font-weight: bold; color: white; width: 100%; transition: 0.3s; }
        .btn-save:hover { background: #146c43; transform: translateY(-2px); }
        .input-group-text { border-radius: 0 12px 12px 0 !important; background-color: #f8f9fa; }
        .form-control { border-radius: 12px 0 0 12px !important; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="mb-0 fw-bold"><i class="fas fa-tent me-2"></i> إضافة خيمة جديدة للمخيم</h3>
                </div>
                
                <div class="card-body p-4 text-start">
                    <form action="{{ route('tents.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label">المنطقة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <select name="sector_id" class="form-select" required>
                                    <option value="">-- اختر المنطقة التابعة لها --</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">رقم الخيمة</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                    <input type="text" name="tent_number" class="form-control" placeholder="مثال: T-10" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label">عدد الأفراد (حد أقصى 20)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" name="capacity" class="form-control" value="4" min="1" max="20" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">حالة الخيمة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                <select name="condition" class="form-select" required>
                                    <option value="good">ممتازة </option>
                                    <option value="worn">مهترئة </option>
                                    <option value="needs_shade">تحتاج شوادر </option>
                                    <option value="flooded">غارقة </option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-save shadow-sm">
                                <i class="fas fa-plus-circle me-1"></i> حفظ بيانات الخيمة
                            </button>
                            <div class="text-center mt-3">
                                <a href="{{ route('tents.index') }}" class="text-decoration-none text-muted small">
                                    <i class="fas fa-arrow-right me-1"></i> العودة لقائمة الخيام
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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