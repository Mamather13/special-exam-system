// Variable to store the row temporarily while modal is open
window.currentRowToDelete = null;

// 1. Accept Function
window.acceptApplication = function(btnElement) {
    const row = btnElement.closest('tr');
    if (row) {
        row.remove();
        window.checkIfTableEmpty();
    }
};

// 2. Open Reject Modal
window.openRejectModal = function(btnElement) {
    window.currentRowToDelete = btnElement.closest('tr');
    
    const overlay = document.getElementById('rejectModalOverlay');
    const box = document.getElementById('rejectModalBox');
    
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
    
    setTimeout(() => {
        overlay.classList.add('opacity-100');
        box.classList.remove('scale-95');
        box.classList.add('scale-100');
    }, 10);
};

// 3. Close Reject Modal
window.closeRejectModal = function() {
    const overlay = document.getElementById('rejectModalOverlay');
    const box = document.getElementById('rejectModalBox');
    
    overlay.classList.remove('opacity-100');
    box.classList.remove('scale-100');
    box.classList.add('scale-95');
    
    setTimeout(() => {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        window.currentRowToDelete = null;
        document.getElementById('rejectReasonInput').value = '';
    }, 300);
};

// 4. Submit Rejection
window.submitRejection = function() {
    const reason = document.getElementById('rejectReasonInput').value;
    console.log("Application Rejected. Reason:", reason);

    if (window.currentRowToDelete) {
        window.currentRowToDelete.remove();
        window.checkIfTableEmpty();
    }
    
    window.closeRejectModal();
};

// 5. Utility: Check if table is empty
window.checkIfTableEmpty = function() {
    const tbody = document.getElementById('studentTableBody');
    if (tbody && tbody.children.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="py-8 text-center text-gray-500 text-sm">
                    No pending applications left.
                </td>
            </tr>
        `;
    }
};