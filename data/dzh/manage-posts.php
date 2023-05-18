<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$stat = Typecho_Widget::widget('Widget_Stat');
$posts = Typecho_Widget::widget('Widget_Contents_Post_Admin');
$isAllPosts = ('on' == $request->get('__typecho_all_posts') || 'on' == Typecho_Cookie::get('__typecho_all_posts'));

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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('文章管理') ?></li>
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
        <a class="btn btn-outline-info px-4 mx-2" href="<?php $options->adminUrl('manage-posts.php'); ?>"><?php _e('取消筛选'); ?></a>
      <?php endif; ?>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto">
      <div class="btn-group position-static">
        <?php if($user->pass('editor', true) && !isset($request->uid)): ?>
        <div class="btn-group position-static">
          <button type="button" class="btn border btn-light dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
            <?php $isAllPosts ? _e('所有') : _e('我的'); ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('__typecho_all_posts=on'); ?>"><?php _e('所有'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('__typecho_all_posts=off'); ?>"><?php _e('我的'); ?></a></li>
          </ul>
        </div>
        <?php endif; ?>
        <div class="btn-group position-static">
          <button type="button" class="btn border btn-light dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if(!isset($request->status) || 'all' == $request->get('status')): ?>
              <?php _e('可用'); ?>
            <?php elseif ('waiting' == $request->get('status')): ?>
              <?php _e('待审核'); ?>
            <?php elseif ('draft' == $request->get('status')): ?>
              <?php _e('草稿'); ?>
            <?php endif; ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('status=all'); ?>"><?php _e('可用'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('status=waiting'); ?>"><?php _e('待审核'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('status=draft'); ?>"><?php _e('草稿'); ?></a></li>
          </ul>
        </div>
        <div class="btn-group position-static">
          <?php Typecho_Widget::widget('Widget_Metas_Category_List')->to($category); ?>
          <?php
            $currentCategory = _t('所有分类');
            $categoryHtml = '';
            while ($category->next()) {
              if($request->get('category') == $category->mid) {
                $currentCategory = $category->name;
              }
              $categoryHtml .= '<li>
                <a class="dropdown-item" href="'.$request->makeUriByRequest('category='.$category->mid).'">'
                  .$category->name.
                '</a></li>';
            }
          ?>
          <button type="button" class="btn border btn-light dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $currentCategory; ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('category='); ?>"><?php _e('所有分类'); ?></a></li>
            <?php echo $categoryHtml; ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2 justify-content-lg-end">
          <button
            class="btn btn-outline-danger px-4 btn-operate"
            lang="<?php _e('你确认要删除这些文章吗?'); ?>"
            href="<?php $security->index('/action/contents-post-edit?do=delete'); ?>"
          >
            <i class="bi bi-trash me-2"></i><?php _e('删除') ?>
          </button>
          <a class="btn btn-primary px-4" href="<?php $options->adminUrl('write-post.php') ?>">
            <i class="bi bi-plus-lg me-2"></i><?php _e('新增文章') ?>
          </a>
      </div>
    </div>
  </div><!--end row-->
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" id="manage_posts">
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
                <tr>
                  <th>
                    <input id="checkAll" class="form-check-input" type="checkbox">
                  </th>
                  <th></th>
                  <th><?php _e('标题') ?></th>
                  <th><?php _e('作者') ?></th>
                  <th><?php _e('分类') ?></th>
                  <th><?php _e('日期') ?></th>
                  <th><?php _e('操作') ?></th>
                </tr>
              </thead>
              <tbody>
              <?php if($posts->have()): ?>
                <?php while($posts->next()): ?>
                <tr id="<?php $posts->theId(); ?>">
                  <td><input class="form-check-input" type="checkbox" value="<?php $posts->cid(); ?>" name="cid[]" /></td>
                  <td>
                    <a
                      href="<?php $options->adminUrl('manage-comments.php?cid=' . ($posts->parentId ? $posts->parentId : $posts->cid)); ?>"
                      class="badge bg-primary size-<?php echo Typecho_Common::splitByCount($posts->commentsNum, 1, 10, 20, 50, 100); ?>"
                      title="<?php $posts->commentsNum(); ?> <?php _e('评论'); ?>">
                      <?php $posts->commentsNum(); ?>
                    </a>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <div class="product-box">
                        <img src="<?php $options->adminUrl('assets/images/no-img.jpg'); ?>" alt="<?php $posts->title(); ?>">
                      </div>
                      <div class="product-info">
                        <a
                          href="<?php $options->adminUrl('write-post.php?cid=' . $posts->cid); ?>"
                          class="product-title">
                          <?php $posts->title(); ?>
                        </a>
                      </div>
                    </div>
                  </td>
                  <td>
                    <a href="<?php $options->adminUrl('manage-posts.php?uid=' . $posts->author->uid); ?>">
                      <?php $posts->author(); ?>
                    </a>
                  </td>
                  <td>
                    <div class="product-tags">
                    <?php $categories = $posts->categories; $length = count($categories); ?>
                      <?php foreach ($categories as $key => $val): ?>
                      <a href="<?php echo $request->makeUriByRequest('category='.$val['mid']) ?>" class="btn-tags">
                        <?php echo $val['name']; ?>
                      </a>
                      <?php endforeach; ?>
                    </div>
                  </td>
                  <td>
                    <?php if ($posts->hasSaved): ?>
                    <?php $modifyDate = new Typecho_Date($posts->modified); ?>
                    <?php _e('保存于 %s', $modifyDate->word()); ?>
                    <?php else: ?>
                    <?php $posts->dateWord(); ?>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary" href="<?php $options->adminUrl('write-post.php?cid=' . $posts->cid); ?>">
                      <span class="material-symbols-outlined">edit</span>
                      <label><?php _e('编辑') ?></label>
                    </a>
                    <?php if ('post_draft' != $posts->type): ?>
                    <a class="btn btn-sm btn-outline-info mx-2" href="<?php $posts->permalink(); ?>" title="<?php _e('浏览 %s', htmlspecialchars($posts->title)); ?>">
                      <span class="material-symbols-outlined">eyeglasses</span>
                      <label><?php _e('预览') ?></label>
                    </a>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                  <td colspan="7">
                    <h6 class="typecho-list-table-title"><?php _e('没有任何文章'); ?></h6>
                  </td>
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
