<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembeli - Sign up</title>
    @vite('resources/css/app.css')
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom, #9fd5ff, #1e73e8);
        }
        .card {
            background: rgba(255, 255, 255, 0.18);
            padding: 2.5rem 3rem;
            border-radius: 1.5rem;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.25);
            backdrop-filter: blur(18px);
            color: #fff;
            width: 100%;
            max-width: 480px;
        }
        h1 {
            margin-top: 0;
            margin-bottom: 1.75rem;
            font-size: 2.3rem;
            font-weight: 700;
        }
        .subtitle {
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            color: #e5e7eb;
        }
        .field {
            margin-bottom: 1rem;
        }
        .field input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: none;
            font-size: 0.95rem;
            background: #ffffff;
            color: #111827;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.18);
        }
        .field.password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
            color: #6b7280;
            background: transparent;
            border: none;
            cursor: pointer;
        }
        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 999px;
            padding: 0.9rem 1rem;
            background: #16a34a;
            color: #ecfdf5;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.05s ease, box-shadow 0.15s ease;
            margin-top: 0.75rem;
        }
        .submit-btn:hover {
            background: #15803d;
            box-shadow: 0 12px 30px rgba(22, 163, 74, 0.5);
            transform: translateY(-1px);
        }
        .terms {
            font-size: 0.75rem;
            margin-top: 0.75rem;
            color: #e5e7eb;
        }
        .signin {
            margin-top: 1.25rem;
            font-size: 0.85rem;
            text-align: center;
        }
        .signin a {
            color: #bfdbfe;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Sign up</h1>
        <p class="subtitle">Looks like you don't have an account. Let's create a new account.</p>

        <form method="POST" action="{{ route('register.pembeli.store') }}">
            @csrf

            <div class="field">
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>

            <div class="field password-wrapper">
                <input id="password" type="password" name="password" placeholder="Password" required>
                <button type="button" class="toggle-password" data-target="password">View</button>
            </div>

            <div class="field password-wrapper">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                <button type="button" class="toggle-password" data-target="password_confirmation">View</button>
            </div>

            <button type="submit" class="submit-btn">Agree and continue</button>

            <p class="terms">By selecting Agree and continue below, I agree to Terms of Service and Privacy Policy.</p>

            <p class="signin">Already have an account? <a href="{{ route('login.pembeli') }}">Log in</a></p>
        </form>
    </div>
<script>
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.textContent = isPassword ? 'Hide' : 'View';
        });
    });
</script>
</body>
</html>
