
<?php
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

date_default_timezone_set('PRC');

$stat = Typecho_Widget::widget('Widget_Stat');

$db = Typecho_Db::get();
$prefix = $db->getPrefix();

//计算分页
$pageSize = 20;
$currentPage = isset($_REQUEST['p']) ? ($_REQUEST['p'] + 0) : 1;

$all = $db->fetchAll($db->select()->from('table.baidusubmit')
    ->order('table.baidusubmit.time', Typecho_Db::SORT_DESC));

$pageCount = ceil( count($all)/$pageSize );

$current = $db->fetchAll($db->select()->from('table.baidusubmit')
    ->page($currentPage, $pageSize)
    ->order('table.baidusubmit.time', Typecho_Db::SORT_DESC));

//计算分组
$options = Helper::options();

$pages = $db->fetchAll($db->select()->from('table.contents')
    ->where('table.contents.status = ?', 'publish')
    ->where('table.contents.created < ?', $options->gmtTime)
    ->where('table.contents.type = ?', 'page')
    ->order('table.contents.created', Typecho_Db::SORT_DESC));

$articles = $db->fetchAll($db->select()->from('table.contents')
    ->where('table.contents.status = ?', 'publish')
    ->where('table.contents.created < ?', $options->gmtTime)
    ->where('table.contents.type = ?', 'post')
    ->order('table.contents.created', Typecho_Db::SORT_DESC));

$count = count($pages) + count($articles);

$group_volume = Helper::options()->plugin('BaiduSubmit')->group;

$group_num = ceil($count / $group_volume);

?>
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('其他') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('百度结构化日志') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row g-3">
    <div class="col-3 hstack">
      <form action="<?php $options->adminUrl('baidu_sitemap/advanced'); ?>" method="POST" class="w-100">
        <div class="d-flex w-100">
          <select name="group" class="form-select w-50 me-2">
            <?php for($i=1;$i<=$group_num;$i++): ?>
            <option value="<?php echo $i; ?>">第<?php echo $i; ?>组</option>
            <?php endfor; ?>
          </select>
          <button type="submit" class="btn btn-primary"><?php _e('发送分组URL'); ?></button>
        </div>
      </form>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto"></div>
    <div class="col-3">
      <form method="POST" action="<?php $options->adminUrl('extending.php?panel=BaiduSubmit%2FLogs.php'); ?>" class="w-100">
        <div class="d-flex search" role="search">
          <select name="p" class="form-select flex-grow-1 me-2">
            <?php for($i=1;$i<=$pageCount;$i++): ?>
            <option value="<?php echo $i; ?>"<?php if($i == $currentPage): ?> selected="true"<?php endif; ?>>第<?php echo $i; ?>页</option>
            <?php endfor; ?>
          </select>

          <button type="submit" class="btn btn-primary w-50"><?php _e('筛选'); ?></button>
          <?php if(isset($request->uid)): ?>
          <input type="hidden" value="<?php echo htmlspecialchars($request->get('uid')); ?>" name="uid" />
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" name="manage_posts" class="operate-form">
            <table class="table align-middle">
              <colgroup>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="25%"/>
                <col width="15%"/>
              </colgroup>
              <thead class="table-light">
                <tr>
                  <th><?php _e('主体'); ?></th>
                  <th><?php _e('动作'); ?></th>
                  <th><?php _e('对象'); ?></th>
                  <th><?php _e('成功'); ?></th>
                  <th><?php _e('更多信息'); ?></th>
                  <th><?php _e('时间'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($current as $line): ?>
                        <tr>
                            <td><?php echo $line['subject']; ?></td>
                            <td><?php echo $line['action']; ?></td>
                            <td><?php echo $line['object']; ?></td>
                            <td <?php if($line['result'] == '失败'){?> style="color: #ff0000" <?php }?>><?php echo $line['result']; ?></td>
                            <td><span class="show-hide">显示</span><span class="org-value" ><pre><?php echo $line['more']; ?></pre></span></td>
                            <td><?php echo date('Y-m-d H:i:s', $line['time']); ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
          </form><!-- end .operate-form -->
        </div>
      </div>
    </div>
  </div>
</main>
<?php
include 'footer-js.php';
?>
<script src="<?php $options->adminStaticUrl('assets/js', 'typecho.js?v=' . $suffixVersion); ?>"></script>
<script>
$(function(){
    var show = $('.show-hide')
    var pre = $('.org-value')

    show.css('color', 'blue');
    show.css('cursor', 'cursor');
    $('.org-value pre').css('background-color', '#E3FFDA');

    pre.hide();

    show.on('click', function(){
        $(this).hide().parent().find('.org-value').show();
    });

    pre.on('click', function(){
        $(this).hide().parent().find('.show-hide').show();
    });
});
</script>
<?php
include 'table-js.php';
include 'footer.php';
?>
