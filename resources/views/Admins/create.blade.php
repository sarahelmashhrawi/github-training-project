@extends('cms.parent')

@section('content')
<div class="container-fluid mt-4">
    <div class="card card-success"> <div class="card-header">
            <h3 class="card-title">إضافة مشرف جديد</h3>
        </div>
        
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <div class="card-body" style="text-align: right;">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="form-group">
                    <label>الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" placeholder="اكتب الاسم هنا" required>
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" placeholder="mail@example.com" required>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" placeholder="اكتب كلمة مرور قوية" required>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">حفظ البيانات</button>
            </div>
        </form>
    </div>
</div>
@endsection