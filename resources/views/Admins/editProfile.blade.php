@extends('cms.parent')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">تعديل الملف الشخصي</h3>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3" style="text-align: right;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger m-3" style="text-align: right;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body" style="text-align: right;">
                        <div class="form-group">
                            <label for="name">الاسم الكامل</label>
                            <input type="text" name="name" class="form-control" id="name" 
                                   value="{{ auth()->user()->name }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" id="email" 
                                   value="{{ auth()->user()->email }}" required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection