<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$stat = Typecho_Widget::widget('Widget_Stat');
$comments = Typecho_Widget::widget('Widget_Comments_Admin');
$isAllComments = ('on' == $request->get('__typecho_all_comments') || 'on' == Typecho_Cookie::get('__typecho_all_comments'));

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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('评论管理') ?></li>
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
        <a class="btn btn-outline-info px-4 mx-2" href="<?php $options->adminUrl('manage-comments.php'); ?>"><?php _e('取消筛选'); ?></a>
      <?php endif; ?>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto">
      <div class="btn-group position-static">
        <?php if($user->pass('editor', true) && !isset($request->cid)): ?>
        <div class="btn-group position-static">
          <button type="button" class="btn border btn-light dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
            <?php $isAllComments ? _e('所有') : _e('我的'); ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('__typecho_all_comments=on'); ?>"><?php _e('所有'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('__typecho_all_comments=off'); ?>"><?php _e('我的'); ?></a></li>
          </ul>
        </div>
        <?php endif; ?>
        <div class="btn-group position-static">
          <button type="button" class="btn border btn-light dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if(!isset($request->status) || 'approved' == $request->get('status')): ?>
              <?php _e('已通过'); ?>
            <?php elseif ('waiting' == $request->get('status')): ?>
              <?php _e('待审核'); ?>
            <?php elseif ('spam' == $request->get('status')): ?>
              <?php _e('垃圾'); ?>
            <?php endif; ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('status=approved'); ?>"><?php _e('已通过'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('status=waiting'); ?>"><?php _e('待审核'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('status=spam'); ?>"><?php _e('垃圾'); ?></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-auto">
      <div class="d-flex align-items-center gap-2 justify-content-lg-end">
        <div class="btn-group">
          <button type="button" class="btn btn-primary"><?php _e('批量操作'); ?></button>
          <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
            <a class="dropdown-item" href="<?php $security->index('/action/comments-edit?do=approved'); ?>"><?php _e('通过'); ?></a>
            <a class="dropdown-item" href="<?php $security->index('/action/comments-edit?do=waiting'); ?>"><?php _e('待审核'); ?></a>
            <a class="dropdown-item" href="<?php $security->index('/action/comments-edit?do=spam'); ?>"><?php _e('标记垃圾'); ?></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" lang="<?php _e('你确认要删除这些评论吗?'); ?>" href="<?php $security->index('/action/comments-edit?do=delete'); ?>"><?php _e('删除') ?></a>
          </div>
        </div>
      </div>
    </div>
  </div><!--end row-->
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" name="manage_comments" class="operate-form">
            <table class="table align-middle">
              <colgroup>
                <col width="3%"/>
                <col width="6%" />
                <col width="20%"/>
                <col width="71%"/>
              </colgroup>
              <thead class="table-light">
                <tr>
                  <th><input id="checkAll" class="form-check-input" type="checkbox"></th>
                  <th><?php _e('作者'); ?></th>
                  <th></th>
                  <th><?php _e('内容'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if($comments->have()): ?>
                <?php while($comments->next()): ?>
                <tr id="<?php $comments->theId(); ?>" data-comment="<?php
                  $comment = array(
                      'author'    =>  $comments->author,
                      'mail'      =>  $comments->mail,
                      'url'       =>  $comments->url,
                      'ip'        =>  $comments->ip,
                      'type'        =>  $comments->type,
                      'text'      =>  $comments->text
                  );
                  echo htmlspecialchars(Json::encode($comment));
                ?>">
                  <td valign="top">
                    <input type="checkbox" class="form-check-input" value="<?php $comments->coid(); ?>" name="coid[]"/>
                  </td>
                  <td valign="top">
                    <div class="comment-avatar">
                      <?php if ('comment' == $comments->type): ?>
                      <?php $comments->gravatar(40); ?>
                      <?php endif; ?>
                      <?php if ('comment' != $comments->type): ?>
                      <?php _e('引用'); ?>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td valign="top" class="comment-head">
                    <div class="comment-meta">
                      <strong class="comment-author"><?php $comments->author(true); ?></strong>
                      <?php if($comments->mail): ?>
                      <br /><span><a href="mailto:<?php $comments->mail(); ?>"><?php $comments->mail(); ?></a></span>
                      <?php endif; ?>
                      <?php if($comments->ip): ?>
                      <br /><span><?php $comments->ip(); ?></span>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td valign="top" class="comment-body">
                    <div class="comment-date"><?php $comments->dateWord(); ?> 于 <a href="<?php $comments->permalink(); ?>"><?php $comments->title(); ?></a></div>
                    <div class="comment-content">
                        <?php $comments->content(); ?>
                    </div>
                    <div class="btn-group btn-group-sm comment-action hidden-by-mouse" role="group">
                      <?php if('approved' == $comments->status): ?>
                      <button type="button" class="btn btn-primary"><?php _e('通过'); ?></button>
                      <?php else: ?>
                      <a class="btn btn-outline-primary operate-approved" href="<?php $security->index('/action/comments-edit?do=approved&coid=' . $comments->coid); ?>"><?php _e('通过'); ?></a>
                      <?php endif; ?>

                      <?php if('waiting' == $comments->status): ?>
                      <button type="button" class="btn btn-primary"><?php _e('待审核'); ?></button>
                      <?php else: ?>
                      <a class="btn btn-outline-primary operate-waiting" href="<?php $security->index('/action/comments-edit?do=waiting&coid=' . $comments->coid); ?>"><?php _e('待审核'); ?></a>
                      <?php endif; ?>

                      <?php if('spam' == $comments->status): ?>
                      <button type="button" class="btn btn-primary"><?php _e('垃圾'); ?></button>
                      <?php else: ?>
                      <a class="btn btn-outline-primary operate-spam" href="<?php $security->index('/action/comments-edit?do=spam&coid=' . $comments->coid); ?>"><?php _e('垃圾'); ?></a>
                      <?php endif; ?>

                      <a class="btn btn-outline-primary operate-edit" href="#<?php $comments->theId(); ?>" rel="<?php $security->index('/action/comments-edit?do=edit&coid=' . $comments->coid); ?>"><?php _e('编辑'); ?></a>

                      <?php if('approved' == $comments->status && 'comment' == $comments->type): ?>
                      <a class="btn btn-outline-primary operate-reply" href="#<?php $comments->theId(); ?>" rel="<?php $security->index('/action/comments-edit?do=reply&coid=' . $comments->coid); ?>"><?php _e('回复'); ?></a>
                      <?php endif; ?>

                      <a
                        class="btn btn-outline-primary operate-delete"
                        lang="<?php _e('你确认要删除%s的评论吗?', htmlspecialchars($comments->author)); ?>"
                        href="<?php $security->index('/action/comments-edit?do=delete&coid=' . $comments->coid); ?>"
                      ><?php _e('删除'); ?></a>
                    </div>
                  </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                  <td colspan="4"><h6 class="typecho-list-table-title"><?php _e('没有评论') ?></h6></td>
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
  // 记住滚动条
  function rememberScroll () {
    $(window).bind('beforeunload', function () {
      $.cookie('__typecho_comments_scroll', $('body').scrollTop());
    });
  }

  // 自动滚动
  (function () {
    var scroll = $.cookie('__typecho_comments_scroll');
    if (scroll) {
      $.cookie('__typecho_comments_scroll', null);
      $('html, body').scrollTop(scroll);
    }
  })();

  $('.operate-delete').click(function () {
    var t = $(this), href = t.attr('href'), tr = t.parents('tr');
    if (confirm(t.attr('lang'))) {
      tr.fadeOut(function () {
          rememberScroll();
          window.location.href = href;
      });
    }
    return false;
  });

  $('.operate-approved, .operate-waiting, .operate-spam').click(function () {
    rememberScroll();
    window.location.href = $(this).attr('href');
    return false;
  });

  $('.operate-reply').click(function () {
    var td = $(this).parents('td'), t = $(this);

    if ($('.comment-reply', td).length > 0) {
        $('.comment-reply').remove();
    } else {
      var form = $('<form method="post" action="'
          + t.attr('rel') + '" class="comment-reply">'
          + '<p><label for="text" class="sr-only"><?php _e('内容'); ?></label><textarea id="text" name="text" class="w-90 mono" rows="3"></textarea></p>'
          + '<p><button type="submit" class="btn btn-s primary"><?php _e('回复'); ?></button> <button type="button" class="btn btn-s cancel"><?php _e('取消'); ?></button></p>'
          + '</form>').insertBefore($('.comment-action', td));

      $('.cancel', form).click(function () {
          $(this).parents('.comment-reply').remove();
      });

      var textarea = $('textarea', form).focus();

      form.submit(function (e) {
        e.preventDefault();
        var t = $(this), tr = t.parents('tr'),
            reply = $('<div class="comment-reply-content"></div>').insertAfter($('.comment-content', tr));

        reply.html('<p>' + textarea.val() + '</p>');
        $.post(t.attr('action'), t.serialize(), function (o) {
            reply.html(o.comment.content)
                .effect('highlight');
        }, 'json');

        t.remove();
      });
    }

    return false;
  });

  $('.operate-edit').click(function () {
    var tr = $(this).parents('tr'), t = $(this), id = tr.attr('id'), comment = tr.data('comment');
    tr.hide();

    var edit = $('<tr class="comment-edit"><td> </td>'
      + '<td colspan="2" valign="top"><form method="post" action="'
      + t.attr('rel') + '" class="comment-edit-info">'
      + '<p><label for="' + id + '-author"><?php _e('用户名'); ?></label><input class="form-control" id="'
      + id + '-author" name="author" type="text"></p>'
      + '<p><label for="' + id + '-mail"><?php _e('电子邮箱'); ?></label>'
      + '<input class="form-control" type="email" name="mail" id="' + id + '-mail"></p>'
      + '<p><label for="' + id + '-url"><?php _e('个人主页'); ?></label>'
      + '<input class="form-control" type="text" name="url" id="' + id + '-url"></p></form></td>'
      + '<td valign="top"><form method="post" action="'
      + t.attr('rel') + '" class="comment-edit-content"><p><label for="' + id + '-text"><?php _e('内容'); ?></label>'
      + '<textarea name="text" id="' + id + '-text" rows="6" class="form-control"></textarea></p>'
      + '<p><button type="submit" class="btn btn-sm btn-primary"><?php _e('提交'); ?></button> '
      + '<button type="button" class="btn btn-sm btn-secondary"><?php _e('取消'); ?></button></p></form></td></tr>')
      .data('id', id).data('comment', comment).insertAfter(tr);

    $('input[name=author]', edit).val(comment.author);
    $('input[name=mail]', edit).val(comment.mail);
    $('input[name=url]', edit).val(comment.url);
    $('textarea[name=text]', edit).val(comment.text).focus();

    $('.cancel', edit).click(function () {
      var tr = $(this).parents('tr');

      $('#' + tr.data('id')).show();
      tr.remove();
    });

    $('form', edit).submit(function (e) {
      e.preventDefault();

      var t = $(this), tr = t.parents('tr'),
          oldTr = $('#' + tr.data('id')),
          comment = oldTr.data('comment');

      $('form', tr).each(function () {
          var items  = $(this).serializeArray();

          for (var i = 0; i < items.length; i ++) {
              var item = items[i];
              comment[item.name] = item.value;
          }
      });

      var html = '<strong class="comment-author">'
          + (comment.url ? '<a target="_blank" href="' + comment.url + '">'
          + comment.author + '</a>' : comment.author) + '</strong>'
          + ('comment' != comment.type ? '<small><?php _e('引用'); ?></small>' : '')
          + (comment.mail ? '<br /><span><a href="mailto:' + comment.mail + '">'
          + comment.mail + '</a></span>' : '')
          + (comment.ip ? '<br /><span>' + comment.ip + '</span>' : '');

      $('.comment-meta', oldTr).html(html);
      $('.comment-content', oldTr).html('<p>' + comment.text + '</p>');
      oldTr.data('comment', comment);

      $.post(t.attr('action'), comment, function (o) {
        $('.comment-content', oldTr).html(o.comment.content);
      }, 'json');

      oldTr.show();
      tr.remove();
    });

    return false;
  });
});
</script>
<?php
include 'table-js.php';
include 'footer.php';
?>
