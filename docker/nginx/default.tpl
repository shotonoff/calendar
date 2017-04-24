server {
    server_name aulinks.local aulinks-nginx;
    root ${NGINX_AULINKS_PROJECT_PATH}/public;

    location /app {
        alias ${NGINX_AULINKS_PROJECT_PATH}/spa/;
    }

    location /pages {
        alias ${NGINX_AULINKS_PROJECT_PATH}/spa/src/pages/;
    }

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ ^/favicon.ico {
        return 200;
    }

    location ~ ^/log$ {
        return 200;
    }

    location ~ ^/(index)\.php(/|$) {
        root ${NGINX_AULINKS_PROJECT_PATH}/public;
        fastcgi_pass php:9000;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    error_log /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}