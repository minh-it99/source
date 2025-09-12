<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="icon" href="../images/favicon.ico">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', monospace;
            background: #000;
            color: #00ff00;
            overflow: hidden;
        }
        
        .crt-effect {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
            background-size: 100% 2px, 3px 100%;
            animation: flicker 0.15s infinite linear alternate;
        }
        
        @keyframes flicker {
            0% { opacity: 1; }
            98% { opacity: 1; }
            99% { opacity: 0.98; }
            100% { opacity: 1; }
        }
        
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
            position: relative;
            z-index: 2;
        }
        
        .ascii-art {
            font-size: 12px;
            line-height: 1;
            margin-bottom: 30px;
            white-space: pre;
            color: #00ff41;
            text-shadow: 0 0 10px #00ff41;
        }
        
        .error-title {
            font-size: 48px;
            font-weight: bold;
            color: #ff0000;
            text-shadow: 0 0 20px #ff0000;
            margin-bottom: 20px;
            animation: blink 1s infinite;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }
        
        .error-message {
            font-size: 18px;
            margin-bottom: 30px;
            color: #00ff00;
        }
        
        .suggestions {
            max-width: 600px;
            text-align: left;
            margin-bottom: 30px;
        }
        
        .suggestions ul {
            list-style: none;
            padding: 0;
        }
        
        .suggestions li {
            margin: 10px 0;
            color: #00ccff;
        }
        
        .suggestions li:before {
            content: "> ";
            color: #ff0000;
        }
        
        .back-link {
            color: #ffff00;
            text-decoration: none;
            font-size: 16px;
            border: 1px solid #ffff00;
            padding: 10px 20px;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            background: #ffff00;
            color: #000;
            text-shadow: none;
        }
        
        .terminal-info {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 12px;
            color: #666;
        }
        
        .cursor {
            animation: cursor-blink 1s infinite;
        }
        
        @keyframes cursor-blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @media (max-width: 768px) {
            .ascii-art {
                font-size: 8px;
            }
            .error-title {
                font-size: 32px;
            }
            .error-message {
                font-size: 16px;
            }
            .suggestions {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="crt-effect">
        <div class="container">
            <div class="ascii-art">
 ██╗  ██╗ ██████╗ ██╗  ██╗
 ██║  ██║██╔═████╗██║  ██║
 ███████║██║██╔██║███████║
 ╚════██║████╔╝██║╚════██║
      ██║╚██████╔╝     ██║
      ╚═╝ ╚═════╝      ╚═╝
            </div>
            
            <div class="error-title">ERROR 404</div>
            
            <div class="error-message">
                SYSTEM ERROR: REQUESTED RESOURCE NOT FOUND<br>
                The page you are looking for has been moved or deleted<span class="cursor">_</span>
            </div>
            
            <div class="suggestions">
                <strong style="color: #ffff00;">TROUBLESHOOTING SUGGESTIONS:</strong>
                <ul>
                    <li>Check the URL for typing errors</li>
                    <li>Try refreshing the page (F5)</li>
                    <li>Clear your browser cache and cookies</li>
                    <li>Contact the site administrator</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        // Retro sound effect (optional)
        document.addEventListener('DOMContentLoaded', function() {
            // Add some retro computer sounds on click
            document.querySelector('.back-link').addEventListener('click', function() {
                // You can add audio here if needed
            });
        });
    </script>
</body>
</html>