<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMPASS | Online Registration</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --hero-bg: url("{{ asset('images/sti-img.webp') }}");
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white h-[70px] flex items-center justify-between px-6 border-b-2 border-yellow-400">
        <div class="text-2xl font-black">
            EXAM<span class="text-yellow-400">PASS</span>
        </div>

        <button onclick="openLoginModal()" class="bg-yellow-400 px-6 py-2 rounded font-bold hover:bg-yellow-300">
            Log in
        </button>
    </nav>

    <!-- HERO -->
    <main class="relative flex-grow flex items-center bg-cover bg-center"
        style="background-image: var(--hero-bg);">

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 text-white px-10 max-w-3xl">
            <h1 class="text-5xl font-black mb-4">
                Register for Special Exams
            </h1>
            <p class="text-lg">
                Fast and easy application for special examination requests.
            </p>
        </div>
    </main>

    <!-- LOGIN MODAL -->
    <div id="loginModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70">

        <div class="bg-white p-8 rounded-2xl w-full max-w-md relative">

            <!-- CLOSE -->
            <button onclick="closeLoginModal()" class="absolute top-4 right-5 text-gray-500">✕</button>

            <h2 class="text-xl font-bold mb-6 text-center">Log in</h2>

            <!-- ERROR -->
            @if(session('error'))
                <div class="bg-red-100 text-red-600 p-2 mb-4 rounded text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="text-sm">Email</label>
                    <input type="email" name="email" class="w-full border p-2 rounded" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">
                    <label class="text-sm">Password</label>
                    <input type="password" name="password" class="w-full border p-2 rounded" required>
                </div>

                <!-- SUBMIT -->
                <button type="submit" class="w-full bg-yellow-400 py-3 rounded font-bold hover:bg-yellow-300">
                    Login
                </button>
            </form>

        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>

function openLoginModal() {
    document.getElementById('loginModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

</script>

</body>
</html>
