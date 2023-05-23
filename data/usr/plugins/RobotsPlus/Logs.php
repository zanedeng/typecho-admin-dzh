<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
$config  = Typecho_Widget::widget('Widget_Options')->plugin('RobotsPlus');
$botlist = $config->botlist;
$pagecount = $config->pagecount;
$isdrop = $config->droptable;
if ($botlist == null || $pagecount == null || $isdrop == null)
{
  throw new Typecho_Plugin_Exception('请先设置插件！');
}
$db = Typecho_Db::get();
$prefix = $db->getPrefix();
$p = 1;
$rtype = '';
$oldtype = '';
if (isset($_REQUEST['rpage'])) {
  $p = $_REQUEST['rpage'];
}
if (isset($_REQUEST['do'])) {
  $do = $_REQUEST['do'];
  if ($do == 'delete') {
    if (isset($_REQUEST['lid'])) {
      $lids = $_REQUEST['lid'];
      $deleteCount = 0;
      if ($lids && is_array($lids)) {
        foreach ($lids as $lid) {
          if ($db->query($db->delete($prefix.'robots_logs')->where('lid = ?', $lid))) {
            $deleteCount ++;
          }
        }
      }
      Typecho_Widget::widget('Widget_Notice')->set('成功删除蜘蛛日志',NULL,'success');
      Typecho_Response::redirect(Typecho_Common::url('extending.php?panel=RobotsPlus%2FLogs.php', $options->adminUrl));
    }else{
      Typecho_Widget::widget('Widget_Notice')->set('当前没有选择的日志',NULL,'notice');
      Typecho_Response::redirect(Typecho_Common::url('extending.php?panel=RobotsPlus%2FLogs.php', $options->adminUrl));
    }
  }
  if (strpos($do,'clear')!==false)
  {
    try
    {
      $cleartype = substr($do, 6);
      $options = Typecho_Widget::widget('Widget_Options');
      $timeStamp = $options->gmtTime;
      $offset = $options->timezone - $options->serverTimezone;
      $gtime = $timeStamp + $offset;
      $lowtime = $gtime - ($cleartype * 86400);
      $db->query($db->delete($prefix.'robots_logs')->where('ltime < ?', $lowtime));
      Typecho_Widget::widget('Widget_Notice')->set('清除日志成功',NULL,'success');
      Typecho_Response::redirect(Typecho_Common::url('extending.php?panel=RobotsPlus%2FLogs.php', $options->adminUrl));
    }
    catch (Typecho_Db_Exception $e)
    {
      Typecho_Widget::widget('Widget_Notice')->set('清除日志失败',NULL,'notice');
      Typecho_Response::redirect(Typecho_Common::url('extending.php?panel=RobotsPlus%2FLogs.php', $options->adminUrl));
    }
  }
}
if (isset($_REQUEST['oldtype'])) {
  $oldtype = $_REQUEST['oldtype'];
}

if (isset($_REQUEST['rtype']) && !empty($_REQUEST['rtype'])) {
  $rtype = $_REQUEST['rtype'];
  if ($oldtype !== $rtype) {
    $p = 1;
  }
  $logs = $db->fetchAll($db->select()->from($prefix.'robots_logs')->where('bot = ?', $rtype)->order($prefix.'robots_logs.lid', Typecho_Db::SORT_DESC)->page($p, $pagecount));
  $rows = count($db->fetchAll($db->select('lid')->from($prefix.'robots_logs')->where('bot = ?', $rtype)));
}else{
  $logs = $db->fetchAll($db->select()->from($prefix.'robots_logs')->order($prefix.'robots_logs.lid', Typecho_Db::SORT_DESC)->page($p, $pagecount));
  $rows = count($db->fetchAll($db->select('lid')->from($prefix.'robots_logs')));
}
$co = $rows % $pagecount;
$pageno = floor($rows / $pagecount);
if ($co !== 0) {
  $pageno += 1;
}

