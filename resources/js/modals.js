/*
|--------------------------------------------------------------------------
| Modals (used with the <x-modal id="..."> Blade component)
|--------------------------------------------------------------------------
|   data-modal-open="someId"  on a button  → opens #someId
|   data-modal-close          on a button  → closes the modal it is inside
|   data-auto-open            on a modal   → opens when the page loads
|   data-auto-close="3000"    on a modal   → closes itself after 3 seconds
*/
export function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    // Tailwind: "hidden" = display:none, "flex" = display:flex
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const closeAfter = Number(modal.dataset.autoClose);
    if (closeAfter) setTimeout(() => closeModal(modal), closeAfter);
}

export function closeModal(modal) {
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

export function initModals() {
    document.querySelectorAll('[data-modal-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => openModal(trigger.dataset.modalOpen));
    });

    document.querySelectorAll('[data-modal-close]').forEach((button) => {
        button.addEventListener('click', () => closeModal(button.closest('[data-modal]')));
    });

    // Clicking the dark backdrop (outside the box) closes the modal
    document.querySelectorAll('[data-modal]').forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) closeModal(modal);
        });
    });

    // Esc closes any open modal
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('[data-modal].flex').forEach(closeModal);
        }
    });

    document.querySelectorAll('[data-modal][data-auto-open]').forEach((modal) => openModal(modal.id));
}

/*
|--------------------------------------------------------------------------
| Confirm before submitting
|--------------------------------------------------------------------------
| <form data-confirm="Delete this account?" data-confirm-button="Delete">
| Instead of the browser's plain confirm() box, this shows the styled
| #confirm-dialog modal (in the portal layout) and only submits on "Yes".
*/
export function initConfirmForms() {
    const dialog = document.getElementById('confirm-dialog');
    if (!dialog) return;

    const message = dialog.querySelector('[data-confirm-message]');
    const yesButton = dialog.querySelector('[data-confirm-yes]');
    let pendingForm = null;

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.confirmed === 'true') return; // second time: let it through

            event.preventDefault();
            pendingForm = form;
            message.textContent = form.dataset.confirm;
            yesButton.textContent = form.dataset.confirmButton || 'Yes';
            openModal('confirm-dialog');
        });
    });

    yesButton.addEventListener('click', () => {
        if (!pendingForm) return;
        pendingForm.dataset.confirmed = 'true';
        pendingForm.requestSubmit();
    });
}

/* Anything with data-auto-hide="3000" fades out after 3 seconds. */
export function initAutoHide() {
    document.querySelectorAll('[data-auto-hide]').forEach((element) => {
        setTimeout(() => {
            element.classList.add('opacity-0');
            setTimeout(() => element.remove(), 500);
        }, Number(element.dataset.autoHide));
    });
}
