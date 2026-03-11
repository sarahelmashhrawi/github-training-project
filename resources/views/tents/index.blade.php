<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>إدارة الخيام</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⛺</text></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; color: #333; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #fff; }
        .search-box { position: relative; width: 250px; }
        .search-box input { padding-right: 40px; border-radius: 25px; border: 1px solid #e0e0e0; height: 45px; transition: all 0.3s ease; }
        .search-box input:focus { border-color: #198754; box-shadow: 0 0 8px rgba(25, 135, 84, 0.2); outline: none; }
        .search-box i { position: absolute; right: 15px; top: 13px; color: #198754; font-size: 1.1rem; }
        .badge-good { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .badge-worn { background-color: #fff3cd; color: #664d03; border: 1px solid #ffecb5; }
        .badge-needs_shade { background-color: #cfe2ff; color: #084298; border: 1px solid #b6d4fe; }
        .badge-flooded { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
        .btn-add { background: linear-gradient(45deg, #198754, #2bb179); border: none; border-radius: 10px; transition: transform 0.2s; }
        .btn-add:hover { transform: translateY(-2px); color: #fff; }
    </style>
</head>
<body>

    <main class="container mt-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h3 class="fw-bold m-0"><i class="fas fa-campground text-success me-2"></i> إدارة الخيام</h3>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" id="tentSearch" placeholder="بحث عن خيمة...">
                    </div>
                    <a href="{{ route('tents.create') }}" class="btn btn-success btn-add fw-bold text-white px-4 py-2">
                        <i class="fas fa-plus-circle me-1"></i> إضافة خيمة
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>رقم الخيمة</th>
                            <th>المنطقة</th>
                            <th>الحالة</th>
                            <th>السعة</th>
                            <th class="text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tents as $tent)
                        <tr>
                            <td class="fw-bold text-success">{{ $tent->tent_number }}</td>
                            <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $tent->sector->name ?? 'غير محددة' }}</td>
                            <td>
                                <span class="badge badge-{{ $tent->condition }} px-3 py-2 rounded-pill">
                                    {{ $tent->condition == 'good' ? 'ممتازة' : ($tent->condition == 'worn' ? 'مهترئة' : ($tent->condition == 'needs_shade' ? 'تحتاج شادر' : 'غارقة')) }}
                                </span>
                            </td>
                            <td><i class="fas fa-users me-1 text-secondary"></i> {{ $tent->capacity }} أفراد</td>
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('tents.edit', $tent->id) }}" class="btn btn-outline-warning btn-sm border-0"><i class="fas fa-edit fa-lg"></i></a>
                                    <form action="{{ route('tents.destroy', $tent->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm border-0"><i class="fas fa-trash-alt fa-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">لا توجد خيام مسجلة حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>