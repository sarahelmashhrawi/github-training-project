<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المناطق</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .btn-add { background: linear-gradient(45deg, #0d6efd, #0099ff); border: none; border-radius: 10px; padding: 10px 25px; }
        
        /* تصميم خانة البحث بالعدسة */
        .search-box { position: relative; width: 300px; }
        .search-box input { padding-right: 35px; border-radius: 20px; border: 1px solid #ddd; width: 100%; height: 40px; }
        .search-box i { position: absolute; right: 12px; top: 12px; color: #aaa; }

        .table thead th { color: #555; font-weight: 700; border-bottom: 2px solid #eee !important; }
        
        /* إخفاء إضافات الداتا تيبل المزعجة */
        .dataTables_info, .dataTables_paginate, .dataTables_length { display: none !important; }
        .dataTables_filter { display: none; } /* سنستخدم خانة البحث الخاصة بنا */
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">📍 قائمة المناطق</h3>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" id="mySearchInput" placeholder="بحث عن منطقة...">
                    </div>
                    <a href="{{ route('sectors.create') }}" class="btn btn-primary btn-add fw-bold">إضافة منطقة +</a>
                </div>
            </div>

            <table id="sectorsTable" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>اسم المنطقة</th>
                        <th> العنوان</th>
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sectors as $sector)
                    <tr>
                        <td><span class="text-muted">#{{ $sector->id }}</span></td>
                        <td class="fw-bold">{{ $sector->name }}</td>
                        <td>{{ $sector->description ?? 'غير محدد' }}</td>
                        <td class="text-center">
                            <a href="{{ route('sectors.edit', $sector->id) }}" class="btn btn-warning btn-sm px-3 mx-1">
                                <i class="fa fa-edit"></i> تعديل
                            </a>
                            
                            <form action="{{ route('sectors.destroy', $sector->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm px-3 btn-delete">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // تفعيل الداتا تيبل بشكل "صامت"
            var table = $('#sectorsTable').DataTable({
                "paging": false,
                "info": false,
                "ordering": false,
                "language": { "zeroRecords": "لا يوجد نتائج" }
            });

            // ربط العدسة بالبحث الفعلي
            $('#mySearchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // الجافا سكريبت للحذف الاحترافي (SweetAlert)
            $('.btn-delete').on('click', function() {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'متأكدة من الحذف؟',
                    text: "سيتم إزالة المنطقة نهائياً من النظام",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'تراجع'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>