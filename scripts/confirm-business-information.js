document.addEventListener('DOMContentLoaded', function() {
    const prevBtn = document.querySelector('.prev-btn');
    const acceptBtn = document.querySelector('.accept-btn');
    const links = document.querySelectorAll('.link');

    // Navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            // Navigate to previous page
            window.location.href = 'invite2.php';
        });
    }

    if (acceptBtn) {
        acceptBtn.addEventListener('click', function() {
            // Add loading state
            this.disabled = true;
            this.innerHTML = 'Accepting...';
            
            // Add button press animation
            this.style.transform = 'scale(0.98)';
            
            // Simulate API call
            setTimeout(() => {
                this.style.transform = 'scale(1)';
                // Here you would typically make an API call to accept the invitation
                console.log('Invitation accepted');
                
                // Show success message and redirect
                showModal();
                // Redirect to dashboard or success page
                // window.location.href = 'dashboard.php';
            }, 1500);
        });
    }

    // Add hover effects for buttons
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(-1px)';
            }
        });

        button.addEventListener('mouseleave', function() {
            if (!this.disabled) {
                this.style.transform = 'translateY(0)';
            }
        });
    });

    // Terms of Service and Commercial Terms links
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const type = this.textContent.includes('Terms of Service') ? 'tos' : 'commercial';
            // Here you would typically open the terms in a new tab or modal
            console.log(`Opening ${type} terms...`);
        });
    });

    // Info icon tooltip is handled by CSS
    const infoIcon = document.querySelector('.info-icon');
    if (infoIcon) {
        // Using CSS-based tooltip, no additional JS needed
    }

    // Password Modal Functionality
    const modal = document.querySelector('.password-modal');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.cancel-btn');
    const submitBtn = document.querySelector('.submit-btn');
    const passwordInput = document.querySelector('.password-input input');
    // Show modal function
    function showModal() {
        modal.style.display = 'flex';
        passwordInput.focus();
    }

    // Hide modal function
    function hideModal() {
        modal.style.display = 'none';
        passwordInput.value = '';
    }

    // Close modal when clicking close button
    closeBtn.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);

    // Handle Enter key press
    passwordInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            submitBtn.click();
        }
    });

    hideModal();
});
