<x-layouts.app>
    <div class="p-6">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                Registrar Dashboard
            </h1>
            <p class="text-gray-500 mt-2 font-medium">
                Manage and review pending special exam applications
            </p>
        </div>

        <!-- Success / Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        <!-- Department Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

            <x-notif-card 
                title="Tertiary Department" 
                :count="$tertiaryCount" 
                link="{{ route('registrar.courses', 'tertiary') }}" 
            />

            <x-notif-card 
                title="Senior High School (SHS)" 
                :count="$shsCount" 
                link="{{ route('registrar.courses', 'shs') }}" 
            />

        </div>

        <!-- Recent Requests Preview (optional but useful) -->
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-xl font-bold text-gray-800 mb-4">
                Latest Pending Requests
            </h2>

            @if(isset($latestRequests) && count($latestRequests) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">

                        <thead>
                            <tr class="border-b">
                                <th class="p-2">Student ID</th>
                                <th class="p-2">Subject</th>
                                <th class="p-2">Program</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($latestRequests as $req)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2">{{ $req->student_id }}</td>
                                    <td class="p-2">{{ $req->subject }}</td>
                                    <td class="p-2">{{ $req->program ?? 'N/A' }}</td>
                                    <td class="p-2 text-yellow-600 font-semibold">
                                        {{ $req->status }}
                                    </td>

                                    <td class="p-2 flex gap-2">

                                        <!-- Approve -->
                                        <a href="{{ route('registrar.approve', $req->id) }}"
                                           class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                                            Approve
                                        </a>

                                        <!-- Reject -->
                                        <a href="{{ route('registrar.reject', $req->id) }}"
                                           class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                                            Reject
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <p class="text-gray-500">No pending requests found.</p>
            @endif

        </div>

    </div>
</x-layouts.app>