# syntax=docker.io/docker/dockerfile:1
FROM php:8.2.3-fpm

LABEL maintainer="Ahmedul Haque Abid <a_h_abid@hotmail.com>"

ARG HTTP_PROXY=""
ARG HTTPS_PROXY=""
ARG NO_PROXY="localhost,127.0.0.1"
ARG TIMEZONE="UTC"

ENV http_proxy="${HTTP_PROXY}" \
    https_proxy="${HTTPS_PROXY}" \
    no_proxy="${NO_PROXY}" \
    TZ="${TIMEZONE}" \
    NGINX_VERSION="1.23.3" \
    COMPOSER_VERSION="2.5.4" \
    COMPOSER_HOME="/usr/local/composer" \
    S6_OVERLAY_VERSION="3.1.4.1"

USER root

# S6 Overlay Install
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-noarch.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-noarch.tar.xz
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-x86_64.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-x86_64.tar.xz

ENV S6_BEHAVIOUR_IF_STAGE2_FAILS="2" \
    S6_SERVICES_GRACETIME="10000" \
    S6_KILL_GRACETIME="10000" \
    S6_KILL_FINISH_MAXTIME="17000"

# Add app User
ARG UID="1000"
ARG GID="1000"
RUN groupadd --gid ${GID} app \
    && useradd --uid ${UID} --create-home --system --comment "App User" --shell /bin/bash --gid app app

## Install Nginx + PHP Extensions
RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    echo "-- Configure Timezone --" \
        && echo "${TIMEZONE}" > /etc/timezone \
        && rm /etc/localtime \
        && dpkg-reconfigure -f noninteractive tzdata \
    && echo "-- Install Dependencies --" \
        && apt update \
        && apt upgrade -y \
        && apt install -y --no-install-recommends --no-install-suggests \
            apt-transport-https \
            bc \
            curl \
            gnupg1 \
            lsb-release \
            unzip \
            xz-utils \
            zip \
    && echo "-- Add APT Sources --" \
        && curl -L -o /tmp/nginx_signing.key 'https://nginx.org/keys/nginx_signing.key' \
        && apt-key add /tmp/nginx_signing.key \
        && echo "deb http://nginx.org/packages/mainline/debian/ $(lsb_release -sc) nginx" >> /etc/apt/sources.list \
        && apt update \
    && echo "-- Install Nginx --" \
        && apt install -y --no-install-recommends --no-install-suggests \
            nginx="${NGINX_VERSION}"-1~$(lsb_release -sc) \
    && echo "-- Install PHP Extensions --" \
        && curl -L -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
        && chmod a+x /usr/local/bin/install-php-extensions \
        && sync \
        && install-php-extensions \
            exif \
            intl \
            opcache \
            pcntl \
            pdo_mysql \
            sockets \
            zip \
    && echo "-- Composer Install --" \
        && curl -L -o /usr/local/bin/composer https://github.com/composer/composer/releases/download/${COMPOSER_VERSION}/composer.phar \
        && chmod ugo+x /usr/local/bin/composer \
        && composer --version \
    && echo "-- Cleanup Junks --" \
        && rm -f /usr/local/etc/php-fpm.d/zz-docker.conf | true \
        && rm -f /tmp/nginx_signing.key \
        && apt purge -y --auto-remove lsb-release \
        && apt clean -y \
        && apt autoremove -y \
    && echo "-- Additional Works --" \
        && mkdir -p /docker-entrypoint.nginx.d ${COMPOSER_HOME}/cache /run/php \
        && touch /var/run/nginx.pid \
        && chown -R app:app /var/www/html ${COMPOSER_HOME} /etc/nginx/ /run/nginx.pid /run/php /run/lock/nginx /var/log/nginx /var/cache/nginx

WORKDIR /var/www/html

COPY --chown=app:app ./composer.json ./composer.lock* ./

RUN composer install -o --classmap-authoritative --no-suggest --no-interaction

