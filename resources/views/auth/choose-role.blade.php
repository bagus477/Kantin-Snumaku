<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in Kantin Digital</title>
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
            margin-bottom: 0.75rem;
        }
        .role-options {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            margin-bottom: 1.75rem;
        }
        .role-button {
            display: block;
            width: 100%;
            padding: 0.7rem 1rem;
            border-radius: 999px;
            border: none;
            background: #ffffff;
            color: #1f2933;
            font-size: 0.95rem;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: background 0.15s ease, transform 0.05s ease, box-shadow 0.15s ease;
        }
        .role-button.selected {
            background: #10b981;
            color: #ecfdf5;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
        }
        .role-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.35);
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
        <h1>Log in Kantin Digital</h1>
        <p class="subtitle">Log in Sebagai:</p>

        <form id="role-form" method="GET">
            <input type="hidden" name="role" id="role-input">

            <div class="role-options">
                <button type="button" class="role-button" data-role="pembeli">Pembeli</button>
                <button type="button" class="role-button" data-role="penjual">Penjual</button>
            </div>

            <button type="submit" class="submit-btn">Continue</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('role-form');
        const roleInput = document.getElementById('role-input');
        const buttons = document.querySelectorAll('.role-button');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
                const role = btn.dataset.role;
                roleInput.value = role;

                if (role === 'pembeli') {
                    form.action = '{{ route('login.pembeli') }}';
                } else {
                    form.action = '{{ route('login.penjual') }}';
                }
            });
        });
    </script>
</body>
</html>
