<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

Typecho_Widget::widget('Widget_Themes_Files')->to($files);
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
                class="nav-link"
                href="<?php $options->adminUrl('themes.php'); ?>"
                role="tab"
                aria-selected="false"
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
                class="nav-link active"
                data-bs-toggle="tab"
                href="#primaryhome"
                role="tab"
                aria-selected="true"
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
              <div class="row">
                <div class="col-12 col-lg-3">
                  <div class="card overflow-hidden">
                    <div class="card-body">
                      <h5 class="mt-3 mb-0"><?php _e('模板文件') ?></h5>
                    </div>
                    <div class="fm-menu">
                      <div class="list-group list-group-flush">
                        <?php while($files->next()): ?>
                        <a
                          class="list-group-item py-1 border-top <?php if($files->current): ?>bg-primary text-white<?php endif; ?>"
                          href="<?php $options->adminUrl('theme-editor.php?theme=' . $files->currentTheme() . '&file=' . $files->file); ?>">
                          <i class="bx bx-folder me-2"></i>
                          <span><?php $files->file(); ?></span>
                        </a>
                        <?php endwhile; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-lg-9">
                  <div class="card">
                    <div class="card-body">
                      <form method="post" name="theme" id="theme" action="<?php $security->index('/action/themes-edit'); ?>">
                        <label for="content" class="sr-only"><?php _e('编辑源码'); ?></label>
                        <textarea name="content" id="content" class="form-control" rows="20"  <?php if(!$files->currentIsWriteable()): ?>readonly<?php endif; ?>><?php echo $files->currentContent(); ?></textarea>
                        <div class="col-md-12 mt-3">
                          <?php if($files->currentIsWriteable()): ?>
                          <input type="hidden" name="theme" value="<?php echo $files->currentTheme(); ?>" />
                          <input type="hidden" name="edit" value="<?php echo $files->currentFile(); ?>" />
                          <button type="submit" class="btn btn-primary px-4"><?php _e('保存文件'); ?></button>
                          <?php else: ?>
                              <em><?php _e('此文件无法写入'); ?></em>
                          <?php endif; ?>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!--end main content-->
<?php
include 'footer.php';
?>
