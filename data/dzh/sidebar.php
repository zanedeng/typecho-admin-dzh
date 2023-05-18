<?php

if(!defined('__TYPECHO_ADMIN__')) exit;
$group = array(
  'subscriber' => _t('关注者'),
  'contributor' => _t('贡献者'),
  'editor' => _t('编辑'),
  'administrator' => _t('管理员')
);

?>
<!--start sidebar-->
<aside class="sidebar-wrapper">
  <div class="sidebar-header">
    <div class="logo-icon">
      <img src="assets/images/logo-icon.svg" class="logo-img" alt="">
    </div>
    <div class="logo-name flex-grow-1">
      <h5 class="mb-0"><?php echo $options->title ?></h5>
    </div>
    <div class="sidebar-close ">
      <span class="material-symbols-outlined">close</span>
    </div>
  </div>
  <div class="sidebar-nav" data-simplebar="true">
    <!--navigation-->
    <ul class="metismenu" id="menu">
      <li>
        <a href="<?php $options->adminUrl('index.php'); ?>">
          <div class="parent-icon">
            <span class="material-symbols-outlined">home</span>
          </div>
          <div class="menu-title"><?php _e('控制面板') ?></div>
        </a>
      </li>
      <?php $menu->output(); ?>
    </ul>
    <!--end navigation-->
  </div>
  <div class="sidebar-bottom dropdown dropup-center dropup">
    <div class="dropdown-toggle d-flex align-items-center px-3 gap-3 w-100 h-100" data-bs-toggle="dropdown">
      <div class="user-img">
        <img src="<?php echo Typecho_Common::gravatarUrl($user->mail, 220, 'X', 'mm', $request->isSecure()) ?>" alt="<?php echo $user->screenName ?>">
      </div>
      <div class="user-info">
        <h5 class="mb-0 user-name"><?php $user->screenName(); ?></h5>
        <p class="mb-0 user-designation"><?php echo $group[$user->group]; ?></p>
      </div>
    </div>
    <ul class="dropdown-menu dropdown-menu-end">
      <li>
        <a class="dropdown-item" href="<?php $options->adminUrl('profile.php'); ?>">
          <span class="material-symbols-outlined me-2">account_circle</span>
          <span><?php _e('个人设置') ?></span>
        </a>
      </li>
      <li>
        <div class="dropdown-divider mb-0"></div>
      </li>
      <li>
        <a class="dropdown-item" href="<?php $options->logoutUrl(); ?>">
          <span class="material-symbols-outlined me-2">logout</span>
          <span><?php _e('退出') ?></span>
        </a>
      </li>
    </ul>
  </div>
</aside>
<!--end sidebar-->

<!--start overlay-->
<div class="overlay btn-toggle-menu"></div>
<!--end overlay-->
