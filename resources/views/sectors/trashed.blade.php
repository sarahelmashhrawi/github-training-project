@extends('cms.parent')

@section('title', 'قائمة المناطق')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/sectors/index.css') }}?v={{ time() }}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark m-0">📍 قائمة المناطق</h3>
                
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 rounded shadow-sm">
                        <i class="fa-solid fa-arrow-right mr-1"></i> العودة للوحة التحكم
                    </a> 
                </div>
            </div>

            <table id="sectorsTable" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>اسم المنطقة</th>
                        <th>العنوان</th>
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
                            <div class ="btn group">

                            <a href="{{ route('sectors-restore', $sector->id) }}" class="btn btn-success btn-sm px-3 mx-1 text-white fw-bold">
                                <i class="fa-solid fa-rotate-left"></i> استرجاع
                            </a>
                            <a href="{{ route('sectors-force', $sector->id) }}" class="btn btn-danger btn-sm px-3 mx-1 text-white fw-bold">
                             <i class="fa fa-trash"></i> حذف
                            </a>
                         
                            
                           
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>

</script>
@endsection