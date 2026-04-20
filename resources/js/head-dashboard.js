/**
     * 1. Main Tab Switching 
     * Handles switching between "First Approach", "Final Approval", and "Department Lists"
     */
    window.switchTab = function(clickedBtn, targetViewId) {
        // Reset all main tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-bold');
            btn.classList.add('border-transparent', 'text-gray-500', 'font-medium');
        });

        // Highlight the clicked main tab
        clickedBtn.classList.add('active-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-bold');
        clickedBtn.classList.remove('border-transparent', 'text-gray-500', 'font-medium');

        // Show the correct content section
        document.querySelectorAll('.tab-content').forEach(view => view.classList.add('hidden'));
        document.getElementById(targetViewId).classList.remove('hidden');
    };

    /**
     * 2. Department View Switching
     * Switches between the "Term Cards" (Prelim/Midterm) and the "Student Tables"
     */
    window.showDetails = function(termName) {
        document.getElementById('selected-term-title').innerText = termName + ' - Completed Applications';
        document.getElementById('term-selection-view').classList.add('hidden');
        document.getElementById('details-view').classList.remove('hidden');
    };

    window.showTerms = function() {
        document.getElementById('details-view').classList.add('hidden');
        document.getElementById('term-selection-view').classList.remove('hidden');
    };

    /**
     * 3. Internal Sub-Tab Switching (CRITICAL FOR YOUR NEW TABLES)
     * Handles switching between "Paid Special Exam", "Summary", and "Waived Fee"
     */
    window.switchSubTab = function(clickedBtn, tableId) {
        // Reset all sub-tab button styles
        document.querySelectorAll('.sub-tab-btn').forEach(btn => {
            btn.classList.remove('active-sub-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-black');
            btn.classList.add('border-transparent', 'text-gray-400', 'font-bold');
        });

        // Highlight the clicked sub-tab
        clickedBtn.classList.add('active-sub-tab', 'border-[#F1C40F]', 'text-gray-900', 'font-black');
        clickedBtn.classList.remove('border-transparent', 'text-gray-400', 'font-bold');

        // Hide all tables and show the target one
        document.querySelectorAll('.sub-content').forEach(table => table.classList.add('hidden'));
        document.getElementById(tableId).classList.remove('hidden');
    };