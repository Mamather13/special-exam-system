<x-layouts.app>

<div>
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Special Exam Applications</h1>
            <p class="text-gray-500 mt-1">Manage and track your special exam requests</p>
        </div>
        <button id="openModalBtn" class="bg-[#fedc00] hover:bg-yellow-400 text-gray-900 font-black py-3.5 px-7 rounded-xl shadow-sm transition-all flex items-center gap-2 whitespace-nowrap text-sm">
            <span class="text-xl leading-none">+</span> New Registration
        </button>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Empty State --}}
    <div id="emptyState" class="{{ $requests->isEmpty() ? '' : 'hidden' }} flex flex-col items-center justify-center py-24 border-2 border-dashed border-gray-200 rounded-[2.5rem] bg-gray-50/30">
        <div class="bg-gray-100 p-5 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
        </div>
        <p class="text-gray-500 font-bold text-xl italic mb-1">No form submitted</p>
        <p class="text-gray-400 text-base">Register a new exam to see your status here.</p>
    </div>

    {{-- Applications Grid --}}
    <div id="applicationsGrid" class="{{ $requests->isEmpty() ? 'hidden' : '' }} grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($requests as $row)
        <div class="bg-white p-8 rounded-[1.5rem] shadow-sm border border-gray-100 flex items-center justify-between group cursor-pointer hover:shadow-md transition-all"
             onclick="openStatusModal('{{ $row->subject }}', '{{ $row->subject_code }}', '{{ $row->teacher_name }}', '{{ $row->section }}')">
            <div class="space-y-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">{{ $row->subject }}</h2>
                    <p class="text-gray-400 text-sm mt-1 font-medium">{{ $row->subject_code }} • Prof. {{ $row->teacher_name }} • {{ $row->section }}</p>
                </div>
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-[11px] font-bold border border-blue-100 uppercase tracking-wide">
                    {{ $row->status }}
                </div>
            </div>
            <div class="text-gray-300 group-hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- REGISTRATION MODAL --}}
<div id="modalOverlay" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/40 backdrop-blur-sm transition-opacity duration-300">
    <div id="modalContent" class="bg-white w-full max-w-[1000px] max-h-[95vh] overflow-y-auto rounded-[2rem] shadow-2xl flex flex-col transform transition-all duration-300 scale-95">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-10 pt-10 pb-6 border-b border-gray-100">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Special Exam Registration</h2>
            <button id="closeXBtn" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Registration Form --}}
        <form id="registrationForm" method="POST" action="/student/submit-request" enctype="multipart/form-data" class="px-10 py-8">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                {{-- LEFT: Student Information --}}
                <div class="space-y-5">
                    <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider">Student Information</h3>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Student Number</label>
                        <input type="text" name="student_number" required placeholder="e.g. 02000******"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="Lname" required placeholder="Dela Cruz"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="Fname" required placeholder="Juan"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" name="Mname" placeholder="Santos"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
        
        <div class="space-y-1">
        <label class="block text-sm font-medium text-gray-700">Program</label>
        <select name="program" id="program" required
         class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
            <option value="">Loading programs...</option>
        </select>
        </div>

    <div class="space-y-1">
        <label class="block text-sm font-medium text-gray-700">Year Level</label>
        <select name="year_level" id="year_level" required
            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
            <option value="">Select Year Level</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-2 gap-3">
    <div class="space-y-1">
        <label class="block text-sm font-medium text-gray-700">Section</label>
        <select name="section" id="section" required
            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
            <option value="">Select Program & Year first</option>
        </select>
    </div>
    <div class="space-y-1">
        <label class="block text-sm font-medium text-gray-700">Term</label>
        <select name="term" id="term" required
            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
            <option value="">Select Term</option>
            <option value="1st Term">1st Term</option>
            <option value="2nd Term">2nd Term</option>
        </select>
    </div>
</div>

<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700">Subject</label>
    <select name="subject" id="subject" required
        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
        <option value="">Select Program, Year & Term first</option>
    </select>
    <input type="hidden" name="subject_code" id="subject_code">
</div>

            

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">School Year</label>
                            <input type="text" name="school_year" placeholder="2025-2026"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact_number" required placeholder="09XXXXXXXXX"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Teacher Name</label>
                            <input type="text" name="teacher_name" placeholder="Enter teacher name"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Reason</label>
                        <select name="reason_type" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                            <option value="">Select reason</option>
                            <option value="medical">Medical</option>
                            <option value="death">Death of Relative</option>
                            <option value="personal">Personal</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>

                {{-- RIGHT: Documents --}}
                <div class="space-y-5">
                    <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider">Parent Consent & Documents</h3>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Parent ID (Front)</label>
                        <input type="file" name="parent_id_front" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Parent ID (Back)</label>
                        <input type="file" name="parent_id_back" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Parent Selfie with ID</label>
                        <input type="file" name="parent_selfie" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Parent Signature <span class="text-red-500">*</span></label>
                        <input type="file" name="parent_signature" accept=".jpg,.jpeg,.png,.pdf" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                        <small class="text-gray-400">Parent signs on paper, take photo, then upload.</small>
                    </div>

                    <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider pt-2">Supporting Documents</h3>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Medical Certificate</label>
                        <input type="file" name="medical_certificate" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                        <small class="text-gray-400">Upload if reason is medical.</small>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Death Certificate</label>
                        <input type="file" name="death_certificate" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                        <small class="text-gray-400">Upload if reason is death of relative.</small>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Other Document</label>
                        <input type="file" name="supporting_document" accept=".jpg,.jpeg,.png,.pdf"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                    </div>
                </div>

            </div>

            {{-- Form Footer --}}
            <div class="border-t border-gray-100 mt-8 pt-6 flex items-center justify-end gap-4">
                <button type="button" id="cancelBtn" class="bg-white border border-gray-200 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all text-sm">Cancel</button>
                <button type="submit" class="bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl transition-all text-sm shadow-lg active:scale-95">Submit Application</button>
            </div>
        </form>

    </div>
