<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Valentine Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0f0f12;--card:#1a1a24;--border:#2a2a3a;--red:#ef4444;--pink:#ec4899;--text:#e4e4e7;--muted:#71717a;--input:#27272a;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}

        .navbar{background:var(--card);border-bottom:1px solid var(--border);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;backdrop-filter:blur(10px);}
        .navbar-brand{font-size:1.25rem;font-weight:700;color:#fff;text-decoration:none;display:flex;align-items:center;gap:0.5rem;}
        .navbar-brand span{color:var(--red);}
        .navbar-links{display:flex;gap:1rem;}
        .navbar-links a{color:var(--muted);text-decoration:none;font-size:0.875rem;transition:color 0.2s;}
        .navbar-links a:hover,.navbar-links a.active{color:#fff;}

        .container{max-width:1100px;margin:0 auto;padding:2rem 1.5rem;}

        .card{background:var(--card);border:1px solid var(--border);border-radius:1rem;padding:1.5rem;}
        .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;}
        .card-title{font-size:1.25rem;font-weight:600;}

        .btn{display:inline-flex;align-items:center;gap:0.5rem;padding:0.6rem 1.25rem;border-radius:0.5rem;font-size:0.875rem;font-weight:500;cursor:pointer;transition:all 0.2s;border:none;text-decoration:none;}
        .btn-primary{background:var(--red);color:#fff;}
        .btn-primary:hover{background:#dc2626;}
        .btn-secondary{background:var(--border);color:var(--text);}
        .btn-secondary:hover{background:#3a3a4a;}
        .btn-danger{background:transparent;color:var(--red);border:1px solid var(--red);}
        .btn-danger:hover{background:var(--red);color:#fff;}
        .btn-sm{padding:0.4rem 0.75rem;font-size:0.8rem;}

        table{width:100%;border-collapse:collapse;}
        th,td{padding:0.875rem 1rem;text-align:left;border-bottom:1px solid var(--border);}
        th{color:var(--muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;font-weight:600;}
        tr:hover{background:rgba(255,255,255,0.02);}
        td{font-size:0.9rem;}

        .form-group{margin-bottom:1.25rem;}
        .form-label{display:block;font-size:0.875rem;font-weight:500;margin-bottom:0.5rem;color:var(--muted);}
        .form-input{width:100%;padding:0.7rem 1rem;background:var(--input);border:1px solid var(--border);border-radius:0.5rem;color:var(--text);font-size:0.9rem;transition:border-color 0.2s;outline:none;}
        .form-input:focus{border-color:var(--red);}
        textarea.form-input{min-height:120px;resize:vertical;font-family:inherit;}
        .form-hint{font-size:0.75rem;color:var(--muted);margin-top:0.25rem;}

        .alert{padding:0.875rem 1rem;border-radius:0.5rem;margin-bottom:1.5rem;font-size:0.875rem;}
        .alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#22c55e;}
        .alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:var(--red);}

        .badge{display:inline-flex;padding:0.2rem 0.6rem;border-radius:9999px;font-size:0.75rem;font-weight:500;}
        .badge-link{background:rgba(239,68,68,0.1);color:var(--red);}

        .empty{text-align:center;padding:3rem 1rem;color:var(--muted);}
        .empty-icon{font-size:3rem;margin-bottom:1rem;}
        .empty-text{font-size:1rem;margin-bottom:1rem;}
        .empty-sub{font-size:0.85rem;color:var(--muted);}

        .avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--red),var(--pink));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;color:#fff;flex-shrink:0;}

        .actions{display:flex;gap:0.5rem;}

        @media(max-width:640px){
            .navbar{padding:0.8rem 1rem;}
            .container{padding:1rem;}
            th:nth-child(4),td:nth-child(4){display:none;}
            .card-header{flex-direction:column;align-items:flex-start;}
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('admin.index') }}" class="navbar-brand"><span>&#10084;</span> Valentine Admin</a>
        <div class="navbar-links">
            <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.*')?'active':'' }}">Data</a>
            <a href="{{ route('admin.create') }}" class="{{ request()->routeIs('admin.create')?'active':'' }}">Tambah Baru</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:0.875rem;padding:0;font-family:inherit;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
