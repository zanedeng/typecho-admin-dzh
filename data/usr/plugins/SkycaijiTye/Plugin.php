<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 文章远程发布接口。修改自<a href="https://www.skycaiji.com">蓝天采集</a>
 *
 * @package SkycaijiTye
 * @author zane.deng
 * @version 1.1.0
 * @link https://www.zanejs.com
 */
class SkycaijiTye_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate(){
        Helper::addPanel(4, 'SkycaijiTye/panel.php', _t('文章远程接口'), _t('文章远程接口'), 'administrator');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
        Helper::removePanel(4, 'SkycaijiTye/panel.php');
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $options = Helper::options();
        $link = new Typecho_Widget_Helper_Layout('div');
        $link->html('<a href="'.$options->adminUrl.'extending.php?panel=SkycaijiTye%2Fpanel.php"><b style="font-size:16px">使用接口</b></a>');
        $author = new Typecho_Widget_Helper_Form_Element_Textarea('author', NULL, '', _t('作者（用户名或id，一行一个随机使用）'));
        $author->addRule('required', _t('请设置作者'));
        $apikey = new Typecho_Widget_Helper_Form_Element_Text('apikey', NULL, '', _t('密钥（防止接口被盗用）'));
        $apikey->addRule('required', _t('请设置密钥'));
        $apitype = new Typecho_Widget_Helper_Form_Element_Select('apitype', array(''=>'便捷（密钥明文传输有泄露风险）','safe'=>'安全（需要签名处理）'), '', _t('接口类型'));
        $html2markdown = new Typecho_Widget_Helper_Form_Element_Radio('html2markdown', array('disable'=>_t('不转换'),'able'=>_t('自动转换')), 'disable', _t('html转换markdown（在php5.4-php7中有效）'));

        $form->addInput($author);
        $form->addInput($apikey);
        $form->addInput($apitype);
        $form->addInput($html2markdown);
        $form->addItem($link);
    }
    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
}
