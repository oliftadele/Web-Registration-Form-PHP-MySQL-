document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registrationForm');
    const inputs = form.querySelectorAll('input[type="text"], select, textarea');
    const toast = document.getElementById('toast');

    // 1. Data Persistence (localStorage)
    const loadDraft = () => {
        const savedData = JSON.parse(localStorage.getItem('registrationDraft'));
        if (savedData) {
            Object.keys(savedData).forEach(key => {
                const input = form.elements[key];
                if (input) {
                    if (input.type === 'checkbox') {
                        input.checked = savedData[key];
                    } else if (input.type === 'radio') {
                        if (input.value === savedData[key]) input.checked = true;
                    } else {
                        input.value = savedData[key];
                    }
                    validateField(input);
                }
            });
        }
    };

    const saveDraft = () => {
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            // Simple logic for single values, could be enhanced for arrays (hobbies)
            data[key] = value;
        });
        localStorage.setItem('registrationDraft', JSON.stringify(data));
    };

    // 2. Real-time Validation
    const validateField = (input) => {
        const group = input.closest('.form-group');
        if (!group) return;

        if (input.value.trim() !== '') {
            group.classList.add('success');
            group.classList.remove('error');
        } else {
            group.classList.remove('success');
            // We only show error on blur or submit to avoid being annoying
        }
    };

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            validateField(input);
            saveDraft();
        });

        input.addEventListener('blur', () => {
            const group = input.closest('.form-group');
            if (input.value.trim() === '' && input.hasAttribute('required')) {
                group.classList.add('error');
                input.classList.add('error-shake');
                setTimeout(() => input.classList.remove('error-shake'), 400);
            }
        });
    });

    // 3. Success Animation & Feedback
    const showToast = (message) => {
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    };

    const triggerConfetti = () => {
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 },
            colors: ['#007bff', '#28a745', '#ffc107', '#dc3545']
        });
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Basic check
        let hasError = false;
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                const group = input.closest('.form-group');
                if (group) group.classList.add('error');
                hasError = true;
            }
        });

        if (hasError) {
            showToast('Please fill in all fields! ⚠️');
            return;
        }

        // Gather data
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            if (key === 'hobbies') {
                if (!data[key]) data[key] = [];
                data[key].push(value);
            } else {
                data[key] = value;
            }
        });

        try {
            const response = await fetch('submit.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.status === 'success') {
                triggerConfetti();
                showToast(result.message || 'Registration Successful! 🎉');
                localStorage.removeItem('registrationDraft');
                
                setTimeout(() => {
                    form.reset();
                    form.querySelectorAll('.form-group').forEach(g => g.classList.remove('success', 'error'));
                }, 2000);
            } else {
                showToast('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Submission error:', error);
            showToast('Failed to connect to server. ❌');
        }
    });

    // 4. Sleek Clear Animation
    form.addEventListener('reset', (e) => {
        e.preventDefault();
        form.classList.add('clearing');
        
        setTimeout(() => {
            // Manually clear all inputs to avoid reset event recursion
            inputs.forEach(input => {
                input.value = '';
                const group = input.closest('.form-group');
                if (group) group.classList.remove('success', 'error');
            });

            // Clear radio buttons
            form.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.checked = false;
            });

            // Clear checkboxes
            form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Clear select
            form.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
            });

            localStorage.removeItem('registrationDraft');
            form.classList.remove('clearing');
            showToast('Form Cleared 🗑️');
        }, 300);
    });

    // Initial Load
    loadDraft();
});
