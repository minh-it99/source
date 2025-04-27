document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.auth-form');
    const codeInput = document.getElementById('code');
    const errorMessage = document.querySelector('.error-message');

    // Function to show error
    function showError() {
        errorMessage.style.display = 'flex';
        codeInput.classList.add('error');
    }

    // Function to hide error
    function hideError() {
        errorMessage.style.display = 'none';
        codeInput.classList.remove('error');
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const code = codeInput.value.trim();
        
        if (!code) {
            showError();
            return;
        }

        if (code.length < 6) {
            showError();
            return;
        }

        // Check if code is numeric
        if (!/^\d+$/.test(code)) {
            showError();
            return;
        }
    });
}); 