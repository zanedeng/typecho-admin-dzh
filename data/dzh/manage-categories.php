<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
Typecho_Widget::widget('Widget_Metas_Category_Admin')->to($categories);
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('分类管理') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <form method="post" name="manage_categories" class="operate-form">
  <div class="row g-2">
    <div class="col-12 col-md-6">
      <a class="btn btn-sm btn-primary px-4" href="<?php $options->adminUrl('category.php') ?>">
        <i class="bi bi-plus-lg me-2"></i><?php _e('新增分类') ?>
      </a>
    </div>
    <div class="col-12 col-md-6">
      <div class="d-flex align-items-center justify-content-lg-end">
        <button
          class="btn btn-sm btn-outline-danger me-2 btn-operate w-25"
          lang="<?php _e('此分类下的所有内容将被删除, 你确认要删除这些分类吗?'); ?>"
          href="<?php $security->index('/action/metas-category-edit?do=delete'); ?>"
        >
          <i class="bi bi-trash me-2"></i><?php _e('删除') ?>
        </button>
        <button
          class="btn btn-sm btn-outline-warning me-2 btn-operate w-25"
          lang="<?php _e('刷新分类可能需要等待较长时间, 你确认要刷新这些分类吗?'); ?>"
          href="<?php $security->index('/action/metas-category-edit?do=refresh'); ?>">
          <i class="bi bi-arrow-repeat me-2"></i><?php _e('刷新'); ?>
        </button>
        <button
          class="btn btn-sm btn-primary btn-operate rounded-end-0"
          style="width: 10rem;"
          href="<?php $security->index('/action/metas-category-edit?do=merge'); ?>"
        >
          <?php _e('合并到'); ?>
        </button>
        <select class="form-select form-select-sm rounded-start-0 flex-grow-1" name="merge">
          <?php $categories->parse('<option value="{mid}">{name}</option>'); ?>
        </select>
      </div>
    </div>
  </div><!--end row-->
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
            <table class="table align-middle">
              <colgroup>
                <col width="20"/>
                <col width=""/>
                <col width="10%"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="10%"/>
                <col width="15%"/>
              </colgroup>
              <thead class="table-light">
                <tr class="nodrag">
                  <th><input id="checkAll" class="form-check-input" type="checkbox"></th>
                  <th><?php _e('名称'); ?></th>
                  <th><?php _e('子分类'); ?></th>
                  <th><?php _e('缩略名'); ?></th>
                  <th></th>
                  <th><?php _e('文章数'); ?></th>
                  <th><?php _e('操作'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if($categories->have()): ?>
                <?php while ($categories->next()): ?>
                <tr id="mid-<?php $categories->theId(); ?>">
                  <td>
                    <input type="checkbox" class="form-check-input" value="<?php $categories->mid(); ?>" name="mid[]"/>
                  </td>
                  <td>
                    <a href="<?php $options->adminUrl('category.php?mid=' . $categories->mid); ?>"><?php $categories->name(); ?></a>

                  </td>
                  <td>
                    <?php if (count($categories->children) > 0): ?>
                    <a href="<?php $options->adminUrl('manage-categories.php?parent=' . $categories->mid); ?>"><?php echo _n('一个分类', '%d个分类', count($categories->children)); ?></a>
                    <?php else: ?>
                    <a href="<?php $options->adminUrl('category.php?parent=' . $categories->mid); ?>"><?php echo _e('新增'); ?></a>
                    <?php endif; ?>
                  </td>
                  <td><?php $categories->slug(); ?></td>
                  <td>
                    <?php if ($options->defaultCategory == $categories->mid): ?>
                    <?php _e('默认'); ?>
                    <?php else: ?>
                    <a class="hidden-by-mouse" href="<?php $security->index('/action/metas-category-edit?do=default&mid=' . $categories->mid); ?>" title="<?php _e('设为默认'); ?>"><?php _e('默认'); ?></a>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a class="badge bg-primary size-<?php echo Typecho_Common::splitByCount($categories->count, 1, 10, 20, 50, 100); ?>"
                      href="<?php $options->adminUrl('manage-posts.php?category=' . $categories->mid); ?>">
                      <?php $categories->count(); ?>
                    </a>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="<?php $options->adminUrl('category.php?mid=' . $categories->mid); ?>">
                      <span class="material-symbols-outlined">edit</span>
                      <label><?php _e('编辑') ?></label>
                    </a>
                    <a class="btn btn-sm btn-outline-info mx-2" href="<?php $categories->permalink(); ?>" title="<?php _e('浏览 %s', $categories->name); ?>">
                      <span class="material-symbols-outlined">eyeglasses</span>
                      <label><?php _e('浏览') ?></label>
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                  <td colspan="6"><h6 class="typecho-list-table-title"><?php _e('没有任何分类'); ?></h6></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
  </form>
</main>
<!--end main content-->
<?php
include 'footer-js.php';
?>
<script src="<?php $options->adminStaticUrl('assets/js', 'typecho.js?v=' . $suffixVersion); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
  var table = $('.table').tableDnD({
      onDrop : function () {
        var ids = [];

        $('input[type=checkbox]', table).each(function () {
            ids.push($(this).val());
        });

        $.post('<?php $security->index('/action/metas-category-edit?do=sort'); ?>',
            $.param({mid : ids}));

        $('tr', table).each(function (i) {
            if (i % 2) {
                $(this).addClass('even');
            } else {
                $(this).removeClass('even');
            }
        });
      }
  });
});
</script>
<?php
include 'table-js.php';
include 'footer.php';
?>
