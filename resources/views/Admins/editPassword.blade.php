@extends('cms.parent')

@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">تعديل كلمة المرور</h3>
        </div>
        @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('password.update') }}" method="POST">
    @csrf
    @method('PUT')            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>كلمة المرور الحالية</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">تحديث كلمة المرور</button>
            </div>
        </form>
    </div>
</div>
@endsection