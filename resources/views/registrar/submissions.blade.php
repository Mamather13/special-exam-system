<x-layouts.app>
    <div class="p-6">

        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="text-gray-500 text-sm mb-4 inline-block">
            ← Back
        </a>

        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $course }}
        </h1>
        <p class="text-gray-500 mb-6">
            Pending special exam requests
        </p>

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow p-4">

            <table class="w-full text-sm text-left">

                <!-- Header -->
                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="p-3">STUDENT</th>
                        <th class="p-3">STUDENT NO.</th>
                        <th class="p-3">SUBJECT</th>
                        <th class="p-3">SECTION</th>
                        <th class="p-3">EXAM TYPE</th>
                        <th class="p-3">TERM</th>
                        <th class="p-3">REASON</th>
                        <th class="p-3">DATE</th>
                        <th class="p-3">DOCUMENTS</th>
                        <th class="p-3 text-right">STATUS</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>

                    @forelse($requests as $req)
                        <tr class="border-b hover:bg-gray-50">

                            <!-- Student -->
                            <td class="p-3 font-semibold text-gray-800">
                                {{ $req->student_id }}
                            </td>

                            <!-- Student Number -->
                            <td class="p-3 text-gray-600">
                                {{ $req->student_number }}
                            </td>

                            <!-- Subject -->
                            <td class="p-3">
                                <div class="font-medium">
                                    {{ $req->subject }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $req->subject_code }}
                                </div>
                            </td>

                            <!-- Section -->
                            <td class="p-3">{{ $req->section }}</td>

                            <!-- Exam Type -->
                            <td class="p-3">{{ $req->exam_type }}</td>

                            <!-- Term -->
                            <td class="p-3">{{ $req->term }}</td>

                            <!-- Reason -->
                            <td class="p-3 text-gray-500 italic">
                                {{ $req->reason }}
                            </td>

                            <!-- Date -->
                            <td class="p-3 text-gray-500">
                                {{ \Carbon\Carbon::parse($req->date_submitted)->format('Y-m-d H:i') }}
                            </td>

                            <!-- Documents -->
                            <td class="p-3">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                    View Docs
                                </button>
                            </td>

                            <!-- Status -->
                            <td class="p-3 text-right space-x-2">

                            <!-- Approve -->
                            <a href="{{ route('registrar.approve', $req->id) }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                                 Approve
                            </a>

                            <!-- Reject -->
                            <a href="{{ route('registrar.reject', $req->id) }}"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                             Reject
                            </a>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center p-6 text-gray-400">
                                No pending requests
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</x-layouts.app>