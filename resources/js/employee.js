/*
| Employee Portal behaviour.
| The Clock In / Clock Out itself is a normal form POST handled by Laravel
| (Employee\PortalController@clock) — this file only does the live clock,
| the mobile sidebar and the "still on duty" sign-out warning.
*/
import { openModal } from './modals';

export function initEmployeePortal() {
    // Live clock (any element with data-live-clock / data-live-date)
    const clocks = document.querySelectorAll('[data-live-clock]');
    const dates = document.querySelectorAll('[data-live-date]');

    if (clocks.length || dates.length) {
        const tick = () => {
            const now = new Date();
            clocks.forEach((el) => {
                el.textContent = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: el.dataset.liveClock === 'short' ? undefined : '2-digit',
                });
            });
            dates.forEach((el) => {
                el.textContent = now.toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                });
            });
        };
        tick();
        setInterval(tick, 1000);
    }

    // Mobile sidebar toggle
    const sidebar = document.getElementById('sidebar');
    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => sidebar?.classList.toggle('-translate-x-full'));
    });

    // Warn before signing out while still clocked in
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm && logoutForm.dataset.onDuty === 'true') {
        logoutForm.addEventListener('submit', (e) => {
            if (logoutForm.dataset.confirmed === 'true') return;
            e.preventDefault();
            openModal('logout-warning');
        });

        document.getElementById('logout-anyway')?.addEventListener('click', () => {
            logoutForm.dataset.confirmed = 'true';
            logoutForm.requestSubmit();
        });
    }
}
