@extends('cms.parent')

@section('title', 'تفاصيل الحملة')

@section('styles')
    <style>
        .main-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 0px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: none;
            overflow: hidden;
        }
        .form-header {
            background-color: #00cfe8; /* أزرق فاتح مخصص للعرض */
            color: #ffffff;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-header h4 { font-weight: 700; margin: 0; }
        .form-body {
            padding: 30px 25px;
        }
        /* ستايل زر التعديل البرتقالي */
        .btn-edit {
            background-color: #ff9f43;
            color: white;
            border-radius: 25px;
            padding: 10px 40px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit:hover { color:white; background-color: #e68a35;}
        .detail-label { color: #8a94a6; font-weight: 500; font-size: 0.95em;}
        .detail-value { color: #343a40; font-weight: 500; font-size: 1.1em;}
        .detail-row {
            padding: 15px 0;
            border-bottom: 1px solid #edf2f9;
            margin-bottom: 0; 
        }
        .status-badge {
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .btn-recede {
            border-radius: 20px;
            padding: 6px 20px;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="main-card shadow-sm">
            <div class="form-header shadow-sm">
                <h4 class="mb-0"><i class="fas fa-eye me-2"></i>تفاصيل الحملة: {{ $campaign->title ?? 'بدون عنوان' }}</h4>
                <a href="{{ route('campaigns.index') }}" class="btn btn-light btn-sm btn-recede px-3">عودة للقائمة</a>
            </div>

            <div class="form-body">
                <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
                    <div class="card-body p-4">
                        
                        <div class="row align-items-center detail-row">
                            <div class="col-md-3"><span class="detail-label">الموقع / القطاع</span></div>
                            <div class="col-md-9"><span class="detail-value">{{ $campaign->location }}</span></div>
                        </div>
                        
                        <div class="row align-items-center detail-row">
                            <div class="col-md-3"><span class="detail-label">تاريخ البدء</span></div>
                            <div class="col-md-9"><span class="detail-value text-success">{{ $campaign->start_date }}</span></div>
                        </div>
                        
                        <div class="row align-items-center detail-row">
                            <div class="col-md-3"><span class="detail-label">الحالة</span></div>
                            <div class="col-md-9">
                                @php
                                    $statusText = 'غير محدد';
                                    $badgeClass = 'bg-secondary';

                                    if ($campaign->status === 'available') {
                                        $statusText = 'متاح';
                                        $badgeClass = 'bg-success'; // لون أخضر
                                    } elseif ($campaign->status === 'full') {
                                        $statusText = 'ممتلئ';
                                        $badgeClass = 'bg-danger'; // لون أحمر
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">{{ $statusText }}</span>
                            </div>
                        </div>
                        
                        <div class="row align-items-center detail-row">
                            <div class="col-md-3"><span class="detail-label">العائلات المستهدفة</span></div>
                            <div class="col-md-9"><span class="detail-value">{{ $campaign->target_families ?? 'غير محدد' }}</span></div>
                        </div>
                        
                        <div class="row align-items-center detail-row border-bottom-0">
                            <div class="col-md-3"><span class="detail-label">السعة الإجمالية</span></div>
                            <div class="col-md-9"><span class="detail-value">{{ $campaign->total_capacity ?? 'غير محدد' }}</span></div>
                        </div>
                        
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
                    <div class="card-body p-4">
                        <span class="detail-label mb-3 d-block">وصف الحملة</span>
                        <p class="mt-2 text-dark fs-6" style="line-height: 1.8;">{{ $campaign->description ?? 'لا يوجد وصف متاح لهذه الحملة.' }}</p>
                    </div>
                </div>

                <div class="text-center mt-5 pt-3 border-top" style="border-color: #edf2f9 !important;">
                    <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit me-2"></i>تعديل الحملة
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection