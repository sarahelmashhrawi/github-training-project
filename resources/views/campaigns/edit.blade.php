@extends('cms.parent')

@section('title', 'تعديل بيانات المساعدة')

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
            background-color: #ff9f43; 
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
        .btn-update {
            background-color: #ff9f43;
            color: white;
            border-radius: 25px;
            padding: 10px 40px;
            font-weight: 500;
            border: none;
        }
        .btn-update:hover { background-color: #e68a35; color: white; }
        .form-label { color: #8a94a6; font-weight: 500; font-size: 0.95em; margin-bottom: 8px;}
        .form-control, .form-select { 
            border-radius: 20px; 
            border: 1px solid #edf2f9; 
            padding: 12px 20px; 
            background-color: #fbfcfd;
            color: #343a40;
        }
        .form-control:focus, .form-select:focus {
            border-color: #d1d9e6;
            box-shadow: none;
            background-color: #ffffff;
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
                <h4><i class="fas fa-edit me-2"></i>تعديل المساعدة: {{ $campaign->title ?? 'بدون عنوان' }}</h4>
                <a href="{{ route('campaigns.index') }}" class="btn btn-light btn-sm btn-recede px-3">تراجع</a>
            </div>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4 rounded-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">نوع المساعدة (مثال: طرود، بطانيات)</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $campaign->title) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">المنطقة / القطاع</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $campaign->location) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">عدد العائلات المستفيدة</label>
                            <input type="number" name="target_families" class="form-control" value="{{ old('target_families', $campaign->target_families) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">الكمية المتاحة للتوزيع</label>
                            <input type="number" name="total_capacity" value="{{ old('total_capacity', $campaign->total_capacity) }}" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">تاريخ البدء</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $campaign->start_date) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">تاريخ الانتهاء</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $campaign->end_date) }}">
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">حالة التوزيع</label>
                            <select name="status" class="form-control">
                                <option value="" disabled>اختر الحالة</option>
                                <option value="available" {{ (isset($campaign) && $campaign->status == 'available') ? 'selected' : '' }}>متاح</option>
                                <option value="full" {{ (isset($campaign) && $campaign->status == 'full') ? 'selected' : '' }}>ممتلئ</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-4">
                            <label class="form-label">تفاصيل المساعدة / ملاحظات</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $campaign->description) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-update px-5">تحديث البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection