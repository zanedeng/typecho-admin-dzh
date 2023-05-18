<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('页面管理') ?></li>
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
        <a class="btn btn-outline-info px-4 mx-2" href="<?php $options->adminUrl('manage-pages.php'); ?>"><?php _e('取消筛选'); ?></a>
      <?php endif; ?>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto"></div>
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2 justify-content-lg-end">
          <button
            class="btn btn-outline-danger px-4 btn-operate"
            lang="<?php _e('你确认要删除这些页面吗?'); ?>"
            href="<?php $security->index('/action/contents-page-edit?do=delete'); ?>"
          >
            <i class="bi bi-trash me-2"></i><?php _e('删除') ?>
          </button>
          <a class="btn btn-primary px-4" href="<?php $options->adminUrl('write-page.php') ?>">
            <i class="bi bi-plus-lg me-2"></i><?php _e('新增页面') ?>
          </a>
      </div>
    </div>
  </div><!--end row-->
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" id="manage_pages">
            <table class="table align-middle">
              <colgroup>
                <col width="20"/>
                <col width="5%"/>
                <col width=""/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
              </colgroup>
              <thead class="table-light">
                <tr class="nodrag">
                  <th>
                    <input id="checkAll" class="form-check-input" type="checkbox">
                  </th>
                  <th></th>
                  <th><?php _e('标题'); ?></th>
                  <th><?php _e('缩略名'); ?></th>
                  <th><?php _e('作者'); ?></th>
                  <th><?php _e('日期'); ?></th>
                  <th><?php _e('操作') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php Typecho_Widget::widget('Widget_Contents_Page_Admin')->to($pages); ?>
                <?php if($pages->have()): ?>
                  <?php while($pages->next()): ?>
                  <tr id="<?php $pages->theId(); ?>">
                    <td><input type="checkbox" class="form-check-input" value="<?php $pages->cid(); ?>" name="cid[]"/></td>
                    <td><a href="<?php $options->adminUrl('manage-comments.php?cid=' . $pages->cid); ?>" class="badge bg-primary size-<?php echo Typecho_Common::splitByCount($pages->commentsNum, 1, 10, 20, 50, 100); ?>" title="<?php $pages->commentsNum(); ?> <?php _e('评论'); ?>"><?php $pages->commentsNum(); ?></a></td>
                    <td>
                      <a href="<?php $options->adminUrl('write-page.php?cid=' . $pages->cid); ?>"><?php $pages->title(); ?></a>
                      <?php
                      if ($pages->hasSaved || 'page_draft' == $pages->type) {
                          echo '<em class="status">' . _t('草稿') . '</em>';
                      } else if ('hidden' == $pages->status) {
                          echo '<em class="status">' . _t('隐藏') . '</em>';
                      }
                      ?>
                    </td>
                    <td><?php $pages->slug(); ?></td>
                    <td><?php $pages->author(); ?></td>
                    <td>
                      <?php if ($pages->hasSaved): ?>
                      <span class="description">
                      <?php $modifyDate = new Typecho_Date($pages->modified); ?>
                      <?php _e('保存于 %s', $modifyDate->word()); ?>
                      </span>
                      <?php else: ?>
                      <?php $pages->dateWord(); ?>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a class="btn btn-sm btn-outline-primary" href="<?php $options->adminUrl('write-page.php?cid=' . $pages->cid); ?>">
                        <span class="material-symbols-outlined">edit</span>
                        <label><?php _e('编辑') ?></label>
                      </a>
                      <?php if ('page_draft' != $pages->type): ?>
                      <a class="btn btn-sm btn-outline-info mx-2" href="<?php $pages->permalink(); ?>" title="<?php _e('浏览 %s', htmlspecialchars($posts->title)); ?>">
                        <span class="material-symbols-outlined">eyeglasses</span>
                        <label><?php _e('预览') ?></label>
                      </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7"><h6 class="typecho-list-table-title"><?php _e('没有任何页面'); ?></h6></td>
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
<?php
include 'table-js.php';
include 'footer.php';
?>
