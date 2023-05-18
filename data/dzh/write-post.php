<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('撰写新文章') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-body">
            <?php if ($post->draft): ?>
                <?php if ($post->draft['cid'] != $post->cid): ?>
                    <?php $postModifyDate = new Typecho_Date($post->draft['modified']); ?>
                    <cite class="edit-draft-notice"><?php _e('你正在编辑的是保存于 %s 的草稿, 你也可以 <a href="%s">删除它</a>', $postModifyDate->word(),
                            $security->getIndex('/action/contents-post-edit?do=deleteDraft&cid=' . $post->cid)); ?></cite>
                <?php else: ?>
                    <cite class="edit-draft-notice"><?php _e('当前正在编辑的是未发布的草稿'); ?></cite>
                <?php endif; ?>
                <input name="draft" type="hidden" value="<?php echo $post->draft['cid'] ?>" />
            <?php endif; ?>
            <div class="mb-1">
              <input
                type="text"
                class="form-control"
                name="title"
                id="title"
                autocomplete="off"
                value="<?php $post->title(); ?>"
                placeholder="<?php _e('标题'); ?>"
              />
            </div>
            <?php
            $permalink = Typecho_Common::url($options->routingTable['post']['url'], $options->index);
            list ($scheme, $permalink) = explode(':', $permalink, 2);
            $permalink = ltrim($permalink, '/');
            $permalink = preg_replace("/\[([_a-z0-9-]+)[^\]]*\]/i", "{\\1}", $permalink);
            if ($post->have()) {
              $permalink = str_replace(array(
                  '{cid}', '{category}', '{year}', '{month}', '{day}'
              ), array(
                  $post->cid, $post->category, $post->year, $post->month, $post->day
              ), $permalink);
            }
            $input = '<input type="text" id="slug" name="slug" autocomplete="off" value="'
              . htmlspecialchars($post->slug)
              . '" class="form-control" style="display: inline-block;
              width: auto; padding: 0.1rem 0.5rem; border-radius: 0; border-width: 0px; border-bottom-width: 1px;" />';
            ?>
            <div class="mb-4">
              <?php echo preg_replace("/\{slug\}/i", $input, $permalink); ?>
            </div>
            <div class="mt-4 mb-4">
              <textarea
                style="height: <?php $options->editorSize(); ?>px"
                autocomplete="off"
                id="text"
                name="text"
                class="form-control"><?php echo htmlspecialchars($post->text); ?></textarea>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="custom-fields">
              <label class="form-check-label" for="custom-fields"><?php _e('自定义字段'); ?></label>
            </div>
          </div>
        </div>
        <?php include 'custom-fields.php'; ?>
        <p class="submit clearfix">
          <span class="float-start">
            <input type="hidden" name="cid" value="<?php $post->cid(); ?>" />
            <button type="button" id="btn-preview" class="btn btn-sm btn-outline-primary"><?php _e('预览文章'); ?></button>
            <button type="submit" name="do" value="save" id="btn-save" class="btn btn-sm btn-outline-primary"><?php _e('保存草稿'); ?></button>
            <button type="submit" name="do" value="publish" class="btn btn-sm btn-primary" id="btn-submit"><?php _e('发布文章'); ?></button>
            <?php if ($options->markdown && (!$post->have() || $post->isMarkdown)): ?>
            <input type="hidden" name="markdown" value="1" />
            <?php endif; ?>
          </span>
          <span class="float-end">
            <button type="button" id="btn-cancel-preview" class="btn btn-sm btn-outline-primary">
              <?php _e('取消预览'); ?>
            </button>
          </span>
        </p>
        <?php Typecho_Plugin::factory('admin/write-post.php')->content($post); ?>
      </div>
      <div class="col-12 col-lg-4">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-tabs nav-primary" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab-base" role="tab" aria-selected="true">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon">
                      <i class='bi bi-home font-18 me-1'></i>
                    </div>
                    <div class="tab-title"><?php _e('选项') ?></div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-advance" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon">
                      <i class='bx bx-user-pin font-18 me-1'></i>
                    </div>
                    <div class="tab-title"><?php _e('高级选项') ?></div>
                  </div>
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-files" role="tab" aria-selected="false">
                  <div class="d-flex align-items-center">
                    <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                    </div>
                    <div class="tab-title"><?php _e('附件') ?></div>
                  </div>
                </a>
              </li>
            </ul>
            <div class="tab-content py-3">
              <div class="tab-pane fade show active" id="tab-base" role="tabpanel">
                <div class="mb-4">
                  <label for="date" class="form-label"><?php _e('发布日期'); ?></label>
                  <input
                    type="text"
                    class="form-control date-time"
                    name="date"
                    id="date"
                    value="<?php $post->have() ? $post->date('Y-m-d H:i') : ''; ?>"
                  />
                </div>
                <div class="mb-4">
                  <label for="category" class="form-label"><?php _e('分类'); ?></label>
                  <select class="form-select" id="category" name="category" data-placeholder="<?php _e('选择文章分类') ?>" multiple>
                    <?php Typecho_Widget::widget('Widget_Metas_Category_List')->to($category); ?>
                    <?php
                      if ($post->have()) {
                          $categories = Typecho_Common::arrayFlatten($post->categories, 'mid');
                      } else {
                          $categories = array();
                      }
                    ?>
                    <?php while($category->next()): ?>
                    <option <?php if(in_array($category->mid, $categories)): ?>selected<?php endif; ?> value="<?php $category->mid(); ?>"><?php $category->name(); ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="mb-4">
                  <label for="token-input-tags" class="form-label"><?php _e('标签'); ?></label>
                  <input type="text" class="form-control" id="tags" name="tags" data-role="tagsinput" value="<?php $post->tags(',', false); ?>">
                </div>
                <?php Typecho_Plugin::factory('admin/write-post.php')->option($post); ?>
              </div>
              <div class="tab-pane fade" id="tab-advance" role="tabpanel">
                <?php if($user->pass('editor', true)): ?>
                <div class="mb-4">
                  <label for="visibility" class="form-label"><?php _e('公开度'); ?></label>
                  <select class="form-select mb-3" id="visibility" name="visibility">
                  <?php if ($user->pass('editor', true)): ?>
                    <option value="publish"<?php if (($post->status == 'publish' && !$post->password) || !$post->status): ?> selected<?php endif; ?>><?php _e('公开'); ?></option>
                    <option value="hidden"<?php if ($post->status == 'hidden'): ?> selected<?php endif; ?>><?php _e('隐藏'); ?></option>
                    <option value="password"<?php if (strlen($post->password) > 0): ?> selected<?php endif; ?>><?php _e('密码保护'); ?></option>
                    <option value="private"<?php if ($post->status == 'private'): ?> selected<?php endif; ?>><?php _e('私密'); ?></option>
                    <?php endif; ?>
                    <option value="waiting"<?php if (!$user->pass('editor', true) || $post->status == 'waiting'): ?> selected<?php endif; ?>><?php _e('待审核'); ?></option>
                  </select>
                </div>
                <div id="post-password" class="mb-4 <?php if (strlen($post->password) == 0): ?>hidden<?php endif; ?>">
                  <label for="protect-pwd" class="form-label"><?php _e('内容密码'); ?></label>
                  <input type="text" name="password" id="protect-pwd" class="form-control" value="<?php $post->password(); ?>" size="16" placeholder="<?php _e('内容密码'); ?>" />
                </div>
                <?php endif; ?>
                <div class="mb-4">
                  <label class="form-label"><?php _e('权限控制'); ?></label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allowComment" name="allowComment" <?php if($post->allow('comment')): ?>checked="true"<?php endif; ?>>
                    <label class="form-check-label" for="allowComment"><?php _e('允许评论'); ?></label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allowPing" name="allowPing" <?php if($post->allow('ping')): ?>checked="true"<?php endif; ?>>
                    <label class="form-check-label" for="allowPing"><?php _e('允许被引用'); ?></label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allowFeed" name="allowFeed" <?php if($post->allow('feed')): ?>checked="true"<?php endif; ?>>
                    <label class="form-check-label" for="allowFeed"><?php _e('允许在聚合中出现'); ?></label>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="trackback" class="form-label"><?php _e('引用通告'); ?></label>
                  <textarea id="trackback" class="form-control" name="trackback" rows="2"></textarea>
                  <div class="my-2 small text-secondary">
                    <?php
                      echo _t('每一行一个引用地址, 用回车隔开')
                    ?>
                  </div>
                </div>
                <?php Typecho_Plugin::factory('admin/write-post.php')->advanceOption($post); ?>
              </div>
              <div class="tab-pane fade" id="tab-files" role="tabpanel">
                <?php include 'file-upload.php'; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <?php if($post->have()): ?>
            <?php $modified = new Typecho_Date($post->modified); ?>
            <?php _e('本文由 <a href="%s">%s</a> 撰写，',
            Typecho_Common::url('manage-posts.php?uid=' . $post->author->uid, $options->adminUrl), $post->author->screenName); ?>
            <?php _e('最后更新于 %s', $modified->word()); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>
