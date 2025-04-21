<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Detail - Premium Arabica</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6F4E37;
            --secondary-color: #D2B48C;
            --text-color: #333;
            --light-bg: #F9F5F0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--light-bg);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .product-image {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image:hover img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1rem;
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .product-subtitle {
            font-size: 1.2rem;
            color: var(--secondary-color);
            margin-bottom: 2rem;
        }

        .product-description {
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .product-features {
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            color: var(--primary-color);
        }

        .price-section {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .price {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-right: 2rem;
        }

        .add-to-cart {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-to-cart:hover {
            background-color: #5a3d2b;
        }

        .product-meta {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .meta-item {
            text-align: center;
        }

        .meta-label {
            font-size: 0.9rem;
            color: #666;
        }

        .meta-value {
            font-weight: 500;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .product-detail {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product-detail">
            <div class="product-image">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Premium Arabica Coffee">
            </div>
            <div class="product-info">
                <h1 class="product-title">Premium Arabica Coffee</h1>
                <p class="product-subtitle">Single Origin - Ethiopia Yirgacheffe</p>
                
                <p class="product-description">
                    Experience the exquisite taste of our premium Arabica coffee beans, sourced directly from the highlands of Ethiopia. 
                    This single-origin coffee offers a complex flavor profile with notes of blueberry, chocolate, and floral undertones.
                </p>

                <div class="product-features">
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>100% Arabica Beans</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Medium Roast</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Freshly Roasted</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">✓</span>
                        <span>Direct Trade</span>
                    </div>
                </div>

                <div class="price-section">
                    <span class="price">$24.99</span>
                    <button class="add-to-cart">Add to Cart</button>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <div class="meta-label">Origin</div>
                        <div class="meta-value">Ethiopia</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Altitude</div>
                        <div class="meta-value">1,900m</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Process</div>
                        <div class="meta-value">Washed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 
