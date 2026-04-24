@extends('cms.parent')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-outline card-danger text-center">
                <div class="card-header">
                    <h3 class="card-title" style="float: none;">تسجيل الخروج</h3>
                </div>
                <div class="card-body">
                    <p>هل أنت متأكد أنك تريد تسجيل الخروج والعودة للرئيسية؟</p>
                    <div class="d-flex justify-content-center" style="gap: 10px;">
                        <form action="{{ route('logout.final') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">نعم، سجل الخروج</button>
</form>
<a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">إلغاء</a>                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection