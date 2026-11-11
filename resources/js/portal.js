/*
|--------------------------------------------------------------------------
| Logged-in pages: live clock + mobile sidebar
|--------------------------------------------------------------------------
| Recording attendance is NOT done here. It is a normal form POST handled
| by Laravel (AttendanceController), so the time is always saved in Firebase.
*/
export function initPortal() {
    // Live clock: any element with data-live-clock / data-live-date
    const clocks = document.querySelectorAll('[data-live-clock]');
    const dates = document.querySelectorAll('[data-live-date]');

    if (clocks.length || dates.length) {
        const tick = () => {
            const now = new Date();

            clocks.forEach((element) => {
                element.textContent = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    // data-live-clock="short" hides the seconds
                    second: element.dataset.liveClock === 'short' ? undefined : '2-digit',
                });
            });

            dates.forEach((element) => {
                element.textContent = now.toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                });
            });
        };

        tick();
        setInterval(tick, 1000);
    }

    // Mobile: the ☰ button slides the sidebar in and out
    const sidebar = document.getElementById('sidebar');
    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => sidebar?.classList.toggle('-translate-x-full'));
    });
}
