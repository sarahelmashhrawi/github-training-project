// ننتظر لحد ما الصفحة تحمل بالكامل
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. تأثير ظهور البطاقة بنعومة (Fade-in)
    const loginCard = document.getElementById('loginCard');
    // بنخليها تظهر بعد 100 جزء من الثانية عشان يعطي تأثير حلو
    setTimeout(() => {
        loginCard.classList.add('show-card');
    }, 100);

    // 2. إظهار/إخفاء كلمة المرور
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        // فحص نوع الحقل الحالي
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // تغيير شكل أيقونة العين
        const eyeIcon = this.querySelector('i');
        if (type === 'text') {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });

    // 3. تأثير زر التحميل عند إرسال الفورم
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    loginForm.addEventListener('submit', function() {
        //  إرسال الفورم، بنغير حالة الزر
        submitBtn.classList.add('loading');
        
        // إخفاء النص العادي وإظهار دائرة التحميل
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
    });

});