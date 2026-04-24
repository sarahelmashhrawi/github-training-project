@extends('cms.parent')

@section('title', 'إدارة مساعدات الخيام')

@section('styles')
    <style>
        .main-card {
            background-color: #ffffff;
            border-radius: 15px; 
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
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
            padding: 10px 40px 10px 20px; 
            width: 320px;
            background-color: #fbfcfd;
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
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="main-card shadow-sm">
            
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: #edf2f9 !important;">
                <h3 class="header-title mb-3 mb-md-0">إدارة توزيع المساعدات للخيام</h3>
                <div class="d-flex flex-wrap align-items-center gap-3">
                  
                    <a href="{{ route('campaigns.create') }}" class="btn-add-campaign">
                        <i class="fas fa-plus me-1"></i> إضافة مساعدة جديدة
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-3">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table text-center table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نوع المساعدة</th>
                            <th>المنطقة</th>
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
                                    <a href="{{ route('campaigns.show', $campaign->id) }}" class="action-icon text-info" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('campaigns.edit', $campaign->id) }}" class="action-icon edit-icon" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button type="button" class="delete-icon action-icon" onclick="confirmDestroy(`{{ route('campaigns.destroy', $campaign->id) }}`, this)" title="حذف">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center pt-5 text-muted">لا توجد مساعدات مسجلة حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection