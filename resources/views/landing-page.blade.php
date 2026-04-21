<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMPASS | Online Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --color-sti-yellow: #fedc00;
            --hero-bg: url("{{ asset('images/sti-img.webp') }}");
        }
    </style>
</head>
<body class="bg-[#f9fafb] text-gray-800 font-sans leading-relaxed antialiased">

    <div class="min-h-screen flex flex-col">
        
        <nav class="bg-white h-[70px] flex items-center justify-center border-b-2 border-[#fedc00] sticky top-0 z-50">
            <div class="flex items-center justify-between w-full max-w-[1440px] px-[1.5%]">
                
                <div class="text-2xl font-black uppercase text-gray-900 whitespace-nowrap tracking-[0.1em] flex items-center">EXAM<span class="text-[#fedc00]">PASS</span></div>

                <div class="flex items-center">
                    <button onclick="togglePortalModal()" class="bg-[#fedc00] hover:bg-yellow-400 text-gray-900 font-bold px-8 py-2.5 rounded-md shadow-sm transition-all text-sm  tracking-tight">
                        Log in
                    </button>
                </div>
            </div>
        </nav>

        <main class="relative flex-grow w-full bg-cover bg-center flex items-center overflow-hidden" 
              style="background-image: var(--hero-bg); min-height: calc(100vh - 70px);">
            
            <div class="absolute inset-0 bg-black/40 md:bg-transparent md:bg-gradient-to-r md:from-black/80 md:via-black/30 md:to-transparent"></div>

            <div class="relative z-10 px-8 md:px-24 max-w-4xl w-full py-20">
                <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-black leading-[1.15] mb-4 tracking-tight drop-shadow-2xl">
                    Register for <br class="hidden md:block">
                    <span class="text-white">Special Exams</span>
                </h1>
                
                <p class="text-gray-100 text-base md:text-xl font-medium max-w-xl drop-shadow-md leading-relaxed">
                    Fast and easy application for special examination requests.
                </p>
            </div>
        </main>

        <div id="portalModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="fixed inset-0 bg-black/70 transition-opacity" onclick="togglePortalModal()"></div>

            <div class="flex items-center justify-center min-h-screen p-4">
                
                <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-xl p-8 md:p-12 transform transition-all border border-gray-100">
                    
                    <button onclick="togglePortalModal()" class="absolute top-6 right-8 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>

                    <h2 class="text-gray-500 text-sm font-medium mb-8">Select your portal to continue:</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <a href="{{ route('student.dashboard') }}" class="bg-[#fedc00] hover:bg-yellow-400 text-gray-900 font-bold py-4 px-6 rounded-xl text-center shadow-sm transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i class="fa-solid fa-user-graduate"></i> Student Login
                        </a>

                        <a href="{{ route('teacher.dashboard') }}" class="bg-[#fedc00] hover:bg-yellow-400 text-gray-900 font-bold py-4 px-6 rounded-xl text-center shadow-sm transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i class="fa-solid fa-chalkboard-user"></i> Teacher Login
                        </a>

                        <a href="{{ route('head.dashboard') }}" class="bg-[#fedc00] hover:bg-yellow-400 text-gray-900 font-bold py-4 px-6 rounded-xl text-center shadow-sm transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i class="fa-solid fa-id-card-clip"></i> Program Head
                        </a>

                        <a href="{{ route('registrar.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-xl text-center transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i class="fa-solid fa-file-invoice text-gray-400"></i> Registrar
                        </a>

                        <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-xl text-center transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i class="fa-solid fa-user-shield text-gray-400"></i> Admin login
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.togglePortalModal = function() {
            const modal = document.getElementById('portalModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); // Prevent background scroll
            } else {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        };
    </script>
</body>
</html>