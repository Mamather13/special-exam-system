<x-layouts.app>
<div class="max-w-7xl mx-auto p-8 font-sans">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">Pending Student Applications</h1>
        <p class="text-gray-500 mt-2 font-medium">Review and approve special exam requests from your students</p>
    </div>

    {{-- Subject List View --}}
    <div id="subject-list-view">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800">Your Subjects</h2>
            <p class="text-sm text-gray-500 mt-1">Select a subject to review pending requests</p>
        </div>

        @if($subjects->isEmpty())
            <div class="p-12 bg-white rounded-2xl border border-dashed border-gray-200 text-center">
                <p class="text-gray-500 font-medium">No pending requests at the moment.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($subjects as $subject)
                    <div onclick="showSubjectRequests('{{ addslashes($subject->subject) }}')"
                         class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300 cursor-pointer group">
                        <div class="relative inline-flex items-center justify-center w-14 h-14 bg-[#FFF9D6] rounded-xl mb-4 group-hover:bg-[#FFF4B3] transition-colors">
                            <svg class="w-7 h-7 text-[#F1C40F]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                            </svg>
                            @if($subject->total > 0)
                                <span class="absolute -top-2 -right-2 bg-[#EF4444] text-white text-[11px] font-bold w-5 h-5 flex items-center justify-center rounded-full border-[2px] border-white">
                                    {{ $subject->total }}
                                </span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ $subject->subject }}</h3>
                        <p class="text-xs text-gray-400 font-medium uppercase mb-1">{{ $subject->subject_code ?? '' }}</p>
                        @if($subject->total > 0)
                            <p class="text-sm font-medium text-[#EF4444] mt-1">{{ $subject->total }} pending approval{{ $subject->total > 1 ? 's' : '' }}</p>
                        @else
                            <p class="text-sm font-medium text-gray-400 mt-1">No pending requests</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Subject Requests Detail View --}}
    <div id="subject-requests-view" class="hidden">
        <div class="flex items-center gap-4 mb-6">
            <button onclick="backToSubjects()" class="flex flex-col items-center justify-center w-16 h-14 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span class="text-[10px] font-bold text-gray-900 mt-1 uppercase">Back</span>
            </button>
            <div>
                <h2 class="text-2xl font-black text-gray-900" id="subject-title"></h2>
                <p class="text-sm text-gray-500 mt-1">Pending special exam requests</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Student</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Student No.</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Section</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Year Level</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Exam Type</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Term</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Reason</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Date</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Documents</th>
                        <th class="py-4 px-6 text-[12px] font-bold text-gray-900 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody id="subject-requests-tbody" class="divide-y divide-gray-100">
                    <tr><td colspan="10" class="py-10 text-center text-gray-400 text-sm">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Document Modal --}}
<div id="doc-modal" class="fixed inset-0 bg-black/60 z-50 hidden items-center justify-center p-4" style="display:none;">
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
            <button onclick="approveRequest()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all">✓ Approve</button>
            <button onclick="rejectRequest()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all">✗ Reject</button>
        </div>
    </div>
</div>

{{-- Success/Error Toast --}}
<div id="toast" class="fixed bottom-6 right-6 z-50 hidden px-6 py-3 rounded-2xl text-white font-bold text-sm shadow-lg transition-all"></div>

<script>
    let allRequests = @json($requests);
    let currentRequestId = null;

    function showSubjectRequests(subject) {
        document.getElementById('subject-list-view').classList.add('hidden');
        document.getElementById('subject-requests-view').classList.remove('hidden');
        document.getElementById('subject-title').innerText = subject;

        const filtered = allRequests.filter(r => r.subject === subject);
        const tbody = document.getElementById('subject-requests-tbody');

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" class="py-10 text-center text-gray-400 text-sm">No pending requests for this subject.</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(r => `
            <tr id="row-${r.id}" class="hover:bg-gray-50 transition-colors">
                <td class="py-4 px-6 text-sm font-bold text-gray-900">${r.Lname ? r.Lname + ', ' + r.Fname : r.Fname ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-500">${r.student_number ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-600">${r.section ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-600">${r.year_level ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-600">${r.exam_type ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-600">${r.term ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-500 italic">${r.reason ?? '-'}</td>
                <td class="py-4 px-6 text-sm text-gray-500">${r.date_submitted ?? '-'}</td>
                <td class="py-4 px-6">
                    <button onclick="viewDocs(${r.id})" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all">
                        View Docs
                    </button>
                </td>
                <!-- 🔥 ACTION BUTTONS HERE -->
    <td class="py-4 px-6 space-x-2">
        <button onclick="approveRequest(${r.id})"
            class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded">
            Approve
        </button>

        <button onclick="rejectRequest(${r.id})"
            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
            Reject
        </button>
    </td>
            </tr>
        `).join('');
    }

    function backToSubjects() {
        document.getElementById('subject-requests-view').classList.add('hidden');
        document.getElementById('subject-list-view').classList.remove('hidden');
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
            container.innerHTML = '<p class="text-gray-400 text-sm col-span-2 text-center py-8">No documents uploaded for this request.</p>';
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

        document.getElementById('doc-modal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('doc-modal').style.display = 'none';
        currentRequestId = null;
    }

    function approveRequest(id) {
    window.location.href = `/teacher/approve/${id}`;
}

function rejectRequest(id) {
    if (confirm("Reject this request?")) {
        window.location.href = `/teacher/reject/${id}`;
    }
}

    function showToast(message, color) {
        const toast = document.getElementById('toast');
        toast.innerText = message;
        toast.className = `fixed bottom-6 right-6 z-50 px-6 py-3 rounded-2xl text-white font-bold text-sm shadow-lg bg-${color}-500`;
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
</script>
</x-layouts.app>