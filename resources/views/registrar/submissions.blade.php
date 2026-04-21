<x-layouts.app>
    <div>

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('registrar.courses', 'tertiary') }}" class="inline-flex items-center text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-md transition-colors">
                &larr; Back
            </a>
            <h1 class="text-3xl font-black text-gray-800">BS Information Technology - Submissions</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse" id="submissionsTable">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                        <th class="p-4 font-bold">Student Name</th>
                        <th class="p-4 font-bold">Student ID</th>
                        <th class="p-4 font-bold">Attachment</th>
                        <th class="p-4 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="row-1" class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-sm font-medium text-gray-800">Juan Dela Cruz</td>
                        <td class="p-4 text-sm text-gray-600">2023-00001</td>
                        <td class="p-4 text-sm text-blue-600 hover:underline cursor-pointer">View Selfie w/ ID</td>
                        <td class="p-4 flex gap-2">
                            <button onclick="acceptSubmission(1)" class="bg-[#16a34a] hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm font-semibold transition-colors shadow-sm">Accept</button>
                            <button onclick="openModal(1)" class="bg-[#991b1b] hover:bg-red-900 text-white px-4 py-1.5 rounded-md text-sm font-semibold transition-colors shadow-sm">Reject</button>
                        </td>
                    </tr>
                    
                    <tr id="row-2" class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-sm font-medium text-gray-800">Maria Santos</td>
                        <td class="p-4 text-sm text-gray-600">2023-00002</td>
                        <td class="p-4 text-sm text-blue-600 hover:underline cursor-pointer">View Selfie w/ ID</td>
                        <td class="p-4 flex gap-2">
                            <button onclick="acceptSubmission(2)" class="bg-[#16a34a] hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-sm font-semibold transition-colors shadow-sm">Accept</button>
                            <button onclick="openModal(2)" class="bg-[#991b1b] hover:bg-red-900 text-white px-4 py-1.5 rounded-md text-sm font-semibold transition-colors shadow-sm">Reject</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="rejectModal" style="display: none;" class="fixed inset-0 z-50 items-center justify-center">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeModal()"></div>

            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6 m-4">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Reason for Rejection</h2>
                <p class="text-sm text-gray-600 mb-4">Please provide a reason why this application is being rejected.</p>

                <textarea id="rejectReason" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none resize-none h-28 mb-5" placeholder="Type reason here..."></textarea>

                <div class="flex items-center gap-3">
                    <button onclick="closeModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">Cancel</button>
                    <button onclick="submitReject()" class="px-5 py-2.5 bg-[#ef4444] hover:bg-red-600 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">Submit Reject</button>
                </div>
            </div>
        </div>

    </div>

    <script>
        let currentSelectedId = null;
        const modal = document.getElementById('rejectModal');
        const reasonInput = document.getElementById('rejectReason');

        // Open Modal
        function openModal(id) {
            currentSelectedId = id;
            modal.style.display = 'flex'; // Use flex to center it
            reasonInput.value = ''; // Clear text area
        }

        // Close Modal
        function closeModal() {
            modal.style.display = 'none';
            currentSelectedId = null;
        }

        // Submit Reject (Removes the row)
        function submitReject() {
            if (currentSelectedId !== null) {
                const row = document.getElementById('row-' + currentSelectedId);
                if (row) {
                    row.remove(); // Vanish effect
                }
                closeModal();
            }
        }

        // Accept (Removes the row immediately)
        function acceptSubmission(id) {
            const row = document.getElementById('row-' + id);
            if (row) {
                row.remove(); // Vanish effect
            }
        }
    </script>
</x-layouts.app>