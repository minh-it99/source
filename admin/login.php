<?php
session_start();

// Nếu đã đăng nhập, chuyển hướng về trang admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-title {
            color: #333;
            margin-bottom: 1.5rem;
        }

        .login-button {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #166fe5;
        }

        .error-message {
            color: #e53e3e;
            margin-top: 1rem;
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Admin Login</h1>
        <button class="login-button" onclick="showLoginPrompt()">Login</button>
        <div id="errorMessage" class="error-message">Invalid credentials</div>
    </div>

    <script>
        function showLoginPrompt() {
            const username = prompt('Enter username:');
            if (username === null) return;

            const password = prompt('Enter password:');
            if (password === null) return;

            // Gửi thông tin đăng nhập đến server
            fetch('verify_login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.php';
                } else {
                    document.getElementById('errorMessage').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('errorMessage').style.display = 'none';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('errorMessage').style.display = 'block';
            });
        }
    </script>
</body>
</html> 