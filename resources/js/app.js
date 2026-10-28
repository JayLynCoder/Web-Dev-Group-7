/*
| Single JS entry point (loaded on every page by the layouts).
| Each feature module checks for its own elements, so it is safe to
| load everything everywhere.
*/
import './bootstrap';
import { initCursorTrail } from './cursorTrail';
import { initModals } from './modals';
import { initEmployeePortal } from './employee';
import { initPasswordChecker, initImagePreview } from './forms';

document.addEventListener('DOMContentLoaded', () => {
    initCursorTrail();
    initModals();
    initEmployeePortal();
    initPasswordChecker();
    initImagePreview();
});
