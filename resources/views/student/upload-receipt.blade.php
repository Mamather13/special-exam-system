{{-- resources/views/student/upload-receipt.blade.php --}}
{{-- Shown when application status = 'approved' (teacher approved, awaiting payment) --}}

@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 px-4">

    {{-- Header card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">{{ $application->subject_code }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ $application->teacher_name }} &bull; {{ $application->section }}
                </p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                Teacher Approved
            </span>
        </div>
    </div>

    {{-- Payment instruction --}}
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-4">
        <div class="flex gap-3">
            <div class="mt-0.5 flex-shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-amber-800">Payment required before proceeding</p>
                <p class="text-sm text-amber-700 mt-1">
                    Please pay <strong>₱200.00</strong> at the cashier window and upload your official receipt below.
                    Your application will be forwarded to the Program Head after submission.
                </p>
            </div>
        </div>
    </div>

    {{-- Upload form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-medium text-gray-900 mb-5">Upload Official Receipt</h2>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5">
                <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('student.application.submit-receipt', $application->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            {{-- Receipt number --}}
            <div class="mb-4">
                <label for="or_number" class="block text-sm font-medium text-gray-700 mb-1">
                    Official Receipt (OR) Number
                </label>
                <input
                    type="text"
                    id="or_number"
                    name="or_number"
                    value="{{ old('or_number') }}"
                    placeholder="e.g. 0012345"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                />
            </div>

            {{-- Amount paid (readonly) --}}
            <div class="mb-4">
                <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-1">
                    Amount Paid
                </label>
                <input
                    type="text"
                    id="amount_paid"
                    name="amount_paid"
                    value="200.00"
                    readonly
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed"
                />
            </div>

            {{-- File upload --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Receipt Image
                    <span class="text-gray-400 font-normal">(JPG, PNG, or PDF — max 5MB)</span>
                </label>

                {{-- Drop zone --}}
                <label
                    for="receipt_file"
                    id="drop-zone"
                    class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors"
                >
                    <div id="drop-placeholder" class="flex flex-col items-center gap-1 text-center px-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                    </div>
                    <p id="file-name" class="hidden text-sm text-blue-600 font-medium"></p>
                    <input
                        id="receipt_file"
                        name="receipt_file"
                        type="file"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="hidden"
                        required
                    />
                </label>
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl text-sm transition-colors"
            >
                Submit Receipt & Continue
            </button>
        </form>
    </div>

    {{-- Close / back --}}
    <div class="mt-3">
        <a href="{{ route('student.applications.index') }}"
           class="block text-center text-sm text-gray-500 hover:text-gray-700 py-3">
            Back to My Applications
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const input = document.getElementById('receipt_file');
    const placeholder = document.getElementById('drop-placeholder');
    const fileNameEl = document.getElementById('file-name');

    input.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            placeholder.classList.add('hidden');
            fileNameEl.textContent = this.files[0].name;
            fileNameEl.classList.remove('hidden');
        }
    });
</script>
@endpush
