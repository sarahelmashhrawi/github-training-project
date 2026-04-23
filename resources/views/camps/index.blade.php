@extends('cms.parent')

@section('title', 'إدارة المخيمات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/families/families.css') }}">
@endsection

@section('content')

<div class="container-fluid mt-4">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h3 class="fw-bold m-0"><i class="fas fa-campground text-primary me-2"></i> إدارة المخيمات</h3>
            <div class="d-flex align-items-center gap-3">
                <div class="search-box">
                    <i class="fa fa-search"></i>
                    <input type="text" id="campSearch" placeholder="بحث عن مخيم...">
                </div>
                <a href="{{ route('camps.create') }}" class="btn btn-primary btn-add fw-bold text-white px-4 py-2">
                    <i class="fas fa-plus-circle me-1"></i> إضافة مخيم جديد
                </a>
            </div>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 rounded shadow-sm">
                <i class="fa-solid fa-arrow-right mr-1"></i> العودة للوحة التحكم
            </a> 
        </div>

        <div class="table-responsive">
            <table id="campsTable" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>رقم المخيم</th>
                        <th>اسم المخيم</th>
                        <th>الموقع</th>
                        <th>القطاع</th>
                        <th>السعة القصوى</th>
                        <th>الحالة</th> 
                        <th class="text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($camps as $camp)
                    <tr>
                        <td class="fw-bold">{{ $camp->camp_number }}</td>
                        <td class="text-primary"><i class="fas fa-map-signs me-1 text-muted"></i> {{ $camp->name }}</td>
                        <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $camp->location }}</td>
                        <td>
                            <span class="badge bg-info px-3 py-2 rounded-pill text-dark">
                                {{ $camp->sector->name ?? 'غير محدد' }}
                            </span>
                        </td>
                        <td>{{ $camp->max_capacity }} خيمة</td>
                        <td>
                            @if($camp->status == 'active')
                                <span class="badge bg-success px-3 py-2 rounded-pill">نشط</span>
                            @elseif($camp->status == 'full')
                                <span class="badge bg-danger px-3 py-2 rounded-pill">ممتلئ</span>
                            @else
                                <span class="badge bg-warning px-3 py-2 rounded-pill text-dark">تحت الإنشاء</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group gap-2">
                                <a href="{{ route('camps.edit', $camp->id) }}" class="btn btn-outline-warning btn-sm border-0"><i class="fas fa-edit"></i></a>
                                <button type="button" onclick="confirmDestroy(`{{ route('camps.destroy', $camp->id) }}`, this)" class="btn btn-outline-danger btn-sm border-0"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5">لا توجد مخيمات مسجلة حالياً</td></tr>
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
        $("#campSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#campsTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection