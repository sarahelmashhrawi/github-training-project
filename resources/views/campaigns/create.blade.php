@extends('cms.parent')

@section('title', 'إضافة مساعدة جديدة للخيام')

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
            background-color: #28a745; 
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
        .btn-save {
            background-color: #28a745;
            color: white;
            border-radius: 25px;
            padding: 10px 40px;
            font-weight: 500;
            border: none;
        }
        .btn-save:hover { background-color: #218838; color: white; }
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
                <h4>إضافة مساعدات جديدة للخيام</h4>
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

                <form action="{{ route('campaigns.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">نوع المساعدة (مثال: طرود، بطانيات)</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="أدخل نوع المساعدة" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">المنطقة / القطاع</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="أدخل المنطقة" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">عدد العائلات المستفيدة</label>
                            <input type="number" name="target_families" class="form-control" value="{{ old('target_families') }}" placeholder="أدخل العدد" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">الكمية المتاحة للتوزيع</label>
                            <input type="number" name="total_capacity" class="form-control" value="{{ old('total_capacity') }}" placeholder="أدخل الكمية" required>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">تاريخ البدء</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">تفاصيل المساعدة / ملاحظات</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="أدخل أي تفاصيل إضافية">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
    <label class="form-label">حالة المساعدة</label>
    <select name="status" class="form-control" required>
        <option value="available">متاح للتوزيع</option>
        <option value="full">مكتمل التوزيع</option>
    </select>
</div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-save px-5">حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection