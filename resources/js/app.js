/*
|--------------------------------------------------------------------------
| Single JavaScript entry point (loaded on every page by the layouts)
|--------------------------------------------------------------------------
| Each module looks for its own elements first and does nothing if they
| are not on the page, so it is safe to load everything everywhere.
*/
import './bootstrap';
import { initCursorTrail } from './cursorTrail';
import { initModals, initConfirmForms, initAutoHide } from './modals';
import { initPortal } from './portal';
import { initPasswordChecker, initImagePreview } from './forms';

document.addEventListener('DOMContentLoaded', () => {
    initCursorTrail();     // binary 0/1 trail behind the mouse
    initModals();          // open / close any <x-modal>
    initConfirmForms();    // "Are you sure?" dialog for forms with data-confirm
    initAutoHide();        // elements with data-auto-hide="3000" disappear
    initPortal();          // live clock + mobile sidebar
    initPasswordChecker(); // register page checklist
    initImagePreview();    // register student picture preview
});
