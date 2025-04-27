<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interview Scheduled Successfully</title>
    <link rel="icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="/styles/two-factor-authentication.css">
    <style>
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 3;
        }
        .success-card {
            background: rgba(255, 255, 255, 0.12);
            border: 1.5px solid rgba(255,255,255,0.22);
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.22);
            padding: 40px 32px 32px 32px;
            color: #fff;
            text-align: center;
            max-width: 380px;
            z-index: 13;
        }
        .checkmark {
            width: 80px;
            height: 80px;
            display: block;
            margin: 0 auto 24px auto;
        }
        .checkmark-circle {
            stroke: #4BB543;
            stroke-width: 6;
            fill: none;
            stroke-dasharray: 240;
            stroke-dashoffset: 240;
            animation: circle-anim 0.7s ease-out forwards;
        }
        .checkmark-check {
            stroke: #4BB543;
            stroke-width: 6;
            fill: none;
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: check-anim 0.4s 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        @keyframes circle-anim {
            to { stroke-dashoffset: 0; }
        }
        @keyframes check-anim {
            to { stroke-dashoffset: 0; }
        }
        .success-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #fff;
        }
        .success-desc {
            color: #b0b3b8;
            font-size: 1.05rem;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <svg class="checkmark" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="22"/>
                <polyline class="checkmark-check" points="14,28 23,36 38,18"/>
            </svg>
            <div class="success-title">Interview Scheduled Successfully!</div>
            <div class="success-desc">Your interview request has been submitted.<br>We will contact you soon. Thank you!</div>
        </div>
    </div>
</body>
</html> 