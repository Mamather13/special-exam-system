<x-layouts.app>
    <div class="max-w-6xl mx-auto p-8 mt-4">
    
    <div class="flex items-center gap-6 mb-8">
        <button  data-url="{{ route('teacher.dashboard') }}" 
     onclick="window.location=this.getAttribute('data-url')" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors bg-white shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back
        </button>
        <h1 class="text-3xl font-black text-gray-800">Mathematics 101</h1>
    </div>

    <div class="bg-white rounded-[1.5rem] shadow-sm border border-gray-100 overflow-hidden px-4 py-2">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="py-5 px-6 text-sm font-bold text-gray-700 border-b border-gray-100">Student Name</th>
                    <th class="py-5 px-6 text-sm font-bold text-gray-700 border-b border-gray-100">Student ID</th>
                    <th class="py-5 px-6 text-sm font-bold text-gray-700 border-b border-gray-100">Section</th>
                    <th class="py-5 px-6 text-sm font-bold text-gray-700 border-b border-gray-100">Date Submitted</th>
                    <th class="py-5 px-6 text-sm font-bold text-gray-700 border-b border-gray-100">Actions</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                
                <tr class="group hover:bg-gray-50/50 transition-colors">
                    <td class="py-5 px-6 text-sm text-gray-600 font-medium border-b border-gray-50">Juan Dela Cruz</td>
                    <td class="py-5 px-6 text-sm text-gray-500 border-b border-gray-50">2023-00001</td>
                    <td class="py-5 px-6 text-sm text-gray-500 border-b border-gray-50">IT-3A</td>
                    <td class="py-5 px-6 text-sm text-gray-500 border-b border-gray-50">2026-03-28</td>
                    <td class="py-5 px-6 border-b border-gray-50">
                        <div class="flex gap-3">
                            <button onclick="acceptApplication(this)" class="bg-[#2ecc71] hover:bg-[#27ae60] text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">Accept</button>
                            <button onclick="openRejectModal(this)" class="bg-[#e74c3c] hover:bg-[#c0392b] text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">Reject</button>
                        </div>
                    </td>
                </tr>

                <tr class="group hover:bg-gray-50/50 transition-colors">
                    <td class="py-5 px-6 text-sm text-gray-600 font-medium border-b border-gray-50">Maria Santos</td>
                    <td class="py-5 px-6 text-sm text-gray-500 border-b border-gray-50">2023-00002</td>
                    <td class="py-5 px-6 text-sm text-gray-500 border-b border-gray-50">IT-2B</td>
                    <td class="py-5 px-6 text-sm text-gray-500 border-b border-gray-50">2026-03-29</td>
                    <td class="py-5 px-6 border-b border-gray-50">
                        <div class="flex gap-3">
                            <button onclick="acceptApplication(this)" class="bg-[#2ecc71] hover:bg-[#27ae60] text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">Accept</button>
                            <button onclick="openRejectModal(this)" class="bg-[#e74c3c] hover:bg-[#c0392b] text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">Reject</button>
                        </div>
                    </td>
                </tr>

                <tr class="group hover:bg-gray-50/50 transition-colors">
                    <td class="py-5 px-6 text-sm text-gray-600 font-medium">Pedro Reyes</td>
                    <td class="py-5 px-6 text-sm text-gray-500">2023-00003</td>
                    <td class="py-5 px-6 text-sm text-gray-500">CS-3A</td>
                    <td class="py-5 px-6 text-sm text-gray-500">2026-03-30</td>
                    <td class="py-5 px-6">
                        <div class="flex gap-3">
                            <button onclick="acceptApplication(this)" class="bg-[#2ecc71] hover:bg-[#27ae60] text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">Accept</button>
                            <button onclick="openRejectModal(this)" class="bg-[#e74c3c] hover:bg-[#c0392b] text-white px-5 py-2 rounded-lg font-bold text-sm transition-colors shadow-sm">Reject</button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<div id="rejectModalOverlay" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center opacity-0 transition-opacity duration-300">
    
    <div id="rejectModalBox" class="bg-white rounded-2xl p-8 w-full max-w-md shadow-xl scale-95 transition-transform duration-300">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Reason for Rejection</h2>
        <p class="text-sm text-gray-600 mb-4">Please provide a reason why this application is being rejected.</p>
        
        <textarea id="rejectReasonInput" rows="4" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#e74c3c] focus:border-[#e74c3c] outline-none transition-all resize-none mb-6 shadow-sm" placeholder="Type reason here..."></textarea>
        
        <div class="flex gap-3">
            <button onclick="closeRejectModal()" class="px-5 py-2.5 border border-gray-200 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-50 transition-colors bg-white">Cancel</button>
            <button onclick="submitRejection()" class="px-5 py-2.5 bg-[#e74c3c] hover:bg-[#c0392b] text-white rounded-lg text-sm font-bold transition-colors shadow-sm">Submit Reject</button>
        </div>
    </div>

</div>
</x-layouts.app>