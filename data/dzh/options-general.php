<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

/** 时区 */
$timezoneList = array(
  "0"         => _t('格林威治(子午线)标准时间 (GMT)'),
  "3600"      => _t('中欧标准时间 阿姆斯特丹,荷兰,法国 (GMT +1)'),
  "7200"      => _t('东欧标准时间 布加勒斯特,塞浦路斯,希腊 (GMT +2)'),
  "10800"     => _t('莫斯科时间 伊拉克,埃塞俄比亚,马达加斯加 (GMT +3)'),
  "14400"     => _t('第比利斯时间 阿曼,毛里塔尼亚,留尼汪岛 (GMT +4)'),
  "18000"     => _t('新德里时间 巴基斯坦,马尔代夫 (GMT +5)'),
  "21600"     => _t('科伦坡时间 孟加拉 (GMT +6)'),
  "25200"     => _t('曼谷雅加达 柬埔寨,苏门答腊,老挝 (GMT +7)'),
  "28800"     => _t('北京时间 香港,新加坡,越南 (GMT +8)'),
  "32400"     => _t('东京平壤时间 西伊里安,摩鹿加群岛 (GMT +9)'),
  "36000"     => _t('悉尼关岛时间 塔斯马尼亚岛,新几内亚 (GMT +10)'),
  "39600"     => _t('所罗门群岛 库页岛 (GMT +11)'),
  "43200"     => _t('惠灵顿时间 新西兰,斐济群岛 (GMT +12)'),
  "-3600"     => _t('佛德尔群岛 亚速尔群岛,葡属几内亚 (GMT -1)'),
  "-7200"     => _t('大西洋中部时间 格陵兰 (GMT -2)'),
  "-10800"    => _t('布宜诺斯艾利斯 乌拉圭,法属圭亚那 (GMT -3)'),
  "-14400"    => _t('智利巴西 委内瑞拉,玻利维亚 (GMT -4)'),
  "-18000"    => _t('纽约渥太华 古巴,哥伦比亚,牙买加 (GMT -5)'),
  "-21600"    => _t('墨西哥城时间 洪都拉斯,危地马拉,哥斯达黎加 (GMT -6)'),
  "-25200"    => _t('美国丹佛时间 (GMT -7)'),
  "-28800"    => _t('美国旧金山时间 (GMT -8)'),
  "-32400"    => _t('阿拉斯加时间 (GMT -9)'),
  "-36000"    => _t('夏威夷群岛 (GMT -10)'),
  "-39600"    => _t('东萨摩亚群岛 (GMT -11)'),
  "-43200"    => _t('艾尼威托克岛 (GMT -12)')
);

/** 扩展名 */
$attachmentTypesOptionsResult = (NULL != trim($options->attachmentTypes))
  ? array_map('trim', explode(',', $options->attachmentTypes))
  : array();
$attachmentTypesOptionsValue = array();

if (in_array('@image@', $attachmentTypesOptionsResult)) {
  $attachmentTypesOptionsValue[] = '@image@';
}

if (in_array('@media@', $attachmentTypesOptionsResult)) {
  $attachmentTypesOptionsValue[] = '@media@';
}

if (in_array('@doc@', $attachmentTypesOptionsResult)) {
  $attachmentTypesOptionsValue[] = '@doc@';
}

$attachmentTypesOther = array_diff($attachmentTypesOptionsResult, $attachmentTypesOptionsValue);
$attachmentTypesOtherValue = '';
if (!empty($attachmentTypesOther)) {
  $attachmentTypesOptionsValue[] = '@other@';
  $attachmentTypesOtherValue = implode(',', $attachmentTypesOther);
}

