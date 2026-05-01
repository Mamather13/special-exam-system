
<x-layouts.app>
<div class="max-w-7xl mx-auto p-8 font-sans">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">Program Head Dashboard</h1>
        <p class="text-gray-500 mt-2 font-medium">Manage special exam approvals and student records</p>
    </div>

    {{-- Tabs --}}
    <div class="border-b border-gray-200 mb-8">
        <nav class="-mb-px flex space-x-8" id="dashboardTabs">
            <button onclick="switchTab(this, 'first-approach-view')"
                    class="tab-btn active-tab border-[#F1C40F] text-gray-900 border-b-[3px] py-4 px-1 text-sm font-bold flex items-center gap-2 transition-all">
                First Approach
                <span class="bg-[#EF4444] text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $totalPending }}</span>
            </button>
            <button onclick="switchTab(this, 'final-approval-view')"
                    class="tab-btn border-transparent text-gray-500 border-b-[3px] py-4 px-1 text-sm font-medium flex items-center gap-2 transition-all">
                Final Approval
                <span class="bg-[#EF4444] text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $totalFinal }}</span>
            </button>
            <button onclick="switchTab(this, 'department-lists-view')"
                    class="tab-btn border-transparent text-gray-500 border-b-[3px] py-4 px-1 text-sm font-medium transition-all">
                Department Lists
            </button>
        </nav>
    </div>

    {{-- FIRST APPROACH TAB --}}
<div id="first-approach-view" class="tab-content">

    {{-- Course List View --}}
    <div id="course-list-view">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800">Pending Requests by Course</h2>
            <p class="text-sm text-gray-500 mt-1">Select a course to review student requests</p>
        </div>

        @if($courses->isEmpty())
            <div class="p-12 bg-white rounded-2xl border border-dashed border-gray-200 text-center">
                <p class="text-gray-500 font-medium">No pending requests at the moment.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($courses as $course)
                <button onclick="showCourseRequests('{{ $course->program }}')"
                   class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all text-left block w-full">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center group-hover:bg-yellow-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-yellow-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.966 8.966 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        @if($course->total > 0)
                            <span class="bg-red-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $course->total }}</span>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">{{ $course->program }}</h3>
                    <p class="text-sm mt-1 {{ $course->total > 0 ? 'text-red-500 font-medium' : 'text-gray-400' }}">
                        {{ $course->total > 0 ? $course->total . ' pending approval' . ($course->total > 1 ? 's' : '') : 'No pending requests' }}
                    </p>
                </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Course Requests Detail View --}}
    <div id="course-requests-view" class="hidden">
        <div class="flex items-center gap-4 mb-6">
            <button onclick="backToCourses()" class="flex flex-col items-center justify-center w-16 h-14 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span class="text-[10px] font-bold text-gray-900 mt-1 uppercase">Back</span>
            </button>
            <div>
                <h2 class="text-2xl font-black text-gray-900" id="course-title">BSIT</h2>
                <p class="text-sm text-gray-500 mt-1">Pending special exam requests</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Student</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Student No.</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Subject</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Section</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Exam Type</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Term</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Reason</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Date</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Documents</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
    @foreach($finalApplications as $app)
    <tr class="hover:bg-gray-50 transition-colors">
        <td class="py-5 px-8 text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($app->date_submitted)->format('M d, Y') }}
        </td>
        <td class="py-5 px-8 text-sm font-bold text-gray-900">
            {{ $app->Lname }}, {{ $app->Fname }}
        </td>
        <td class="py-5 px-8 text-sm text-gray-500">{{ $app->program }}</td>
        <td class="py-5 px-8 text-sm text-gray-500">
            {{ $app->subject }}<br>
            <span class="text-xs text-gray-400">{{ $app->subject_code }}</span>
        </td>
        <td class="py-5 px-8">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                Pending Final Approval
            </span>
        </td>
        <td class="py-5 px-8">
            <div class="flex gap-2">
                <a href="/head/final-approve/{{ $app->id }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-bold text-xs transition-all">
                   Approve
                </a>
                <a href="/head/reject/{{ $app->id }}"
                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-bold text-xs transition-all">
                   Reject
                </a>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</div>

