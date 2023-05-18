<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

Typecho_Widget::widget('Widget_Stat')->to($stat);
Typecho_Widget::widget('Widget_Contents_Attachment_Admin')->to($attachments);
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('文件管理') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row g-3">
    <div class="col-auto hstack">
      <div class="position-relative">
        <form id="search-form" method="get">
          <input
            class="form-control px-5"
            type="search"
            placeholder="<?php _e('请输入关键字') ?>"
            name="keywords"
            value="<?php echo htmlspecialchars($request->keywords); ?>"
          >
          <span class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
        </form>
      </div>
      <?php if ('' != $request->keywords): ?>
        <a class="btn btn-outline-info px-4 mx-2" href="<?php $options->adminUrl('manage-medias.php'); ?>"><?php _e('取消筛选'); ?></a>
      <?php endif; ?>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto"></div>
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2 justify-content-lg-end">
          <button
            class="btn btn-outline-danger px-4 btn-operate"
            lang="<?php _e('你确认要删除这些文件吗?'); ?>"
            href="<?php $security->index('/action/contents-attachment-edit?do=delete'); ?>"
          >
            <i class="bi bi-trash me-2"></i><?php _e('删除') ?>
          </button>
          <button
            class="btn btn-outline-warning px-4 btn-operate"
            lang="<?php _e('您确认要清理未归档的文件吗?'); ?>"
            href="<?php $security->index('/action/contents-attachment-edit?do=clear'); ?>"
          >
            <i class="bi bi-radioactive me-2"></i><?php _e('清理未归档文件') ?>
          </button>
      </div>
    </div>
  </div><!--end row-->
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" name="manage_medias" class="operate-form">
          <table class="table align-middle">
            <colgroup>
              <col width="20"/>
              <col width="6%"/>
              <col width="30%"/>
              <col width=""/>
              <col width="30%"/>
              <col width="16%"/>
            </colgroup>
            <thead class="table-light">
              <tr>
                <th><input id="checkAll" class="form-check-input" type="checkbox"></th>
                <th> </th>
                <th><?php _e('文件名'); ?></th>
                <th><?php _e('上传者'); ?></th>
                <th><?php _e('所属文章'); ?></th>
                <th><?php _e('发布日期'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if($attachments->have()): ?>
                <?php while($attachments->next()): ?>
                <?php $mime = Typecho_Common::mimeIconType($attachments->attachment->mime); ?>
                <tr id="<?php $attachments->theId(); ?>">
                  <td><input type="checkbox" class="form-check-input" value="<?php $attachments->cid(); ?>" name="cid[]"/></td>
                  <td><a href="<?php $options->adminUrl('manage-comments.php?cid=' . $attachments->cid); ?>" class="balloon-button size-<?php echo Typecho_Common::splitByCount($attachments->commentsNum, 1, 10, 20, 50, 100); ?>"><?php $attachments->commentsNum(); ?></a></td>
                  <td>
                  <i class="mime-<?php echo $mime; ?>"></i>
                  <a href="<?php $options->adminUrl('media.php?cid=' . $attachments->cid); ?>"><?php $attachments->title(); ?></a>
                  <a href="<?php $attachments->permalink(); ?>" title="<?php _e('浏览 %s', $attachments->title); ?>"><i class="i-exlink"></i></a>
                  </td>
                  <td><?php $attachments->author(); ?></td>
                  <td>
                  <?php if ($attachments->parentPost->cid): ?>
                  <a href="<?php $options->adminUrl('write-' . (0 === strpos($attachments->parentPost->type, 'post') ? 'post' : 'page') . '.php?cid=' . $attachments->parentPost->cid); ?>"><?php $attachments->parentPost->title(); ?></a>
                  <?php else: ?>
                  <span class="description"><?php _e('未归档'); ?></span>
                  <?php endif; ?>
                  </td>
                  <td><?php $attachments->dateWord(); ?></td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                  <td colspan="6"><h6 class="typecho-list-table-title"><?php _e('没有任何文件'); ?></h6></td>
                </tr>
                <?php endif; ?>
            </tbody>
          </table>
          </form>
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
  
});
</script>
<?php
include 'table-js.php';
include 'footer.php';
?>
