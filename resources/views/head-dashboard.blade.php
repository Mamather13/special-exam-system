<x-layouts.app>
    <div class="max-w-7xl mx-auto p-8 font-sans">
        
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                Program Head Dashboard
            </h1>
            <p class="text-gray-500 mt-2 font-medium">
                Manage special exam approvals and student records
            </p>
        </div>

        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs" id="dashboardTabs">
                <button onclick="switchTab(this, 'first-approach-view')" 
                        class="tab-btn active-tab border-[#F1C40F] text-gray-900 border-b-[3px] py-4 px-1 text-sm font-bold flex items-center gap-2 transition-all">
                    First Approach
                    <span class="bg-[#EF4444] text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[20px]">4</span>
                </button>

                <button onclick="switchTab(this, 'final-approval-view')" 
                        class="tab-btn border-transparent text-gray-500 border-b-[3px] py-4 px-1 text-sm font-medium flex items-center gap-2 transition-all">
                    Final Approval
                    <span class="bg-[#EF4444] text-white text-[11px] font-bold px-2 py-0.5 rounded-full min-w-[20px]">3</span>
                </button>

                <button onclick="switchTab(this, 'department-lists-view')" 
                        class="tab-btn border-transparent text-gray-500 border-b-[3px] py-4 px-1 text-sm font-medium transition-all">
                    Department Lists
                </button>
            </nav>
        </div>

        <div id="first-approach-view" class="tab-content">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-800">Select Department</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-card-subject title="Mathematics 101" :count="3" :route="route('teacher.subject')" />
                <x-card-subject title="English 102" :count="2" :route="route('teacher.subject')" />
                <x-card-subject title="Chemistry 101" :count="0" :route="route('teacher.subject')" />
            </div>
        </div>

        <div id="final-approval-view" class="tab-content hidden">
            <div class="p-12 bg-white rounded-2xl border border-dashed border-gray-200 text-center">
                <div class="text-gray-400 mb-2 text-4xl"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <p class="text-gray-500 font-medium">No final approvals pending at the moment.</p>
            </div>
        </div>

        <div id="department-lists-view" class="tab-content hidden">
    
    <div id="term-selection-view">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-800">Select Academic Term</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <button onclick="showDetails('Prelim')" class="text-left group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#FFF9D6] transition-colors">
                    <i class="fa-solid fa-file text-gray-400 group-hover:text-[#F1C40F]"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Prelim</h3>
                <p class="text-sm text-gray-500">View completed applications for Prelims</p>
            </button>
            
            <button onclick="showDetails('Mid-term')" class="text-left group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#FFF9D6] transition-colors">
                    <i class="fa-solid fa-file-invoice text-gray-400 group-hover:text-[#F1C40F]"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Mid-term</h3>
                <p class="text-sm text-gray-500">View completed applications for Mid-terms</p>
            </button>

            <button onclick="showDetails('Pre-final')" class="text-left group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#FFF9D6] transition-colors">
                    <i class="fa-solid fa-file-signature text-gray-400 group-hover:text-[#F1C40F]"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Pre-final</h3>
                <p class="text-sm text-gray-500">View completed applications for Pre-finals</p>
            </button>

            <button onclick="showDetails('Finals')" class="text-left group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#FFF9D6] transition-colors">
                    <i class="fa-solid fa-graduation-cap text-gray-400 group-hover:text-[#F1C40F]"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Finals</h3>
                <p class="text-sm text-gray-500">View completed applications for Finals</p>
            </button>
        </div>
    </div>

    <div id="details-view" class="hidden">
        <div class="flex items-center gap-6 mb-6">
            <button onclick="showTerms()" class="flex flex-col items-center justify-center w-21 h-14 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors bg-white shadow-sm">
                <i class="fa-solid fa-arrow-left text-gray-700"></i>
                <span class="text-[10px] font-bold text-gray-900 mt-1 uppercase">Back</span>
            </button>
            <div>
                <h2 class="text-3xl font-black text-gray-900" id="selected-term-title">Prelim - Completed Applications</h2>
                <div class="mt-2 bg-[#FFF1F1] border border-[#FEE2E2] px-3 py-1.5 rounded-lg flex items-center gap-2 w-fit">
                    <i class="fa-solid fa-circle-exclamation text-[#EF4444] text-xs"></i>
                    <p class="text-[11px] text-[#B91C1C] font-medium">Deadline of submission for the list of students who will take the special exam: <span class="font-bold underline">March 15, 2026</span></p>
                </div>
            </div>
            <div class="ml-auto">
                <button class="bg-[#2ecc71] hover:bg-[#27ae60] text-white px-5 py-3 rounded-xl font-bold text-sm flex items-center gap-2 transition-all shadow-sm">
                    <i class="fa-solid fa-file-excel"></i> Export All to Excel
                </button>
            </div>
        </div>

        <div class="flex border-b border-gray-200 mb-8 space-x-12">
            <button onclick="switchSubTab(this, 'paid-table')" class="sub-tab-btn active-sub-tab border-[#F1C40F] border-b-4 py-4 text-[13px] font-black text-gray-900 tracking-wide uppercase">
                Paid Special Exam
            </button>
            <button onclick="switchSubTab(this, 'summary-table')" class="sub-tab-btn border-transparent border-b-4 py-4 text-[13px] font-bold text-gray-400 hover:text-gray-600 transition-all tracking-wide uppercase">
                Summary
            </button>
            <button onclick="switchSubTab(this, 'waived-table')" class="sub-tab-btn border-transparent border-b-4 py-4 text-[13px] font-bold text-gray-400 hover:text-gray-600 transition-all tracking-wide uppercase">
                Waived Fee (Valid Reason)
            </button>
        </div>

        <div id="paid-table" class="sub-content bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Date Applied</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Student Name</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Section</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject / Course Title</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject Code</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Program / Strand</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500">20/02/2026</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900">Gole Cruz, Holly Klein D.</td>
                        <td class="py-5 px-8 text-sm text-gray-600">BSHM 2-203</td>
                        <td class="py-5 px-8 text-sm text-gray-600">Science, Technology, and Society</td>
                        <td class="py-5 px-8 text-sm text-gray-500 uppercase">GEDC1013</td>
                        <td class="py-5 px-8 text-sm text-gray-600 font-bold">BSIT</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500">24/02/2026</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900">Sumayao, Clarenz Josef</td>
                        <td class="py-5 px-8 text-sm text-gray-600">BSIT 2-202</td>
                        <td class="py-5 px-8 text-sm text-gray-600">Systems Integration and Architecture</td>
                        <td class="py-5 px-8 text-sm text-gray-500 uppercase">INTE1021</td>
                        <td class="py-5 px-8 text-sm text-gray-600 font-bold">BSIT</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="summary-table" class="sub-content hidden bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject Code</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Subject / Course</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase text-right">Count</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500 font-bold uppercase">ACCT1002</td>
                        <td class="py-5 px-8 text-sm text-gray-900">Conceptual Framework and Accounting Standards</td>
                        <td class="py-5 px-8 text-sm text-gray-900 font-black text-right">1</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500 font-bold uppercase">CBMC1003</td>
                        <td class="py-5 px-8 text-sm text-gray-900">Strategic Management</td>
                        <td class="py-5 px-8 text-sm text-gray-900 font-black text-right">3</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500 font-bold uppercase">CTHC1006</td>
                        <td class="py-5 px-8 text-sm text-gray-900">Philippine Culture and Tourism Geography</td>
                        <td class="py-5 px-8 text-sm text-gray-900 font-black text-right">10</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="waived-table" class="sub-content hidden bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Date of Application</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Student Name</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Section</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Course/Subject Title</th>
                        <th class="py-5 px-8 text-[13px] font-bold text-gray-900 uppercase">Reason / Message</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500">20/02/2026</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900">rjames delossantos</td>
                        <td class="py-5 px-8 text-sm text-gray-600">BSHM 2-204</td>
                        <td class="py-5 px-8 text-sm text-gray-600">Science, Technology, and Society</td>
                        <td class="py-5 px-8 text-[12px] text-gray-500 italic">Diagnosed with Acute Tonsillopharyngitis (Medical Certificate)</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-5 px-8 text-sm text-gray-500">24/02/2026</td>
                        <td class="py-5 px-8 text-sm font-black text-gray-900">richie lumits</td>
                        <td class="py-5 px-8 text-sm text-gray-600">BSTM 3-203</td>
                        <td class="py-5 px-8 text-sm text-gray-600">Strategic Management</td>
                        <td class="py-5 px-8 text-[12px] text-gray-500 italic">Death of Grandfather (Death Certificate)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-layouts.app>