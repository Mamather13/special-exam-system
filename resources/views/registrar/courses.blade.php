<x-layouts.app>
    <div class="p-6">

        <!-- Back -->
        <a href="{{ route('registrar.dashboard') }}" 
           class="text-gray-500 text-sm mb-4 inline-block">
            ← Back
        </a>

        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            {{ strtoupper($type) }} Courses
        </h1>
        <p class="text-gray-500 mb-6">
            Select a course to review student requests
        </p>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($courses as $course)
                <a href="{{ route('registrar.submissions', $course->program) }}">

                    <div class="relative bg-white rounded-xl shadow p-6 hover:shadow-lg transition cursor-pointer">

                        <!-- Badge -->
                        <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            {{ $course->total }}
                        </div>

                        <!-- Icon -->
                        <div class="text-gray-400 mb-4 text-xl">
                            📘
                        </div>

                        <!-- Course Name -->
                        <h2 class="text-lg font-bold text-gray-900">
                            {{ $course->program }}
                        </h2>

                        <!-- Count -->
                        <p class="text-red-500 text-sm mt-2">
                            {{ $course->total }} pending approval{{ $course->total > 1 ? 's' : '' }}
                        </p>

                    </div>

                </a>
            @empty
                <p class="text-gray-400">No courses found.</p>
            @endforelse

        </div>

    </div>
</x-layouts.app>