<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$config = Typecho_Widget::widget('Widget_Plugins_Config')->config();
$config->setAttribute('class', 'row g-3 needs-validation')
?>

<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('其他') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('设置插件') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="card mt-4">
    <div class="card-body">
    <?php $config->render(); ?>
    </div>
  </div>
</main>
<!--end main content-->
<?php
include 'footer-js.php';
include 'footer.php';
?>
