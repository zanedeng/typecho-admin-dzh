#!/bin/sh
set -e

# 移除 typecho 项目中的 usr 目录
# 并为 typecho 项目中的 usr 目录在项目的 data/usr 位置建立一个同步的链接。
[ ! -L /var/www/usr ] && \
	rm -r /var/www/usr && \
	ln -s /data/usr /var/www/usr && \

# 为 typecho 项目的管理界面代码目录在项目的 data/dzh 位置建立一个同步的链接。
[ ! -L /var/www/dzh ] && \
	ln -s /data/dzh /var/www/dzh && \

# 移除 typecho 项目中的 var/Typecho/Widget/Helper/Form 目录
# 为 typecho 项目的 var/Typecho/Widget/Helper/Form 目录在项目的 data/var/Typecho/Widget/Helper/Form 位置建立一个同步的链接。
[ ! -L /var/www/var/Typecho/Widget/Helper/Form ] && \
[ -e /data/var/Typecho/Widget/Helper/Form ] && \
  rm -r /var/www/var/Typecho/Widget/Helper/Form
	ln -sf /data/var/Typecho/Widget/Helper/Form /var/www/var/Typecho/Widget/Helper/Form

# 移除 typecho 项目中的 var/Widget/Menu.php 文件
# 为 typecho 项目的 var/Widget/Menu.php 在项目的 data/Widget/Menu.php 位置建立一个同步的链接。
[ ! -L /var/www/var/Widget/Menu.php ] && \
[ -e /data/var/Widget/Menu.php ] && \
  rm -r /var/www/var/Widget/Menu.php
	ln -sf /data/var/Widget/Menu.php /var/www/var/Widget/Menu.php

# 判断根目录下的 config.inc.php 文件是不是软链接
# 如果不是，同时 data 目录下又存在 config.inc.php 文件, 则为根目录下的 config.inc.php 创建软连接
[ ! -L /var/www/config.inc.php ] && \
[ -e /data/config.inc.php ] && \
	ln -sf /data/config.inc.php /var/www/config.inc.php

if [ -e /data/config.inc.php ] && ! grep -q '__TYPECHO_SITE_URL__' /data/config.inc.php; then
	sed -i "s|define('__TYPECHO_ROOT_DIR__', '/var/www');.*|define('__TYPECHO_ROOT_DIR__', '/var/www'); define('__TYPECHO_SITE_URL__', '/');|i" /data/config.inc.php
fi

chown -R www-data:www-data /data
chmod -R a+rw /data
chown -R www-data:www-data /var/www

php-fpm&
nginx
