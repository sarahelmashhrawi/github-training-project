<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | نظام إدارة المخيم</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #28a745;        
            --primary-hover: #218838;  
            --sidebar-bg: #1c2b36;     
            --sidebar-hover: #243441;   
            --bg-color: #f4f7f6;       
            --text-main: #2c3e50;      
            --text-muted: #7f8c8d;     
            --card-bg: #ffffff;        
        }
        
        body { margin: 0; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: var(--bg-color); display: flex; height: 100vh; overflow: hidden; color: var(--text-main); }

        /* القائمة الجانبية */
        .sidebar { width: 260px; background-color: var(--sidebar-bg); color: #ecf0f1; transition: 0.3s; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar.collapsed { width: 70px; }
        .sidebar-header { padding: 20px; text-align: center; font-size: 20px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; color: #fff; }
        .sidebar.collapsed .sidebar-title { display: none; }
        .menu-items { padding: 10px 0; flex: 1; overflow-y: auto; }
        .menu-item { padding: 15px 20px; color: #bdc3c7; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: 0.2s; cursor: pointer; border-right: 4px solid transparent; }
        .menu-item:hover, .menu-item.active { background-color: var(--sidebar-hover); color: white; border-right-color: var(--primary); }

        /* المحتوى */
        .main-content { flex: 1; display: flex; flex-direction: column; transition: 0.3s; overflow-y: auto; }
        .topbar { background: var(--card-bg); padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .toggle-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-main); }
        .user-info { display: flex; align-items: center; gap: 20px; font-weight: 600; }
        .btn-logout { background-color: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 8px; }

        .content-area { padding: 30px; }
        .welcome-text h2 { color: var(--text-main); font-weight: bold; margin-bottom: 15px; }

        /* كروت الإحصائيات */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; }
        .stat-card { background: var(--card-bg); padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 20px; }
        .stat-icon { width: 65px; height: 65px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 26px; }
        .stat-details h3 { margin: 0; color: var(--text-muted); font-size: 15px; }
        .stat-details p { margin: 5px 0 0 0; font-size: 32px; font-weight: 900; }
        
        .card-individuals { border-right: 4px solid #3498db; }
        .card-individuals .stat-icon { background-color: rgba(52, 152, 219, 0.1); color: #3498db; }
        .card-tents { border-right: 4px solid var(--primary); }
        .card-tents .stat-icon { background-color: rgba(40, 167, 69, 0.1); color: var(--primary); }
        .card-families { border-right: 4px solid #f39c12; }
        .card-families .stat-icon { background-color: rgba(243, 156, 18, 0.1); color: #f39c12; }

        /* الرسم البياني */
        .charts-container { margin-top: 30px; display: grid; grid-template-columns: minmax(300px, 500px); }
        .chart-card { background: var(--card-bg); padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 4px solid var(--primary); }
        .chart-wrapper { position: relative; height: 320px; }
    </style>
</head>
<body>

   <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="sidebar-title">إدارة المخيم</span>
            <i class="fa-solid fa-campground" style="color: var(--primary);"></i>
        </div>
        <div class="menu-items">
            <a href="{{ route('dashboard') }}" class="menu-item active">
                <i class="fa-solid fa-cubes"></i>
                <span class="menu-text">لوحة القيادة</span>
            </a>
            <a href="{{ route('individuals.index') }}" class="menu-item">
                <i class="fa-solid fa-person-walking-luggage"></i>
                <span class="menu-text">إدارة النازحين</span>
            </a>
            <a href="{{ route('tents.index') }}" class="menu-item">
                <i class="fa-solid fa-tents"></i>
                <span class="menu-text">إدارة الخيام</span>
            </a>
            <a href="{{ route('families.index') }}" class="menu-item">
                <i class="fa-solid fa-house-user"></i>
                <span class="menu-text">إدارة العائلات</span>
            </a>
            
            <a href="{{ route('campaigns.index') }}" class="menu-item">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span class="menu-text">إدارة مساعدات الخيام</span>
            </a>
            
        </div>
    </nav>
    <main class="main-content">
        <header class="topbar">
            <button class="toggle-btn" id="sidebar-toggle">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="fa-solid fa-power-off"></i> خروج</button>
                </form>
            </div>
        </header>

        <div class="content-area">
            <div class="welcome-text">
                <h2>مرحباً، {{ auth()->user()->name }} 👋</h2>
                <p>إحصائيات دقيقة بناءً على الفئات العمرية المسجلة.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card card-individuals">
                    <div class="stat-icon"><i class="fa-solid fa-people-group"></i></div>
                    <div class="stat-details">
                        <h3>إجمالي النازحين</h3>
                        <p>{{ $individualsCount ?? 0 }}</p>
                    </div>
                </div>
                <div class="stat-card card-tents">
                    <div class="stat-icon"><i class="fa-solid fa-campground"></i></div>
                    <div class="stat-details">
                        <h3>الخيام المسجلة</h3>
                        <p>{{ $tentsCount ?? 0 }}</p>
                    </div>
                </div>
                <div class="stat-card card-families">
                    <div class="stat-icon"><i class="fa-solid fa-house-user"></i></div>
                    <div class="stat-details">
                        <h3>العائلات</h3>
                        <p>{{ $familiesCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="charts-container">
                <div class="chart-card">
                    <h3><i class="fa-solid fa-chart-pie" style="color: var(--primary); margin-left: 8px;"></i> توزيع الفئات العمرية</h3>
                    <div class="chart-wrapper">
                        <canvas id="demographicsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </main>

   <script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('demographicsChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');

        // جلب البيانات من لارافيل
       const cCount = {{ (int)($childrenCount ?? 0) }};
const yCount = {{ (int)($youthCount ?? 0) }};
const wCount = {{ (int)($womenCount ?? 0) }};
const eCount = {{ (int)($eldersCount ?? 0) }};

        // اطبعي الرقم في الـ Console عشان نتأكد إنه مش صفر
        console.log("عدد المسنين الواصل للـ Blade هو: " + eCount);

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
                    legend: { position: 'bottom', rtl: true }
                }
            }
        });
    });
</script>
</body>
</html>