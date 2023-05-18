FROM php:7.2.10-fpm-alpine3.8

RUN sed -i "s/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g" /etc/apk/repositories && \
    apk --update --no-cache add \
    shadow \
    nginx \
    git \
    unzip \
    wget \
    curl-dev \
    libcurl && \
    docker-php-ext-install pdo pdo_mysql mbstring bcmath curl && \
    mkdir -p /var/www && \
    wget http://typecho.org/build.tar.gz -O typecho.tgz && \
    tar zxvf typecho.tgz && \
    mv build/* /var/www && \
    sed -i "s|define('__TYPECHO_ROOT_DIR__', dirname(__FILE__));.*|define('__TYPECHO_ROOT_DIR__', '/var/www'); define('__TYPECHO_SITE_URL__', '/');|i" /var/www/install.php && \
    sed -i "s|/admin/|/dzh/|i" /var/www/install.php && \
    sed -i 's|@file_put_contents(\x27\.\/config\.inc\.php\x27, \$contents);|@file_put_contents("\.\/config\.inc\.php", \$contents);system("cp -v \/var\/www\/config\.inc\.php \/data\/config\.inc\.php \&\& rm -f \/var\/www\/config\.inc\.php \&\& ln -sf \/data\/config\.inc\.php \/var\/www\/config\.inc\.php");|g' /var/www/install.php && \
    chown -R www-data:www-data /var/www && \
    rm -f typecho.tgz

COPY docker/favicon.ico /var/www

COPY docker/plugins.sh /plugins.sh
RUN chmod +x /plugins.sh && sh /plugins.sh

COPY docker/run.sh /run.sh
RUN chmod +x /run.sh

# grant all privileges to www-data
RUN usermod -u 1000 www-data

WORKDIR /var/www
EXPOSE 80

VOLUME /data

COPY docker/config/nginx.conf /etc/nginx/nginx.conf
ENTRYPOINT [ "sh", "/run.sh" ]
