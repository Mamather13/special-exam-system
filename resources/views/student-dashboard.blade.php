<x-layouts.app>

<div x-data="{
    step: 1,
    reason: '',
    nextStep() {
        // Basic validation before proceeding
        const required = ['student_number','Lname','Fname','program','year_level','section','term','subject','contact_number'];
        let valid = true;
        required.forEach(name => {
            const el = document.querySelector('[name=' + name + ']');
            if (el && !el.value) { el.classList.add('border-red-400'); valid = false; }
            else if (el) el.classList.remove('border-red-400');
        });
        if (!this.reason) {
            document.querySelector('[name=reason_type]').classList.add('border-red-400');
            valid = false;
        } else {
            document.querySelector('[name=reason_type]').classList.remove('border-red-400');
        }
        if (valid) this.step = 2;
    },
    prevStep() { this.step = 1; }
}">

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

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-medium">
            {{ session('error') }}
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
             onclick="openStatusModal('{{ $row->subject }}', '{{ $row->subject_code }}', '{{ $row->teacher_name }}', '{{ $row->section }}', '{{ $row->status }}', '{{ $row->id }}')">
            <div class="space-y-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">{{ $row->subject }}</h2>
                    <p class="text-gray-400 text-sm mt-1 font-medium">{{ $row->subject_code }} â€¢ Prof. {{ $row->teacher_name }} â€¢ {{ $row->section }}</p>
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

</div>{{-- end x-data --}}

