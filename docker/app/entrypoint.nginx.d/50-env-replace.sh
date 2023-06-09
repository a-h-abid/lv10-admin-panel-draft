#!/bin/bash
set -e;

if [ "${NGINX_MODIFY_CONFIGS}" = "true" ]; then

    echo '!!! NGINX MODIFYING CONFIGS based on ENV !!!'

    ## CONF
    echo '--- Updating /etc/nginx/nginx.conf ---'
    sed -i "s!\${NGINX_CONF_USER}!${NGINX_CONF_USER}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_WORKER_PROCESSES}!${NGINX_CONF_WORKER_PROCESSES}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_EVENTS_WORKER_CONNECTIONS}!${NGINX_CONF_EVENTS_WORKER_CONNECTIONS}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_HTTP_KEEPALIVE_TIMEOUT}!${NGINX_CONF_HTTP_KEEPALIVE_TIMEOUT}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_HTTP_LOG_NOT_FOUND}!${NGINX_CONF_HTTP_LOG_NOT_FOUND}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_HTTP_GZIP_STATIC}!${NGINX_CONF_HTTP_GZIP_STATIC}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_HTTP_GZIP_MIN_LENGTH}!${NGINX_CONF_HTTP_GZIP_MIN_LENGTH}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_HTTP_GZIP_COMP_LEVEL}!${NGINX_CONF_HTTP_GZIP_COMP_LEVEL}!" /etc/nginx/nginx.conf
    sed -i "s!\${NGINX_CONF_HTTP_CLIENT_MAX_BODY_SIZE}!${NGINX_CONF_HTTP_CLIENT_MAX_BODY_SIZE}!" /etc/nginx/nginx.conf

    ## VHOST
    echo '--- Updating /etc/nginx/conf.d/* ---'
    sed -i "s!\${NGINX_VHOST_HTTP_LISTEN_PORT}!${NGINX_VHOST_HTTP_LISTEN_PORT}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_HTTPS_LISTEN_PORT}!${NGINX_VHOST_HTTPS_LISTEN_PORT}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_HTTP_SERVER_NAME}!${NGINX_VHOST_HTTP_SERVER_NAME}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_HTTPS_SERVER_NAME}!${NGINX_VHOST_HTTPS_SERVER_NAME}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_DOCUMENT_ROOT}!${NGINX_VHOST_DOCUMENT_ROOT}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_REDIRECT_FROM_SERVER_NAME}!${NGINX_VHOST_REDIRECT_FROM_SERVER_NAME}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_REDIRECT_TO_PROTOCOL}!${NGINX_VHOST_REDIRECT_TO_PROTOCOL}!" /etc/nginx/conf.d/*
    sed -i "s!\${NGINX_VHOST_REDIRECT_TO_SERVER_NAME}!${NGINX_VHOST_REDIRECT_TO_SERVER_NAME}!" /etc/nginx/conf.d/*

    echo '--- Updating /etc/nginx/includes/ssl-params.conf ---'
    sed -i "s!\${NGINX_VHOST_SSL_CERTIFICATE}!${NGINX_VHOST_SSL_CERTIFICATE}!" /etc/nginx/includes/ssl-params.conf
    sed -i "s!\${NGINX_VHOST_SSL_CERTIFICATE_KEY}!${NGINX_VHOST_SSL_CERTIFICATE_KEY}!" /etc/nginx/includes/ssl-params.conf

    echo '--- Updating /etc/nginx/includes/loc-*.conf ---'
    sed -i "s!\${NGINX_VHOST_LOCATION_ROOT_TRY_FILES}!${NGINX_VHOST_LOCATION_ROOT_TRY_FILES}!" /etc/nginx/includes/loc-root.conf

    echo '--- Updating /etc/nginx/includes/loc-*.conf for DNS Resolver ---'
    sed -i "s!\${NGINX_VHOST_DNS_RESOLVER_IP}!${NGINX_VHOST_DNS_RESOLVER_IP}!" /etc/nginx/includes/loc-*.conf

    if [ -f "/etc/nginx/includes/loc-phpfpm.conf" ]; then
        echo '--- Updating /etc/nginx/includes/loc-phpfpm.conf for PHPFPM ---'
        sed -i "s!\${NGINX_VHOST_UPSTREAM_PHPFPM_SERVICE_HOST_PORT}!${NGINX_VHOST_UPSTREAM_PHPFPM_SERVICE_HOST_PORT}!" /etc/nginx/includes/loc-phpfpm.conf
        sed -i "s!\${NGINX_VHOST_UPSTREAM_PHPFPM_FASTCGI_READ_TIMEOUT}!${NGINX_VHOST_UPSTREAM_PHPFPM_FASTCGI_READ_TIMEOUT}!" /etc/nginx/includes/loc-phpfpm.conf
        sed -i "s!\${NGINX_VHOST_UPSTREAM_PHPFPM_FASTCGI_PASS}!${NGINX_VHOST_UPSTREAM_PHPFPM_FASTCGI_PASS}!" /etc/nginx/includes/loc-phpfpm.conf
    fi

fi
