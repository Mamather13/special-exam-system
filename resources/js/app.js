import './bootstrap';

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