{{-- Document Modal --}}
<div id="doc-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 class="text-lg font-black text-gray-900">Verification Documents</h3>
            <button onclick="closeModal()" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="modal-docs" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4"></div>
        <div class="p-6 border-t border-gray-100 flex gap-3 justify-end">
            <button onclick="approveRequest()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all">Approve</button>
            <button onclick="rejectRequest()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all">Reject</button>
        </div>
    </div>
</div>

    {{-- FINAL APPROVAL TAB --}}
    <div id="final-approval-view" class="tab-content hidden">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800">Final Approval</h2>
        </div>
        @if($totalFinal == 0)
            <div class="p-12 bg-white rounded-2xl border border-dashed border-gray-200 text-center">
                <p class="text-gray-500 font-medium">No final approvals pending at the moment.</p>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Date</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Student</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Course</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Status</th>
<th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($finalApplications as $app)
<tr class="hover:bg-gray-50 transition-colors">
    <td class="py-5 px-8 text-sm text-gray-500">
        {{ \Carbon\Carbon::parse($app->date_submitted)->format('M d, Y') }}
    </td>
    <td class="py-5 px-8 text-sm font-bold text-gray-900">
        {{ $app->Lname }}, {{ $app->Fname }}
    </td>
    <td class="py-5 px-8 text-sm text-gray-500">{{ $app->program }}</td>
    <td class="py-5 px-8 text-sm text-gray-500">
        {{ $app->subject }}
        <span class="block text-xs text-gray-400">{{ $app->subject_code }}</span>
    </td>
    <td class="py-5 px-8">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
            Pending Final
        </span>
    </td>
    <td class="py-5 px-8">
        <div class="flex gap-2">
            <button onclick="openFinalModal(
                '{{ $app->id }}',
                '{{ $app->Fname }} {{ $app->Lname }}',
                '{{ $app->subject }}',
                '{{ $app->or_number }}',
                '{{ $app->amount_paid }}',
                '{{ $app->receipt_path }}',
                '{{ $app->parent_id_front }}',
                '{{ $app->parent_id_back }}',
                '{{ $app->parent_signature }}',
                '{{ $app->parent_selfie }}',
                '{{ $app->medical_certificate }}',
                '{{ $app->death_certificate }}',
                '{{ $app->supporting_document }}'
            )" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl font-bold text-xs transition-all">
                View Docs
            </button>
        </div>
    </td>
</tr>
@endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- DEPARTMENT LISTS TAB --}}
    <div id="department-lists-view" class="tab-content hidden">
        <div id="term-selection-view">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-800">Select Exam Period</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach(['Prelim', 'Midterm', 'Prefinal', 'Final'] as $period)
                <button onclick="showDetails('{{ $period }}')"
                        class="text-left group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-yellow-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 group-hover:text-yellow-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">{{ $period }}</h3>
                    <p class="text-sm text-gray-500 mt-1">View completed applications</p>
                </button>
                @endforeach
            </div>
        </div>

        <div id="details-view" class="hidden">
            <div class="flex items-center gap-6 mb-6">
                <button onclick="showTerms()" class="flex flex-col items-center justify-center w-16 h-14 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors bg-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    <span class="text-[10px] font-bold text-gray-900 mt-1 uppercase">Back</span>
                </button>
                <div>
                    <h2 class="text-3xl font-black text-gray-900" id="selected-term-title">Prelim</h2>
                    <p class="text-sm text-gray-500 mt-1">Completed special exam applications</p>
                </div>
                <div class="ml-auto">
                    <button onclick="exportExcel()" class="bg-[#2ecc71] hover:bg-[#27ae60] text-white px-5 py-3 rounded-xl font-bold text-sm flex items-center gap-2 transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export to Excel
                    </button>
                </div>
            </div>

            {{-- Sub tabs --}}
            <div class="flex border-b border-gray-200 mb-8 space-x-12">
                <button onclick="switchSubTab(this, 'paid-table')" class="sub-tab-btn active-sub-tab border-[#F1C40F] border-b-4 py-4 text-[13px] font-black text-gray-900 tracking-wide uppercase">
                    Paid Special Exam
                </button>
                <button onclick="switchSubTab(this, 'summary-table')" class="sub-tab-btn border-transparent border-b-4 py-4 text-[13px] font-bold text-gray-400 hover:text-gray-600 transition-all tracking-wide uppercase">
                    Summary
                </button>
                <button onclick="switchSubTab(this, 'waived-table')" class="sub-tab-btn border-transparent border-b-4 py-4 text-[13px] font-bold text-gray-400 hover:text-gray-600 transition-all tracking-wide uppercase">
                    Waived Fee
                </button>
            </div>

            {{-- Paid Table --}}
            <div id="paid-table" class="sub-content bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Date Applied</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Student Name</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Section</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject Code</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Program</th>
                        </tr>
                    </thead>
                    <tbody id="paid-tbody" class="divide-y divide-gray-100">
                        <tr><td colspan="6" class="py-10 text-center text-gray-400 text-sm">Loading...</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- Summary Table --}}
            <div id="summary-table" class="sub-content hidden bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject Code</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase text-right">Count</th>
                        </tr>
                    </thead>
                    <tbody id="summary-tbody" class="divide-y divide-gray-100">
                        <tr><td colspan="3" class="py-10 text-center text-gray-400 text-sm">Loading...</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- Waived Table --}}
            <div id="waived-table" class="sub-content hidden bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Date</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Student Name</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Section</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject</th>
                            <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Reason</th>
                        </tr>
                    </thead>
                    <tbody id="waived-tbody" class="divide-y divide-gray-100">
                        <tr><td colspan="5" class="py-10 text-center text-gray-400 text-sm">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- FINAL APPROVAL DOCUMENT MODAL --}}
<div id="final-modal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <div>
                <h3 class="text-lg font-black text-gray-900" id="final-modal-name">Student Name</h3>
                <p class="text-sm text-gray-400" id="final-modal-subject">Subject</p>
            </div>
            <button onclick="closeFinalModal()" class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Payment Info --}}
        <div class="px-6 pt-6">
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">Payment Information</h4>
            <div class="grid grid-cols-2 gap-4 bg-green-50 rounded-2xl p-4 border border-green-100">
                <div>
                    <p class="text-xs text-gray-500">OR Number</p>
                    <p class="font-bold text-gray-900" id="final-or-number">—</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Amount Paid</p>
                    <p class="font-bold text-green-600" id="final-amount">—</p>
                </div>
            </div>
            {{-- Receipt --}}
            <div class="mt-3" id="final-receipt-container">
                <p class="text-xs text-gray-500 mb-1">Official Receipt</p>
                <img id="final-receipt-img" src="" alt="Receipt"
                    class="w-full max-h-48 object-contain rounded-xl border border-gray-200 bg-gray-50">
            </div>
        </div>

        {{-- Documents --}}
        <div class="p-6">
            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3">Verification Documents</h4>
            <div id="final-modal-docs" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
        </div>

        {{-- Actions --}}
        <div class="p-6 border-t border-gray-100 flex gap-3 justify-end">
            <button onclick="closeFinalModal()" class="px-6 py-2.5 rounded-xl font-bold text-sm border border-gray-200 hover:bg-gray-50 transition-all">Cancel</button>
            <button id="final-reject-btn" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all">Reject</button>
            <button id="final-approve-btn" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all">Approve & Schedule</button>
        </div>
    </div>
</div>

</div>

<script>
// Tab switching
function switchTab(btn, viewId) {
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-bold');
        b.classList.add('border-transparent', 'text-gray-500', 'font-medium');
    });
    btn.classList.add('active-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-bold');
    btn.classList.remove('border-transparent', 'text-gray-500', 'font-medium');

    document.querySelectorAll('.tab-content').forEach(v => v.classList.add('hidden'));
    document.getElementById(viewId).classList.remove('hidden');
}

// Sub tab switching
function switchSubTab(btn, tableId) {
    document.querySelectorAll('.sub-tab-btn').forEach(b => {
        b.classList.remove('active-sub-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-black');
        b.classList.add('border-transparent', 'text-gray-400', 'font-bold');
    });
    btn.classList.add('active-sub-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-black');
    btn.classList.remove('border-transparent', 'text-gray-400', 'font-bold');

    document.querySelectorAll('.sub-content').forEach(t => t.classList.add('hidden'));
    document.getElementById(tableId).classList.remove('hidden');
}

let currentTerm = '';

function showDetails(term) {
    currentTerm = term;
    document.getElementById('term-selection-view').classList.add('hidden');
    document.getElementById('details-view').classList.remove('hidden');
    document.getElementById('selected-term-title').innerText = term;
    loadTableData(term);
}

