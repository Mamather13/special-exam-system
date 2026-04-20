import './bootstrap';
import 'flowbite';
import './teacher-subject.js';
import './head-dashboard.js';
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

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
        e.preventDefault();

        const subject = document.getElementById('subject')?.value || "Unnamed Subject";
        const teacher = document.getElementById('teacher')?.value || "Instructor";
        const section = document.getElementById('section')?.value || "N/A";
        const code = "IT-" + Math.floor(Math.random() * 900 + 100);

        const card = document.createElement('div');
        card.className = "bg-white p-8 rounded-[1.5rem] shadow-sm border border-gray-100 flex items-center justify-between group cursor-pointer hover:shadow-md transition-all";
        
        // Escape single quotes for safety
        const sSub = subject.replace(/'/g, "\\'");
        const sTea = teacher.replace(/'/g, "\\'");
        const sSec = section.replace(/'/g, "\\'");
        
        // This attribute will now find the global function defined at the top
        card.setAttribute('onclick', `openStatusModal('${sSub}', '${code}', '${sTea}', '${sSec}')`);

        card.innerHTML = `
            <div class="space-y-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">${subject}</h2>
                    <p class="text-gray-400 text-sm mt-1 font-medium">${code} • Prof. ${teacher} • ${section}</p>
                </div>
                <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-[11px] font-bold border border-blue-100 uppercase tracking-wide">
                    Submitted
                </div>
            </div>
            <div class="text-gray-300 group-hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        `;

        applicationsGrid?.appendChild(card);
        applicationsGrid?.classList.remove('hidden');
        emptyState?.classList.add('hidden');

        closeRegModal();
    });
});