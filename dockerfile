# ======= Stage 1: Builder =======
FROM php:8.2-cli AS builder

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install \
    intl \
    zip \
    pdo_mysql \
    opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts --no-autoloader

# Copy application files
COPY . .

# Generate autoloader and run post-install scripts
RUN composer dump-autoload --optimize && \
    cp .env.example .env

# ======= Stage 2: Final image =======
FROM php:8.2-apache

# Install system packages with security updates
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install \
    intl \
    zip \
    pdo_mysql \
    opcache \
    && apt-get upgrade -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configure PHP for production
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Security hardening
RUN { \
    echo 'expose_php=Off'; \
    echo 'display_errors=Off'; \
    echo 'log_errors=On'; \
    echo 'allow_url_fopen=Off'; \
    echo 'allow_url_include=Off'; \
    } > /usr/local/etc/php/conf.d/security.ini

# Enable Apache modules and security headers
RUN a2enmod rewrite headers && \
    echo 'ServerTokens Prod' >> /etc/apache2/apache2.conf && \
    echo 'ServerSignature Off' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy built app from builder
COPY --from=builder /var/www/html /var/www/html

# Create secure Apache virtual host
COPY <<EOF /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    DocumentRoot /var/www/html/public
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        Options -Indexes -MultiViews
    </Directory>
    <Directory /var/www/html>
        Options -Indexes
        AllowOverride None
        Require all denied
    </Directory>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</VirtualHost>
EOF

# Set secure permissions
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
