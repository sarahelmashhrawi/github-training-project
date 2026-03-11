<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة العائلات</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2280%22>👨‍👩‍👧‍👦</text></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; color: #333; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #fff; }
        .search-box { position: relative; width: 250px; }
        .search-box input { padding-right: 40px; border-radius: 25px; border: 1px solid #e0e0e0; height: 45px; transition: all 0.3s ease; }
        .search-box input:focus { border-color: #0d6efd; box-shadow: 0 0 8px rgba(13, 110, 253, 0.2); outline: none; }
        .search-box i { position: absolute; right: 15px; top: 13px; color: #0d6efd; font-size: 1.1rem; }
        
        /* ألوان تصنيفات العائلات */
        .badge-normal { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
        .badge-female { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
        .badge-orphans { background-color: #cff4fc; color: #055160; border: 1px solid #b6effb; }
        
        .btn-add { background: linear-gradient(45deg, #0d6efd, #0dcaf0); border: none; border-radius: 10px; transition: transform 0.2s; }
        .btn-add:hover { transform: translateY(-2px); color: #fff; }
        
        .dataTables_filter, .dataTables_length, .dataTables_paginate { display: none !important; }
        .table thead th { background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; color: #555; }
    </style>
</head>
<body>

    <main class="container mt-5 mb-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h3 class="fw-bold m-0"><i class="fas fa-users text-primary me-2"></i> إدارة العائلات</h3>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" id="familySearch" placeholder="بحث عن عائلة...">
                    </div>
                    <a href="{{ route('families.create') }}" class="btn btn-primary btn-add fw-bold text-white px-4 py-2">
                        <i class="fas fa-plus-circle me-1"></i> تسجيل عائلة
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="familiesTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>اسم رب الأسرة</th>
                            <th>رقم الهوية</th>
                            <th>رقم الخيمة</th>
                            <th>التصنيف</th>
                            <th>المنطقة الأصلية</th>
                            <th>المنطقة الحالية</th> 
                            <th class="text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($families as $family)
                        <tr>
                            <td class="fw-bold text-primary"><i class="fas fa-user-tie me-1 text-muted"></i> {{ $family->head_name }}</td>
                            <td>{{ $family->id_number ?? 'غير مسجل' }}</td>
                            <td>
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-tent me-1"></i> خيمة {{ $family->tent->tent_number ?? 'بدون' }}
                                </span>
                            </td>
                            <td>
                                @if($family->family_type == 'normal')
                                    <span class="badge badge-normal px-3 py-2 rounded-pill">طبيعية</span>
                                @elseif($family->family_type == 'female_headed')
                                    <span class="badge badge-female px-3 py-2 rounded-pill">تعيلها امرأة</span>
                                @else
                                    <span class="badge badge-orphans px-3 py-2 rounded-pill">أيتام</span>
                                @endif
                            </td>
                            <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $family->original_area ?? 'غير محدد' }}</td>
                            
                            <td><i class="fas fa-map-pin text-warning me-1"></i> {{ $family->current_area ?? 'غير محدد' }}</td>
                            
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('families.show', $family->id) }}" class="btn btn-outline-info btn-sm border-0" title="عرض الأفراد">
                                        <i class="fas fa-eye fa-lg"></i>
                                    </a>
                                    <a href="{{ route('families.edit', $family->id) }}" class="btn btn-outline-warning btn-sm border-0" title="تعديل">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <form action="{{ route('families.destroy', $family->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm border-0 btn-delete" title="حذف">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users-slash fa-4x mb-3 opacity-25"></i>
                                    <p class="h5">لا توجد عائلات مسجلة حالياً</p>
                                    <small>ابدئي بتسجيل أول عائلة في المخيم</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            const table = $('#familiesTable').DataTable({ 
                "paging": false,
                "info": false, 
                "ordering": true,
                "dom": 't', 
                "language": { "zeroRecords": "لم يتم العثور على عائلات" } 
            });

            $('#familySearch').on('keyup', function() { 
                table.search(this.value).draw(); 
            });

            $('.btn-delete').on('click', function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'هل أنتِ متأكدة؟',
                    text: "سيتم حذف العائلة وجميع الأفراد التابعين لها نهائياً!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'إلغاء'
                }).then((result) => { 
                    if (result.isConfirmed) form.submit(); 
                });
            });
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'رائع!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

</body>
</html>