function botname($bot)
{
  switch ($bot) {
    case "baidu":   return '百度'; break;
    case "google":  return '谷歌'; break;
    case "yahoo":   return '雅虎'; break;
    case "sogou":   return '搜狗'; break;
    case "youdao":  return '有道'; break;
    case "soso":    return '搜搜'; break;
    case "bing":    return '必应'; break;
    case "360":     return '360搜索'; break;
  }
}
?>
<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('其他') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">蜘蛛日志</li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <form method="get" action="<?php $options->adminUrl('extending.php?panel=RobotsPlus%2FLogs.php'); ?>">
  <div class="row g-3">
    <div class="col-auto d-flex align-items-center">
      <select name="rtype" class="form-select me-2" style="width: 200px;">
        <option value="">所有蜘蛛</option>
        <?php
          if (sizeof($botlist)>0) {
            foreach ($botlist as $bot) {
              $selected = $rtype==$bot ? ' selected="selected"' : NULL;
              echo '<option value="'.$bot.'"'.$selected.'>'.botname($bot).'</option>';
            }
          }
        ?>
      </select>
      <input type="hidden" value="<?php echo $request->get('panel'); ?>" name="panel" />
      <?php if(isset($request->page)): ?>
        <input type="hidden" value="<?php echo $request->get('rpage'); ?>" name="rpage" />
      <?php endif; ?>
      <button type="submit" class="btn btn-primary">查看</button>
    </div>
    <div class="col-auto flex-grow-1 overflow-auto"></div>
    <div class="col-auto">
      <button type="button" class="btn btn-outline-danger btn-operate" lang="你确认要删除这些日志吗?" href="<?php echo $request->makeUriByRequest('do=delete') ?>"><?php _e('删除') ?></button>
      <div class="btn-group">
        <button type="button" class="btn btn-primary"><?php _e('清除选项') ?></button>
        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_0') ?>">清除所有</a>
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_1') ?>">保留一天</a>
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_2') ?>">保留两天</a>
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_3') ?>">保留三天</a>
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_7') ?>">保留一周</a>
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_15') ?>">保留半个月</a>
          <a class="dropdown-item" lang="你确认要清除所有的日志吗?" href="<?php echo $request->makeUriByRequest('do=clear_30') ?>">保留一个月</a>
        </div>
      </div>
    </div>
  </div><!--end row-->
  </form>
  <div class="card mt-4">
    <div class="card-body">
      <div class="product-table">
        <div class="table-responsive white-space-nowrap">
          <form method="post" action="<?php $options->adminUrl('extending.php?panel=RobotsPlus%2FLogs.php'); ?>">
          <table class="table align-middle">
            <colgroup>
              <col width="25"/>
              <col width="50"/>
              <col width="260"/>
              <col width="60"/>
              <col width="30"/>
              <col width="110"/>
              <col width="205"/>
              <col width="150"/>
            </colgroup>
            <thead class="table-light">
              <tr>
                <th><input id="checkAll" class="form-check-input" type="checkbox"></th>
                <th> </th>
                <th>受访地址</th>
                <th> </th>
                <th> </th>
                <th>蜘蛛名称</th>
                <th>IP地址<a style="padding-left:12px;" href="javascript:void(0);" onclick="showIpLocation();">查询位置</a></th>
                <th class="typecho-radius-topright">日期</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($logs)): ?>
              <?php foreach ($logs as $log): ?>
              <tr class="even" id="post-5">
                <td>
                  <input type="checkbox" class="form-check-input" value="<?php echo $log['lid']; ?>" name="lid[]"/>
                </td>
                <td></td>
                <td colspan="2">
                  <a href="<?php echo str_replace("%23", "#", $log['url']); ?>">
                    <?php echo urldecode(str_replace("%23", "#", $log['url'])); ?>
                  </a>
                </td>
                <td></td>
                <td><?php echo botname($log['bot']); ?></td>
                <td>
                  <div class="robotx_ip"><?php echo $log['ip']; ?></div>
                  <div class="robotx_location"></div></td>
                <td>
                  <?php echo date('Y-m-d H:i:s',$log['ltime']); ?>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="8"><h6 class="typecho-list-table-title"><?php _e('当前无蜘蛛日志'); ?></h6></td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
          <?php if($pageno > 1): ?>
          <nav aria-label="...">
            <ul class="pagination pagination-sm">
              <?php if ($p > 1): ?>
              <li class="page-item"><a class="page-link" href="<?php echo $request->makeUriByRequest('rpage='.($p - 1)) ?>" tabindex="-1">&laquo;</a>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $pageno; $i++): ?>
              <li class="page-item">
                <a
                  class="page-link <?php if ($i == $p): ?>active<?php endif; ?>"
                  <?php if ($i == $p): ?>aria-current="page"<?php endif; ?>
                  href="<?php echo $request->makeUriByRequest('rpage='.$i) ?>">
                  <?php echo $i ?>
                </a>
                <?php if ($i == $p): ?><span class="visually-hidden">(current)</span><?php endif; ?>
              </li>
              <?php endfor; ?>
              <?php if ($pageno != $p): ?>
              <li class="page-item"><a class="page-link" href="<?php echo $request->makeUriByRequest('rpage='.($p + 1)) ?>" tabindex="-1">&raquo;</a>
              <?php endif; ?>
            </ul>
          </nav>
          <?php endif; ?>
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
function showIpLocation(){
    jQuery(".robotx_location").text("正在查询...");
    jQuery(".robotx_ip").each(function(){
      var myd = jQuery(this);
      jQuery.getScript("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=" + myd.text(),function(){
        var ipadd = "没有找到匹配的 IP 地址信息";
        if (remote_ip_info.ret == '1'){
            ipadd = remote_ip_info.country + " "
            + remote_ip_info.province + " "
            + remote_ip_info.district + " "
            + remote_ip_info.desc + " "
            + remote_ip_info.isp;
            myd.next().text(ipadd).css("color","#BD6800");
        }else{
          myd.next().text(ipadd).css("color","#f00");
        }
      });
  });
}
</script>
<?php
include 'table-js.php';
include 'footer.php';
?>
