<x-layouts.app>
    <main class="mx-auto max-w-[1440px] px-6 py-12">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                    My Special Exam Applications
                </h1>
                <p class="text-gray-500 mt-2 font-medium">
                    Manage and track your special exam requests
                </p>
            </div>
            <button id="openModalBtn" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-black py-3.5 px-7 rounded-xl shadow-sm transition-all flex items-center gap-2 whitespace-nowrap text-sm">
                <span class="text-xl leading-none">+</span> New Registration
            </button>
        </div>

        <div id="emptyState" class="flex flex-col items-center justify-center py-20 border-2 border-dashed border-gray-100 rounded-[2rem] bg-gray-50/30">
            <div class="bg-gray-100 p-4 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <p class="text-gray-500 font-bold text-lg italic">No form submitted</p>
            <p class="text-gray-400 text-sm">Register a new exam to see your status here.</p>
        </div>

        <div id="applicationsGrid" class="hidden grid grid-cols-1 lg:grid-cols-2 gap-8">
            </div>

        <div id="modalOverlay" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-black/40 backdrop-blur-sm transition-opacity duration-300">
            <div id="modalContent" class="bg-white w-full max-w-[1000px] max-h-[95vh] overflow-y-auto rounded-[2rem] shadow-2xl flex flex-col transform transition-all duration-300 scale-95">
                
                <div class="flex items-center justify-between px-10 pt-10 pb-6">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Special Exam Registration</h2>
                    <button id="closeXBtn" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form id="registrationForm" class="px-10 pb-10 grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="space-y-6">
                        <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider">Student Information</h3>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input id="fullName" type="text" placeholder="Enter your name" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Course</label>
                                <input id="course" type="text" placeholder="e.g., BSIT" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Section</label>
                                <input id="section" type="text" placeholder="Enter section" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                            <input id="subject" type="text" placeholder="Enter subject name" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Teacher</label>
                            <input id="teacher" type="text" placeholder="Enter teacher name" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Section</label>
                                <input id="section" type="text" placeholder="Enter section name" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Teacher</label>
                                <input id="teacher" type="text" placeholder="Enter teacher name" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-[15px] font-bold text-gray-800 uppercase tracking-wider">Verification Documents</h3>
                        
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Parent/Guardian Signature</label>
                            <div onclick="document.getElementById('sigUpload').click()" class="border-2 border-dashed border-gray-200 rounded-[1.5rem] bg-gray-50/50 flex flex-col items-center justify-center p-8 hover:bg-gray-100 transition-colors cursor-pointer group">
                                <input type="file" id="sigUpload" class="hidden" accept="image/*">
                                <div id="sigPreviewContainer" class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400 mb-2 group-hover:text-yellow-500 transition-colors"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                    <p class="text-sm font-bold text-gray-900" id="sigFileName">Drag and drop signature</p>
                                    <span class="mt-4 bg-yellow-400 text-gray-900 font-bold py-2 px-5 rounded-lg text-xs">Browse Files</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Parent Face + Government ID</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-[1.5rem] bg-gray-50/50 flex flex-col items-center justify-center p-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400 mb-2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" /></svg>
                                <p class="text-sm font-medium text-gray-400">Capture verification photo</p>
                                <button type="button" class="mt-4 bg-yellow-400 text-gray-900 font-bold py-2.5 px-6 rounded-lg text-sm shadow-sm transition-all active:scale-95">Capture Photo</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="border-t border-gray-100 px-10 py-6 flex items-center justify-end gap-4 bg-gray-50/30 rounded-b-[2rem]">
                    <button id="cancelBtn" class="bg-white border border-gray-200 text-gray-800 font-bold py-3 px-8 rounded-xl transition-all text-sm">Cancel</button>
                    <button id="submitFormBtn" class="bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-xl transition-all text-sm shadow-lg active:scale-95">Submit Application</button>
                </div>
            </div>
        </div>

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

                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white shadow-sm shadow-yellow-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-[11px] font-black text-gray-900 mt-4 text-center leading-tight">Submitted</span>
                </div>

                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black">2</div>
                    <span class="text-[11px] font-black text-gray-300 mt-4 text-center leading-tight">Teacher<br>Accepted</span>
                </div>

                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black">3</div>
                    <span class="text-[11px] font-black text-gray-300 mt-4 text-center leading-tight">PH 1st<br>Approval</span>
                </div>

                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black">4</div>
                    <span class="text-[11px] font-black text-gray-300 mt-4 text-center leading-tight">Payment<br>Confirmed</span>
                </div>

                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black">5</div>
                    <span class="text-[11px] font-black text-gray-300 mt-4 text-center leading-tight">PH Final<br>Approval</span>
                </div>

                <div class="flex flex-col items-center relative z-10 w-20">
                    <div class="w-10 h-10 bg-white border-4 border-gray-100 rounded-full flex items-center justify-center text-gray-300 font-black">6</div>
                    <span class="text-[11px] font-black text-gray-300 mt-4 text-center leading-tight">Scheduled</span>
                </div>
            </div>
        </div>

        <button onclick="closeStatusModal()" class="w-full mt-10 py-4 border border-gray-200 rounded-2xl font-black text-gray-800 hover:bg-gray-50 transition-all tracking-wide">
            Close
        </button>
    </div>
</div>

    </main>
</x-layouts.app>