{{-- REGISTRATION MODAL --}}
<div id="modalOverlay" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/40 backdrop-blur-sm transition-opacity duration-300"
     x-data="{
         step: 1,
         reason: '',
         nextStep() {
             const required = ['student_number','Lname','Fname','program','year_level','section','term','subject','contact_number'];
             let valid = true;
             required.forEach(name => {
                 const el = document.querySelector('#registrationForm [name=' + name + ']');
                 if (el && !el.value.trim()) { el.classList.add('border-red-400'); valid = false; }
                 else if (el) el.classList.remove('border-red-400');
             });
             if (!this.reason) {
                 document.querySelector('#registrationForm [name=reason_type]').classList.add('border-red-400');
                 valid = false;
             } else {
                 document.querySelector('#registrationForm [name=reason_type]').classList.remove('border-red-400');
             }
             if (valid) this.step = 2;
         },
         prevStep() { this.step = 1; }
     }">

    <div id="modalContent" class="bg-white w-full max-w-[700px] max-h-[95vh] overflow-y-auto rounded-[2rem] shadow-2xl flex flex-col transform transition-all duration-300 scale-95">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-10 pt-10 pb-6 border-b border-gray-100">
            <div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight">Special Exam Registration</h2>
                {{-- Step indicator --}}
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full"
                        :class="step === 1 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400'">1</span>
                    <span class="text-xs text-gray-400">Student Info</span>
                    <span class="text-gray-300 text-xs">â†’</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full"
                        :class="step === 2 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-400'">2</span>
                    <span class="text-xs text-gray-400">Parent Consent & Documents</span>
                </div>
            </div>
            <button id="closeXBtn" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Registration Form --}}
        <form id="registrationForm" method="POST" action="/student/submit-request" enctype="multipart/form-data" class="px-10 py-8">
            @csrf

            {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• STEP 1: Student Information â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
            <div x-show="step === 1" class="space-y-5">
                <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider">Student Information</h3>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Student Number</label>
                    <input type="text" name="student_number" placeholder="e.g. 02000******"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all">
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="Lname" placeholder="Dela Cruz"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="Fname" placeholder="Juan"
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
                        <select name="program" id="program"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                            <option value="">Loading programs...</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Year Level</label>
                        <select name="year_level" id="year_level"
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
                        <select name="section" id="section"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                            <option value="">Select Program & Year first</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Term</label>
                        <select name="term" id="term"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                            <option value="">Select Term</option>
                            <option value="1st Term">1st Term</option>
                            <option value="2nd Term">2nd Term</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject" id="subject"
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
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="contact_number" placeholder="09XXXXXXXXX"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Teacher Name</label>
                    <input type="text" name="teacher_name" placeholder="Enter teacher name"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Reason <span class="text-red-500">*</span></label>
                    <select name="reason_type" x-model="reason"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:border-yellow-400 transition-all">
                        <option value="">Select reason</option>
                        <option value="medical">Medical</option>
                        <option value="death">Death of Relative</option>
                        <option value="personal">Personal</option>
                        <option value="others">Others</option>
                    </select>
                </div>

                {{-- Next Button --}}
                <div class="pt-2">
                    <button type="button" @click="nextStep"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all text-sm shadow-sm active:scale-95">
                        Next â†’
                    </button>
                </div>
            </div>

            {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• STEP 2: Parent Consent & Documents â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}
            <div x-show="step === 2" class="space-y-5">
                <div class="flex items-center gap-3 mb-2">
                    <button type="button" @click="prevStep"
                        class="text-sm text-gray-500 hover:text-gray-800 flex items-center gap-1 transition-colors">
                        â† Back
                    </button>
                    <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider">Parent Consent & Documents</h3>
                </div>

                {{-- Reason badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-full text-xs font-semibold text-blue-700">
                    Reason:
                    <span x-text="reason === 'medical' ? 'Medical' : reason === 'death' ? 'Death of Relative' : reason === 'personal' ? 'Personal' : 'Others'"></span>
                </div>

                {{-- FACE VERIFICATION COMPONENT --}}
                <livewire:parent-verification />

                {{-- Hidden inputs filled by Livewire after verification --}}
                <input type="hidden" name="face_verified"   id="face_verified_input"   value="0">
                <input type="hidden" name="liveness_passed" id="liveness_passed_input" value="0">
                <input type="hidden" name="match_score"     id="match_score_input"     value="0">

                {{-- Medical Certificate â€” only for medical --}}
                <div x-show="reason === 'medical'" class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">
                        Medical Certificate <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="medical_certificate" accept=".jpg,.jpeg,.png,.pdf"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                    <small class="text-gray-400">Upload your medical certificate.</small>
                </div>

                {{-- Death Certificate â€” only for death of relative --}}
                <div x-show="reason === 'death'" class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">
                        Death Certificate <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="death_certificate" accept=".jpg,.jpeg,.png,.pdf"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                    <small class="text-gray-400">Upload the death certificate of relative.</small>
                </div>

                {{-- Submit --}}
                <div class="border-t border-gray-100 pt-6 flex items-center justify-end gap-4">
                    <button type="button" id="cancelBtn"
                        class="bg-white border border-gray-200 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl transition-all text-sm shadow-lg active:scale-95">
                        Submit Application
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- STATUS MODAL --}}
<div id="statusModal" class="hidden fixed inset-0 z-[110] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="statusContent" class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl flex flex-col transform transition-all duration-300 scale-95 opacity-0 relative p-10">

        {{-- X close button --}}
        <button onclick="closeStatusModal()" class="absolute top-8 right-8 p-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Title --}}
        <div class="mb-10">
            <h2 id="statusTitle" class="text-4xl font-black text-gray-900 tracking-tight mb-2">Subject Name</h2>
            <p id="statusSubtitle" class="text-gray-400 font-medium tracking-wide">CODE â€¢ PROFESSOR â€¢ SECTION</p>
        </div>

        {{-- Progress bar --}}
        <div class="bg-[#FFFDF5] rounded-[2rem] p-10 border border-yellow-50/50">
            <h4 class="font-black text-gray-800 mb-10 text-lg">Application Progress</h4>
            <div class="relative flex items-center justify-between w-full px-4">
                <div class="absolute top-5 left-10 right-10 h-1 bg-gray-200 -z-0"></div>
                <div id="activeProgressLine" class="absolute top-5 left-10 h-1 bg-yellow-400 -z-0 transition-all duration-500" style="width: 0%;"></div>
                @foreach(['Submitted','PH 1st Approval','Teacher','Payment Confirmed','PH Final Approval','Scheduled'] as $i => $stepLabel)
                <div class="flex flex-col items-center relative z-10 w-20">
                    <div id="step-circle-{{ $i }}" class="w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black shadow-sm transition-all duration-300">
                        {{ $i + 1 }}
                    </div>
                    <span id="step-label-{{ $i }}" class="text-[11px] font-black text-gray-300 mt-4 text-center leading-tight">{{ $stepLabel }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Scheduled message --}}
        <div id="scheduledMessage" class="hidden mt-6 p-5 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            <div>
                <p class="text-sm font-black text-blue-800">Application Approved!</p>
                <p class="text-sm text-blue-600 mt-0.5">Your special exam has been approved. Please wait for your exam schedule to be announced by your teacher or program head.</p>
            </div>
        </div>

        {{-- Upload Receipt button --}}
        <form method="POST" action="{{ url('/student/upload-receipt/1') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" name="receipt" required class="mb-2">

    <button type="submit" class="bg-yellow-400 px-4 py-2 rounded-xl font-bold w-full">
        Upload OR
    </button>
</form>
</form>

        {{-- Close button --}}
        <button onclick="closeStatusModal()" class="w-full mt-10 py-4 border border-gray-200 rounded-2xl font-black text-gray-800 hover:bg-gray-50 transition-all tracking-wide">Close</button>

    </div>
</div>

{{-- Scripts --}}
<script>
// Modal open/close
const modalOverlay  = document.getElementById('modalOverlay');
const modalContent  = document.getElementById('modalContent');
const openModalBtn  = document.getElementById('openModalBtn');
const closeXBtn     = document.getElementById('closeXBtn');
const cancelBtn     = document.getElementById('cancelBtn');

function openModal() {
    modalOverlay.classList.remove('hidden');
    setTimeout(() => modalContent.classList.remove('scale-95'), 10);
}
function closeModal() {
    modalContent.classList.add('scale-95');
    setTimeout(() => modalOverlay.classList.add('hidden'), 200);
}
openModalBtn?.addEventListener('click', openModal);
closeXBtn?.addEventListener('click', closeModal);
cancelBtn?.addEventListener('click', closeModal);
modalOverlay?.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });

