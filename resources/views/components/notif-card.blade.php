@props(['title', 'count' => 0, 'link' => '#'])

<a href="{{ $link }}" class="relative block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow focus:outline-none focus:ring-2 focus:ring-[#FFD200]">
    
    @if($count > 0)
        <div class="absolute -top-3 -right-3 bg-red-500 text-white text-xs font-bold w-7 h-7 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
            {{ $count }}
        </div>
    @endif
    
    <div class="flex items-center justify-between">
        <h3 class="text-xl font-bold text-gray-800">{{ $title }}</h3>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </div>
</a>