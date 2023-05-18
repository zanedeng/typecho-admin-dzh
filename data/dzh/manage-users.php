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
    <div class="breadcrumb-title pe-3"><?php _e('用户管理') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('用户管理') ?></li>
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
        <a class="btn btn-outline-info px-4 mx-2" href="<?php $options->adminUrl('manage-users.php'); ?>"><?php _e('取消筛选'); ?></a>
      <?php endif; ?>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto"></div>
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2 justify-content-lg-end">
          <button
            class="btn btn-outline-danger px-4 btn-operate"
            lang="<?php _e('你确认要删除这些用户吗?'); ?>"
            href="<?php $security->index('/action/users-edit?do=delete'); ?>"
          >
            <i class="bi bi-trash me-2"></i><?php _e('删除') ?>
          </button>
          <a class="btn btn-primary px-4" href="<?php $options->adminUrl('user.php') ?>">
            <i class="bi bi-plus-lg me-2"></i><?php _e('新增用户') ?>
          </a>
      </div>
    </div>
  </div><!--end row-->
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" name="manage_users" class="operate-form">
            <table class="table align-middle">
              <colgroup>
                <col width="20"/>
                <col width="6%"/>
                <col width="30%"/>
                <col width=""/>
                <col width="25%"/>
                <col width="15%"/>
              </colgroup>
              <thead class="table-light">
                <tr>
                  <th><input id="checkAll" class="form-check-input" type="checkbox"></th>
                  <th> </th>
                  <th><?php _e('用户名'); ?></th>
                  <th><?php _e('昵称'); ?></th>
                  <th><?php _e('电子邮件'); ?></th>
                  <th><?php _e('用户组'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php Typecho_Widget::widget('Widget_Users_Admin')->to($users); ?>
                  <?php while($users->next()): ?>
                  <tr id="user-<?php $users->uid(); ?>">
                    <td><input type="checkbox" class="form-check-input" value="<?php $users->uid(); ?>" name="uid[]"/></td>
                    <td>
                      <a 
                        href="<?php $options->adminUrl('manage-posts.php?uid=' . $users->uid); ?>" 
                        class="badge bg-primary size-<?php echo Typecho_Common::splitByCount($users->postsNum, 1, 10, 20, 50, 100); ?>"
                      >
                        <?php $users->postsNum(); ?>
                      </a>
                    </td>
                    <td><a href="<?php $options->adminUrl('user.php?uid=' . $users->uid); ?>"><?php $users->name(); ?></a>
                    <a href="<?php $users->permalink(); ?>" title="<?php _e('浏览 %s', $users->screenName); ?>"><i class="i-exlink"></i></a>
                    </td>
                    <td><?php $users->screenName(); ?></td>
                    <td><?php if($users->mail): ?><a href="mailto:<?php $users->mail(); ?>"><?php $users->mail(); ?></a><?php else: _e('暂无'); endif; ?></td>
                    <td><?php switch ($users->group) {
                        case 'administrator':
                            _e('管理员');
                            break;
                        case 'editor':
                            _e('编辑');
                            break;
                        case 'contributor':
                            _e('贡献者');
                            break;
                        case 'subscriber':
                            _e('关注者');
                            break;
                        case 'visitor':
                            _e('访问者');
                            break;
                        default:
                            break;
                    } ?></td>
                  </tr>
                  <?php endwhile; ?>
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
