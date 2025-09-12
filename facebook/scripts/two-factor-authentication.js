document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.auth-form');
    const codeInput = document.getElementById('code');
    const confirmBtn = document.querySelector('.confirm-btn');
    const learnMoreLink = document.querySelector('.learn-more');
    const alternativeAuthLink = document.querySelector('.alternative-auth');
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

        // Add loading state
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = 'Verifying...';
    });

    // Format input to only allow numbers and max 8 digits
   

    // Handle learn more link
    learnMoreLink.addEventListener('click', function(e) {
        e.preventDefault();
        // Here you would typically open documentation or help page
        console.log('Opening 2FA documentation...');
    });

    // Handle alternative authentication link
    alternativeAuthLink.addEventListener('click', function(e) {
        e.preventDefault();
        // Here you would typically show alternative auth options
        console.log('Opening alternative authentication options...');
    });
}); 