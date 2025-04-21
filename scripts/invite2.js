document.addEventListener('DOMContentLoaded', function() {
    const prevBtn = document.querySelector('.prev-btn');
    const continueBtn = document.querySelector('.continue-btn');
    const declineLink = document.querySelector('.decline-link');

    // Navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            // Navigate to previous page
            window.location.href = 'invite.php';
        });
    }

    if (continueBtn) {
        continueBtn.addEventListener('click', function() {
            // Add button press animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
                // Navigate to next page (would be invite3.php)
                console.log('Proceeding to next step...');
                window.location.href = 'confirm-business-information.php';
            }, 100);
        });
    }

    // Decline invitation
    if (declineLink) {
        declineLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to decline this invitation?')) {
                console.log('Invitation declined');
                // Here you would typically redirect to a decline confirmation page
            }
        });
    }

    // Info icon tooltip
    const infoIcon = document.querySelector('.info-icon');
    if (infoIcon) {
        // Using CSS-based tooltip, no additional JS needed
        // The tooltip is handled by CSS [data-tooltip] attribute
    }

    // Add hover effects for buttons
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}); 