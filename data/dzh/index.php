<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$stat = Typecho_Widget::widget('Widget_Stat');
?>
<!--start main content-->
<main class="page-content">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-4 row-cols-xxl-4">
    <div class="col">
      <div class="card radius-10 border-0 border-start border-primary border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="">
              <p class="mb-1"><?php _e('文章数量') ?></p>
              <h4 class="mb-0 text-primary"><?php $stat->myPublishedPostsNum() ?></h4>
            </div>
            <div class="ms-auto widget-icon bg-primary text-white">
              <i class="bi bi-journal-bookmark"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card radius-10 border-0 border-start border-success border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="">
              <p class="mb-1"><?php _e('评论数量') ?></p>
              <h4 class="mb-0 text-success"><?php $stat->myPublishedCommentsNum() ?></h4>
            </div>
            <div class="ms-auto widget-icon bg-success text-white">
              <i class="bi bi-chat-text"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card radius-10 border-0 border-start border-danger border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="">
              <p class="mb-1"><?php _e('文章分类数量') ?></p>
              <h4 class="mb-0 text-danger"><?php $stat->categoriesNum() ?></h4>
            </div>
            <div class="ms-auto widget-icon bg-danger text-white">
              <i class="bi bi-tags"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if($options->allowRegister): ?>
    <div class="col">
      <div class="card radius-10 border-0 border-start border-warning border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="">
              <p class="mb-1"><?php _e('会员数量') ?></p>
              <h4 class="mb-0 text-warning">214</h4>
            </div>
            <div class="ms-auto widget-icon bg-warning text-dark">
              <i class="bi bi-people-fill"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <!--end row-->
</main>
<!--end main content-->
<?php
include 'footer-js.php';
include 'footer.php';
?>
