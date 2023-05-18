<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

Typecho_Widget::widget('Widget_Themes_List')->to($themes);
?>
<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('系统设置') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('外观设置') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs nav-primary" role="tablist">
            <li class="nav-item" role="presentation">
              <a
                class="nav-link active"
                data-bs-toggle="tab"
                href="#primaryhome"
                role="tab"
                aria-selected="true"
              >
                <div class="d-flex align-items-center">
                  <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                  </div>
                  <div class="tab-title"><?php _e('可以使用的外观') ?></div>
                </div>
              </a>
            </li>
            <?php if (!defined('__TYPECHO_THEME_WRITEABLE__') || __TYPECHO_THEME_WRITEABLE__): ?>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                href="<?php $options->adminUrl('theme-editor.php'); ?>"
                role="tab"
                aria-selected="false"
              >
                <div class="d-flex align-items-center">
                  <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                  </div>
                  <div class="tab-title"><?php _e('编辑当前外观') ?></div>
                </div>
              </a>
            </li>
            <?php endif; ?>
            <?php if (Widget_Themes_Config::isExists()): ?>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                href="<?php $options->adminUrl('options-theme.php'); ?>"
                role="tab"
                aria-selected="false"
              >
                <div class="d-flex align-items-center">
                  <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                  </div>
                  <div class="tab-title"><?php _e('设置外观') ?></div>
                </div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
          <div class="tab-content py-3">
            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
              <div class="row row-cols-1 row-cols-lg-3 g-3">
                <?php while($themes->next()): ?>
                <div class="col">
                  <div class="card">
                    <img
                      src="<?php strpos($themes->screen, 'noscreen.png') ? $options->adminUrl('assets/images/noscreen.png') : $themes->screen(); ?>"
                      alt="<?php $themes->name(); ?>"
                      class="card-img-top"
                    />
                    <div class="card-body">
                      <h5 class="card-title"><?php '' != $themes->title ? $themes->title() : $themes->name(); ?></h5>
                      <p class="card-text"><?php echo nl2br($themes->description); ?></p>
                      <p class="card-text">
                        <small class="text-muted">
                          <?php if($themes->author): ?>
                            <?php _e('作者'); ?>:
                            <?php if($themes->homepage): ?>
                              <a href="<?php $themes->homepage() ?>">
                            <?php endif; ?>
                            <?php $themes->author(); ?>
                            <?php if($themes->homepage): ?>
                              </a>
                            <?php endif; ?>
                            &nbsp;&nbsp;
                          <?php endif; ?>
                          <?php if($themes->version): ?>
                            <?php _e('版本'); ?>:
                            <?php $themes->version() ?>
                          <?php endif; ?>
                        </small>
                      </p>
                    </div>
                    <div class="card-body">
                      <?php if($options->theme != $themes->name): ?>
                        <?php if (!defined('__TYPECHO_THEME_WRITEABLE__') || __TYPECHO_THEME_WRITEABLE__): ?>
                          <a class="btn btn-primary" href="<?php $options->adminUrl('theme-editor.php?theme=' . $themes->name); ?>"><?php _e('编辑'); ?></a>
                        <?php endif; ?>
                        <a class="btn btn-light" href="<?php $security->index('/action/themes-edit?change=' . $themes->name); ?>"><?php _e('启用'); ?></a>
                      <?php else: ?>
                        <a class="btn btn-primary" href="javascript:;"><?php _e('使用中...'); ?></a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <?php endwhile; ?>
              </div><!--end row-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!--end main content-->
<?php
include 'footer-js.php';
include 'footer.php';
?>
