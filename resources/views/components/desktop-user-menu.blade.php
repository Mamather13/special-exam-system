@php
    $userId = session('user_id');
    $user = $userId ? DB::table('users')->where('id', $userId)->first() : null;
    $fullName = $user ? trim(($user->Fname ?? '') . ' ' . ($user->Lname ?? '')) : 'Guest';
    $role = $user ? ucfirst(str_replace('_', ' ', $user->role)) : '';
    $initials = collect(explode(' ', $fullName))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
@endphp

<flux:dropdown position="bottom" align="start">
    <div class="flex items-center gap-3 cursor-pointer px-3 py-2 rounded-xl hover:bg-gray-100 transition-colors">
        <div class="w-9 h-9 rounded-full bg-[#F1C40F] flex items-center justify-center text-white font-black text-sm">
            {{ $initials }}
        </div>
        <div class="text-left hidden md:block">
            <p class="text-sm font-bold text-gray-900 leading-tight">{{ $fullName }}</p>
            <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">{{ $role }}</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    <flux:menu>
        <div class="flex items-center gap-3 px-3 py-3">
            <div class="w-10 h-10 rounded-full bg-[#F1C40F] flex items-center justify-center text-white font-black text-sm flex-shrink-0">
                {{ $initials }}
            </div>
            <div class="grid flex-1 text-start text-sm leading-tight">
                <span class="font-bold text-gray-900 truncate">{{ $fullName }}</span>
                <span class="text-xs text-gray-400 truncate uppercase tracking-wide">{{ $role }}</span>
            </div>
        </div>
        <flux:menu.separator />
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <flux:menu.item
                as="button"
                type="submit"
                icon="arrow-right-start-on-rectangle"
                class="w-full cursor-pointer"
            >
                {{ __('Log out') }}
            </flux:menu.item>
        </form>
    </flux:menu>
</flux:dropdown>