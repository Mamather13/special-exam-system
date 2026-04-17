<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMPASS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans leading-relaxed">

    <nav class="bg-white h-[70px] flex items-center justify-center border-b-2 border-sti-yellow sticky top-0 z-50 ">
        <div class="flex items-center justify-between w-full max-w-[1440px] px-[2%]">
        
            <div class="text-2xl font-black uppercase text-gray-900 whitespace-nowrap tracking-tighter">
                EXAM<span class="text-sti-yellow">PASS</span>
            </div>

            <div class="flex items-center gap-5">
                
                <div class="relative">
                    <button id="notifBtn" type="button" aria-label="Notifications" class="text-gray-600 hover:text-gray-800 transition-colors p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11c0-3.07-1.64-5.64-4.5-6.32V4a1.5 1.5 0 1 0-3 0v.68C7.64 5.36 6 7.929 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 1 1-6 0h6z" />
                        </svg>
                    </button>

                    <div id="notifDropdown" class="hidden absolute top-[calc(100%+15px)] right-0 w-80 bg-white rounded-2xl shadow-xl z-50 overflow-hidden border border-gray-100">
                        <div class="bg-sti-yellow p-5 text-gray-900">
                            <h3 class="m-0 text-base font-bold">Notifications</h3>
                            <p class="mt-0.5 text-xs opacity-80 font-medium">0 new notifications</p>
                        </div>
                        <div class="p-10 text-center bg-white">
                            <p class="text-gray-400 text-sm">No new notifications</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div id="userProfileBtn" class="flex items-center gap-3 py-1.5 px-3 rounded-full hover:bg-gray-100 cursor-pointer transition-colors whitespace-nowrap border border-transparent hover:border-gray-200">
                        <div class="flex flex-col text-left leading-tight">
                            <span class="text-sm font-semibold text-gray-700">Juan Dela Cruz</span>
                            <span class="text-[11px] text-gray-500  mt-1 tracking-widest">Student</span>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-secondary-yellow flex items-center justify-center font-bold text-[15px] text-gray-700 shadow-sm">
    JD
</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25 12 15.75 4.5 8.25" />
                        </svg>
                    </div>

                    <div id="profileDropdown" class="hidden absolute top-[calc(100%+15px)] right-0 w-48 bg-white rounded-xl shadow-xl z-50 py-1.5 border border-gray-100">
                        <ul class="list-none m-0 p-0">
    <li>
        <a href="#" class="flex items-center gap-2.5 py-2.5 px-4 text-gray-600 no-underline text-sm hover:bg-yellow-50 hover:text-sti-yellow-dark transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Settings</span>
        </a>
    </li>

    <li>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2.5 py-2.5 px-4 text-red-600 text-sm hover:bg-red-50 transition-all text-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 5.25v13.5A2.25 2.25 0 006.75 21h6.75A2.25 2.25 0 0015.75 18.75V15m-3-3H21m0 0l-3-3m3 3l-3 3" />
                </svg>
                <span>Sign Out</span>
            </button>
        </form>
    </li>
</ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-[1440px] px-[5%] py-8">
        {{ $slot }}
    </main>

</body>
</html>