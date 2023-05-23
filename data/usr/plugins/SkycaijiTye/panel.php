<?php
include 'common.php';
include 'header.php';
include 'top-header.php';
include 'sidebar.php';

$options=Helper::options();

require_once 'skycaiji2cms/skycaiji2cms.php';
$scj2cms=new skycaiji2cms(
    rtrim(__TYPECHO_ROOT_DIR__,'/\\').DIRECTORY_SEPARATOR.trim(__TYPECHO_PLUGIN_DIR__,'/\\').DIRECTORY_SEPARATOR.'SkycaijiTye',
    $options->pluginUrl.'/SkycaijiTye',
    'utf-8',
    false
);
$scj2cms->apiUrl=$scj2cms->pluginUrl.'post.php';

//报错函数
function funcShowError($msg){
    $options=Helper::options();
    $options->widget('Widget_Notice')->set(_t($msg), 'error');
    $options->response->redirect(Typecho_Common::url('options-plugin.php?config=SkycaijiTye', $options->adminUrl));
}
$scj2cms->funcError='funcShowError';


$pluginConfig=Typecho_Widget::widget('Widget_Options')->plugin('SkycaijiTye');
$scj2cms->pluginConfig=array(
    'apikey'=>$pluginConfig->apikey,
    'author'=>$pluginConfig->author,
    'apitype'=>$pluginConfig->apitype
);

$error=null;
if(empty($pluginConfig)){
    $error='请设置参数';
}elseif(empty($pluginConfig->apikey)){
    $error='请设置密钥';
}elseif(empty($pluginConfig->author)){
    $error='请设置作者';
}
if($error){
    funcShowError($error);
}


$scj2cms->formRequired=array(
    'title'=>'标题',
    'text'=>'正文'
);
$scj2cms->formOptional=array(
    'date'=>'发布时间（默认当前时间）',
    'category'=>'分类名称、缩略名或id（默认空，多个用,号分隔）',
    'tags'=>'标签（默认空，多个用,号分隔）',
    'visibility'=>'公开度（默认publish，可填入 publish 公开、hidden 隐藏、password 密码保护、private 私密、waiting 待审核）',
    'password'=>'内容密码（默认空，当公开度是password时可用）',
    'allowComment'=>'允许评论（默认1，可填入 1 是、0 否）',
    'allowPing'=>'允许被引用（默认1，可填入 1 是、0 否）',
    'allowFeed'=>'允许在聚合中出现（默认1，可填入 1 是、0 否）',
    'trackback'=>'引用通告（默认空）',
    'fieldNames[索引]'=>'【自定义字段】字段名称，索引从0开始',
    'fieldTypes[索引]'=>'【自定义字段】字段类型，可填入 str 字符、int 整数、float 小数，索引从0开始',
    'fieldValues[索引]'=>'【自定义字段】字段值，索引从0开始',
);

echo '<main class="page-content"><h3>文章远程发布接口使用 <a href="'.Typecho_Common::url('options-plugin.php?config=SkycaijiTye', $options->adminUrl).'">设置</a></h3>';
$scj2cms->formView();
echo '</main>';
include 'footer-js.php';
include 'footer.php';
?>
