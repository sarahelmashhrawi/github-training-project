<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>نظام إدارة المخيمات والخيام</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">    
    
  <style>
        body, h1, h2, h3, h4, h5, h6, p, a, button {
            font-family: 'Cairo', sans-serif !important;
        }
        .text-right { text-align: right; }
        .icon, .ficon { text-align: center; }
        .thumnails p { text-align: right; line-height: 1.8; }

        /* --- أكواد شاشة التحميل (Preloader) --- */
        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: #ffffff; z-index: 999999;
            display: flex; justify-content: center; align-items: center;
        }
        .spinner {
            width: 50px; height: 50px;
            border: 5px solid #f3f3f3; border-top: 5px solid #28a745;
            border-radius: 50%; animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        /* --- تنسيقات السلايدر --- */
        .carousel-inner > .item > img {
            width: 100%;
            height: 550px; 
            object-fit: cover; 
            filter: brightness(0.85); 
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5); 
            padding: 30px;
            border-radius: 15px;
            bottom: 25%;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* --- تنسيق قائمة الروابط --- */
        .nav-tabs { border-bottom: none; display: flex; align-items: center; gap: 10px; }
        .nav-tabs > li { float: none; display: inline-block; }
        
        /* --- زر تسجيل الدخول المخصص --- */
        .login-btn-custom {
            background-color: #28a745;
            color: #ffffff !important;
            border-radius: 30px;
            padding: 10px 25px !important;
            font-weight: 700 !important;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(40, 167, 69, 0.3);
            border: 2px solid #28a745;
        }
        .login-btn-custom:hover {
            background-color: transparent;
            color: #28a745 !important;
            transform: translateY(-2px);
        }
    </style>
  </head>
  <body>
    <div id="preloader"><div class="spinner"></div></div>

  <header style="padding-top: 15px; padding-bottom: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background-color: #fff;">
    <div class="container-fluid" style="padding-right: 4%; padding-left: 4%;"> 
        
        <nav class="navbar navbar-default" role="navigation" style="margin: 0; border: none; background: transparent; display: flex; justify-content: space-between; align-items: center; flex-wrap: nowrap;">
            
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}" style="padding: 0; height: auto; display: flex; align-items: center; gap: 15px; text-decoration: none;">
                    <img src="{{ asset('images/logo.png') }}" alt="شعار ملاذ" style="height: 100px; width: auto;">
                    <div>
                        <span style="font-size: 38px; font-weight: bold; color: #28a745; display: block; line-height: 1.1;">ملاذ</span>
                        <span style="font-size: 16px; color: #3eb1d8; font-weight: 600; display: block; padding-top: 4px;">لإدارة مخيمات الإيواء</span>
                    </div>
                </a>
            </div>
            
            <div style="flex: 1; display: flex; justify-content: center;">
                <ul style="display: flex; gap: 50px; list-style: none; margin: 0; padding: 0; align-items: center;">
                    <li><a href="{{ url('/') }}" style="color: #3eb1d8; font-size: 17px; font-weight: bold; text-decoration: none;">الرئيسية</a></li>
                    <li><a href="{{ route('tents.index') }}" style="color: #3eb1d8; font-size: 17px; font-weight: bold; text-decoration: none;">إدارة الخيام</a></li>
                    <li><a href="{{ route('sectors.index') }}" style="color: #3eb1d8; font-size: 17px; font-weight: bold; text-decoration: none;">المناطق والقطاعات</a></li>
                    <li><a href="{{ route('campaigns.index') }}" style="color: #3eb1d8; font-size: 17px; font-weight: bold; text-decoration: none;">إدارة المساعدات</a></li>
                    <li><a href="#contact-footer" style="color: #3eb1d8; font-size: 17px; font-weight: bold; text-decoration: none;">تواصل معنا</a></li> 
                </ul>
            </div>

            <div style="display: flex; gap: 10px; align-items: center;">
                @auth
                    <a href="{{ url('/dashboard') }}" style="background-color: #3eb1d8; color: #fff; padding: 8px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
                        لوحة التحكم <i class="fa fa-tachometer fa-lg"></i> 
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background-color: #dc3545; color: #fff; padding: 8px 20px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            خروج <i class="fa fa-sign-out fa-lg"></i>
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" style="background-color: #3eb1d8; color: #fff; padding: 8px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px;">
                        تسجيل الدخول <i class="fa fa-sign-in fa-lg"></i> 
                    </a>
                @endguest
            </div>

        </nav>
    </div>
