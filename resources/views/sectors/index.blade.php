@extends('cms.parent')

@section('title', 'قائمة المناطق')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/sectors/index.css') }}?v={{ time() }}">
@endsection

@section('content')
    <div class="container mt-5">
        @if(session('success'))
    <div class="alert alert-success shadow-sm" style="border-radius: 10px; border: none; background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px;">
        <i class="fas fa-check-circle ml-2"></i>
        {{ session('success') }}
    </div>
@endif
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">📍 قائمة المناطق</h3>
                
             <div class="d-flex align-items-center gap-3">
    
 <div class="d-flex flex-column gap-2">
    <a href="{{ route('sectors.create') }}" class="btn btn-primary btn-add fw-bold text-white w-100">
        إضافة منطقة +
    </a>
    
    <a href="{{ route('sectors-trashed') }}" class="btn btn-danger btn-add fw-bold text-white w-100">
        <i class="fa-solid fa-trash-can me-1"></i> سلة المحذوفات
    </a>
</div>
</div>
            </div>
 <div>
                     <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 rounded shadow-sm">
            <i class="fa-solid fa-arrow-right mr-1"></i> العودة للوحة التحكم
        </a> 
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
                            <a href="{{ route('sectors.edit', $sector->id) }}" class="btn btn-warning btn-sm px-3 mx-1 text-dark fw-bold">
                                <i class="fa fa-edit"></i> تعديل
                            </a>
                            
                            <button type="button" onclick="confirmDestroy(`{{ route('sectors.destroy', $sector->id) }}`, this)" class="btn btn-danger btn-sm px-3">
                                <i class="fa fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @endsection