@extends('cms.parent')

@section('title', 'تعديل بيانات الخيمة')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/tents/edit.css') }}">


@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card custom-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-success fw-bold"><i class="fas fa-edit me-2"></i> تعديل الخيمة: {{ $tent->tent_number }}</h3>
                    <a href="{{ route('tents.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                    </a>
                </div>
                
                <form id="edit-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الخيمة</label>
                            <input type="text" name="tent_number" class="form-control" value="{{ $tent->tent_number }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">السعة (أفراد)</label>
                            <input type="number" name="capacity" class="form-control" value="{{ $tent->capacity }}" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">المنطقة التابعة لها</label>
                            <select name="sector_id" class="form-control" required>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" @if($tent->sector_id == $sector->id) selected @endif>{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label">حالة الخيمة</label>
                            <select name="condition" class="form-control" required>
                                <option value="good" @if($tent->condition == 'good') selected @endif>ممتازة</option>
                                <option value="worn" @if($tent->condition == 'worn') selected @endif>مهترئة</option>
                                <option value="needs_shade" @if($tent->condition == 'needs_shade') selected @endif>تحتاج شوادر</option>
                                <option value="flooded" @if($tent->condition == 'flooded') selected @endif>غارقة</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" onclick="updateTent('{{ route('tents.update', $tent->id) }}')" class="btn btn-update w-100">
                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateTent(url) {
        let formData = new FormData(document.getElementById('edit-form'));
        performUpdate(url, formData);
    }
</script>
@endsection