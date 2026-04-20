@props(['title', 'count' => 0, 'route'])

<div onclick="window.location='{{ $route }}'" 
     class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
    
    <div class="relative inline-flex items-center justify-center w-14 h-14 bg-[#FFF9D6] rounded-xl mb-4 group-hover:bg-[#FFF4B3] transition-colors">
        <svg class="w-7 h-7 text-[#F1C40F]" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
        </svg>
        
        @if($count > 0)
        <span class="absolute -top-2 -right-2 bg-[#EF4444] text-white text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-[2px] border-white">
            {{ $count }}
        </span>
        @endif
    </div>

    <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ $title }}</h3>
    
    @if($count > 0)
        <p class="text-sm font-medium text-[#EF4444] mt-1">{{ $count }} pending approvals</p>
    @else
        <p class="text-sm font-medium text-gray-400 mt-1">No pending requests</p>
    @endif
</div>