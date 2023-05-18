<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
Typecho_Widget::widget('Widget_Contents_Page_Edit')->to($page);
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('创建新页面') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <form action="<?php $security->index('/action/contents-page-edit'); ?>" method="post" name="write_page">
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="card">
          <div class="card-body">
            <?php if ($page->draft): ?>
              <?php if ($page->draft['cid'] != $page->cid): ?>
                <?php $pageModifyDate = new Typecho_Date($page->draft['modified']); ?>
                <cite class="edit-draft-notice">
                  <?php
                    _e('当前正在编辑的是保存于%s的草稿, 你可以<a href="%s">删除它</a>', $pageModifyDate->word(),
                      $security->getIndex('/action/contents-page-edit?do=deleteDraft&cid=' . $page->cid));
                  ?>
                </cite>
              <?php else: ?>
                <cite class="edit-draft-notice"><?php _e('当前正在编辑的是未发布的草稿'); ?></cite>
              <?php endif; ?>
              <input name="draft" type="hidden" value="<?php echo $page->draft['cid'] ?>" />
            <?php endif; ?>
            <div class="mb-1">
              <input
                type="text"
                class="form-control"
                name="title"
                id="title"
                autocomplete="off"
                value="<?php $page->title(); ?>"
                placeholder="<?php _e('标题'); ?>"
              />
            </div>
            <?php
              $permalink = Typecho_Common::url($options->routingTable['page']['url'], $options->index);
              list ($scheme, $permalink) = explode(':', $permalink, 2);
              $permalink = ltrim($permalink, '/');
              $permalink = preg_replace("/\[([_a-z0-9-]+)[^\]]*\]/i", "{\\1}", $permalink);
              if ($page->have()) {
                $permalink = str_replace(array(
                    '{cid}', '{category}', '{year}', '{month}', '{day}'
                ), array(
                    $page->cid, $page->category, $page->year, $page->month, $page->day
                ), $permalink);
              }
              $input = '<input type="text" id="slug" name="slug" autocomplete="off" value="'
                . htmlspecialchars($page->slug)
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
                class="form-control"><?php echo htmlspecialchars($page->text); ?></textarea>
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
            <input type="hidden" name="cid" value="<?php $page->cid(); ?>" />
            <button type="button" id="btn-preview" class="btn btn-sm btn-outline-primary"><?php _e('预览文章'); ?></button>
            <button type="submit" name="do" value="save" id="btn-save" class="btn btn-sm btn-outline-primary"><?php _e('保存草稿'); ?></button>
            <button type="submit" name="do" value="publish" class="btn btn-sm btn-primary" id="btn-submit"><?php _e('发布文章'); ?></button>
            <?php if ($options->markdown && (!$page->have() || $page->isMarkdown)): ?>
            <input type="hidden" name="markdown" value="1" />
            <?php endif; ?>
          </span>
          <span class="float-end">
            <button type="button" id="btn-cancel-preview" class="btn btn-sm btn-outline-primary">
              <?php _e('取消预览'); ?>
            </button>
          </span>
        </p>
        <?php Typecho_Plugin::factory('admin/write-page.php')->content($page); ?>
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
                    value="<?php $page->have() ? $page->date('Y-m-d H:i') : ''; ?>"
                  />
                </div>
                <div class="mb-4">
                  <label for="order" class="form-label"><?php _e('页面顺序'); ?></label>
                  <input
                    type="text"
                    class="form-control"
                    name="order"
                    id="order"
                    value="<?php $page->order(); ?>"
                  />
                </div>
                <div class="mb-4">
                  <label for="template" class="form-label"><?php _e('自定义模板'); ?></label>
                  <select name="template" id="template" class="form-select">
                    <option value=""><?php _e('不选择'); ?></option>
                    <?php $templates = $page->getTemplates(); foreach ($templates as $template => $name): ?>
                    <option value="<?php echo $template; ?>"<?php if($template == $page->template): ?> selected="true"<?php endif; ?>><?php echo $name; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <div class="my-2 small text-secondary">
                    <?php
                      echo _t('如果你为此页面选择了一个自定义模板, 系统将按照你选择的模板文件展现它')
                    ?>
                  </div>
                </div>
                <?php Typecho_Plugin::factory('admin/write-page.php')->option($page); ?>
              </div>
              <div class="tab-pane fade" id="tab-advance" role="tabpanel">
                <?php if($user->pass('editor', true)): ?>
                <div class="mb-4">
                  <label for="visibility" class="form-label"><?php _e('公开度'); ?></label>
                  <select class="form-select mb-3" id="visibility" name="visibility">
                    <option value="publish"<?php if (($page->status == 'publish' && !$page->password) || !$page->status): ?> selected<?php endif; ?>><?php _e('公开'); ?></option>
                    <option value="hidden"<?php if ($page->status == 'hidden'): ?> selected<?php endif; ?>><?php _e('隐藏'); ?></option>
                  </select>
                </div>
                <div id="post-password" class="mb-4 <?php if (strlen($page->password) == 0): ?>hidden<?php endif; ?>">
                  <label for="protect-pwd" class="form-label"><?php _e('内容密码'); ?></label>
                  <input type="text" name="password" id="protect-pwd" class="form-control" value="<?php $page->password(); ?>" size="16" placeholder="<?php _e('内容密码'); ?>" />
                </div>
                <?php endif; ?>
                <div class="mb-4">
                  <label class="form-label"><?php _e('权限控制'); ?></label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allowComment" name="allowComment" <?php if($page->allow('comment')): ?>checked="true"<?php endif; ?>>
                    <label class="form-check-label" for="allowComment"><?php _e('允许评论'); ?></label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allowPing" name="allowPing" <?php if($page->allow('ping')): ?>checked="true"<?php endif; ?>>
                    <label class="form-check-label" for="allowPing"><?php _e('允许被引用'); ?></label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="allowFeed" name="allowFeed" <?php if($page->allow('feed')): ?>checked="true"<?php endif; ?>>
                    <label class="form-check-label" for="allowFeed"><?php _e('允许在聚合中出现'); ?></label>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="trackback" class="form-label"><?php _e('引用通告'); ?></label>
                  <textarea id="trackback" class="form-control" name="trackback" rows="2"></textarea>
                  <div class="my-2 small text-secondary">
                    <?php
                      echo _t('每一行一个引用地址, 用回车隔开');
                    ?>
                  </div>
                </div>
                <?php Typecho_Plugin::factory('admin/write-page.php')->advanceOption($page); ?>
              </div>
              <div class="tab-pane fade" id="tab-files" role="tabpanel">
                <?php include 'file-upload.php'; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <?php if($page->have()): ?>
            <?php $modified = new Typecho_Date($page->modified); ?>
            <?php _e('本页面由 <a href="%s">%s</a> 创建,',
                Typecho_Common::url('manage-pages.php?uid=' . $page->author->uid, $options->adminUrl), $page->author->screenName); ?>
            <?php _e('最后更新于 %s', $modified->word()); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </form>
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
Typecho_Plugin::factory('admin/write-page.php')->trigger($plugged)->richEditor($page);
if (!$plugged) {
    include 'editor-js.php';
}
include 'file-upload-js.php';
include 'custom-fields-js.php';
include 'footer.php';
?>
