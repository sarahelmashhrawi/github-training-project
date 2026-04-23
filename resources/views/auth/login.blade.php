<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول | نظام إدارة المخيم</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            /* مسار صورة الخلفية */

            background-image: url('{{ asset('images/login (1).png') }}'); 
            /* background: url('{{ asset("images/camp-background.jpg") }}') no-repeat center center fixed; */
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-color: #e9ecef; /* لون احتياطي في حال عدم تحميل الصورة */
        }

        .overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            text-align: center;
            z-index: 2;
            border-top: 6px solid #0d6efd; 
        }

        .shield-icon {
            background-color: #e6f0ff;
            color: #0d6efd;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 15px auto;
        }

        .system-title {
            font-weight: 700;
            color: #212529;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .system-subtitle {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            text-align: right;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 13px;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            height: 48px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            background-color: #f8faff;
            padding-right: 40px; 
            padding-left: 40px;  
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .input-wrapper input:focus {
            border-color: #0d6efd;
            background-color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .input-wrapper .icon-right {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 14px;
        }

        .input-wrapper .icon-left {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0d6efd;
            font-size: 14px;
            cursor: pointer;
        }

        .input-wrapper .icon-left.text-muted {
            color: #6c757d !important;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 25px;
        }

        .checkbox-container input {
            margin-left: 8px;
            cursor: pointer;
        }

        .checkbox-container label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
            cursor: pointer;
            margin: 0;
        }

        .btn-login {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px;
            width: 100%;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #0b5ed7;
            color: white;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #adb5bd;
            font-size: 13px;
            font-weight: 600;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e9ecef;
        }
        .divider::before { margin-left: 15px; }
        .divider::after { margin-right: 15px; }

        /* --- تنسيقات أيقونات السوشيال ميديا الدائرية --- */
        .social-icons-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            color: white;
            font-size: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .social-icon:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .social-icon.facebook {
            background-color: #1877f2;
        }

      .social-icon.x-twitter {
    background-color: #000000; /* اللون الأسود الرسمي لمنصة X */
}
        /* --- تنسيق رابط نسيان كلمة المرور --- */
        .forgot-password-link {
            display: inline-block;
            margin-top: 5px;
            font-size: 14px;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .forgot-password-link:hover {
            text-decoration: underline;
            color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="login-card">
    <div class="shield-icon">
        <i class="fas fa-shield-alt"></i>
    </div>
    
    <h2 class="system-title">نظام إدارة المخيم</h2>
    <p class="system-subtitle">بوابة الدخول للمشرفين والمتطوعين</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope icon-right"></i>
                <input type="email" name="email" value="{{ old('email', 'admin@admin.com') }}" class="@error('email') is-invalid @enderror" required autofocus>
            </div>
            @error('email')
                <span class="text-danger d-block mt-1" style="font-size: 12px; text-align: right;">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

    <div class="form-group">
    <label>كلمة المرور</label>
    <div class="input-wrapper">
        <i class="fas fa-lock icon-right"></i>
        <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror" required>
        <i class="fas fa-eye icon-left text-muted" id="togglePassword"></i>
    </div>
</div>

        <div class="checkbox-container">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">تذكرني على هذا الجهاز</label>
        </div>

        <button type="submit" class="btn-login">
            تسجيل الدخول
            <i class="fas fa-sign-in-alt"></i>
        </button>
    </form>

    <div class="divider">أو</div>

    <div class="social-icons-container">
        <a href="https://www.facebook.com/" class="social-icon facebook" title="تسجيل الدخول باستخدام فيسبوك">
            <i class="fab fa-facebook-f"></i> 
        </a>
<a href="https://x.com/" class="social-icon x-twitter" title="منصة X"><i class="fab fa-x-twitter"></i>        </a>
    </div>
<div style="margin-top: 15px;">
        <a href="/password/reset" class="forgot-password-link">هل نسيت كلمة المرور؟</a>
    </div>
</div>

    <script src="{{ asset('js/login-script.js') }}"></script>

</body>
</html>