function showTerms() {
    document.getElementById('details-view').classList.add('hidden');
    document.getElementById('term-selection-view').classList.remove('hidden');
}

function loadTableData(term) {
    fetch(`/head/department-data?exam_type=${encodeURIComponent(term)}`)
        .then(r => r.json())
        .then(data => {
            // Paid table
            const paidTbody = document.getElementById('paid-tbody');
            const paid = data.paid;
            if (paid.length === 0) {
                paidTbody.innerHTML = '<tr><td colspan="6" class="py-10 text-center text-gray-400 text-sm">No paid records found.</td></tr>';
            } else {
                paidTbody.innerHTML = paid.map(r => `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500">${r.date_submitted}</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900">${r.student_name}</td>
                        <td class="py-5 px-8 text-sm text-gray-600">${r.section}</td>
                        <td class="py-5 px-8 text-sm text-gray-600">${r.subject}</td>
                        <td class="py-5 px-8 text-sm text-gray-500 uppercase">${r.subject_code}</td>
                        <td class="py-5 px-8 text-sm font-bold text-gray-600">${r.program}</td>
                    </tr>
                `).join('');
            }

            // Summary table
            const summaryTbody = document.getElementById('summary-tbody');
            const summary = data.summary;
            if (summary.length === 0) {
                summaryTbody.innerHTML = '<tr><td colspan="3" class="py-10 text-center text-gray-400 text-sm">No summary data found.</td></tr>';
            } else {
                summaryTbody.innerHTML = summary.map(r => `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-8 text-sm font-bold text-gray-500 uppercase">${r.subject_code}</td>
                        <td class="py-5 px-8 text-sm text-gray-900">${r.subject}</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900 text-right">${r.count}</td>
                    </tr>
                `).join('');
            }

            // Waived table
            const waivedTbody = document.getElementById('waived-tbody');
            const waived = data.waived;
            if (waived.length === 0) {
                waivedTbody.innerHTML = '<tr><td colspan="5" class="py-10 text-center text-gray-400 text-sm">No waived records found.</td></tr>';
            } else {
                waivedTbody.innerHTML = waived.map(r => `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500">${r.date_submitted}</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900">${r.student_name}</td>
                        <td class="py-5 px-8 text-sm text-gray-600">${r.section}</td>
                        <td class="py-5 px-8 text-sm text-gray-600">${r.subject}</td>
                        <td class="py-5 px-8 text-sm text-gray-500 italic">${r.reason}</td>
                    </tr>
                `).join('');
            }
        });
}

function exportExcel() {
    window.location.href = `/head/export-excel?exam_type=${encodeURIComponent(currentTerm)}`;
}

// Course requests
let allRequests = @json($requests ?? []);
let currentRequestId = null;

function showCourseRequests(program) {
    document.getElementById('course-list-view').classList.add('hidden');
    document.getElementById('course-requests-view').classList.remove('hidden');
    document.getElementById('course-title').innerText = program;

    const filtered = allRequests.filter(r => r.program === program);
    const tbody = document.getElementById('requests-tbody');

    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" class="py-10 text-center text-gray-400 text-sm">No pending requests for this course.</td></tr>';
        return;
    }

    tbody.innerHTML = filtered.map(r => `
        <tr class="hover:bg-gray-50 transition-colors">
            <td class="py-4 px-6 text-sm font-bold text-gray-900">${r.Lname}, ${r.Fname}</td>
            <td class="py-4 px-6 text-sm text-gray-500">${r.student_number}</td>
            <td class="py-4 px-6 text-sm text-gray-700">${r.subject}<br><span class="text-xs text-gray-400">${r.subject_code ?? ''}</span></td>
            <td class="py-4 px-6 text-sm text-gray-600">${r.section}</td>
            <td class="py-4 px-6 text-sm text-gray-600">${r.exam_type ?? '-'}</td>
            <td class="py-4 px-6 text-sm text-gray-600">${r.term}</td>
            <td class="py-4 px-6 text-sm text-gray-500 italic">${r.reason}</td>
            <td class="py-4 px-6 text-sm text-gray-500">${r.date_submitted}</td>
            <td class="py-4 px-6">
                <button onclick="viewDocs(${r.id})" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                    View Docs
                </button>
            </td>
            <td class="py-4 px-6">
                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full">Pending</span>
            </td>
        </tr>
    `).join('');
}

