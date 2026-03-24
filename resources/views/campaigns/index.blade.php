<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة مساعدات الخيام</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9; 
            font-family: 'Tajawal', sans-serif; 
            color: #6c757d;
        }
        .main-card {
            background-color: #ffffff;
            border-radius: 15px; 
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
            margin-top: 50px;
            border: none;
        }
        .header-title {
            color: #343a40;
            font-weight: 700;
        }
        .btn-add-campaign {
            background-color: #28a745; 
            color: #ffffff;
            border-radius: 25px; 
            padding: 10px 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-add-campaign:hover {
            background-color: #218838;
            color: #ffffff;
        }
        .search-input {
    border-radius: 25px;
    border: 1px solid #e1e5eb;
    padding: 10px 20px 10px 40px; 
    width: 320px;
    background-color: #fbfcfd;
}

.search-input {
    padding: 10px 40px 10px 20px; 
}

.search-icon {
    color: #a8b3c4;
    right: 15px; 
    left: auto; 
    font-size: 1.1em;
    pointer-events: none;
}
        .table thead th {
            border-bottom: 2px solid #edf2f9;
            color: #8a94a6;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        .table tbody td {
            padding: 15px;
            color: #343a40;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f9;
        }
        .action-icon {
            text-decoration: none;
            margin: 0 8px;
            font-size: 1.1em;
            transition: transform 0.2s;
        }
        .action-icon:hover { transform: scale(1.1); }
        .edit-icon { color: #ff9f43; } 
        .delete-icon {
            color: #ea5455; 
            border: none;
            background: none;
            padding: 0;
            cursor: pointer;
        }
        .status-badge {
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .confirm-alert {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            z-index: 1000;
            text-align: center;
            width: 450px;
        }
        .confirm-alert-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 999;
        }
        .btn-yes { background-color: #ea5455; color: white; border-radius: 10px; padding: 10px 30px; }
        .btn-no { background-color: #b8c2cc; color: #343a40; border-radius: 10px; padding: 10px 30px; }
    </style>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📦</text></svg>">
</head>
<body>
    <div class="container main-card shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: #edf2f9 !important;">
            <h3 class="header-title">إدارة توزيع المساعدات للخيام</h3>
            <div class="d-flex align-items-center">
                <div class="position-relative">
                    <input type="text" class="search-input" placeholder="البحث عن مساعدة...">
                    <i class="fas fa-search search-icon position-absolute top-50 translate-middle-y"></i>
                </div>
                <a href="{{ route('campaigns.create') }}" class="btn-add-campaign ms-3">
                    إضافة مساعدة جديدة +
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table text-center table-borderless">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نوع المساعدة</th>
                        <th>المنطقة </th>
                        <th>تاريخ البدء</th>
                        <th>تاريخ الانتهاء</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
@forelse($campaigns as $campaign)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td class="fw-bold">{{ $campaign->title }}</td>
        <td>{{ $campaign->location }}</td>
        <td>{{ $campaign->start_date }}</td>
        
        <td>{{ $campaign->end_date ?? 'لم يحدد' }}</td> 
        
        <td>
            @if($campaign->status == 'available')
                <span class="badge bg-success status-badge">متاح للتوزيع</span>
            @elseif($campaign->status == 'full')
                <span class="badge bg-danger status-badge">مكتمل التوزيع</span>
            @else
                <span class="badge bg-secondary status-badge">غير محدد</span>
            @endif
        </td>
        
        <td class="action-column">
            <a href="{{ route('campaigns.show', $campaign->id) }}" class="action-icon text-info" title="عرض"><i class="fas fa-eye"></i></a>
            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="action-icon edit-icon" title="تعديل"><i class="fas fa-edit"></i></a>
            
            <form id="delete-form-{{ $campaign->id }}" action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" class="delete-icon action-icon" onclick="showConfirmAlert({{ $campaign->id }})" title="حذف">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center pt-5">لا توجد مساعدات مسجلة حالياً.</td>
    </tr>
@endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="confirm-alert-overlay" class="confirm-alert-overlay" onclick="closeConfirmAlert()"></div>
    <div id="confirm-alert" class="confirm-alert">
        <i class="fas fa-exclamation-triangle text-warning mb-4" style="font-size: 4rem;"></i>
        <h3 class="fw-bold text-dark">هل أنت متأكد؟</h3>
        <p class="text-muted fs-5">لن تتمكن من التراجع عن حذف هذا السجل!</p>
        <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-yes px-5 me-3" id="confirm-btn-yes" onclick="submitDelete()">نعم، احذف!</button>
            <button class="btn btn-no px-5" onclick="closeConfirmAlert()">إلغاء</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        let currentCampaignId = null;

        function showConfirmAlert(id) {
            currentCampaignId = id;
            document.getElementById('confirm-alert-overlay').style.display = 'block';
            document.getElementById('confirm-alert').style.display = 'block';
        }

        function closeConfirmAlert() {
            document.getElementById('confirm-alert-overlay').style.display = 'none';
            document.getElementById('confirm-alert').style.display = 'none';
        }

        function submitDelete() {
            if (currentCampaignId !== null) {
                document.getElementById('delete-form-' + currentCampaignId).submit();
            }
            closeConfirmAlert();
        }
    </script>
</body>
</html>