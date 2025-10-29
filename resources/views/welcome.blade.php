<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang di TernakPark</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Tailwind CSS (for quick styling) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #2d3748;
        }
        .welcome-container {
            background-color: #ffffff;
            border-radius: 1.5rem; /* rounded-xl */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* shadow-xl */
            padding: 2.5rem; /* p-10 */
            text-align: center;
            max-width: 800px;
            width: 90%;
            animation: fadeIn 1s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header-text {
            font-size: 2.5rem; /* text-5xl */
            font-weight: 700; /* font-bold */
            color: #38a169; /* text-green-600 */
            margin-bottom: 1rem;
        }
        .sub-header-text {
            font-size: 1.25rem; /* text-xl */
            color: #4a5568; /* text-gray-700 */
            margin-bottom: 2rem;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem; /* gap-6 */
            margin-bottom: 2.5rem;
        }
        .feature-item {
            background-color: #edf2f7; /* bg-gray-100 */
            padding: 1.5rem; /* p-6 */
            border-radius: 0.75rem; /* rounded-lg */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .feature-icon {
            font-size: 2rem; /* text-4xl */
            color: #38a169; /* text-green-600 */
            margin-bottom: 0.75rem;
        }
        .auth-links a {
            display: inline-block;
            background-color: #38a169; /* bg-green-600 */
            color: #ffffff;
            padding: 0.75rem 2rem; /* py-3 px-8 */
            border-radius: 9999px; /* rounded-full */
            text-decoration: none;
            font-weight: 600; /* font-semibold */
            transition: background-color 0.3s ease;
            margin: 0 0.5rem;
        }
        .auth-links a:hover {
            background-color: #2f855a; /* hover:bg-green-700 */
        }
        .auth-links a.register {
            background-color: #4299e1; /* bg-blue-500 */
        }
        .auth-links a.register:hover {
            background-color: #3182ce; /* hover:bg-blue-600 */
        }
        .footer-text {
            margin-top: 2rem;
            font-size: 0.875rem; /* text-sm */
            color: #a0aec0; /* text-gray-500 */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header-text {
                font-size: 2rem;
            }
            .sub-header-text {
                font-size: 1rem;
            }
            .welcome-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1 class="header-text">
            <i class="fas fa-leaf animate-bounce"></i> Selamat Datang di Dashboard TP!
        </h1>

        <div class="feature-grid">
            <div class="feature-item">
                <i class="fas fa-paw feature-icon"></i>
                <h4 class="text-lg font-semibold mb-2">Manajemen Ternak</h4>
                <p class="text-sm text-gray-600">Catat dan lacak setiap domba dengan detail.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-warehouse feature-icon"></i>
                <h4 class="text-lg font-semibold mb-2">Manajemen Kavling</h4>
                <p class="text-sm text-gray-600">Atur kavling secara efisien.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-home feature-icon"></i>
                <h4 class="text-lg font-semibold mb-2">Manajemen Kandang</h4>
                <p class="text-sm text-gray-600">Atur kandang secara efisien.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-carrot feature-icon"></i>
                <h4 class="text-lg font-semibold mb-2">Inventaris Pakan</h4>
                <p class="text-sm text-gray-600">Pantau stok pakan.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-handshake feature-icon"></i>
                <h4 class="text-lg font-semibold mb-2">Data Investor</h4>
                <p class="text-sm text-gray-600">Kelola informasi investor.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-users feature-icon"></i>
                <h4 class="text-lg font-semibold mb-2">Manajemen ABK</h4>
                <p class="text-sm text-gray-600">Data lengkap ABK peternakan.</p>
            </div>
        </div>

        <div class="auth-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="register">Register</a>
                    @endif
                @endauth
            @endif
        </div>

        <p class="footer-text">
            &copy; {{ date('Y') }} TernakPark. All rights reserved.
        </p>
    </div>

    <script>
        // Simple animation for the leaf icon
        const leafIcon = document.querySelector('.animate-bounce');
        if (leafIcon) {
            leafIcon.style.animationIterationCount = 'infinite';
            leafIcon.style.animationDuration = '2s';
            leafIcon.style.animationTimingFunction = 'ease-in-out';
        }
    </script>
</body>
</html>
