<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

//首页显示
$frontPageParts = explode(':', $options->frontPage);
$frontPageType = $frontPageParts[0];
$frontPageValue = count($frontPageParts) > 1 ? $frontPageParts[1] : '';

$frontPageOptions = array(
  'recent'   =>  _t('显示最新发布的文章')
);

$frontPattern = '</label></span><span class="multiline front-archive%class%">'
  . '<input class="form-check-input" type="checkbox" id="frontArchive" name="frontArchive"
  style="float: none; margin: 0.25rem 0.2rem 0.25rem 1rem;"
  value="1"' . ($options->frontArchive && 'recent' != $frontPageType ? ' checked' : '') .' />
  <label for="frontArchive">' . _t('同时将文章列表页路径更改为 %s',
  '<input type="text" name="archivePattern" class="form-control"
  style="width: 100px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;"
  value="'. htmlspecialchars(decodeRule($options->routingTable['archive']['url'])) . '" />')
  . '</label>';

// 页面列表
$db = Typecho_Db::get();
$pages = $db->fetchAll($db->select('cid', 'title')
->from('table.contents')->where('type = ?', 'page')
->where('status = ?', 'publish')->where('created < ?', $options->time));

if (!empty($pages)) {
    $pagesSelect = '<select name="frontPagePage" id="frontPage-frontPagePage" class="form-select"
    style="width: 120px; display: inline-block; font-size: 0.8rem;padding: 0.1rem 0.8rem; margin: 0 5px;">';
    foreach ($pages as $page) {
        $selected = '';
        if ('page' == $frontPageType && $page['cid'] == $frontPageValue) {
            $selected = ' selected="true"';
        }

        $pagesSelect .= '<option value="' . $page['cid'] . '"' . $selected
        . '>' . $page['title'] . '</option>';
    }
    $pagesSelect .= '</select>';
    $frontPageOptions['page'] = _t('使用 %s 页面作为首页', '</label>' . $pagesSelect . '<label for="frontPage-frontPagePage">');
    $selectedFrontPageType = 'page';
}

// 自定义文件列表
$files = glob($options->themeFile($options->theme, '*.php'));
$filesSelect = '';

foreach ($files as $file) {
    $info = Typecho_Plugin::parseInfo($file);
    $file = basename($file);

    if ('index.php' != $file && 'index' == $info['title']) {
        $selected = '';
        if ('file' == $frontPageType && $file == $frontPageValue) {
            $selected = ' selected="true"';
        }

        $filesSelect .= '<option value="' . $file . '"' . $selected
        . '>' . $file . '</option>';
    }
}

if (!empty($filesSelect)) {
    $frontPageOptions['file'] = _t('直接调用 %s 模板文件',  '</label>
      <select name="frontPageFile" id="frontPage-frontPageFile">'. $filesSelect . '</select>
      <label for="frontPage-frontPageFile">');
    $selectedFrontPageType = 'file';
}

if (isset($frontPageOptions[$frontPageType]) && 'recent' != $frontPageType && isset($selectedFrontPageType)) {
    $selectedFrontPageType = $frontPageType;
    $frontPattern = str_replace('%class%', '', $frontPattern);
}

if (isset($selectedFrontPageType)) {
    $frontPattern = str_replace('%class%', ' hidden', $frontPattern);
    $frontPageOptions[$selectedFrontPageType] .= $frontPattern;
}
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('阅读设置') ?></li>
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
            action="<?php echo $security->getIndex('/action/options-reading'); ?>"
            method="post"
            enctype="application/x-www-form-urlencoded"
            novalidate
          >
            <div class="col-md-12">
              <label for="postDateFormat" class="form-label"><?php _e('文章日期格式') ?></label>
              <input
                type="text"
                class="form-control"
                id="postDateFormat"
                name="postDateFormat"
                value="<?php $options->postDateFormat() ?>"
              >
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('此格式用于指定显示在文章归档中的日期默认显示格式.') . '<br />'
                  . _t('在某些主题中这个格式可能不会生效, 因为主题作者可以自定义日期格式.') . '<br />'
                  . _t('请参考 <a href="http://www.php.net/manual/zh/function.date.php">PHP 日期格式写法</a>.')
                ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="frontPage" class="form-label"><?php _e('站点首页') ?></label>
              <div class="col-md-12">
                <?php foreach ($frontPageOptions as $key => $value): ?>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    value="<?php echo $key; ?>"
                    id="frontPage-<?php echo $key; ?>"
                    name="frontPage"
                    <?php echo $key == $frontPageType ? ' checked' : '' ?>
                  >
                  <label class="form-check-label" for="frontPage-<?php echo $key; ?>">
                    <?php echo $value; ?>
                  </label>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="postsListSize" class="form-label"><?php _e('文章列表数目') ?></label>
              <input
                type="text"
                class="form-control"
                id="postsListSize"
                name="postsListSize"
                value="<?php $options->postsListSize() ?>"
              >
            </div>
            <div class="col-md-12">
              <label for="pageSize" class="form-label"><?php _e('每页文章数目') ?></label>
              <input
                type="text"
                class="form-control"
                id="pageSize"
                name="pageSize"
                value="<?php $options->pageSize() ?>"
              >
            </div>
            <div class="col-md-12">
              <label for="feedFullText" class="form-label"><?php _e('聚合全文输出') ?></label>
              <div class="d-flex align-items-center gap-3">
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="feedFullText-0"
                    name="feedFullText"
                    value="0"
                    <?php echo $options->feedFullText == 0 ? ' checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="feedFullText-0"><?php _e('仅输出摘要') ?></label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="feedFullText-1"
                    name="feedFullText"
                    value="1"
                    <?php echo $options->feedFullText == 1 ? 'checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="feedFullText-1"><?php _e('全文输出') ?></label>
                </div>
              </div>
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('如果你不希望在聚合中输出文章全文,请使用仅输出摘要选项.') . '<br />'
                  . _t('摘要的文字取决于你在文章中使用分隔符的位置.')
                ?>
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
