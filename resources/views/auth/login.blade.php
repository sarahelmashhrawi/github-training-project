<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام إدارة المخيمات</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-image: url('{{ asset('images/login (1).png') }}'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.4);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 550px; 
            padding: 50px; 
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
            /* إضافة كلاس للإخفاء المبدئي عشان حركة الـ Fade-in */
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        /* كلاس رح نضيفه بالـ JS عشان تظهر البطاقة */
        .login-card.show-card {
            opacity: 1;
            transform: translateY(0);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #0d6efd, #0dcaf0);
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 20px auto;
        }

        .login-header h2 {
            font-weight: 700;
            color: #2c3e50;
            font-size: 26px;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #6c757d;
        }
        
        /* تعديل الزوايا عشان أيقونة العين تكون عاليسار */
        .input-group-text.icon-right { border-radius: 0 10px 10px 0 !important; }
        .input-group-text.icon-left { border-radius: 10px 0 0 10px !important; cursor: pointer; }

        .form-control {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        /* تعديل الحقل اللي ما عنده أيقونة عاليسار (الإيميل) */
        .form-control.no-left-icon { border-radius: 10px 0 0 10px !important; }
        /* الحقل اللي بالنص (الباسوورد) */
        .form-control.middle-input { border-radius: 0 !important; border-left: none; }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .input-group:focus-within .input-group-text {
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-login {
            background: linear-gradient(45deg, #0d6efd, #0b5ed7);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
            color: white;
        }

        /* كلاس عشان حالة التحميل (الزر لما ينضغط) */
        .btn-login.loading {
            opacity: 0.8;
            pointer-events: none;
        }

        .alert-danger {
            border-radius: 10px;
            font-size: 14px;
            border-left: 4px solid #dc3545;
        }

        .invalid-feedback {
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="login-card" id="loginCard">
        <div class="text-center login-header">
            <div class="login-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>نظام إدارة المخيم</h2>
            <p>بوابة الدخول للمشرفين والمتطوعين</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-center p-3 mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    البريد الإلكتروني أو كلمة المرور غير صحيحة.
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label fw-bold text-secondary small mb-2">البريد الإلكتروني</label>
                <div class="input-group">
                    <span class="input-group-text icon-right"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control no-left-icon @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com" autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-bold text-secondary small mb-2">كلمة المرور</label>
                <div class="input-group">
                    <span class="input-group-text icon-right"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control middle-input" required placeholder="••••••••">
                    <span class="input-group-text icon-left" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label text-secondary small" for="remember">
                        تذكرني على هذا الجهاز
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-login" id="submitBtn">
                <span id="btnText"><i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول</span>
                <span id="btnSpinner" class="d-none">
                    <i class="fas fa-circle-notch fa-spin me-2"></i> جاري الدخول...
                </span>
            </button>
        </form>
    </div>

    <script src="{{ asset('js/login-script.js') }}"></script>
</body>
</html>