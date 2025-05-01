<?php
if (!defined('LOADING_INCLUDED')) {
    define('LOADING_INCLUDED', true);
?>
    <div id="global-loading" style="display: none;">
        <div class="loading-overlay"></div>
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Waiting...</div>
        </div>
    </div>

    <style>
        #global-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }

        .loading-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        .loading-text {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        // Hàm hiển thị loading
        function showLoading() {
            document.getElementById('global-loading').style.display = 'flex';
        }

        // Hàm ẩn loading
        function hideLoading() {
            document.getElementById('global-loading').style.display = 'none';
        }

        // Tự động ẩn loading khi trang tải xong
        window.addEventListener('load', function() {
            hideLoading();
        });


        // Xử lý loading khi click vào link
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && !e.target.hasAttribute('data-no-loading')) {
                showLoading();
            }
        });
    </script>
<?php
}
?> 