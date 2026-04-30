/**
 * Real-time form validation — shows hints under each field as you type.
 * No alerts. Data is never cleared on error.
 */

const RULES = {
    full_name: {
        pattern: /^[A-Za-z\s]{3,}$/,
        msg: 'Full name must contain only letters and spaces (min 3 characters).'
    },
    name: {
        pattern: /^[A-Za-z\s]{3,}$/,
        msg: 'Name must contain only letters and spaces (min 3 characters).'
    },
    username: {
        pattern: /^[A-Za-z0-9]{3,}$/,
        msg: 'Username must be at least 3 characters - letters and numbers only, no special characters.'
    },
    email: {
        pattern: /^[a-zA-Z0-9._%+-]+@gmail\.com$/,
        msg: 'Only @gmail.com addresses are accepted.'
    },
    phone: {
        pattern: /^(98|97)[0-9]{8}$/,
        msg: 'Phone must start with 98 or 97 and be exactly 10 digits.'
    },
    address: {
        pattern:/^.{4,}$/,
        msg: 'Address must be at least 4 characters.'
    }
};

const PWD_RULES = {
    length:{ test: v => v.length >= 6,
    msg:'At least 6 characters' },
    upper:{ test: v => /[A-Z]/.test(v),
    msg:'At least one uppercase letter (A-Z)' },
    number:{ test: v => /[0-9]/.test(v),
    msg:'At least one number (0-9)' },
    special:{ test: v => /[@#$%^&*!]/.test(v),
    msg:'At least one special character (@, #, $, %, etc.)' }
};

// ── helpers ──────────────────────────────────────────────────────────────────

function getHint(input) {
    return input.parentElement.querySelector('.field-hint');
}

function setValid(input) {
    input.classList.remove('input-invalid');
    input.classList.add('input-valid');
    const hint = getHint(input);
    if (hint) { hint.textContent = ''; hint.className = 'field-hint'; }
}

function setInvalid(input, msg) {
    input.classList.remove('input-valid');
    input.classList.add('input-invalid');
    const hint = getHint(input);
    if (hint) { hint.textContent = '' + msg; hint.className = 'field-hint hint-error'; }
}

function clearState(input) {
    input.classList.remove('input-valid', 'input-invalid');
    const hint = getHint(input);
    if (hint) { hint.textContent = ''; hint.className = 'field-hint'; }
}

// ── field validators ─────────────────────────────────────────────────────────

function validateField(input) {
    const name = input.name;
    const val = input.value.trim();

    if (val === '') { clearState(input); return true; } // empty = neutral (required handled on submit)

    if (RULES[name]) {
        if (RULES[name].pattern.test(val)) { setValid(input); return true; }
        else { setInvalid(input, RULES[name].msg); return false; }
    }
    return true;
}

function validatePassword(input) {
    const val = input.value;
    if (val === '') { clearState(input); return true; }

    const failed = Object.values(PWD_RULES).filter(r => !r.test(val));
    if (failed.length === 0) {
        setValid(input);
        return true;
    } else {
        setInvalid(input, failed.map(r => r.msg).join('. '));
        return false;
    }
}

function validateConfirm(confirmInput, passwordInput) {
    const val = confirmInput.value;
    if (val === '') { clearState(confirmInput); return true; }

    if (val === passwordInput.value) { setValid(confirmInput); return true; }
    else { setInvalid(confirmInput, 'Passwords do not match.'); return false; }
}

// ── attach listeners ──────────────────────────────────────────────────────────

function attachValidation(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const fields = form.querySelectorAll('input[name]');
    const pwdInput = form.querySelector('input[name="password"]');
    const confInput = form.querySelector('input[name="confirm_password"]');

    fields.forEach(input => {
        if (input.name === 'password') {
            input.addEventListener('input', () => {
                validatePassword(input);
                if (confInput && confInput.value) validateConfirm(confInput, input);
            });
        } else if (input.name === 'confirm_password') {
            input.addEventListener('input', () => validateConfirm(input, pwdInput));
        } else if (input.type !== 'submit' && input.type !== 'hidden') {
            input.addEventListener('input', () => validateField(input));
            input.addEventListener('blur',  () => { if (input.value) validateField(input); });
        }
    });

    // ── on submit: check all fields are valid before allowing POST ────────────
    form.addEventListener('submit', function(e) {
        let valid = true;

        fields.forEach(input => {
            if (input.type === 'submit' || input.type === 'hidden') return;
            const val = input.value.trim();

            if (input.hasAttribute('required') && val === '') {
                setInvalid(input, 'This field is required.');
                valid = false;
                return;
            }
            if (val === '') return;

            if (input.name === 'password') {
                if (!validatePassword(input)) valid = false;
            } else if (input.name === 'confirm_password') {
                if (!validateConfirm(input, pwdInput)) valid = false;
            } else {
                if (!validateField(input)) valid = false;
            }
        });

        if (!valid) e.preventDefault();
    });
}
