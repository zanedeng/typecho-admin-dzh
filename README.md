<div align="center"> <a href="https://github.com/zanedeng/typecho-admin-dzh"> <img alt="Typecho Admin DZH Logo" width="200" height="200" src="./logo.svg"> </a> <br> <br>

[![license](https://img.shields.io/github/license/zanedeng/typecho-admin-dzh.svg)](LICENSE)

<h1>Typecho Admin DZH</h1>
</div>

### 简介
---
这是一套 Typecho 后台管理界面的项目，它使用 Bootstrap 5 框架构建。可以在所有主要的Web浏览器、桌面和所有智能手机设备上运行，提供浅色/深色两条主题，旨在提供更好的用户视觉体验。

## 安装使用
---
- docker 安装（推荐使用方式）

```bash
docker build -f ./docker/Dockerfile -t typecho-admin-dzh .
```

```bash
docker run -it --rm \
    -p 8080:80 \
    --mount type=tmpfs,destination=/tmp \
    -e APP_DEBUG=true \
    -e PHP_MAX_EXECUTION_TIME=1800 \
    -v {你的项目所在目录}/typecho-admin-dzh/data:/data \
    typecho-admin-dzh:latest
```

- 替换文件部署

1. 下载官网的最新版本，并解压到你需要放置项目的地方

```bash
 wget http://typecho.org/build.tar.gz -O typecho.tgz && \
 tar zxvf typecho.tgz && \
 mv build/* /var/www
```
2. 替换 `install.php` 文件中的后台路径如下:

```bash
/** 后台路径(相对路径) */
define('__TYPECHO_ADMIN_DIR__', '/dzh/');
```
具体的后台路径 `dzh` 可以根据你自己修改后的目录而定。修改 `install.php` 是为了在安装生成 `config.inc.php` 文件，如果你的项目是已经安装过的，可以直接修改`config.inc.php` 文件对应的内容。

3. 用项目中 `data/var/Typecho/Widget/Helper/Form` 目录下的所有文件替换 Tyecho 项目中的对应文件，这里主要是为了适配主题，对表单组件进行了修改。
4. 用项目中 `data/var/Widget/Menu.php` 目录下文件替换 Tyecho 项目中的对应文件，这里主要是对后台菜单做了相应的修改。

## 截图
---
<p align="center">
    <img alt="Typecho Admin DZH Screenshot" width="100%" src="./screenshots/05.png">
    <br>
    <br>
    <img alt="Typecho Admin DZH Screenshot" width="100%" src="./screenshots/04.png">
    <br>
    <br>
    <img alt="Typecho Admin DZH Screenshot" width="100%" src="./screenshots/03.png">
    <br>
    <br>
    <img alt="Typecho Admin DZH Screenshot" width="100%" src="./screenshots/02.png">
    <br>
    <br>
    <img alt="Typecho Admin DZH Screenshot" width="100%" src="./screenshots/01.png">
    <br>
    <br>
</p>
