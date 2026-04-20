 let currentRowToDelete = null;

    // 1. Accept Function (Instantly removes the row)
    function acceptApplication(btnElement) {
        const row = btnElement.closest('tr');
        if (row) {
            // Optional: You could add a fade-out animation here before removing
            row.remove();
            checkIfTableEmpty();
        }
    }

    // 2. Open Reject Modal
    function openRejectModal(btnElement) {
        // Save the specific row so the modal knows which one to delete later
        currentRowToDelete = btnElement.closest('tr');
        
        const overlay = document.getElementById('rejectModalOverlay');
        const box = document.getElementById('rejectModalBox');
        
        // Show and animate
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        
        // Small delay to allow CSS transitions to trigger
        setTimeout(() => {
            overlay.classList.add('opacity-100');
            box.classList.remove('scale-95');
            box.classList.add('scale-100');
        }, 10);
    }

    // 3. Close Reject Modal (Without deleting)
    function closeRejectModal() {
        const overlay = document.getElementById('rejectModalOverlay');
        const box = document.getElementById('rejectModalBox');
        
        // Reverse animation
        overlay.classList.remove('opacity-100');
        box.classList.remove('scale-100');
        box.classList.add('scale-95');
        
        // Wait for animation to finish before hiding
        setTimeout(() => {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            currentRowToDelete = null; // Reset the target row
            document.getElementById('rejectReasonInput').value = ''; // Clear textarea
        }, 300);
    }

    // 4. Submit Rejection (Deletes row and closes modal)
    function submitRejection() {
        const reason = document.getElementById('rejectReasonInput').value;
        
        // In a real system, you would send the 'reason' to your Laravel backend here.
        console.log("Application Rejected. Reason:", reason);

        // Delete the row
        if (currentRowToDelete) {
            currentRowToDelete.remove();
            checkIfTableEmpty();
        }
        
        closeRejectModal();
    }

    // 5. Utility: Check if table is empty after removing rows
    function checkIfTableEmpty() {
        const tbody = document.getElementById('studentTableBody');
        if (tbody.children.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500 text-sm">
                        No pending applications left.
                    </td>
                </tr>
            `;
        }
    }