# Copy App Files
COPY --chown=app:app ./app ./app
COPY --chown=app:app ./bootstrap ./bootstrap
COPY --chown=app:app ./config ./config
COPY --chown=app:app ./database ./database
COPY --chown=app:app ./lang ./lang
COPY --chown=app:app ./public ./public
COPY --chown=app:app ./resources ./resources
COPY --chown=app:app ./routes ./routes
COPY --chown=app:app ./storage ./storage
COPY --chown=app:app ./artisan ./

# Copy PHP INI & FPM Configs
COPY --chown=root:root ./docker/app/php/php.ini /usr/local/etc/php/php.ini
COPY --chown=root:root ./docker/app/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy Nginx Configs
COPY --chown=app:app ./docker/app/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --chown=app:app ./docker/app/nginx/conf.d/*.conf /etc/nginx/conf.d/
COPY --chown=app:app ./docker/app/nginx/includes/*.conf /etc/nginx/includes/
COPY --chown=app:app ./docker/entrypoint.nginx.d/*.sh /docker-entrypoint.nginx.d/

# Copy service script
COPY --chown=app:app ./docker/app/start-nginx.sh /etc/services.d/nginx/run
COPY --chown=app:app ./docker/app/start-phpfpm.sh /etc/services.d/php_fpm/run

# Fix permissions
RUN chmod ugo+x /docker-entrypoint.nginx.d/*.sh \
    && chmod 755 /etc/services.d/nginx/run /etc/services.d/php_fpm/run \
    && sed -i '/resolver \${NGINX_VHOST_DNS_RESOLVER_IP}/d' /etc/nginx/includes/loc-phpfpm.conf \
    && sed -i '/set \$upstreamName/d' /etc/nginx/includes/loc-phpfpm.conf

# Copy SSL Certs
COPY --chown=root:root ./.commons/certs/* /etc/ssl/certs/

# Unset proxy, timezone ENVs
ENV http_proxy="" \
    https_proxy="" \
    no_proxy="" \
    TZ=""

# PHP INI Settings for production by default
ENV PHP_INI_OUTPUT_BUFFERING=4096 \
    PHP_INI_MAX_EXECUTION_TIME=60 \
    PHP_INI_MAX_INPUT_TIME=60 \
    PHP_INI_MEMORY_LIMIT="256M" \
    PHP_INI_DISPLAY_ERRORS="Off" \
    PHP_INI_DISPLAY_STARTUP_ERRORS="Off" \
    PHP_INI_POST_MAX_SIZE="2M" \
    PHP_INI_FILE_UPLOADS="On" \
    PHP_INI_UPLOAD_MAX_FILESIZE="2M" \
    PHP_INI_MAX_FILE_UPLOADS="2" \
    PHP_INI_ALLOW_URL_FOPEN="On" \
    PHP_INI_ERROR_LOG="" \
    PHP_INI_DATE_TIMEZONE="${TIMEZONE}" \
    PHP_INI_SESSION_SAVE_HANDLER="files" \
    PHP_INI_SESSION_SAVE_PATH="/tmp" \
    PHP_INI_SESSION_USE_STRICT_MODE=0 \
    PHP_INI_SESSION_USE_COOKIES=1 \
    PHP_INI_SESSION_USE_ONLY_COOKIES=1 \
    PHP_INI_SESSION_NAME="APP_SSID" \
    PHP_INI_SESSION_COOKIE_SECURE="On" \
    PHP_INI_SESSION_COOKIE_LIFETIME=0 \
    PHP_INI_SESSION_COOKIE_PATH="/" \
    PHP_INI_SESSION_COOKIE_DOMAIN="" \
    PHP_INI_SESSION_COOKIE_HTTPONLY="On" \
    PHP_INI_SESSION_COOKIE_SAMESITE="" \
    PHP_INI_SESSION_UPLOAD_PROGRESS_NAME="APP_UPLOAD_PROGRESS" \
    PHP_INI_OPCACHE_ENABLE=1 \
    PHP_INI_OPCACHE_ENABLE_CLI=0 \
    PHP_INI_OPCACHE_MEMORY_CONSUMPTION=256 \
    PHP_INI_OPCACHE_INTERNED_STRINGS_BUFFER=16 \
    PHP_INI_OPCACHE_MAX_ACCELERATED_FILES=100000 \
    PHP_INI_OPCACHE_MAX_WASTED_PERCENTAGE=25 \
    PHP_INI_OPCACHE_USE_CWD=0 \
    PHP_INI_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    PHP_INI_OPCACHE_REVALIDATE_FREQ=0 \
    PHP_INI_OPCACHE_SAVE_COMMENTS=0 \
    PHP_INI_OPCACHE_ENABLE_FILE_OVERRIDE=1 \
    PHP_INI_OPCACHE_MAX_FILE_SIZE=0 \
    PHP_INI_OPCACHE_FAST_SHUTDOWN=1

ENV PHPFPM_CONF_WWW_USER="www-data" \
    PHPFPM_CONF_WWW_GROUP="www-data" \
    PHPFPM_CONF_WWW_LISTEN="/run/php/php-fpm.sock" \
    PHPFPM_CONF_WWW_LISTEN_OWNER="www-data" \
    PHPFPM_CONF_WWW_LISTEN_GROUP="www-data" \
    PHPFPM_CONF_WWW_LISTEN_MODE=0660 \
    PHPFPM_CONF_WWW_PM="dynamic" \
    PHPFPM_CONF_WWW_PM_MAX_CHILDREN=5 \
    PHPFPM_CONF_WWW_PM_START_SERVERS=2 \
    PHPFPM_CONF_WWW_PM_MIN_SPARE_SERVERS=1 \
    PHPFPM_CONF_WWW_PM_MAX_SPARE_SERVERS=3 \
    PHPFPM_CONF_WWW_PM_PROCESS_IDLE_TIMEOUT="10s" \
    PHPFPM_CONF_WWW_PM_MAX_REQUESTS=0

ENV NGINX_MODIFY_CONFIGS="true" \
    NGINX_CONF_USER="www-data www-data" \
    NGINX_CONF_WORKER_PROCESSES="4" \
    NGINX_CONF_EVENTS_WORKER_CONNECTIONS="2048" \
    NGINX_CONF_HTTP_KEEPALIVE_TIMEOUT="15s" \
    NGINX_CONF_HTTP_LOG_NOT_FOUND="off" \
    NGINX_CONF_HTTP_GZIP_STATIC="off" \
    NGINX_CONF_HTTP_GZIP_MIN_LENGTH="20" \
    NGINX_CONF_HTTP_GZIP_COMP_LEVEL="6" \
    NGINX_CONF_HTTP_CLIENT_MAX_BODY_SIZE="2m" \
    NGINX_VHOST_HTTP_LISTEN_PORT="80" \
    NGINX_VHOST_HTTPS_LISTEN_PORT="443" \
    NGINX_VHOST_DNS_RESOLVER_IP="127.0.0.11" \
    NGINX_VHOST_ENABLE_HTTP_TRAFFIC="true" \
    NGINX_VHOST_ENABLE_HTTPS_TRAFFIC="false" \
    NGINX_VHOST_HTTP_SERVER_NAME="_" \
    NGINX_VHOST_HTTPS_SERVER_NAME="_" \
    NGINX_VHOST_DOCUMENT_ROOT="/var/www/html" \
    NGINX_VHOST_LOCATION_ROOT_TRY_FILES="\$uri \$uri/ /index.php\$is_args\$args" \
    NGINX_VHOST_UPSTREAM_PHPFPM_SERVICE_HOST_PORT="localhost:9000" \
    NGINX_VHOST_UPSTREAM_PHPFPM_FASTCGI_READ_TIMEOUT="600" \
    NGINX_VHOST_UPSTREAM_PHPFPM_FASTCGI_PASS="unix:/run/php/php-fpm.sock" \
    NGINX_VHOST_SSL_CERTIFICATE="/etc/ssl/certs/ssl-cert-snakeoil.pem" \
    NGINX_VHOST_SSL_CERTIFICATE_KEY="/etc/ssl/certs/ssl-cert-snakeoil.key" \
    NGINX_VHOST_USE_PHPFPM="true"

STOPSIGNAL SIGTERM

ENTRYPOINT []

CMD ["/init"]

USER app
