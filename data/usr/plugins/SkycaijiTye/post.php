<?php
include_once '../../../config.inc.php';
function skycaiji2cms_head_func(){
    if(!defined('__TYPECHO_ROOT_DIR__')){
        exit;
    }
}
skycaiji2cms_head_func();
define('skycaiji2cms_head_func', 'skycaiji2cms_head_func');

require_once 'skycaiji2cms/skycaiji2cms.php';
$options=Helper::options();
$scj2cms=new skycaiji2cms(
    rtrim(__TYPECHO_ROOT_DIR__,'/\\').DIRECTORY_SEPARATOR.trim(__TYPECHO_PLUGIN_DIR__,'/\\').DIRECTORY_SEPARATOR.'SkycaijiTye',
    $options->pluginUrl.'/SkycaijiTye',
    'utf-8',
    false
);

//根网址
$options->rootUrl=str_replace('/usr/plugins/SkycaijiTye', '', $options->rootUrl);
$options->rootUrl=rtrim($options->rootUrl,'/');

//终止执行
function pluginExitDo(){
    global $scj2cms;
    $html=ob_get_contents();//获取输出
    $html=trim($html);
    ob_clean();//清理页面
    if(!empty($html)){
        if(strpos($html, '{')===0){
            //是json
            $json=json_decode($html,true);
            if(isset($json['success'])){
                //typecho的数据
                $cid=intval($json['cid']);
                if($cid>0){
                    $db=Typecho_Db::get();
                    $update=$db->update('table.contents')->rows(array('type'=>'post'))->where('cid = ?',$cid);//设置为post
                    $db->query($update);
                    
                    $options=Helper::options();
                    $scj2cms->returnJson($cid,'',$options->rootUrl.'/index.php/archives/'.$cid.'/');
                }else{
                    $scj2cms->returnJson(0,'失败');
                }
            }else{
                exit($html);
            }
        }else{
            if(preg_match('/<div class="container">([\s\S]+?)<\/div>/i', $html, $error)){
                $error=trim($error[1]);
            }
            $error=$error?$error:'错误';
            $scj2cms->returnJson(0,$error);
        }
    }
    $scj2cms->returnJson(0,'失败');
}

ob_clean();//清除输出
ob_start();//缓存输出

register_shutdown_function('pluginExitDo');

$pluginConfig=Typecho_Widget::widget('Widget_Options')->plugin('SkycaijiTye');
$scj2cms->pluginConfig=array(
    'apikey'=>$pluginConfig->apikey,
    'author'=>$pluginConfig->author,
    'apitype'=>$pluginConfig->apitype,
    'html2markdown'=>$pluginConfig->html2markdown
);

//发布函数
function funcApiPost(){
    global $scj2cms;
    if(empty($_POST['title'])){
        $scj2cms->returnJson(0,'标题为空');
    }
    if(empty($_POST['text'])){
        $scj2cms->returnJson(0,'正文为空');
    }
    
    $tyReq=Typecho_Request::getInstance();
    
    if('able'==$scj2cms->pluginConfig['html2markdown']&&PHP_VERSION_ID>50400&&PHP_VERSION_ID<80000){
        //html转Markdown
        require 'vendor/autoload.php';
        $converter = new \League\HTMLToMarkdown\HtmlConverter();
        $text=$_POST['text'];
        $text=preg_replace('/<div[^<>]*>/i','<p>',$text);
        $text=preg_replace('/<\/div[^<>]*>/i','</p>',$text);
        $text=preg_replace('/<(style|script)[^<>]*>[\s\S]*?<\/\1>/i', '', $text);//去除脚本
        $text=strip_tags($text,'<p><strong><em><a><blockquote><pre><code><img><ol><ul><h1><h2><h3><h4><h5><h6><hr>');
        
        $text='<!--markdown-->'.$converter->convert($text);
        $_POST['text']=$text;
        $tyReq->setParam('text', $text);
    }
    
    $db=Typecho_Db::get();
    $query=null;
    //作者
    $author=$scj2cms->randLine($scj2cms->pluginConfig['author']);
    if(is_numeric($author)){
        $query=$db->select('uid')->from('table.users')->where('uid = ?', intval($author));
    }else{
        $query=$db->select('uid')->from('table.users')->where('name = ?', $author);
    }
    $userData=$db->fetchRow($query);
    $uid=0;
    if(!empty($userData)){
        $uid=$userData['uid'];
    }
    if($uid<=0){
        $scj2cms->returnJson(0,'作者'.$author.'不存在');
    }
    
    Typecho_Widget::widget('Widget_User')->to($user);
    $user->simpleLogin($uid);
    
    $_SERVER['HTTP_X_REQUESTED_WITH']='XMLHttpRequest';
    
    $defParams=array('visibility'=>'publish','allowComment'=>1,'allowPing'=>1,'allowFeed'=>1);
    foreach ($defParams as $k=>$v){
        if(!isset($_POST[$k])){
            $tyReq->setParam($k, $v);
        }
    }
    //分类
    $category=$_POST['category'];
    if(!empty($category)){
        $category=explode(',',$category);
        $category=is_array($category)?$category:'';
        $cids=array();
        foreach ($category as $v){
            $query=null;
            if(is_numeric($v)){
                $query=$db->select('*')->from('table.metas')->where('mid=?',intval($v));
            }else{
                $query=$db->select('*')->from('table.metas')->where('slug=?',$v)->orWhere('name=?',$v);
            }
            $catData=$db->fetchRow($query);
            if(!empty($catData)&&$catData['type']=='category'){
                $cids[$catData['mid']]=$catData['mid'];
            }
        }
        $_POST['category']=$cids;
    }else{
        $_POST['category']=null;
    }
    $tyReq->setParam('category', $_POST['category']);
    
    try{
        Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
        $post->writePost();
    }catch (\Exception $ex){
        $scj2cms->returnJson(0,$ex->getMessage());
    }
}
$scj2cms->funcApiPost='funcApiPost';
$scj2cms->apiPost();
?>