<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$phpMaxFilesize = function_exists('ini_get') ? trim(ini_get('upload_max_filesize')) : 0;

if (preg_match("/^([0-9]+)([a-z]{1,2})$/i", $phpMaxFilesize, $matches)) {
    $phpMaxFilesize = strtolower($matches[1] . $matches[2] . (1 == strlen($matches[2]) ? 'b' : ''));
}

Typecho_Widget::widget('Widget_Contents_Attachment_Edit')->to($attachment);
$form = $attachment->form();
$form->setAttribute('class', 'row g-3 needs-validation');
?>
<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('内容管理') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('编辑') ?><?php $attachment->attachment->name() ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card">
        <div class="card-body">
          <?php if ($attachment->attachment->isImage): ?>
          <p><img src="<?php $attachment->attachment->url(); ?>" alt="<?php $attachment->attachment->name(); ?>" class="img-fluid" /></p>
          <?php endif; ?>
          <p>
            <a href=""><strong><?php $attachment->attachment->name(); ?></strong></a>
            <span clas="badge bg-primary">
              <?php echo number_format(ceil($attachment->attachment->size / 1024)); ?> Kb
            </span>
          </p>
          <p>
            <input id="attachment-url" type="text" class="form-control" value="<?php $attachment->attachment->url(); ?>" readonly />
          </p>

          <div id="upload-panel" class="p">
            <div class="upload-area" draggable="true"><?php _e('拖放文件到这里<br>或者 %s选择文件上传%s', '<a href="###" class="upload-file">', '</a>'); ?></div>
            <ul id="file-list"></ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
          <div class="card-body">
          <?php $form->render(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php
include 'footer-js.php';
?>

<?php
include 'footer.php';
?>
