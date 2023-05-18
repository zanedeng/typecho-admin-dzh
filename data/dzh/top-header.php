<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<!--start header-->
<header class="top-header">
  <nav class="navbar navbar-expand justify-content-between">
    <div class="btn-toggle-menu">
      <span class="material-symbols-outlined">menu</span>
    </div>
    <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <input class="form-control form-control-sm rounded-5 px-5" disabled type="search" placeholder="<?php _e('搜索') ?>">
      <span class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
    </div>
    <ul class="navbar-nav top-right-menu gap-2">
      <li class="nav-item d-lg-none d-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <a class="nav-link" href="javascript:;">
          <span class="material-symbols-outlined">search</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="javascript:;">
          <span class="material-symbols-outlined">visibility</span>
        </a>
      </li>
      <li class="nav-item dark-mode">
        <a class="nav-link dark-mode-icon" href="javascript:;">
          <span class="material-symbols-outlined">dark_mode</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" href="#ThemeCustomizer">
          <span class="material-symbols-outlined">settings</span>
        </a>
      </li>
    </ul>
  </nav>
</header>
<!--end header-->

<!-- Search Modal -->
<div class="modal" id="exampleModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header gap-2">
        <div class="position-relative popup-search w-100">
          <input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search" placeholder="Search">
          <span class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
        </div>
        <button type="button" class="btn-close d-xl-none" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="search-list">
          </div>
      </div>
    </div>
  </div>
</div>

<!--start theme customization-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="ThemeCustomizer" aria-labelledby="ThemeCustomizerLable">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="ThemeCustomizerLable"><?php _e('主题定制器') ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <h6 class="mb-0"><?php _e('主题变化') ?></h6>
    <hr>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="LightTheme" value="option1">
      <label class="form-check-label" for="LightTheme"><?php _e('浅色') ?></label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="DarkTheme" value="option2" checked="">
      <label class="form-check-label" for="DarkTheme"><?php _e('深色') ?></label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="SemiDarkTheme" value="option3">
      <label class="form-check-label" for="SemiDarkTheme"><?php _e('半深色') ?></label>
    </div>
    <hr>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="MinimalTheme" value="option3">
      <label class="form-check-label" for="MinimalTheme"><?php _e('极简主题') ?></label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="inlineRadioOptions" id="ShadowTheme" value="option4">
      <label class="form-check-label" for="ShadowTheme"><?php _e('阴影主题') ?></label>
    </div>
  </div>
</div>
<!--end theme customization-->
