<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$commentsShowOptions = array(
  'commentsShowCommentOnly'   =>  _t('仅显示评论, 不显示 Pingback 和 Trackback'),
  'commentsMarkdown'      =>  _t('在评论中使用 Markdown 语法'),
  'commentsShowUrl'       =>  _t('评论者名称显示时自动加上其个人主页链接'),
  'commentsUrlNofollow'   =>  _t('对评论者个人主页链接使用 <a href="http://en.wikipedia.org/wiki/Nofollow">nofollow 属性</a>'),
  'commentsAvatar'        =>  _t('启用 <a href="http://gravatar.com">Gravatar</a> 头像服务, 最高显示评级为 %s 的头像',
  '</label><select id="commentsShow-commentsAvatarRating" name="commentsAvatarRating" class="form-select"
  style="width: 120px; display: inline-block; font-size: 0.8rem;padding: 0.1rem 0.8rem; margin: 0 5px;">
  <option value="G"' . ('G' == $options->commentsAvatarRating ? ' selected="true"' : '') . '>' . _t('G - 普通') .'</option>
  <option value="PG"' . ('PG' == $options->commentsAvatarRating ? ' selected="true"' : '') . '>' . _t('PG - 13岁以上') .'</option>
  <option value="R"' . ('R' == $options->commentsAvatarRating ? ' selected="true"' : '') . '>' . _t('R - 17岁以上成人') .'</option>
  <option value="X"' . ('X' == $options->commentsAvatarRating ? ' selected="true"' : '') . '>' . _t('X - 限制级') .'</option></select>
  <label for="commentsShow-commentsAvatarRating">'),
  'commentsPageBreak'     =>  _t('启用分页, 并且每页显示 %s 篇评论, 在列出时将 %s 作为默认显示',
  '</label><input type="text" value="' . $options->commentsPageSize
  . '" class="form-control" id="commentsShow-commentsPageSize" name="commentsPageSize"
  style="width: 100px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;" /><label for="commentsShow-commentsPageSize">',
  '</label><select id="commentsShow-commentsPageDisplay" name="commentsPageDisplay" class="form-select"
  style="width: 120px; display: inline-block; font-size: 0.8rem;padding: 0.1rem 0.8rem; margin: 0 5px;">
  <option value="first"' . ('first' == $options->commentsPageDisplay ? ' selected="true"' : '') . '>' . _t('第一页') . '</option>
  <option value="last"' . ('last' == $options->commentsPageDisplay ? ' selected="true"' : '') . '>' . _t('最后一页') . '</option></select>'
  . '<label for="commentsShow-commentsPageDisplay">'),
  'commentsThreaded'      =>  _t('启用评论回复, 以 %s 层作为每个评论最多的回复层数',
  '</label><input name="commentsMaxNestingLevels" type="text" class="form-control"
  style="width: 100px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;" value="' . $options->commentsMaxNestingLevels . '" id="commentsShow-commentsMaxNestingLevels" />
  <label for="commentsShow-commentsMaxNestingLevels">') . '</label></span><span class="multiline">'
  . _t('将 %s 的评论显示在前面', '<select id="commentsShow-commentsOrder" name="commentsOrder" class="form-select"
  style="width: 120px; display: inline-block; font-size: 0.8rem;padding: 0.1rem 0.8rem; margin: 0 5px;">
  <option value="DESC"' . ('DESC' == $options->commentsOrder ? ' selected="true"' : '') . '>' . _t('较新的') . '</option>
  <option value="ASC"' . ('ASC' == $options->commentsOrder ? ' selected="true"' : '') . '>' . _t('较旧的') . '</option></select><label for="commentsShow-commentsOrder">')
);

/** 评论列表数目 */
$commentsShowOptionsValue = array();
if ($options->commentsShowCommentOnly) {
  $commentsShowOptionsValue[] = 'commentsShowCommentOnly';
}

if ($options->commentsMarkdown) {
  $commentsShowOptionsValue[] = 'commentsMarkdown';
}

if ($options->commentsShowUrl) {
  $commentsShowOptionsValue[] = 'commentsShowUrl';
}

if ($options->commentsUrlNofollow) {
  $commentsShowOptionsValue[] = 'commentsUrlNofollow';
}

if ($options->commentsAvatar) {
  $commentsShowOptionsValue[] = 'commentsAvatar';
}

if ($options->commentsPageBreak) {
  $commentsShowOptionsValue[] = 'commentsPageBreak';
}

if ($options->commentsThreaded) {
  $commentsShowOptionsValue[] = 'commentsThreaded';
}

/** 评论提交 */
$commentsPostOptions = array(
  'commentsRequireModeration'     =>  _t('所有评论必须经过审核'),
  'commentsWhitelist'     =>  _t('评论者之前须有评论通过了审核'),
  'commentsRequireMail'           =>  _t('必须填写邮箱'),
  'commentsRequireURL'            =>  _t('必须填写网址'),
  'commentsCheckReferer'          =>  _t('检查评论来源页 URL 是否与文章链接一致'),
  'commentsAntiSpam'              =>  _t('开启反垃圾保护'),
  'commentsAutoClose'             =>  _t('在文章发布 %s 天以后自动关闭评论',
  '</label><input name="commentsPostTimeout" type="text" class="form-control"
  style="width: 100px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;"
  value="' . intval($options->commentsPostTimeout / (24 * 3600)) . '" id="commentsPost-commentsPostTimeout" />
  <label for="commentsPost-commentsPostTimeout">'),
  'commentsPostIntervalEnable'    =>  _t('同一 IP 发布评论的时间间隔限制为 %s 分钟',
  '</label><input name="commentsPostInterval" type="text" class="form-control"
  style="width: 100px; display: inline-block; font-size: 0.8rem; padding: 0.1rem 0.8rem; margin: 0 5px;"
  value="' . round($options->commentsPostInterval / (60), 1) . '" id="commentsPost-commentsPostInterval" />
  <label for="commentsPost-commentsPostInterval">')
);

$commentsPostOptionsValue = array();
if ($options->commentsRequireModeration) {
  $commentsPostOptionsValue[] = 'commentsRequireModeration';
}

if ($options->commentsWhitelist) {
  $commentsPostOptionsValue[] = 'commentsWhitelist';
}

if ($options->commentsRequireMail) {
  $commentsPostOptionsValue[] = 'commentsRequireMail';
}

if ($options->commentsRequireURL) {
  $commentsPostOptionsValue[] = 'commentsRequireURL';
}

if ($options->commentsCheckReferer) {
  $commentsPostOptionsValue[] = 'commentsCheckReferer';
}

if ($options->commentsAntiSpam) {
  $commentsPostOptionsValue[] = 'commentsAntiSpam';
}

if ($options->commentsAutoClose) {
  $commentsPostOptionsValue[] = 'commentsAutoClose';
}

if ($options->commentsPostIntervalEnable) {
  $commentsPostOptionsValue[] = 'commentsPostIntervalEnable';
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
          <li class="breadcrumb-item active" aria-current="page"><?php _e('评论设置') ?></li>
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
            action="<?php echo $security->getIndex('/action/options-discussion'); ?>"
            method="post"
            enctype="application/x-www-form-urlencoded"
            novalidate
          >
            <div class="col-md-12">
              <label for="commentDateFormat" class="form-label"><?php _e('评论日期格式') ?></label>
              <input
                type="text"
                class="form-control"
                id="commentDateFormat"
                name="commentDateFormat"
                value="<?php $options->commentDateFormat() ?>"
              >
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('这是一个默认的格式,当你在模板中调用显示评论日期方法时, 如果没有指定日期格式, 将按照此格式输出.') .
                '<br />'.
                _t('具体写法请参考 <a href="http://www.php.net/manual/zh/function.date.php">PHP 日期格式写法</a>.')
                ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="commentDateFormat" class="form-label"><?php _e('评论列表数目') ?></label>
              <input
                type="text"
                class="form-control"
                id="commentsListSize"
                name="commentsListSize"
                value="<?php $options->commentsListSize() ?>"
              >
              <div class="my-2 small text-secondary">
                <?php echo _t('此数目用于指定显示在侧边栏中的评论列表数目.') ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="commentsShow" class="form-label"><?php _e('评论显示') ?></label>
              <div class="col-md-12">
                <?php foreach ($commentsShowOptions as $key => $value): ?>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value="<?php echo $key; ?>"
                    id="commentsShow-<?php echo $key; ?>"
                    name="commentsShow[]"
                    <?php echo in_array($key, $commentsShowOptionsValue) ? ' checked' : '' ?>
                  >
                  <label class="form-check-label" for="commentsShow-<?php echo $key; ?>">
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
              <label for="commentsPost" class="form-label"><?php _e('评论提交') ?></label>
              <div class="col-md-12">
                <?php foreach ($commentsPostOptions as $key => $value): ?>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value="<?php echo $key; ?>"
                    id="commentsPost-<?php echo $key; ?>"
                    name="commentsPost[]"
                    <?php echo in_array($key, $commentsPostOptionsValue) ? ' checked' : '' ?>
                  >
                  <label class="form-check-label" for="commentsPost-<?php echo $key; ?>">
                    <?php echo $value; ?>
                  </label>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-md-12">
              <label for="commentsHTMLTagAllowed" class="form-label"><?php _e('允许使用的HTML标签和属性') ?></label>
              <textarea
                rows="3"
                class="form-control"
                id="commentsHTMLTagAllowed"
                name="commentsHTMLTagAllowed"
              >
              <?php $options->commentsHTMLTagAllowed() ?>
              </textarea>
              <div class="my-2 small text-secondary">
                <?php
                  echo _t('默认的用户评论不允许填写任何的HTML标签, 你可以在这里填写允许使用的HTML标签.') .
                '<br />'.
                _t('比如: %s', '<code>&lt;a href=&quot;&quot;&gt; &lt;img src=&quot;&quot;&gt; &lt;blockquote&gt;</code>')
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