// Programs loader
document.addEventListener('DOMContentLoaded', function () {
    fetch('/get-programs')
        .then(res => res.json())
        .then(data => {
            let program = document.getElementById('program');
            program.innerHTML = '<option value="">Select Program</option>';
            data.forEach(p => {
                let opt = document.createElement('option');
                opt.value = p; opt.textContent = p;
                program.appendChild(opt);
            });
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
            sectionSelect.innerHTML = data.length
                ? '<option value="">Select Section</option>'
                : '<option value="">No sections found</option>';
            data.forEach(s => {
                let o = document.createElement('option');
                o.value = s; o.textContent = s;
                sectionSelect.appendChild(o);
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
            subjectSelect.innerHTML = data.length
                ? '<option value="">Select Subject</option>'
                : '<option value="">No subjects found</option>';
            data.forEach(row => {
                let o = document.createElement('option');
                o.value = row.subject_title;
                o.textContent = row.subject_title;
                o.dataset.code = row.subject_code;
                subjectSelect.appendChild(o);
            });
        });
}

document.getElementById('program').addEventListener('change', () => { refreshSections(); refreshSubjects(); });
document.getElementById('year_level').addEventListener('change', () => { refreshSections(); refreshSubjects(); });
document.getElementById('section').addEventListener('change', refreshSubjects);
document.getElementById('subject').addEventListener('change', function() {
    document.getElementById('subject_code').value = this.options[this.selectedIndex]?.getAttribute('data-code') || '';
});

// Status modal
function openStatusModal(subject, code, teacher, section, status, id) {
    document.getElementById('statusTitle').textContent    = subject;
    document.getElementById('statusSubtitle').textContent = code + ' â€¢ Prof. ' + teacher + ' â€¢ ' + section;

    // Map status to active step (0-indexed)
    const stepMap = {
        'pending_registrar':    0,
        'pending_program_head': 1,
        'pending_teacher':      2,
        'approved':             3,
        'pending_final':        4,
        'scheduled':            5,
    };
    const activeStep = stepMap[status] ?? 0;

    // Reset all steps to gray
    for (let i = 0; i < 6; i++) {
        const circle = document.getElementById('step-circle-' + i);
        const label  = document.getElementById('step-label-' + i);
        circle.className = 'w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black shadow-sm transition-all duration-300';
        circle.innerHTML = (i + 1);
        label.className  = 'text-[11px] font-black text-gray-300 mt-4 text-center leading-tight';
    }

    // Highlight completed steps (before active)
    for (let i = 0; i < activeStep; i++) {
        const circle = document.getElementById('step-circle-' + i);
        const label  = document.getElementById('step-label-' + i);
        circle.className = 'w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white shadow-sm transition-all duration-300';
        circle.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>';
        label.className  = 'text-[11px] font-black text-gray-900 mt-4 text-center leading-tight';
    }

    // Highlight current active step
    const activeCircle = document.getElementById('step-circle-' + activeStep);
    const activeLabel  = document.getElementById('step-label-' + activeStep);
    activeCircle.className = 'w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white font-black shadow-sm transition-all duration-300';
    activeLabel.className  = 'text-[11px] font-black text-gray-900 mt-4 text-center leading-tight';

    // Animate progress line (each step = 20% of the 5 gaps)
    const linePercent = (activeStep / 5) * 100;
    document.getElementById('activeProgressLine').style.width = linePercent + '%';

    const uploadBtn  = document.getElementById('uploadReceiptBtn');
const uploadLink = document.getElementById('uploadReceiptLink');
console.log("STATUS VALUE:", status);
if (true) {
    uploadLink.href = '/student/applications/' + id + '/upload-receipt';
    uploadBtn.classList.remove('hidden');
    uploadBtn.style.display = 'block';
} else {
    uploadLink.href = '#';
    uploadBtn.classList.add('hidden');
    uploadBtn.style.display = 'none';
}


    // Show/hide scheduled message
    const scheduledMsg = document.getElementById('scheduledMessage');
    if (status === 'scheduled') {
        scheduledMsg.classList.remove('hidden');
    } else {
        scheduledMsg.classList.add('hidden');
    }

    // Open modal
    const modal   = document.getElementById('statusModal');
    const content = document.getElementById('statusContent');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('opacity-100');    modal.classList.remove('opacity-0');
        content.classList.add('opacity-100', 'scale-100'); content.classList.remove('opacity-0', 'scale-95');
    }, 10);
}
function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusContent');
    modal.classList.remove('opacity-100'); modal.classList.add('opacity-0');
    content.classList.remove('opacity-100', 'scale-100'); content.classList.add('opacity-0', 'scale-95');
    setTimeout(() => modal.classList.add('hidden'), 300);
}
</script>

{{-- Face verification result listener --}}
<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('verification-complete', (payload) => {
        const data = Array.isArray(payload) ? payload[0] : payload;
        document.getElementById('face_verified_input').value   = data.faceVerified   ? '1' : '0';
        document.getElementById('liveness_passed_input').value = data.livenessPassed ? '1' : '0';
        document.getElementById('match_score_input').value     = data.matchScore ?? 0;
    });
});
</script>

</x-layouts.app>