function backToCourses() {
    document.getElementById('course-requests-view').classList.add('hidden');
    document.getElementById('course-list-view').classList.remove('hidden');
}

function viewDocs(requestId) {
    const r = allRequests.find(x => x.id === requestId);
    if (!r) return;
    currentRequestId = requestId;

    const docs = [
        { label: 'Parent ID (Front)', file: r.parent_id_front },
        { label: 'Parent ID (Back)', file: r.parent_id_back },
        { label: 'Parent Selfie', file: r.parent_selfie },
        { label: 'Parent Signature', file: r.parent_signature },
        { label: 'Medical Certificate', file: r.medical_certificate },
        { label: 'Death Certificate', file: r.death_certificate },
        { label: 'Supporting Document', file: r.supporting_document },
    ].filter(d => d.file);

    const container = document.getElementById('modal-docs');
    if (docs.length === 0) {
        container.innerHTML = '<p class="text-gray-400 text-sm col-span-2 text-center py-8">No documents uploaded.</p>';
    } else {
        container.innerHTML = docs.map(d => `
            <div class="border border-gray-100 rounded-2xl p-4">
                <p class="text-xs font-bold text-gray-500 uppercase mb-3">${d.label}</p>
                <img src="/storage/${d.file}" alt="${d.label}"
                     class="w-full rounded-xl object-cover max-h-48 bg-gray-50"
                     onerror="this.outerHTML='<div class=\'flex items-center justify-center h-32 bg-gray-50 rounded-xl\'><a href=\'/storage/${d.file}\' target=\'_blank\' class=\'text-blue-500 text-sm font-bold underline\'>View File</a></div>'">
            </div>
        `).join('');
    }

    document.getElementById('doc-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('doc-modal').classList.add('hidden');
    currentRequestId = null;
}

function approveRequest() {
    alert('Approve functionality coming soon! Request ID: ' + currentRequestId);
}

function rejectRequest() {
    alert('Reject functionality coming soon! Request ID: ' + currentRequestId);
}
function openFinalModal(id, name, subject, orNumber, amount, receiptPath, idFront, idBack, signature, selfie, medical, death, supporting) {
    document.getElementById('final-modal-name').textContent = name;
    document.getElementById('final-modal-subject').textContent = subject;
    document.getElementById('final-or-number').textContent = orNumber || '—';
    document.getElementById('final-amount').textContent = amount ? '₱' + amount : '—';

    // Receipt
    const receiptContainer = document.getElementById('final-receipt-container');
    const receiptImg = document.getElementById('final-receipt-img');
    if (receiptPath) {
        receiptImg.src = '/storage/' + receiptPath;
        receiptContainer.classList.remove('hidden');
    } else {
        receiptContainer.classList.add('hidden');
    }

    // Documents
    const docs = [
        { label: 'Parent ID Front',  path: idFront },
        { label: 'Parent ID Back',   path: idBack },
        { label: 'Parent Signature', path: signature },
        { label: 'Parent Selfie',    path: selfie },
        { label: 'Medical Certificate', path: medical },
        { label: 'Death Certificate',   path: death },
        { label: 'Supporting Document', path: supporting },
    ];

    const container = document.getElementById('final-modal-docs');
    container.innerHTML = docs
        .filter(d => d.path)
        .map(d => `
            <div class="rounded-xl border border-gray-100 overflow-hidden">
                <p class="text-xs font-bold text-gray-500 px-3 py-2 bg-gray-50">${d.label}</p>
                <img src="/storage/${d.path}" alt="${d.label}"
                    class="w-full max-h-48 object-contain bg-white p-2"
                    onerror="this.src=''; this.parentElement.innerHTML += '<p class=\'text-xs text-red-400 p-2\'>File not found</p>'">
            </div>
        `).join('');

    // Approve/Reject buttons
    document.getElementById('final-approve-btn').onclick = () => window.location.href = '/head/final-approve/' + id;
    document.getElementById('final-reject-btn').onclick  = () => window.location.href = '/head/reject/' + id;

    document.getElementById('final-modal').classList.remove('hidden');
}

function closeFinalModal() {
    document.getElementById('final-modal').classList.add('hidden');
}
</script>

</x-layouts.app>