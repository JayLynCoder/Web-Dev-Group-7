/*
| Generic modal helpers for <x-modal id="...">.
|   - Any element with data-modal-open="someId" opens #someId
|   - Any element with data-modal-close closes the modal it is inside
|   - Modals with data-auto-open show on page load
|   - Modals with data-auto-close="3000" close themselves after 3 s
*/
export function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
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

    // Click on the dark backdrop closes the modal.
    document.querySelectorAll('[data-modal]').forEach((modal) => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal(modal);
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') document.querySelectorAll('[data-modal].flex').forEach(closeModal);
    });

    document.querySelectorAll('[data-modal][data-auto-open]').forEach((modal) => openModal(modal.id));
}
