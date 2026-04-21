<x-layouts.app>
    <div>
        <a href="{{ route('registrar.dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-6 bg-gray-200 px-3 py-1.5 rounded-md">
            &larr; Back
        </a>
        
        <h1 class="text-3xl font-black text-gray-800 mb-8">Tertiary Courses</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-notif-card title="BS Information Technology" count="8" link="{{ route('registrar.submissions', 'bsit') }}" />
            <x-notif-card title="BS Computer Science" count="4" link="#" />
            <x-notif-card title="BS Business Administration" count="0" link="#" />
        </div>
    </div>
</x-layouts.app>