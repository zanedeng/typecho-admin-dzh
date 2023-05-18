<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
Typecho_Widget::widget('Widget_Metas_Tag_Admin')->to($tags);
$form = Typecho_Widget::widget('Widget_Metas_Tag_Edit')->form();
$form->setAttribute('class', 'row g-3 needs-validation')
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('标签管理') ?></li>
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
      <div class="card mt-4">
        <div class="card-body">
          <form method="post" name="manage_tags" class="operate-form">
            <div class="d-flex align-items-center justify-content-lg-end">
              <button
                class="btn btn-sm btn-outline-danger me-2 btn-operate w-auto"
                lang="<?php _e('你确认要删除这些标签吗?'); ?>"
                href="<?php $security->index('/action/metas-tag-edit?do=delete'); ?>"
              >
                <i class="bi bi-trash me-2"></i><?php _e('删除') ?>
              </button>
              <button
                class="btn btn-sm btn-outline-warning me-2 btn-operate"
                lang="<?php _e('刷新标签可能需要等待较长时间, 你确认要刷新这些标签吗?'); ?>"
                href="<?php $security->index('/action/metas-tag-edit?do=refresh'); ?>">
                <i class="bi bi-arrow-repeat me-2"></i><?php _e('刷新'); ?>
              </button>
              <button
                class="btn btn-sm btn-primary btn-operate rounded-end-0"
                style="width: 10rem;"
                href="<?php $security->index('/action/metas-tag-edit?do=merge'); ?>"
              >
                <?php _e('合并到'); ?>
              </button>
              <input type="text" name="merge" class="form-control form-control-sm rounded-start-0 w-25" />
            </div>
            <hr>
            <ul class="list-notable tag-list clearfix">
              <?php if($tags->have()): ?>
              <?php while ($tags->next()): ?>
              <li class="size-<?php $tags->split(5, 10, 20, 30); ?>" id="<?php $tags->theId(); ?>">
                <input type="checkbox" value="<?php $tags->mid(); ?>" name="mid[]"/>
                <span rel="<?php echo $request->makeUriByRequest('mid=' . $tags->mid); ?>"><?php $tags->name(); ?></span>
                <a class="tag-edit-link" href="<?php echo $request->makeUriByRequest('mid=' . $tags->mid); ?>">
                  <i class="bi bi-pencil-square"></i>
                </a>
              </li>
              <?php endwhile; ?>
              <?php else: ?>
              <h6><?php _e('没有任何标签'); ?></h6>
              <?php endif; ?>
            </ul>
            <input type="hidden" name="do" value="delete" />
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card mt-4">
        <div class="card-body">
          <?php $form->render(); ?>
        </div>
      </div>
    </div>
  </div>
</main>
<!--end main content-->
<?php
include 'footer-js.php';
?>
<script src="<?php $options->adminStaticUrl('assets/js', 'typecho.js?v=' . $suffixVersion); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
  $('.list-notable').tableSelectable({
    checkEl     :   'input[type=checkbox]:not("#checkAll")',
    rowEl       :   'li',
    selectAllEl :   '#checkAll',
    actionEl    :   'button.btn-operate'
  });
});
</script>
<?php
include 'footer.php';
?>