<?php
include 'footer-js.php';
include 'write-js.php';
?>
  <script src="<?php $options->adminStaticUrl('assets/js', 'typecho.js?v=' . $suffixVersion); ?>"></script>
  <script src="<?php $options->adminStaticUrl('assets/plugins/input-tags/js', 'tagsinput.js?v=' . $suffixVersion); ?>"></script>
  <script src="<?php $options->adminStaticUrl('assets/plugins/select2/js', 'select2.min.js?v=' . $suffixVersion); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    $(".date-time").flatpickr({
			enableTime: true,
			dateFormat: "Y-m-d H:i",
		});

    $("#category").select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        allowClear: true
    } );

    // 自动隐藏密码框
    $('#visibility').change(function () {
        var val = $(this).val(), password = $('#post-password');

        if ('password' == val) {
            password.removeClass('hidden');
        } else {
            password.addClass('hidden');
        }
    });

    // 控制选项和附件的切换
    var fileUploadInit = false;
    $('[role="tablist"] li').click(function() {
      var selected_tab = $(this).find('a').attr('href'),
      selected_el = $(selected_tab).removeClass('hidden');
      if (!fileUploadInit) {
        selected_el.trigger('init');
        fileUploadInit = true;
      }
    });

  </script>
<?php
Typecho_Plugin::factory('admin/write-post.php')->trigger($plugged)->richEditor($post);
if (!$plugged) {
    include 'editor-js.php';
}
include 'file-upload-js.php';
include 'custom-fields-js.php';
include 'footer.php';
?>
