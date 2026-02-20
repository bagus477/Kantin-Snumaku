<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjual - Log in</title>
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
        }
        .submit-btn:hover {
            background: #15803d;
            box-shadow: 0 12px 30px rgba(22, 163, 74, 0.5);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Penjual</h1>

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <input type="hidden" name="role" value="penjual">

            <div class="field">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="submit-btn">Continue</button>
        </form>
    </div>
</body>
</html>
