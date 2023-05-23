<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
require dirname(__FILE__) . '/../Access.php';
$extend = Access_Extend::getInstance();
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
          <li class="breadcrumb-item active" aria-current="page"><?php echo $extend->title;?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row">
    <div class="col-12">
      <div class="card mt-4">
        <div class="card-body">
          <ul class="nav nav-tabs nav-primary" role="tablist">
            <li class="nav-item" role="presentation">
              <a
                class="nav-link <?=($extend->action == 'overview' ? ' active' : '')?>"
                href="<?php $options->adminUrl('extending.php?panel=' . Access_Plugin::$panel . '&action=overview'); ?>"
                role="tab"
                aria-selected="<?=($extend->action == 'overview' ? 'true' : 'false')?>"
              >
                <div class="d-flex align-items-center">
                  <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                  </div>
                  <div class="tab-title"><?php _e('访问概览'); ?></div>
                </div>
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link <?=($extend->action == 'logs' ? ' active' : '')?>"
                href="<?php $options->adminUrl('extending.php?panel=' . Access_Plugin::$panel . '&action=logs'); ?>"
                role="tab"
                aria-selected="<?=($extend->action == 'logs' ? 'true' : 'false')?>"
              >
                <div class="d-flex align-items-center">
                  <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                  </div>
                  <div class="tab-title"><?php _e('访问日志'); ?></div>
                </div>
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                href="<?php $options->adminUrl('options-plugin.php?config=Access') ?>"
                role="tab"
                aria-selected="false"
              >
                <div class="d-flex align-items-center">
                  <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                  </div>
                  <div class="tab-title"><?php _e('插件设置'); ?></div>
                </div>
              </a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <?php if($extend->action == 'logs'):?>
            <div class="tab-pane fade show active" role="tabpanel">
              <div class="table-responsive white-space-nowrap">
                <div class="d-flex align-items-center g-3 my-3">
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
                        <input type="hidden" value="<?php echo $request->get('panel'); ?>" name="panel" />
                        <?php if(isset($request->page)): ?>
                          <input type="hidden" value="<?php echo $request->get('page'); ?>" name="page" />
                        <?php endif; ?>
                        <span class="material-symbols-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                      </form>
                    </div>
                    <?php if ('' != $request->keywords): ?>
                      <a class="btn btn-outline-info px-4 mx-2" href="<?php $options->adminUrl('manage-comments.php'); ?>"><?php _e('取消筛选'); ?></a>
                    <?php endif; ?>
                  </div>
                  <div class="col-auto flex-grow-1 overflow-auto"></div>
                  <div class="col-auto">
                    <div class="btn-group position-static">
                      <button type="button" class="btn border btn-light dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if($request->type == 2): ?>
                        <?php _e('仅爬虫'); ?>
                        <?php elseif($request->type == 3): ?>
                        <?php _e('所有'); ?>
                        <?php else: ?>
                        <?php _e('默认(仅人类)'); ?>
                        <?php endif; ?>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('type=1'); ?>"><?php _e('默认(仅人类)'); ?></a></li>
                        <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('type=2'); ?>"><?php _e('仅爬虫'); ?></a></li>
                        <li><a class="dropdown-item" href="<?php echo $request->makeUriByRequest('type=3'); ?>"><?php _e('所有'); ?></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <table class="table align-middle">
                  <colgroup>
                    <col width="5"/>
                    <col width="30%"/>
                    <col width="25%"/>
                    <col width=""/>
                    <col width=""/>
                  </colgroup>
                  <thead class="table-light">
                    <tr>
                      <th><input id="checkAll" class="form-check-input" type="checkbox"></th>
                      <th><?php _e('受访地址'); ?></th>
                      <th><?php _e('UA'); ?></th>
                      <th><?php _e('IP地址'); ?></th>
                      <th><?php _e('日期'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(!empty($extend->logs['list'])): ?>
                    <?php foreach ($extend->logs['list'] as $log): ?>
                    <tr id="<?php echo $log['id']; ?>">
                        <td><input type="checkbox" class="form-check-input" value="<?php echo $log['id']; ?>" name="id[]"/></td>
                        <td><a href="<?php echo str_replace("%23", "#", $log['url']); ?>"><?php echo urldecode(str_replace("%23", "#", $log['url'])); ?></a></td>
                        <td><a data-action="ua" href="#" title="<?php echo $log['ua'];?>"><?php echo $extend->parseUA($log['ua']); ?></a></td>
                        <td><a data-action="ip" data-address="<?php echo $extend->getAddress($log['ip']);?>" href="#"><?php echo $log['ip']; ?></a></td>
                        <td><?php echo date('Y-m-d H:i:s',$log['date']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6"><h6 class="typecho-list-table-title"><?php _e('当前无日志'); ?></h6></td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
                <?php if($extend->logs['rows'] > 1): ?>
                <nav aria-label="...">
                  <ul class="pagination pagination-sm">
                    <?php echo $extend->logs['page']; ?>
                  </ul>
                </nav>
                <?php endif; ?>
              </div>
            </div>
            <?php elseif($extend->action == 'overview'):?>
            <div class="tab-pane fade show active" role="tabpanel">
              <div class="table-responsive white-space-nowrap">
                <table class="table align-middle">
                  <colgroup>
                    <col width="10%"/>
                    <col width="30%"/>
                    <col width="25%"/>
                    <col width=""/>
                  </colgroup>
                  <thead class="table-light">
                    <tr>
                      <th></th>
                      <th><?php _e('浏览量(PV)'); ?></th>
                      <th><?php _e('访客数(UV)'); ?></th>
                      <th><?php _e('IP数'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>今日</td>
                      <td><?php echo $extend->overview['pv']['today']['total'];?></td>
                      <td><?php echo $extend->overview['uv']['today']['total'];?></td>
                      <td><?php echo $extend->overview['ip']['today']['total'];?></td>
                    </tr>
                    <tr>
                      <td>昨日</td>
                      <td><?php echo $extend->overview['pv']['yesterday']['total'];?></td>
                      <td><?php echo $extend->overview['uv']['yesterday']['total'];?></td>
                      <td><?php echo $extend->overview['ip']['yesterday']['total'];?></td>
                    </tr>
                    <tr>
                      <td>总计</td>
                      <td><?php echo $extend->overview['pv']['all']['total'];?></td>
                      <td><?php echo $extend->overview['uv']['all']['total'];?></td>
                      <td><?php echo $extend->overview['ip']['all']['total'];?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <?php endif;?>
          </div>
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
  $('.table').tableSelectable({
    checkEl     :   'input[type=checkbox]:not("#checkAll")',
    rowEl       :   'tr',
    selectAllEl :   '#checkAll',
    actionEl    :   'button.btn-operate'
  });
  $('a[data-action="ip"]').click(function() {
    alert($(this).data('address'));
    return false;
  });

  $('a[data-action="ua"]').click(function() {
    alert($.trim($(this).attr('title')));
    return false;
  });
</script>
<?php
include 'footer.php';
?>
