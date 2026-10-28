// Live password-requirement checklist on the Register page.
export function initPasswordChecker() {
    const password = document.getElementById('register-password');
    const confirmation = document.getElementById('password-confirmation');
    const matchText = document.getElementById('password-match');
    if (!password || !confirmation) return;

    const rules = {
        length: (v) => v.length >= 8,
        uppercase: (v) => /[A-Z]/.test(v),
        lowercase: (v) => /[a-z]/.test(v),
        number: (v) => /[0-9]/.test(v),
        special: (v) => /[!@#$%^&*(),.?":{}|<>_\-+=]/.test(v),
    };

    const checkMatch = () => {
        if (!matchText) return;
        if (confirmation.value === '') {
            matchText.textContent = '';
            return;
        }
        const ok = password.value === confirmation.value;
        matchText.textContent = ok ? '✓ Passwords match' : '✕ Passwords do not match';
        matchText.classList.toggle('text-hexa-green', ok);
        matchText.classList.toggle('text-hexa-red', !ok);
    };

    password.addEventListener('input', () => {
        Object.entries(rules).forEach(([name, test]) => {
            const item = document.getElementById(`requirement-${name}`);
            if (!item) return;
            const passed = test(password.value);
            item.classList.toggle('text-hexa-green', passed);
            item.classList.toggle('text-white/50', !passed);
            item.querySelector('[data-icon]').textContent = passed ? '✓' : '○';
        });
        checkMatch();
    });

    confirmation.addEventListener('input', checkMatch);
}

// Shows the chosen picture before uploading (Register Employee page).
export function initImagePreview() {
    document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
        const preview = document.getElementById(input.dataset.preview);
        if (!preview) return;

        input.addEventListener('change', () => {
            const file = input.files?.[0];
            if (!file) {
                preview.classList.add('hidden');
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });
    });
}
