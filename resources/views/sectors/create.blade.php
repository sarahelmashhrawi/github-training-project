<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة منطقة جديدة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">إضافة منطقة جديدة</h3>
            </div>
            <div class="card-body text-start">
                <form action="{{ route('sectors.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم المنطقة</label>
                        <select name="name" class="form-select" required>
                            <option value="" disabled selected>-- اختر المنطقة --</option>
                            <option value="محافظة شمال غزة">محافظة شمال غزة</option>
                            <option value="محافظة غزة">محافظة غزة</option>
                            <option value="المحافظة الوسطى">المحافظة الوسطى</option>
                            <option value="محافظة خانيونس">محافظة خانيونس</option>
                            <option value="محافظة رفح">محافظة رفح</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">العنوان </label>
                        <textarea name="description" class="form-control" rows="3" placeholder="اكتب العنوان بالتفصيل  او اقرب معلم "></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">المشرف المسؤول</label>
                        <select name="supervisor_id" class="form-select">
                            <option value="">-- اختر مشرفاً من القائمة --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - ({{ $user->phone ?? 'لا يوجد رقم' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">حفظ البيانات</button>
                        <a href="{{ route('sectors.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>