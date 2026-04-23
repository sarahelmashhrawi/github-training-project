@extends('cms.parent')

@section('title', 'إدارة العائلات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/families/families.css') }}">

@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h3 class="fw-bold m-0"><i class="fas fa-users text-primary me-2"></i> إدارة العائلات</h3>
            <div class="d-flex align-items-center gap-3">
                <div class="search-box">
                    
                    <i class="fa fa-search"></i>
                    <input type="text" id="familySearch" placeholder="بحث عن عائلة...">
                </div>
                <a href="{{ route('families.create') }}" class="btn btn-primary btn-add fw-bold text-white px-4 py-2">
                    <i class="fas fa-plus-circle me-1"></i> تسجيل عائلة
                </a>
                
            </div>
        </div>
         <div>
                     <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 rounded shadow-sm">
            <i class="fa-solid fa-arrow-right mr-1"></i> العودة للوحة التحكم
        </a> 
        </div>
       

        <div class="table-responsive">
            <table id="familiesTable" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>اسم رب الأسرة</th>
                        <th>رقم الهوية</th>
                        <th>رقم الخيمة</th>
                        <th>التصنيف</th>
                        <th>المنطقة الأصلية</th>
                        <th>المنطقة الحالية</th> 
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($families as $family)
                    <tr>
                        <td class="fw-bold text-primary"><i class="fas fa-user-tie me-1 text-muted"></i> {{ $family->head_name }}</td>
                        <td>{{ $family->id_number ?? 'غير مسجل' }}</td>
                        <td>
                            @if($family->tent)
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-tent me-1"></i> خيمة {{ $family->tent->tent_number }}
                                </span>
                            @else
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">بدون خيمة</span>
                            @endif
                        </td>
                        <td>
                            @if($family->family_type == 'normal')
                                <span class="badge badge-normal px-3 py-2 rounded-pill">طبيعية</span>
                            @elseif($family->family_type == 'female_headed')
                                <span class="badge badge-female px-3 py-2 rounded-pill">تعيلها امرأة</span>
                            @else
                                <span class="badge badge-orphans px-3 py-2 rounded-pill">أيتام</span>
                            @endif
                        </td>
                        <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $family->original_area ?? 'غير محدد' }}</td>
                        <td><i class="fas fa-map-pin text-warning me-1"></i> {{ $family->current_area ?? 'غير محدد' }}</td>
                        <td class="text-center">
                            <div class="btn-group gap-2">
                                <a href="{{ route('families.show', $family->id) }}" class="btn btn-outline-info btn-sm border-0"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('families.edit', $family->id) }}" class="btn btn-outline-warning btn-sm border-0"><i class="fas fa-edit"></i></a>
<button type="button" onclick="confirmDestroy(`{{ route('families.destroy', $family->id) }}`, this)" class="btn btn-outline-danger btn-sm border-0"><i class="fas fa-trash-alt"></i></button>                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5">لا توجد عائلات مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#familySearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#familiesTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection