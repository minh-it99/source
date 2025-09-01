#!/bin/bash

# Check if domain parameter is provided
if [ -z "$1" ]; then
    echo "Usage: $0 <domain> [chat_id] [token]"
    echo "Example: $0 example.com 123456789 your_bot_token"
    exit 1
fi

DOMAIN=$1
CHAT_ID=$2
TOKEN=$3
WWW_DOMAIN="www.$DOMAIN"
NGINX_AVAILABLE="/etc/nginx/sites-available/$DOMAIN"
NGINX_ENABLED="/etc/nginx/sites-enabled/$DOMAIN"
WEB_ROOT="/var/www/html/$DOMAIN"

echo "Stopping Nginx..."
sudo systemctl stop nginx

# Install certbot if not installed
if ! command -v certbot &> /dev/null; then
    echo "Installing certbot..."
    sudo apt-get update
    sudo apt-get install -y certbot
fi

# check ssl certificate
if [ -d "/etc/letsencrypt/live/$DOMAIN" ]; then
    echo "SSL certificate already exists for $DOMAIN and $WWW_DOMAIN"
else
    # Get SSL certificate
    echo "Getting SSL certificate for $DOMAIN and $WWW_DOMAIN..."
    sudo certbot certonly --standalone -d $DOMAIN -d $WWW_DOMAIN
fi

# Create web root directory
echo "Creating web root directory..."
if [ ! -d "$WEB_ROOT" ]; then
    sudo mkdir -p $WEB_ROOT
    sudo chmod -R 755 $WEB_ROOT
else
    sudo rm -rf $WEB_ROOT
    sudo mkdir -p $WEB_ROOT
    sudo chmod -R 755 $WEB_ROOT
fi

# Copy source files if they exist
if [ -d "/var/www/html/source" ]; then
    echo "Copying source files..."
    sudo cp -r /var/www/html/source/* $WEB_ROOT 2>/dev/null || true
fi

# Write chat-id and token to files if provided
if [ ! -z "$CHAT_ID" ]; then
    echo "Writing chat ID to file..."
    echo "$CHAT_ID" | sudo tee $WEB_ROOT/chat-id.txt > /dev/null
    sudo chmod 644 $WEB_ROOT/chat-id.txt
fi

if [ ! -z "$TOKEN" ]; then
    echo "Writing token to file..."
    echo "$TOKEN" | sudo tee $WEB_ROOT/token.txt > /dev/null
    sudo chmod 644 $WEB_ROOT/token.txt
fi

# check config file
if [ -f "$NGINX_AVAILABLE" ]; then
    rm -rf $NGINX_AVAILABLE
    rm -rf $NGINX_ENABLED
fi

# Create Nginx configuration
echo "Creating Nginx configuration..."
sudo tee $NGINX_AVAILABLE > /dev/null << EOF
server {
    listen 80;
    server_name $DOMAIN $WWW_DOMAIN;

    return 301 https://\$host\$request_uri;
}

server {
    listen 443 ssl;
    server_name $DOMAIN $WWW_DOMAIN;

    ssl_certificate /etc/letsencrypt/live/$DOMAIN/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/$DOMAIN/privkey.pem;

    root $WEB_ROOT;
    index index.html index.htm index.php;

    location / {
        try_files \$uri \$uri/ \$uri.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

# Create symbolic link
echo "Creating symbolic link..."
sudo ln -sf $NGINX_AVAILABLE $NGINX_ENABLED

# Test Nginx configuration
echo "Testing Nginx configuration..."
sudo nginx -t

# Reload Nginx
echo "Reloading Nginx..."
sudo systemctl restart nginx

echo "Setup completed for $DOMAIN!"

if [ ! -z "$CHAT_ID" ]; then
    echo "Chat ID written to: $WEB_ROOT/chat-id.txt"
fi

if [ ! -z "$TOKEN" ]; then
    echo "Token written to: $WEB_ROOT/token.txt"
fi

echo "Please check if everything is working correctly"