$attachmentTypesOptions = array(
  '@image@'    =>  _t('图片文件') . ' <code>(gif jpg jpeg png tiff bmp)</code>',
  '@media@'    =>  _t('多媒体文件') . ' <code>(mp3 wmv wma rmvb rm avi flv)</code>',
  '@doc@'      =>  _t('常用档案文件') . ' <code>(txt doc docx xls xlsx ppt pptx zip rar pdf)</code>',
  '@other@'    =>  _t('其他格式 %s', ' <input type="text" class="form-control"
  style="width: 300px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;"
  name="attachmentTypesOther" value="' . htmlspecialchars($attachmentTypesOtherValue) . '" />'),
);
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('基本设置') ?></li>
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
            action="<?php echo $security->getIndex('/action/options-general'); ?>"
            method="post"
            enctype="application/x-www-form-urlencoded"
            novalidate
          >
            <div class="col-md-12">
              <label for="title" class="form-label"><?php _e('站点名称') ?></label>
              <input
                type="text"
                class="form-control"
                id="title"
                name="title"
                value="<?php $options->title() ?>"
                required
              >
              <div class="invalid-feedback">
                <?php _e('请填写站点名称.') ?>
              </div>
              <div class="my-2 small text-secondary"><?php _e('站点的名称将显示在网页的标题处.') ?></div>
            </div>
            <?php if (!defined('__TYPECHO_SITE_URL__')): ?>
            <div class="col-md-12">
              <label for="siteUrl" class="form-label"><?php _e('站点地址') ?></label>
              <input
                type="text"
                class="form-control"
                id="siteUrl"
                name="siteUrl"
                value="<?php $options->originalSiteUrl() ?>"
                required
              >
              <div class="my-2 small text-secondary"><?php _e('站点地址主要用于生成内容的永久链接.') ?></div>
            </div>
            <?php endif; ?>
            <div class="col-md-12">
              <label for="description" class="form-label"><?php _e('站点描述') ?></label>
              <input
                type="text"
                class="form-control"
                id="description"
                name="description"
                value="<?php $options->description() ?>"
              >
              <div class="my-2 small text-secondary"><?php _e('站点描述将显示在网页代码的头部.') ?></div>
            </div>
            <div class="col-md-12">
              <label for="keywords" class="form-label"><?php _e('关键词') ?></label>
              <input
                type="text"
                class="form-control"
                id="keywords"
                name="keywords"
                value="<?php $options->keywords() ?>"
              >
              <div class="my-2 small text-secondary"><?php _e('请以半角逗号 "," 分割多个关键字.') ?></div>
            </div>
            <div class="col-md-12">
              <label for="allowRegister" class="form-label"><?php _e('是否允许注册') ?></label>
              <div class="d-flex align-items-center gap-3">
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="allowRegister-0"
                    name="allowRegister"
                    value="0"
                    <?php echo $options->allowRegister == 0 ? ' checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="allowRegister-0"><?php _e('不允许') ?></label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="allowRegister-1"
                    name="allowRegister"
                    value="1"
                    <?php echo $options->allowRegister == 1 ? 'checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="allowRegister-1"><?php _e('允许') ?></label>
                </div>
              </div>
              <div class="my-2 small text-secondary">
                <?php _e('允许访问者注册到你的网站, 默认的注册用户不享有任何写入权限.') ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="allowXmlRpc" class="form-label"><?php _e('XMLRPC 接口') ?></label>
              <div class="d-flex align-items-center gap-3">
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="allowXmlRpc-0"
                    name="allowXmlRpc"
                    value="0"
                    <?php echo $options->allowXmlRpc == 0 ? ' checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="allowXmlRpc-0"><?php _e('关闭') ?></label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="allowXmlRpc-1"
                    name="allowXmlRpc"
                    value="1"
                    <?php echo $options->allowXmlRpc == 1 ? 'checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="allowXmlRpc-1"><?php _e('仅关闭 Pingback 接口') ?></label>
                </div>
                <div class="form-check">
                  <input
                    type="radio"
                    class="form-check-input"
                    id="allowXmlRpc-2"
                    name="allowXmlRpc"
                    value="2"
                    <?php echo $options->allowXmlRpc == 2 ? 'checked="checked"' : '' ?>
                    required
                  >
                  <label class="form-check-label" for="allowXmlRpc-2"><?php _e('打开') ?></label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <label for="timezone" class="form-label"><?php _e('时区') ?></label>
              <div class="col-md-12">
                <select class="form-select" id="timezone" name="timezone">
                  <option selected disabled value>请选择...</option>
                  <?php foreach ($timezoneList as $key => $value): ?>
                    <option
                      value="<?php echo $key; ?>"
                      <?php echo $options->timezone == $key ? ' selected="true"' : '' ?>>
                      <?php echo $value; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <label for="attachmentTypes" class="form-label"><?php _e('允许上传的文件类型') ?></label>
              <div class="col-md-12">
                <?php foreach ($attachmentTypesOptions as $key => $value): ?>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value="<?php echo $key; ?>"
                    id="attachmentTypes-<?php echo $key; ?>"
                    name="attachmentTypes[]"
                    <?php echo in_array($key, $attachmentTypesOptionsValue) ? ' checked' : '' ?>
                  >
                  <label class="form-check-label" for="attachmentTypes-<?php echo $key; ?>">
                    <?php echo $value; ?>
                  </label>
                </div>
                <?php endforeach; ?>
                <div class="my-2 small text-secondary">
                  <?php _e('用逗号 "," 将后缀名隔开, 例如: %s', '<code>cpp, h, mak</code>') ?>
                </div>
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
