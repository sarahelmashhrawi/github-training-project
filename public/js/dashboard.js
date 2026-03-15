// public/js/dashboard.js

document.addEventListener('DOMContentLoaded', function() {
    console.log('تم تحميل ملف جافاسكريبت لوحة التحكم بنجاح! 🚀');

    // كود لفتح وإغلاق القائمة الجانبية (Sidebar)
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // إظهار رسالة ترحيبية بناءً على الوقت
    const hour = new Date().getHours();
    let greeting = 'مرحباً';
    if (hour < 12) greeting = 'صباح الخير';
    else if (hour < 18) greeting = 'مساء الخير';
    
    const greetingElement = document.getElementById('time-greeting');
    if (greetingElement) {
        greetingElement.textContent = greeting;
    }
});