<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobFinder') | Karir Bandung</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
            --shadow: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.1);
            --radius: 12px;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark);
        }
        
        .app-container { display: flex; min-height: 100vh; }
        
        .sidebar {
            width: 260px;
            background: var(--white);
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .sidebar-brand h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .sidebar-brand span {
            font-size: 0.75rem;
            opacity: 0.9;
            display: block;
            margin-top: 0.25rem;
        }
        
        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }
        
        .nav-section {
            padding: 0.5rem 1rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--gray);
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover, .nav-link.active {
            background: var(--light);
            color: var(--primary);
            border-left-color: var(--primary);
        }
        
        .nav-link i { width: 20px; text-align: center; }
        
        .sidebar-footer { padding: 1rem; border-top: 1px solid var(--light); }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--light);
            border-radius: var(--radius);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .user-details h4 { font-size: 0.875rem; font-weight: 600; }
        .user-details span { font-size: 0.75rem; color: var(--gray); }
        
        .main-wrapper { flex: 1; margin-left: 260px; padding: 2rem; }
        
        .main-content {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            min-height: calc(100vh - 4rem);
            padding: 2rem;
        }
        
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }
        
        .btn-success { background: var(--success); color: white; }
        .btn-warning { background: var(--warning); color: white; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-secondary { background: var(--gray); color: white; }
        .btn-outline { background: transparent; border: 1px solid var(--gray); color: var(--dark); }
        .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.75rem; }
        
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
        }
        
        .card-body { padding: 1.25rem; }
        .form-group { margin-bottom: 1rem; }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.375rem;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }
        
        .table-container { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        
        .table th, .table td {
            padding: 0.875rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--gray);
            font-weight: 600;
            background: var(--light);
        }
        
        .table tbody tr:hover { background: #f8fafc; }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-primary { background: #eef2ff; color: var(--primary); }
        .badge-success { background: #ecfdf5; color: #059669; }
        .badge-warning { background: #fffbeb; color: #d97706; }
        .badge-danger { background: #fef2f2; color: #dc2626; }
        .badge-info { background: #f0f9ff; color: #0284c7; }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
            padding: 1.25rem;
            border-radius: var(--radius);
            border: 1px solid #e2e8f0;
        }
        
        .stat-card h3 { font-size: 1.75rem; font-weight: 700; color: var(--primary); }
        .stat-card p { font-size: 0.8rem; color: var(--gray); margin-top: 0.25rem; }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--dark); }
        
        .grid { display: grid; gap: 1rem; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        
        .job-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
        
        .job-card {
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: var(--radius);
            padding: 1.25rem;
            transition: all 0.2s;
        }
        
        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .job-card h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--dark); }
        .job-card .company { color: var(--gray); font-size: 0.875rem; margin-bottom: 0.75rem; }
        .job-meta { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
        .job-meta span { font-size: 0.75rem; color: var(--gray); display: flex; align-items: center; gap: 0.25rem; }
        .actions { display: flex; gap: 0.5rem; }
        
        .empty-state { text-align: center; padding: 3rem; color: var(--gray); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-overlay.active { display: flex; }
        
        .modal {
            background: var(--white);
            border-radius: var(--radius);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-body { padding: 1.25rem; }
        .modal-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }
        
        .text-center { text-align: center; }
        .text-muted { color: var(--gray); }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        
        .detail-grid { display: grid; grid-template-columns: 140px 1fr; gap: 0.75rem; }
        .detail-label { font-weight: 500; color: var(--gray); font-size: 0.875rem; }
        .detail-value { color: var(--dark); }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h1><i class="fas fa-briefcase"></i> JobFinder</h1>
                <span>Karir Kabupaten Bandung</span>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">Menu Utama</div>
                <a href="{{ route('jobfinder.dashboard') }}" class="nav-link {{ request()->routeIs('jobfinder.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('jobfinder.lowongan.index') }}" class="nav-link {{ request()->routeIs('jobfinder.lowongan.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> Lowongan Kerja
                </a>
                <a href="{{ route('jobfinder.lamaran.index') }}" class="nav-link {{ request()->routeIs('jobfinder.lamaran.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i> Lamaran
                </a>
                
                <div class="nav-section">Akun</div>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left; font-family: inherit; font-size: inherit;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </nav>
            
            <div class="sidebar-footer">
                @php /** @var \App\Models\User $authUser */ $authUser = Auth::user(); @endphp
                <div class="user-info">
                    <div class="user-avatar">{{ strtoupper(substr($authUser->name, 0, 1)) }}</div>
                    <div class="user-details">
                        <h4>{{ $authUser->name }}</h4>
                        <span>{{ ucfirst($authUser->role) }}</span>
                    </div>
                </div>
            </div>
        </aside>
        
        <div class="main-wrapper">
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-times-circle"></i>
                        <ul style="margin: 0; padding-left: 1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        setTimeout(() => document.querySelectorAll('.alert').forEach(a => a.style.display = 'none'), 5000);
    </script>
    @stack('scripts')
</body>
</html>
