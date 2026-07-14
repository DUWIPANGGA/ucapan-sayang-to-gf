<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Valentine Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0f0f12;--card:#1a1a24;--border:#2a2a3a;--red:#ef4444;--pink:#ec4899;--text:#e4e4e7;--muted:#71717a;--input:#27272a;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:1rem;}
        body::before{content:'';position:fixed;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle at center,rgba(239,68,68,0.08) 0%,transparent 50%);pointer-events:none;}

        .login-wrap{width:100%;max-width:400px;position:relative;z-index:1;}
        .login-card{background:var(--card);border:1px solid var(--border);border-radius:1rem;padding:2.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.4);}
        .login-brand{text-align:center;margin-bottom:2rem;}
        .login-brand .icon{font-size:2.5rem;margin-bottom:0.5rem;}
        .login-brand h1{font-size:1.5rem;font-weight:700;color:#fff;}
        .login-brand p{font-size:0.875rem;color:var(--muted);margin-top:0.25rem;}

        .form-group{margin-bottom:1.25rem;}
        .form-label{display:block;font-size:0.875rem;font-weight:500;margin-bottom:0.5rem;color:var(--muted);}
        .form-input{width:100%;padding:0.7rem 1rem;background:var(--input);border:1px solid var(--border);border-radius:0.5rem;color:var(--text);font-size:0.9rem;transition:border-color 0.2s;outline:none;font-family:inherit;}
        .form-input:focus{border-color:var(--red);}

        .form-check{display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;}
        .form-check input[type="checkbox"]{width:16px;height:16px;accent-color:var(--red);cursor:pointer;}
        .form-check label{font-size:0.85rem;color:var(--muted);cursor:pointer;}

        .btn-login{width:100%;padding:0.75rem;border:none;border-radius:0.5rem;background:linear-gradient(135deg,var(--red),var(--pink));color:#fff;font-size:0.95rem;font-weight:600;cursor:pointer;transition:all 0.3s;font-family:inherit;}
        .btn-login:hover{opacity:0.9;transform:translateY(-1px);box-shadow:0 4px 15px rgba(239,68,68,0.3);}
        .btn-login:active{transform:translateY(0);}

        .alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:var(--red);padding:0.75rem 1rem;border-radius:0.5rem;margin-bottom:1.5rem;font-size:0.85rem;}

        .login-footer{text-align:center;margin-top:1.5rem;font-size:0.8rem;color:var(--muted);}
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-card">
            <div class="login-brand">
                <div class="icon">&#10084;&#65039;</div>
                <h1>Valentine Admin</h1>
                <p>Masuk untuk mengelola data</p>
            </div>

            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="admin@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" required placeholder="Masukkan password">
                </div>

                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
        <div class="login-footer">&copy; {{ date('Y') }} Valentine App</div>
    </div>
</body>
</html>
