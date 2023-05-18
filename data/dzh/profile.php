<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$stat = Typecho_Widget::widget('Widget_Stat');

$profileForm = Typecho_Widget::widget('Widget_Users_Profile')->profileForm();
$profileForm->setAttribute('class', 'row g-3 needs-validation');

$optionsForm = Typecho_Widget::widget('Widget_Users_Profile')->optionsForm();
$optionsForm->setAttribute('class', 'row g-3 needs-validation');

$passwordForm = Typecho_Widget::widget('Widget_Users_Profile')->passwordForm();
$passwordForm->setAttribute('class', 'row g-3 needs-validation');

$passwordForm->getInput('password')->input->setAttribute('class', 'form-control');
$passwordForm->getInput('confirm')->input->setAttribute('class', 'form-control');
?>

<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('个人设置') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('个人设置') ?></li>
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
          <h5><?php _e('个人资料'); ?></h5>
          <hr>
          <?php $profileForm->render(); ?>
        </div>
      </div>
      <?php if($user->pass('contributor', true)): ?>
      <div class="card">
        <div class="card-body">
          <h5><?php _e('撰写设置'); ?></h5>
          <hr>
          <?php $optionsForm->render(); ?>
        </div>
      </div>
      <?php endif; ?>
      <div class="card">
        <div class="card-body">
          <h5><?php _e('密码修改'); ?></h5>
          <hr>
          <?php $passwordForm->render(); ?>
        </div>
      </div>
      <?php Typecho_Widget::widget('Widget_Users_Profile')->personalFormList(); ?>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card w-100">
        <div class="card-body">
          <div class="customer-profile text-center">
            <a href="http://gravatar.com/emails/" title="<?php _e('在 Gravatar 上修改头像'); ?>">
              <?php echo '<img src="' . Typecho_Common::gravatarUrl($user->mail, 220, 'X', 'mm', $request->isSecure()) . '" class="rounded-circle" alt="' . $user->screenName . '" />'; ?>
            </a>
            <div class="mt-4">
              <h5 class="mb-1 customer-name fw-bold"><?php $user->screenName(); ?></h5>
              <p class="mb-0 customer-designation"><?php $user->name(); ?></p>
            </div>
            <div class="customer-social-profiles mt-4 d-flex align-items-center justify-content-center gap-3">
              
            </div>
          </div>
        </div>
        <div class="hstack align-items-center justify-content-between p-3 border-top">
          <div class="">
              <p class="mb-1 font-text1"><?php _e('日志数量') ?></p>
              <h6 class="mb-0 fw-bold text-center"><?php $stat->myPublishedPostsNum() ?></h6>
          </div>
          <div class="vr"></div>
          <div class="">
            <p class="mb-1 font-text1"><?php _e('评论数') ?></p>
            <h6 class="mb-0 fw-bold text-center"><?php $stat->myPublishedCommentsNum() ?></h6>
          </div>
          <div class="vr"></div>
          <div class="">
            <p class="mb-1 font-text1"><?php _e('分类数') ?></p>
            <h6 class="mb-0 fw-bold text-center"><?php $stat->categoriesNum() ?></h6>
          </div>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
          <?php
            if ($user->logged > 0) {
              $logged = new Typecho_Date($user->logged);
              _e('最后登录: %s', $logged->word());
            }
          ?>
          </li>
        </ul>
      </div>
    </div>
  </div>
</main>
<!--end main content-->
<?php
include 'footer-js.php';
include 'footer.php';
?>