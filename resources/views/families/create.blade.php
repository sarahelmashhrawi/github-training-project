<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة عائلة جديدة</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>👨‍👩‍👧‍👦</text></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { border: none; background: linear-gradient(45deg, #0d6efd, #0dcaf0); color: white; padding: 25px; }
        .form-label { font-weight: bold; color: #444; margin-bottom: 8px; }
        .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #ddd; transition: 0.3s; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 8px rgba(13, 110, 253, 0.2); }
        .btn-save { background: #0d6efd; border: none; border-radius: 12px; padding: 12px; font-weight: bold; color: white; width: 100%; transition: 0.3s; }
        .btn-save:hover { background: #0b5ed7; transform: translateY(-2px); }
        .input-group-text { border-radius: 0 12px 12px 0 !important; background-color: #f8f9fa; }
        .form-control, .form-select { border-radius: 12px 0 0 12px !important; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="mb-0 fw-bold"><i class="fas fa-users me-2"></i> تسجيل عائلة جديدة في المخيم</h3>
                </div>
                
                <div class="card-body p-4 text-start">
                    <form action="{{ route('families.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">الخيمة المخصصة</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tent"></i></span>
                                    <select name="tent_id" class="form-select" required>
                                        <option value="">-- اختر رقم الخيمة --</option>
                                        @foreach($tents as $tent)
                                            <option value="{{ $tent->id }}">خيمة {{ $tent->tent_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">تصنيف العائلة</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                    <select name="family_type" class="form-select" required>
                                        <option value="normal">عائلة طبيعية (Normal)</option>
                                        <option value="female_headed">تعيلها امرأة (Female Headed)</option>
                                        <option value="orphans">أيتام (Orphans)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">اسم رب / ربة الأسرة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                <input type="text" name="head_name" class="form-control" placeholder="الاسم الرباعي" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="form-label">رقم الهوية</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="id_number" class="form-control" placeholder="رقم الهوية">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <label class="form-label">رقم الجوال</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control" placeholder="05xxxxxxxxx">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label">المنطقة الأصلية (النزوح)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                    <input type="text" name="original_area" class="form-control" placeholder="مثال: غزة - الرمال">
                                </div>
                            </div>
                        </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">المنطقة الحالية</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                        <input type="text" name="current_area" class="form-control" placeholder="مثال: دير البلح - المواصي">
                                    </div>
                                </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-save shadow-sm">
                                <i class="fas fa-save me-1"></i> حفظ بيانات العائلة
                            </button>
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
            confirmButtonText: 'حسناً'
        });
    </script>
    @endif
</body>
</html>