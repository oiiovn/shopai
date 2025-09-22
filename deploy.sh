#!/bin/bash

# 🚀 TCSN Deployment Script
# Script tự động deploy lên hosting

echo "🚀 Starting TCSN Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="TCSN"
LOCAL_PATH="/Applications/XAMPP/xamppfiles/htdocs/TCSN"
BACKUP_DIR="/tmp/tcsn_backup_$(date +%Y%m%d_%H%M%S)"

# Check if we're in the right directory
if [ ! -d "$LOCAL_PATH/Script" ]; then
    echo -e "${RED}❌ Error: Script directory not found at $LOCAL_PATH/Script${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Project structure verified${NC}"

# Create backup directory
mkdir -p "$BACKUP_DIR"
echo -e "${YELLOW}📁 Created backup directory: $BACKUP_DIR${NC}"

# Step 1: Create production package
echo -e "${YELLOW}📦 Creating production package...${NC}"

# Create temporary deployment directory
DEPLOY_DIR="/tmp/tcsn_deploy_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$DEPLOY_DIR"

# Copy Script directory
cp -r "$LOCAL_PATH/Script" "$DEPLOY_DIR/"

# Remove development files
echo -e "${YELLOW}🧹 Cleaning development files...${NC}"
rm -rf "$DEPLOY_DIR/Script/node_modules"
rm -rf "$DEPLOY_DIR/Script/vendor"
rm -rf "$DEPLOY_DIR/Script/content/cache/*"
rm -rf "$DEPLOY_DIR/Script/content/uploads/*"
rm -rf "$DEPLOY_DIR/Script/logs/*"

# Remove backup files
find "$DEPLOY_DIR" -name "*.backup" -delete
find "$DEPLOY_DIR" -name "*.bak" -delete
find "$DEPLOY_DIR" -name "*.tmp" -delete

# Create .htaccess for production
cat > "$DEPLOY_DIR/Script/.htaccess" << 'EOF'
# TCSN Production .htaccess
RewriteEngine On

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"

# Cache control
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/svg+xml "access plus 1 month"
</IfModule>

# Gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# URL Rewriting
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Block access to sensitive files
<Files "config.php">
    Order Allow,Deny
    Deny from all
</Files>

<Files "*.sql">
    Order Allow,Deny
    Deny from all
</Files>

<Files "*.md">
    Order Allow,Deny
    Deny from all
</Files>
EOF

# Create deployment package
echo -e "${YELLOW}📦 Creating deployment package...${NC}"
cd /tmp
tar -czf "tcsn_deploy_$(date +%Y%m%d_%H%M%S).tar.gz" -C "$DEPLOY_DIR" .

echo -e "${GREEN}✅ Deployment package created successfully!${NC}"
echo -e "${YELLOW}📁 Package location: /tmp/tcsn_deploy_$(date +%Y%m%d_%H%M%S).tar.gz${NC}"

# Display next steps
echo -e "${GREEN}🎉 Deployment package ready!${NC}"
echo ""
echo -e "${YELLOW}📋 Next steps:${NC}"
echo "1. Upload the package to your hosting server"
echo "2. Extract the package in your public_html directory"
echo "3. Update config.php with production database settings"
echo "4. Set proper file permissions (755 for directories, 644 for files)"
echo "5. Create database and import SQL files"
echo "6. Setup cron jobs"
echo "7. Test the application"
echo ""
echo -e "${GREEN}📖 See DEPLOYMENT_GUIDE.md for detailed instructions${NC}"

# Cleanup
rm -rf "$DEPLOY_DIR"

echo -e "${GREEN}✅ Deployment script completed!${NC}"