</div>

{{-- STATUS MODAL --}}
<div id="statusModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="statusContent" class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl flex flex-col transform transition-all duration-300 scale-95 opacity-0 relative p-10">
        <button onclick="closeStatusModal()" class="absolute top-8 right-8 p-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="mb-10">
            <h2 id="statusTitle" class="text-4xl font-black text-gray-900 tracking-tight mb-2">Subject Name</h2>
            <p id="statusSubtitle" class="text-gray-400 font-medium tracking-wide">CODE • PROFESSOR • SECTION</p>
        </div>
        <div class="bg-[#FFFDF5] rounded-[2rem] p-10 border border-yellow-50/50">
            <h4 class="font-black text-gray-800 mb-10 text-lg">Application Progress</h4>
            <div class="relative flex items-center justify-between w-full px-4">
                <div class="absolute top-5 left-10 right-10 h-1 bg-gray-200 -z-0"></div>
                <div id="activeProgressLine" class="absolute top-5 left-10 h-1 bg-yellow-400 -z-0" style="width: 0%;"></div>
                @foreach(['Submitted','Teacher Accepted','PH 1st Approval','Payment Confirmed','PH Final Approval','Scheduled'] as $i => $step)
                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 {{ $i === 0 ? 'bg-yellow-400' : 'bg-white border-4 border-gray-100' }} rounded-full flex items-center justify-center {{ $i === 0 ? 'text-white' : 'text-gray-300 font-black' }} shadow-sm">
                        @if($i === 0)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    <span class="text-[11px] font-black {{ $i === 0 ? 'text-gray-900' : 'text-gray-300' }} mt-4 text-center leading-tight">{{ $step }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <button onclick="closeStatusModal()" class="w-full mt-10 py-4 border border-gray-200 rounded-2xl font-black text-gray-800 hover:bg-gray-50 transition-all tracking-wide">Close</button>
    </div>
</div>

{{-- Dynamic Subject Load Script --}}
<script>
// Load programs on page load
fetch('/get-programs')
    .then(r => r.json())
    .then(data => {
        const programSelect = document.getElementById('program');
        programSelect.innerHTML = '<option value="">Select Program</option>';
        data.forEach(program => {
            let option = document.createElement('option');
            option.value = program;
            option.textContent = program;
            programSelect.appendChild(option);
        });
    });

function refreshSections() {
    const program   = document.getElementById('program').value;
    const yearLevel = document.getElementById('year_level').value;

    const sectionSelect = document.getElementById('section');
    sectionSelect.innerHTML = '<option value="">Select Program & Year first</option>';

    if (!program || !yearLevel) return;

    fetch(`/get-sections?program=${encodeURIComponent(program)}&year_level=${encodeURIComponent(yearLevel)}`)
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) {
                sectionSelect.innerHTML = '<option value="">No sections found</option>';
                return;
            }
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
            data.forEach(section => {
                let option = document.createElement('option');
                option.value = section;
                option.textContent = section;
                sectionSelect.appendChild(option);
            });
        });
}

function refreshSubjects() {
    const program   = document.getElementById('program').value;
    const yearLevel = document.getElementById('year_level').value;
    const section   = document.getElementById('section').value;

    const subjectSelect = document.getElementById('subject');
    subjectSelect.innerHTML = '<option value="">Select Section first</option>';
    document.getElementById('subject_code').value = '';

    if (!program || !yearLevel || !section) return;

    fetch(`/get-subjects?program=${encodeURIComponent(program)}&year_level=${encodeURIComponent(yearLevel)}&section=${encodeURIComponent(section)}`)
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) {
                subjectSelect.innerHTML = '<option value="">No subjects found</option>';
                return;
            }
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';
            data.forEach(row => {
                let option = document.createElement('option');
                option.value = row.subject_title;
                option.textContent = row.subject_title;
                option.dataset.code = row.subject_code;
                subjectSelect.appendChild(option);
            });
        });
}

document.getElementById('program').addEventListener('change', () => {
    refreshSections();
    refreshSubjects();
});

document.getElementById('year_level').addEventListener('change', () => {
    refreshSections();
    refreshSubjects();
});

document.getElementById('section').addEventListener('change', refreshSubjects);

document.getElementById('subject').addEventListener('change', function() {
    const code = this.options[this.selectedIndex]?.getAttribute('data-code') || '';
    document.getElementById('subject_code').value = code;
});
</script>

</x-layouts.app>