</header>
    <div id="main-slider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#main-slider" data-slide-to="0" class="active"></li>
            <li data-target="#main-slider" data-slide-to="1"></li>
            <li data-target="#main-slider" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{ asset('images/slider-1.jpg') }}" alt="نظام متكامل لإدارة الخيام">
                <div class="carousel-caption">
                    <h2 class="wow fadeInDown" style="color: #fff; font-weight: bold;">نظام متكامل لإدارة الخيام</h2>
                    <h4 class="wow fadeInUp" style="color: #f8f9fa; line-height: 1.6;">تابع حالة الخيام، سعتها، واحتياجاتها بضغطة زر.</h4>
                    <a href="{{ route('tents.create') }}" class="btn btn-success wow zoomIn" data-wow-delay="0.5s" style="font-size: 20px; padding: 10px 25px; margin-top: 20px; border-radius: 30px; font-weight: bold;">أضف خيمة جديدة الآن!</a>
                </div>
            </div>
            
            <div class="item">
                <img src="{{ asset('images/slider-2.jpg') }}" alt="متابعة فورية للأعطال">
                <div class="carousel-caption">
                    <h2 class="wow fadeInDown" style="color: #fff; font-weight: bold;">متابعة فورية للأعطال</h2>
                    <h4 class="wow fadeInUp" style="color: #f8f9fa; line-height: 1.6;">حدد الخيام المهترئة أو التي تحتاج إلى شوادر بسهولة وسرعة.</h4>
                </div>
            </div>

            <div class="item">
                <img src="{{ asset('images/slider-4.jpg') }}" alt="مبادرات الأمل والدعم النفسي">
                <div class="carousel-caption">
                    <h2 class="wow fadeInDown" style="color: #fff; font-weight: bold;">نصنع الأمل لأطفالنا</h2>
                    <h4 class="wow fadeInUp" style="color: #f8f9fa; line-height: 1.6;">ندعم الأنشطة الترفيهية والمبادرات النفسية لضمان بيئة آمنة وإيجابية للأطفال داخل المخيم.</h4>
                </div>
            </div>
        </div>

        <a class="left carousel-control" href="#main-slider" role="button" data-slide="prev" style="background-image: none;">
            <i class="fa fa-angle-left fa-3x" aria-hidden="true" style="position: absolute; top: 50%; left: 30px; transform: translateY(-50%); text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></i>
            <span class="sr-only">السابق</span>
        </a>
        <a class="right carousel-control" href="#main-slider" role="button" data-slide="next" style="background-image: none;">
            <i class="fa fa-angle-right fa-3x" aria-hidden="true" style="position: absolute; top: 50%; right: 30px; transform: translateY(-50%); text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></i>
            <span class="sr-only">التالي</span>
        </a>
    </div>

    <div class="container text-center mt-5" style="margin-top: 60px; margin-bottom: 50px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="contents">
                    <h2 style="font-weight: bold; color: #333;">طوّر من آلية إدارتك للمخيم بأسلوب <span style="color: #3eb1d8;">منظم</span> و<span style="color: #28a745;">احترافي</span></h2>
                    <p style="font-size: 18px; color: #666; margin-top: 15px;">هذا النظام مصمم لتسهيل عمل فرق الإشراف والمتابعة الميدانية للخيام والمناطق.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row text-center">
            <div class="recent">
                <button class="btn-primarys" style="border: none; background: transparent;"><h3 style="font-weight: bold; color: #3eb1d8;">مميزات النظام</h3></button>
                <hr style="width: 100px; border-top: 3px solid #28a745; margin-top: 0;">
            </div>
        </div>
    </div>
    
    <div class="container" style="margin-bottom: 50px;">
        <div class="row text-center">
            <div class="content">
                <div class="col-md-4">
                    <div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.4s">
                        <div class="align-center">
                            <h4 style="font-weight: bold;">واجهة متجاوبة</h4>                  
                            <div class="icon" style="margin: 20px 0;">
                                <i class="fa fa-desktop fa-5x text-success"></i>
                            </div>
                            <p>يعمل النظام بكفاءة على جميع الأجهزة (كمبيوتر، جهاز لوحي، هاتف محمول) لتسهيل العمل الميداني.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="wow flipInY" data-wow-offset="0" data-wow-delay="0.8s">
                        <div class="align-center">
                            <h4 style="font-weight: bold;">إدارة شاملة للبيانات</h4>                  
                            <div class="icon" style="margin: 20px 0;">
                                <i class="fa fa-database fa-5x text-success"></i>
                            </div>
                            <p>حفظ وتنظيم تفاصيل كل خيمة، سعتها، وحالتها الحالية في قاعدة بيانات مركزية وآمنة.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="wow flipInY" data-wow-offset="0" data-wow-delay="1.2s">
                        <div class="align-center">
                            <h4 style="font-weight: bold;">تتبع المناطق</h4>                  
                            <div class="icon" style="margin: 20px 0;">
                                <i class="fa fa-map-marker fa-5x text-success"></i>
                            </div>
                            <p>تقسيم المخيم إلى مناطق وقطاعات ليسهل الوصول للخيام وتوجيه فرق الصيانة والمساعدة.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container" style="margin-top: 50px; background: #f9f9f9; padding: 40px 20px; border-radius: 15px;">
        <div class="about">         
            <div class="row text-center">
                <div class="recent">
                    <button class="btn-primarys" style="border:none; background:transparent;"><h3 style="font-weight: bold; color: #3eb1d8;">عن النظام</h3></button>
                    <hr style="width: 100px; border-top: 3px solid #28a745; margin-top: 0;">
                </div>
            </div>              
            <div class="row" style="margin-top: 30px;">           
                <div class="col-lg-6 mar-bot30">
                    <div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.2s">
                        <img alt="المخيم" class="img-responsive img-thumbnail" src="{{ asset('images/slider-3.jpg') }}" width="100%" style="border-radius: 10px;"/>
                    </div>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="wow fadeInUp" data-wow-offset="0" data-wow-delay="0.6s">
                        <div class="thumnails">
                            <h4 class="text-success text-right" style="font-weight: bold; font-size: 24px; margin-bottom: 20px;">هدفنا تسهيل الحياة داخل المخيمات</h4>                                        
                            <p style="font-size: 16px;">جاءت فكرة هذا النظام لحل مشاكل التكدس العشوائي وفقدان بيانات سكان الخيام. من خلال هذه المنصة، يمكن لمدراء المخيمات متابعة حالة الخيام بشكل دقيق (ممتازة، مهترئة، تحتاج شادر، غارقة) والتعامل مع الطوارئ بسرعة.</p>                               
                            <p style="font-size: 16px;">نسعى لتوفير بيئة منظمة تضمن توزيعاً عادلاً للموارد وتسهل على فرق الإغاثة الوصول للأشخاص الأكثر تضرراً بناءً على البيانات الدقيقة التي يوفرها النظام.</p>
                        </div>
                    </div>
                </div>                  
            </div>                  
        </div>          
    </div>
    
    <footer id="contact-footer" style="margin-top: 50px; background: #2c3e50; color: #ecf0f1; padding-top: 40px;">
        <div class="container text-right">
            <div class="row">
                <div class="col-lg-4">
                    <div class="widget">
                        <h5 class="widgetheading" style="color: #28a745; font-weight: bold; border-bottom: 2px solid #3eb1d8; padding-bottom: 10px; display: inline-block;">تواصل معنا</h5>
                        <address style="margin-top: 15px;">
                        <strong>إدارة المخيم المركزي</strong><br>
                         المنطقة الإدارية، المبنى الرئيسي<br>
                        </address>
                        <p>
                            <i class="fa fa-phone"></i> 0590000000 <br>
                            <i class="fa fa-envelope"></i> info@camp-management.com
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget">
                        <h5 class="widgetheading" style="color: #28a745; font-weight: bold; border-bottom: 2px solid #3eb1d8; padding-bottom: 10px; display: inline-block;">روابط هامة</h5>
                        <ul class="link-list" style="padding-right: 0; list-style: none; margin-top: 15px;">
                            <li style="margin-bottom: 10px;"><a href="{{ route('tents.index') }}" style="color: #ecf0f1;"><i class="fa fa-angle-left"></i> إدارة الخيام</a></li>
                            <li><a href="{{ route('tents.create') }}" style="color: #ecf0f1;"><i class="fa fa-angle-left"></i> إضافة خيمة جديدة</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget">
                        <h5 class="widgetheading" style="color: #28a745; font-weight: bold; border-bottom: 2px solid #3eb1d8; padding-bottom: 10px; display: inline-block;">ملاحظات النظام</h5>
                        <p style="margin-top: 15px;">هذا النظام يتم تحديثه بشكل دوري لضمان أعلى درجات الأمان وحفظ البيانات. نرجو التواصل مع الدعم الفني في حال واجهتكم أي مشكلة تقنية.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="sub-footer" style="background: #1a252f; padding: 20px 0; margin-top: 30px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="copyright text-right" style="margin-top: 5px;">
                            <p style="margin: 0;">
                                <span>&copy; نظام إدارة المخيمات 2024 - جميع الحقوق محفوظة.</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 text-left">
                        <ul class="social-network" style="list-style: none; padding: 0; margin: 0; display: flex; justify-content: flex-end; gap: 15px;">
                            <li><a href="#" style="color: #ecf0f1; font-size: 18px;"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" style="color: #ecf0f1; font-size: 18px;"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script>
        $(window).on('load', function() {
            $('#preloader').fadeOut('slow', function() {
                $(this).remove();
                new WOW().init();
            }); 
        });
    </script>
  </body>
</html>