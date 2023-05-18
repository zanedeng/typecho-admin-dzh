<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$errorStr = '';
if (!$options->rewrite && !$request->is('enableRewriteAnyway=1')) {
  $errorStr = _t('重写功能检测失败, 请检查你的服务器设置');
  /** 如果是apache服务器, 可能存在无法写入.htaccess文件的现象 */
  if (((isset($_SERVER['SERVER_SOFTWARE']) && false !== strpos(strtolower($_SERVER['SERVER_SOFTWARE']), 'apache'))
    || function_exists('apache_get_version')) && !file_exists(__TYPECHO_ROOT_DIR__ . '/.htaccess')
    && !is_writeable(__TYPECHO_ROOT_DIR__)) {
    $errorStr .= '<br /><strong>' . _t('我们检测到你使用了apache服务器, 但是程序无法在根目录创建.htaccess文件, 这可能是产生这个错误的原因.')
      . _t('请调整你的目录权限, 或者手动创建一个.htaccess文件.') . '</strong>';
  }

  $errorStr .= '<br /><input type="checkbox" class="form-check-input" name="enableRewriteAnyway" id="enableRewriteAnyway" value="1" />'
    . ' <label for="enableRewriteAnyway">' . _t('如果你仍然想启用此功能, 请勾选这里') . '</label>';
}

$patterns = array(
  '/archives/[cid:digital]/' => _t('默认风格') . ' <code>/archives/{cid}/</code>',
  '/archives/[slug].html' => _t('wordpress风格') . ' <code>/archives/{slug}.html</code>',
  '/[year:digital:4]/[month:digital:2]/[day:digital:2]/[slug].html' => _t('按日期归档') . ' <code>/archives/{year}/{month}/{day}/{slug}.html</code>',
  '/[category]/[slug].html' => _t('按分类归档') . ' <code>/{category}/{slug}.html</code>'
);

/** 自定义文章路径 */
$postPatternValue = $options->routingTable['post']['url'];

/** 增加个性化路径 */
$customPatternValue = NULL;
if (isset($request->__typecho_form_item_postPattern)) {
    $customPatternValue = $request->__typecho_form_item_postPattern;
    Typecho_Cookie::delete('__typecho_form_item_postPattern');
} else if (!isset($patterns[$postPatternValue])) {
    $customPatternValue = decodeRule($postPatternValue);
}
$patterns['custom'] = _t('个性化定义') .
' <input type="text" class="form-control"
style="width: 300px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;"
name="customPattern" value="' . $customPatternValue . '" />';

?>
<!--start main content-->
<main class="page-content">
  <!--breadcrumb-->
  <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><?php _e('系统设置') ?></div>
    <div class="ps-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 p-0">
          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php _e('链接设置') ?></li>
        </ol>
      </nav>
    </div>
    <div class="ms-auto">
      <div class="btn-group"></div>
    </div>
  </div>
  <!--end breadcrumb-->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body p-4">
          <form
            class="row g-3 needs-validation"
            action="<?php echo $security->getRootUrl('index.php/action/options-permalink'); ?>"
            method="post"
            enctype="application/x-www-form-urlencoded"
            novalidate
          >
            <?php if (!defined('__TYPECHO_REWRITE__')): ?>
            <div class="col-md-12">
              <label for="rewrite" class="form-label"><?php _e('是否使用地址重写功能') ?></label>
              <div class="d-flex align-items-center gap-3">
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="rewrite-0"
                    name="rewrite"
                    value="0"
                    <?php echo $options->rewrite == 0 ? ' checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="rewrite-0"><?php _e('不启用') ?></label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="rewrite-1"
                    name="rewrite"
                    value="1"
                    <?php echo $options->rewrite == 1 ? 'checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="rewrite-1"><?php _e('启用') ?></label>
                </div>
              </div>
              <?php if (!empty($errorStr)): ?>
                <div class="alert border-0 bg-warning-subtle alert-dismissible fade show py-2">
                  <div class="d-flex align-items-center">
                    <div class="fs-3 text-warning"><span class="material-symbols-outlined">warning</span>
                    </div>
                    <div class="ms-3">
                      <div class="text-warning"><?php echo $errorStr; ?></div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('地址重写即 rewrite 功能是某些服务器软件提供的优化内部连接的功能.') . '<br />'
                  . _t('打开此功能可以让你的链接看上去完全是静态地址.')
                ?>
              </div>
            </div>
            <?php endif; ?>
            <div class="col-md-12">
              <label for="postPattern" class="form-label"><?php _e('自定义文章路径') ?></label>
              <div class="col-md-12">
                <?php foreach ($patterns as $key => $value): ?>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    value="<?php echo $key; ?>"
                    id="postPattern-<?php echo $key; ?>"
                    name="postPattern"
                    <?php echo $key == $postPatternValue ? ' checked' : '' ?>
                  >
                  <label class="form-check-label" for="postPattern-<?php echo $key; ?>">
                    <?php echo $value; ?>
                  </label>
                </div>
                <?php endforeach; ?>
              </div>
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('可用参数: <code>{cid}</code> 日志 ID, <code>{slug}</code> 日志缩略名, <code>{category}</code> 分类, <code>{directory}</code> 多级分类, <code>{year}</code> 年, <code>{month}</code> 月, <code>{day}</code> 日')
                  . '<br />' . _t('选择一种合适的文章静态路径风格, 使得你的网站链接更加友好.')
                  . '<br />' . _t('一旦你选择了某种链接风格请不要轻易修改它.')
                ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="pagePattern" class="form-label"><?php _e('独立页面路径') ?></label>
              <input
                type="text"
                class="form-control"
                id="pagePattern"
                name="pagePattern"
                value="<?php echo decodeRule($options->routingTable['page']['url']) ?>"
              >
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('可用参数: <code>{cid}</code> 页面 ID, <code>{slug}</code> 页面缩略名')
                  . '<br />'
                  . _t('请在路径中至少包含上述的一项参数.') ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="categoryPattern" class="form-label"><?php _e('分类路径') ?></label>
              <input
                type="text"
                class="form-control"
                id="categoryPattern"
                name="categoryPattern"
                value="<?php echo decodeRule($options->routingTable['page']['url']) ?>"
              >
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('可用参数: <code>{mid}</code> 分类 ID, <code>{slug}</code> 分类缩略名, <code>{directory}</code> 多级分类')
                      . '<br />'
                      . _t('请在路径中至少包含上述的一项参数.') ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-md-flex d-grid align-items-center gap-3">
                <button type="submit" class="btn btn-primary px-4"><?php echo _e('确认提交') ?></button>
              </div>
            </div>
          </form>
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
