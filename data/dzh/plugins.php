<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';
Typecho_Widget::widget('Widget_Plugins_List@activated', 'activated=1')->to($activatedPlugins);
Typecho_Widget::widget('Widget_Plugins_List@unactivated', 'activated=0')->to($deactivatedPlugins);
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('插件管理') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="card mt-4">
    <div class="card-body">
      <ul class="nav nav-tabs nav-primary" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" data-bs-toggle="pill" href="#activatedPlugins" role="tab" aria-selected="true">
            <div class="d-flex align-items-center">
              <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
              </div>
              <div class="tab-title"><?php _e('启用的插件'); ?></div>
            </div>
          </a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" data-bs-toggle="pill" href="#deactivatedPlugins" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
              <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
              </div>
              <div class="tab-title"><?php _e('禁用的插件'); ?></div>
            </div>
          </a>
        </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="activatedPlugins" role="tabpanel">
          <div class="table-responsive white-space-nowrap">
            <table class="table align-middle">
              <colgroup>
                <col width="25%"/>
                <col width=""/>
                <col width="8%"/>
                <col width="10%"/>
                <col width="20%"/>
              </colgroup>
              <thead class="table-light">
                <tr>
                  <th><?php _e('名称'); ?></th>
                  <th><?php _e('描述'); ?></th>
                  <th><?php _e('版本'); ?></th>
                  <th><?php _e('作者'); ?></th>
                  <th><?php _e('操作'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php while ($activatedPlugins->next()): ?>
                <tr id="plugin-<?php $activatedPlugins->name(); ?>">
                  <td><?php $activatedPlugins->title(); ?>
                  <?php if (!$activatedPlugins->dependence): ?>
                  <img src="<?php $options->adminUrl('images/notice.gif'); ?>" title="<?php _e('%s 无法在此版本的typecho下正常工作', $activatedPlugins->title); ?>" alt="<?php _e('%s 无法在此版本的typecho下正常工作', $activatedPlugins->title); ?>" class="tiny" />
                  <?php endif; ?>
                  </td>
                  <td><?php $activatedPlugins->description(); ?></td>
                  <td><?php $activatedPlugins->version(); ?></td>
                  <td><?php echo empty($activatedPlugins->homepage) ? $activatedPlugins->author : '<a href="' . $activatedPlugins->homepage
                  . '">' . $activatedPlugins->author . '</a>'; ?></td>
                  <td>
                      <?php if ($activatedPlugins->activate || $activatedPlugins->deactivate || $activatedPlugins->config || $activatedPlugins->personalConfig): ?>
                          <?php if ($activatedPlugins->config): ?>
                              <a href="<?php $options->adminUrl('options-plugin.php?config=' . $activatedPlugins->name); ?>"><?php _e('设置'); ?></a>
                              &bull;
                          <?php endif; ?>
                          <a lang="<?php _e('你确认要禁用插件 %s 吗?', $activatedPlugins->name); ?>" href="<?php $security->index('/action/plugins-edit?deactivate=' . $activatedPlugins->name); ?>"><?php _e('禁用'); ?></a>
                      <?php else: ?>
                          <span class="important"><?php _e('即插即用'); ?></span>
                      <?php endif; ?>
                  </td>
                </tr>
                <?php endwhile; ?>
                  
                <?php if (!empty($activatedPlugins->activatedPlugins)): ?>
                <?php foreach ($activatedPlugins->activatedPlugins as $key => $val): ?>
                <tr>
                  <td><?php echo $key; ?></td>
                  <td colspan="3"><span class="warning"><?php _e('此插件文件已经损坏或者被不安全移除, 强烈建议你禁用它'); ?></span></td>
                  <td><a lang="<?php _e('你确认要禁用插件 %s 吗?', $key); ?>" href="<?php $security->index('/action/plugins-edit?deactivate=' . $key); ?>"><?php _e('禁用'); ?></a></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="deactivatedPlugins" role="tabpanel">
          <div class="table-responsive white-space-nowrap">
            <table class="table align-middle">
            <colgroup>
                <col width="25%"/>
                <col width=""/>
                <col width="8%"/>
                <col width="10%"/>
                <col width="20%"/>
              </colgroup>
              <thead class="table-light">
                <tr>
                  <th><?php _e('名称'); ?></th>
                  <th><?php _e('描述'); ?></th>
                  <th><?php _e('版本'); ?></th>
                  <th><?php _e('作者'); ?></th>
                  <th><?php _e('操作'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php if ($deactivatedPlugins->have()): ?>
                <?php while ($deactivatedPlugins->next()): ?>
                <tr id="plugin-<?php $deactivatedPlugins->name(); ?>">
                  <td><?php $deactivatedPlugins->title(); ?></td>
                  <td><?php $deactivatedPlugins->description(); ?></td>
                  <td><?php $deactivatedPlugins->version(); ?></td>
                  <td><?php echo empty($deactivatedPlugins->homepage) ? $deactivatedPlugins->author : '<a href="' . $deactivatedPlugins->homepage
                  . '">' . $deactivatedPlugins->author . '</a>'; ?></td>
                  <td>
                      <a href="<?php $security->index('/action/plugins-edit?activate=' . $deactivatedPlugins->name); ?>"><?php _e('启用'); ?></a>
                  </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                  <td colspan="5"><h6 class="typecho-list-table-title"><?php _e('没有安装插件'); ?></h6></td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!--end main content-->
<?php
include 'footer-js.php';
include 'footer.php';
?>
