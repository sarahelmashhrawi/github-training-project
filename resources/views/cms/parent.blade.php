<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>نظام إدارة المخيم | لوحة التحكم</title>
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('cms/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('cms/plugins/jqvmap/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('cms/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('cms/plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('cms/plugins/summernote/summernote-bs4.min.css') }}">
  
  <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
  
  @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('dashboard') }}" class="nav-link">الرئيسية</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">تواصل معنا</a>
    </li>
  </ul>

  <ul class="navbar-nav mr-auto"> 
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="بحث..." aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <li class="nav-item d-none d-sm-flex align-items-center">
        <span class="text-muted px-2">|</span>
    </li>

    <li class="nav-item d-flex align-items-center">
        <span class="text-secondary font-weight-bold mx-2" style="font-size: 0.95rem;">
            {{ auth()->user()->name ?? 'المدير' }}
        </span>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm shadow-sm d-flex align-items-center" style="border-radius: 4px;">
                <i class="fa-solid fa-power-off" style="margin-left: 5px;"></i> خروج
            </button>
        </form>
    </li>
  </ul>
 </nav>

 <aside class="main-sidebar sidebar-dark-primary elevation-4" style="text-align: right; direction: rtl;">
    <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center pb-3 pt-3">
      <i class="fa-solid fa-tent text-success" style="font-size: 1.5rem; margin-right: 15px; margin-left: 10px;"></i>
      <span class="brand-text font-weight-bold text-white">إدارة المخيم</span>
    </a>

    <div class="sidebar">
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="#" onclick="showImageOptions(event)">
            <img id="sidebar_profile_image" 
                 src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('cms/dist/img/user2-160x160.jpg') }}" 
                 class="img-circle elevation-2" 
                 alt="User Image" 
                 style="cursor: pointer; width: 35px; height: 35px; object-fit: cover;">
        </a>
        <input type="file" id="upload_new_image" accept="image/*" style="display: none;" onchange="updateProfileImage(this)">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name ?? 'مستخدم النظام' }}</a>
      </div>
     </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="padding-right: 0;">
          
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link active d-flex align-items-center">
              <i class="nav-icon fas fa-tachometer-alt" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">لوحة التحكم </p>
            </a>
          </li>
          <li class="nav-header">إدارة المستحدمين</li>
          <li class="nav-item mt-1">
            <a href="#" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-edit" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0; width: 100%; display: flex; justify-content: space-between; align-items: center;">
                <span>الاعدادات</span>
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('families.create') }}" class="nav-link d-flex align-items-center" style="padding-right: 25px;">
                  <i class="far fa-circle nav-icon text-warning" style="margin-left: 10px; font-size: 14px;"></i>
                  <p>تعديل كلمة المرور</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tents.create') }}" class="nav-link d-flex align-items-center" style="padding-right: 25px;">
                  <i class="far fa-circle nav-icon text-success" style="margin-left: 10px; font-size: 14px;"></i>
                  <p>تعديل الملف الشخصي</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sectors.create') }}" class="nav-link d-flex align-items-center" style="padding-right: 25px;">
                  <i class="far fa-circle nav-icon text-info" style="margin-left: 10px; font-size: 14px;"></i>
                  <p>خروج</p>
                </a>
              </li>
            </ul>

          <li class="nav-item mt-1">
            <a href="{{ route('individuals.index') }}" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-walking" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">إدارة النازحين</p>
            </a>
          </li>
          
          <li class="nav-item mt-1">
            <a href="{{ route('sectors.index') }}" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-walking" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">إدارة المناطق</p>
            </a>
          </li>

          <li class="nav-item mt-1">
            <a href="{{ route('tents.index') }}" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-campground" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">إدارة الخيام</p>
            </a>
          </li>

          <li class="nav-item mt-1">
            <a href="{{ route('families.index') }}" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-house-user" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">إدارة العائلات</p>
            </a>
          </li>

          <li class="nav-item mt-1">
            <a href="#" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-hands-helping" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">إدارة مساعدات الخيام</p>
            </a>
          </li>

          <hr style="border-top: 1px solid #4f5962; width: 80%; margin: 15px auto;">

        

          {{-- بداية تعديل قسم النماذج ليصبح قائمة منسدلة --}}
          <li class="nav-item mt-1">
            <a href="#" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-edit" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0; width: 100%; display: flex; justify-content: space-between; align-items: center;">
                <span>النماذج</span>
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('families.create') }}" class="nav-link d-flex align-items-center" style="padding-right: 25px;">
                  <i class="far fa-circle nav-icon text-warning" style="margin-left: 10px; font-size: 14px;"></i>
                  <p>إضافة عائلة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('tents.create') }}" class="nav-link d-flex align-items-center" style="padding-right: 25px;">
                  <i class="far fa-circle nav-icon text-success" style="margin-left: 10px; font-size: 14px;"></i>
                  <p>إضافة خيمة</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sectors.create') }}" class="nav-link d-flex align-items-center" style="padding-right: 25px;">
                  <i class="far fa-circle nav-icon text-info" style="margin-left: 10px; font-size: 14px;"></i>
                  <p>إضافة منطقة</p>
                </a>
              </li>
            </ul>
          </li>
          {{-- نهاية تعديل قسم النماذج --}}

          <li class="nav-item mt-1">
            <a href="#" class="nav-link d-flex align-items-center">
              <i class="nav-icon fas fa-table" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0; width: 100%; display: flex; justify-content: space-between; align-items: center;">
                <span>الجداول</span>
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>

          <li class="nav-header mt-3 text-uppercase" style="font-weight: bold; padding-right: 15px;">أمثلة </li>

          {{-- التقويم --}}
          <li class="nav-item mt-1">
            <a href="#calendar-widget" class="nav-link d-flex align-items-center">
              <i class="nav-icon far fa-calendar-alt" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0; width: 100%; display: flex; justify-content: space-between; align-items: center;">
                <span>التقويم</span>
                <span class="badge badge-info">2</span>
              </p>
            </a>
          </li>

          {{-- معرض الصور --}}
          <li class="nav-item mt-1 mb-3">
            <a href="#" class="nav-link d-flex align-items-center">
              <i class="nav-icon far fa-image" style="margin-left: 10px; margin-right: 0;"></i>
              <p style="margin: 0;">معرض الصور</p>
            </a>
          </li>

        </ul>
      </nav>
      </div>
    </aside>

  <div class="content-wrapper">
    <section class="content" style="padding-top: 20px;">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 Camp Management System.</strong>
  </footer>
</div>

<script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('cms/dist/js/adminlte.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{ asset('cms/js/crud.js') }}"></script>

@yield('scripts')
</body>
</html>