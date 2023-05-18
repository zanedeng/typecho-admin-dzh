<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
$form = Typecho_Widget::widget('Widget_Users_Edit')->form();
$form->setAttribute('class', 'row g-3 needs-validation');
$password = $form->getInput('password');
$password->input->setAttribute('class', 'form-control');

$confirm = $form->getInput('confirm');
$confirm->input->setAttribute('class', 'form-control');
?>

<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('用户管理') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('新增用户') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
        <?php $form->render(); ?>
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