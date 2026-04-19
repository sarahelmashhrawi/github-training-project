@extends('cms.parent')

@section('styles')

<link rel="stylesheet" href="{{ asset('cms/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')
    {{-- رسالة الترحيب --}}
    <div class="mb-4">
        <h2 class="text-info font-weight-bold">مرحباً، {{ auth()->user()->name ?? 'مدير النظام' }} 👋</h2>
        <p class="text-muted">إحصائيات دقيقة بناءً على البيانات المسجلة في المخيم.</p>
    </div>

    {{-- المربعات الإحصائية (Small Boxes) --}}
  <div class="row">
    <div class="col-lg-4 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $individualsCount ?? 0 }}</h3>
                <p>إجمالي النازحين</p>
            </div>
            <div class="icon"><i class="fa-solid fa-people-group"></i></div>
            <a href="{{ route('individuals.index') }}" class="small-box-footer">التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $tentsCount ?? 0 }}</h3>
                <p>الخيام المسجلة</p>
            </div>
            <div class="icon"><i class="fa-solid fa-campground"></i></div>
            <a href="{{ route('tents.index') }}" class="small-box-footer">التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $sectorsCount ?? 0 }}</h3>
                <p>إدارة المناطق</p>
            </div>
            <div class="icon"><i class="fa-solid fa-map-marked-alt"></i></div>
            <a href="{{ route('sectors.index') }}" class="small-box-footer">التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-4 col-12">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $campaignsCount ?? 0 }}</h3>
                <p>إدارة المساعدات</p>
            </div>
            <div class="icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
            <a href="{{ route('campaigns.index') }}" class="small-box-footer">التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $familiesCount ?? 0 }}</h3>
                <p>العائلات</p>
            </div>
            <div class="icon"><i class="fa-solid fa-house-user"></i></div>
            <a href="{{ route('families.index') }}" class="small-box-footer">التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
        </div>
    </div>
</div>

    {{-- صف يحتوي على الرسم البياني والتقويم --}}
    <div class="row mt-3">
        {{-- الرسم البياني --}}
        <div class="col-md-7">
            <div class="card card-success card-outline">
                <div class="card-header d-flex align-items-center">
                    <h3 class="text-info font-weight-bold">
                        <i class="fa-solid fa-chart-pie text-success mr-2"></i> توزيع الفئات العمرية
                    </h3>
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <canvas id="demographicsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
<div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  To Do List
                </h3>

                <div class="card-tools">
                  <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                  <li>
                    <!-- drag handle -->
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo1" id="todoCheck1">
                      <label for="todoCheck1"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text">Design a nice theme</span>
                    <!-- Emphasis label -->
                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                      <label for="todoCheck2"></label>
                    </div>
                    <span class="text">Make the theme responsive</span>
                    <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo3" id="todoCheck3">
                      <label for="todoCheck3"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo4" id="todoCheck4">
                      <label for="todoCheck4"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo5" id="todoCheck5">
                      <label for="todoCheck5"></label>
                    </div>
                    <span class="text">Check your messages and notifications</span>
                    <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo6" id="todoCheck6">
                      <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
              </div>
            </div>
            
        {{-- التقويم --}}
        <div class="col-md-5">
            <div class="card bg-gradient-success" id="calendar-widget">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="far fa-calendar-alt ml-1"></i> التقويم</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a href="javascript:void(0)" onclick="addNewEvent()" class="dropdown-item">إضافة حدث جديد</a>
                                <a href="#" class="dropdown-item">مسح الأحداث</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">عرض التقويم</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="calendar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('cms/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('cms/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function addNewEvent() {
        Swal.fire({ title: 'إضافة حدث جديد', input: 'text', showCancelButton: true, confirmButtonText: 'إضافة', cancelButtonText: 'إلغاء' });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // تفعيل التقويم
        $('#calendar').datetimepicker({ format: 'L', inline: true });

        // تفعيل الرسم البياني
        const canvas = document.getElementById('demographicsChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const cCount = {{ (int)($childrenCount ?? 0) }};
        const yCount = {{ (int)($youthCount ?? 0) }};
        const wCount = {{ (int)($womenCount ?? 0) }};
        const eCount = {{ (int)($eldersCount ?? 0) }};

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['أطفال', 'شباب', 'نساء', 'مسنين'],
                datasets: [{
                    data: [cCount, yCount, wCount, eCount],
                    backgroundColor: ['#3498db', '#28a745', '#f39c12', '#7f8c8d'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', rtl: true, labels: { font: { family: 'Cairo' } } }
                }
            }
        });
    });
</script>
@endsection