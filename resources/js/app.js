import './bootstrap';
import 'flowbite';
import './teacher-subject.js';
import './head-dashboard.js';


document.addEventListener('DOMContentLoaded', () => {
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const profileBtn = document.getElementById('userProfileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    const closeDropdowns = () => {
        if (notifDropdown) notifDropdown.classList.add('hidden');
        if (profileDropdown) profileDropdown.classList.add('hidden');
    };

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            notifDropdown.classList.toggle('hidden');
            if (profileDropdown) profileDropdown.classList.add('hidden');
        });
    }

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            if (notifDropdown) notifDropdown.classList.add('hidden');
        });
    }

    document.addEventListener('click', (event) => {
        if (notifDropdown && !notifDropdown.contains(event.target) && event.target !== notifBtn) {
            notifDropdown.classList.add('hidden');
        }

        if (profileBtn && profileDropdown && !profileBtn.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
});

// --- 1. GLOBAL FUNCTIONS (Fixed for 'onclick' errors) ---
// We attach these to 'window' so the HTML can always see them
window.openStatusModal = function(subject, code, prof, section) {
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusContent');
    
    if (!modal || !content) return;

    // Update labels in the modal
    document.getElementById('statusTitle').innerText = subject;
    document.getElementById('statusSubtitle').innerText = `${code} • Prof. ${prof} • ${section}`;
    
    // Animate Open
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.body.style.overflow = 'hidden';
};

window.closeStatusModal = function() {
    const modal = document.getElementById('statusModal');
    const content = document.getElementById('statusContent');
    
    if (!modal || !content) return;

    modal.classList.remove('opacity-100');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 300);
};

// --- 2. DOM CONTENT LOADED ---
document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.getElementById('openModalBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalContent = document.getElementById('modalContent');
    const submitFormBtn = document.getElementById('submitFormBtn');
    const sigUpload = document.getElementById('sigUpload');
    const sigFileName = document.getElementById('sigFileName');
    const applicationsGrid = document.getElementById('applicationsGrid');
    const emptyState = document.getElementById('emptyState');

    // Registration Modal Open
    if (openModalBtn) {
        openModalBtn.onclick = () => {
            modalOverlay.classList.remove('hidden');
            setTimeout(() => {
                modalOverlay.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        };
    }

    // Generic Close for Registration Modal
    window.closeRegModal = () => {
        modalOverlay.classList.remove('opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modalOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    };

    // Attach close to X and Cancel
    document.getElementById('closeXBtn')?.addEventListener('click', closeRegModal);
    document.getElementById('cancelBtn')?.addEventListener('click', closeRegModal);

    // Signature Upload Update
    sigUpload?.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            sigFileName.innerText = `Selected: ${e.target.files[0].name}`;
            sigFileName.classList.add('text-green-600');
        }
    });

    // --- 3. SUBMISSION LOGIC ---
    submitFormBtn?.addEventListener('click', (e) => {
    
        document.getElementById('registrationForm').submit();
    
    });
});