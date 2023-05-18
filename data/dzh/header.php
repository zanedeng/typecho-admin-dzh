<?php
if (!defined('__TYPECHO_ADMIN__')) {
    exit;
}

$header = '
<!--plugins-->
<link rel="stylesheet" href="' . Typecho_Common::url('perfect-scrollbar.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/plugins/perfect-scrollbar/css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('metisMenu.min.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/plugins/metismenu/css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('simplebar.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/plugins/simplebar/css')) . '">
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<!-- loader-->
<link rel="stylesheet" href="' . Typecho_Common::url('pace.min.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<script src="' . Typecho_Common::url('pace.min.js?v=' . $suffixVersion, $options->adminStaticUrl('assets/js')) . '"></script>

<!--Styles-->
<link rel="stylesheet" href="' . Typecho_Common::url('bootstrap.min.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="' . Typecho_Common::url('icons.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<link rel="stylesheet" href="' . Typecho_Common::url('tagsinput.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/plugins/input-tags/css')) . '" >
<link rel="stylesheet" href="' . Typecho_Common::url('main.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('dark-theme.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('semi-dark-theme.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('minimal-theme.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('shadow-theme.css?v=' . $suffixVersion, $options->adminStaticUrl('assets/css')) . '">
';

/** 注册一个初始化插件 */
$header = Typecho_Plugin::factory('admin/header.php')->header($header);

?>
<!DOCTYPE HTML>
<html data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php _e('%s - %s - Powered by zane.deng', $menu->title, $options->title); ?></title>
    <?php echo $header; ?>
  </head>
  <body>
