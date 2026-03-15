<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | نظام إدارة المخيم</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #a67c52;
            --sidebar-bg: #3e2723;
            --sidebar-hover: #4e342e;
            --bg-color: #fdfbf7;
            --text-main: #3e2723;
            --text-muted: #8d6e63;
        }
        body { margin: 0; font-family: 'Segoe UI', Tahoma, sans-serif; background-color: var(--bg-color); display: flex; height: 100vh; overflow: hidden; }

        .sidebar { width: 260px; background-color: var(--sidebar-bg); color: white; transition: 0.3s; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.05); }
        .sidebar.collapsed { width: 70px; }
        .sidebar-header { padding: 20px; text-align: center; font-size: 20px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between; color: #fdfbf7; }
        .sidebar.collapsed .sidebar-title { display: none; }
        .menu-items { padding: 10px 0; flex: 1; overflow-y: auto; }
        .menu-item { padding: 15px 20px; color: #d7ccc8; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: 0.2s; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background-color: var(--sidebar-hover); color: white; border-right: 4px solid var(--primary); }
        .sidebar.collapsed .menu-text { display: none; }

        .main-content { flex: 1; display: flex; flex-direction: column; transition: 0.3s; overflow-y: auto; }

        .topbar { background: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .toggle-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-main); transition: 0.2s; }
        .toggle-btn:hover { color: var(--primary); }
        .user-info { display: flex; align-items: center; gap: 15px; font-weight: 600; color: var(--text-main); }

        .btn-logout { background-color: #8d6e63; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 14px; font-family: inherit; transition: 0.2s; display: flex; align-items: center; gap: 8px; }
        .btn-logout:hover { background-color: #6d4c41; }

        .content-area { padding: 30px; }
        .welcome-text { margin-bottom: 30px; color: var(--text-main); }

        /* هنا شبكة البطاقات اللي بتخليهم جنب بعض */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 20px; border-right: 4px solid var(--primary); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; min-width: 60px; }
        .stat-details h3 { margin: 0; color: var(--text-muted); font-size: 14px; font-weight: bold; }
        .stat-details p { margin: 5px 0 0 0; font-size: 28px; font-weight: 900; color: var(--text-main); }
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
        </div>
    </nav>

    <main class="main-content">
        <header class="topbar">
            <button class="toggle-btn" id="sidebar-toggle">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            
            <div class="user-info">
                <span><i class="fa-solid fa-user-gear" style="color: var(--primary);"></i> {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout"><i class="fa-solid fa-power-off"></i> خروج</button>
                </form>
            </div>
        </header>

        <div class="content-area">
            <div class="welcome-text">
                <h2><span id="time-greeting">مرحباً</span>، {{ auth()->user()->name }} 👋</h2>
                <p>إليك نظرة عامة على إحصائيات المخيم اليوم.</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card" style="border-right-color: var(--primary);">
                    <div class="stat-icon" style="background: #f8efe6; color: var(--primary);"><i class="fa-solid fa-people-group"></i></div>
                    <div class="stat-details">
                        <h3>إجمالي النازحين</h3>
                        <p>{{ $individualsCount }}</p>
                    </div>
                </div>
                <div class="stat-card" style="border-right-color: #6d4c41;">
                    <div class="stat-icon" style="background: #efebe9; color: #6d4c41;"><i class="fa-solid fa-campground"></i></div>
                    <div class="stat-details">
                        <h3>الخيام المسجلة</h3>
                        <p>{{ $tentsCount }}</p>
                    </div>
                </div>
                <div class="stat-card" style="border-right-color: #bcaaa4;">
                    <div class="stat-icon" style="background: #fafafa; color: #8d6e63;"><i class="fa-solid fa-house-user"></i></div>
                    <div class="stat-details">
                        <h3>العائلات</h3>
                        <p>{{ $familiesCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>