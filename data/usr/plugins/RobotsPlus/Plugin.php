<?php
/**
 * 蜘蛛来访日志插件，记录蜘蛛爬行的时间及其网址。修改自<a href="http://www.yovisun.com">YoviSun</a>
 *
 * @package RobotsPlus
 * @author  zane.deng
 * @version 1.0.0
 * @link http://www.zanejs.com
 */
class RobotsPlus_Plugin implements Typecho_Plugin_Interface
{
  public static function activate()
  {
    $meg = RobotsPlus_Plugin::install();
    Helper::addPanel(4, 'RobotsPlus/Logs.php', '蜘蛛日志', '查看蜘蛛日志', 'administrator');
        Typecho_Plugin::factory('Widget_Archive')->header = array('RobotsPlus_Plugin', 'isbot');
    return _t($meg.'。请进行<a href="options-plugin.php?config=RobotsPlus">初始化设置</a>');
  }

  public static function deactivate()
	{
		$config  = Typecho_Widget::widget('Widget_Options')->plugin('RobotsPlus');
		$isdrop = $config->droptable;
		if ($isdrop == 0)
		{
			$db = Typecho_Db::get();
			$prefix = $db->getPrefix();
			$db->query("DROP TABLE `".$prefix."robots_logs`", Typecho_Db::WRITE);
		}
		Helper::removePanel(4, 'RobotsPlus/Logs.php');
	}

  public static function config(Typecho_Widget_Helper_Form $form)
	{
		$options = array (
			'baidu' => '百度',
			'google' => '谷歌',
			'sogou' => '搜狗',
			'youdao' => '有道',
			'soso' => '搜搜',
			'bing' => '必应',
			'yahoo' => '雅虎',
      '360' => '360搜索'
		);
		$botlist = new Typecho_Widget_Helper_Form_Element_Checkbox(
			'botlist', $options, '', '蜘蛛记录设置:', '请选择要记录的蜘蛛日志');

		$pagecount = new Typecho_Widget_Helper_Form_Element_Text(
          'pagecount', NULL, '',
          '分页数量', '每页显示的日志数量');
		$dbool = array (
			'0' => '删除',
			'1' => '不删除'
			);
		$droptable = new Typecho_Widget_Helper_Form_Element_Radio(
			'droptable', $dbool, '', '删除数据表:', '请选择是否在禁用插件时，删除日志数据表');
        $form->addInput($botlist);
		$form->addInput($pagecount);
		$form->addInput($droptable);
	}

  public static function personalConfig(Typecho_Widget_Helper_Form $form)
	{
	}

	public static function install()
	{
		$installDb = Typecho_Db::get();
		$type = explode('_', $installDb->getAdapterName());
		$type = array_pop($type);
		$prefix = $installDb->getPrefix();
		$scripts = file_get_contents('usr/plugins/RobotsPlus/Mysql.sql');
		$scripts = str_replace('typecho_', $prefix, $scripts);
		$scripts = str_replace('%charset%', 'utf8', $scripts);
		$scripts = explode(';', $scripts);
		try {
			foreach ($scripts as $script) {
				$script = trim($script);
				if ($script) {
					$installDb->query($script, Typecho_Db::WRITE);
				}
			}
			return '成功创建数据表，插件启用成功';
		} catch (Typecho_Db_Exception $e) {
			$code = $e->getCode();
			if(('Mysql' == $type && 1050 == $code)) {
					$script = 'SELECT `lid`, `bot`, `url`, `ip`, `ltime` from `' . $prefix . 'robots_logs`';
					$installDb->query($script, Typecho_Db::READ);
					return '数据表已存在，插件启用成功';
			} else {
				throw new Typecho_Plugin_Exception('数据表建立失败，插件启用失败。错误号：'.$code);
			}
		}
	}

  public static function isbot($rule = NULL)
  {
		$config  = Typecho_Widget::widget('Widget_Options')->plugin('RobotsPlus');
		$bot = NULL;
		$botlist = $config->botlist;
		if (sizeof($botlist)>0) {
			@ $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
			foreach ($botlist as $value) {
				if (strpos($useragent,$value)!== false) {
					$bot = $value;
				}
			}
			if ($bot !== NULL) {
				$request = new Typecho_Request;
				$ip = $request->getIp();
				$url = $_SERVER['REQUEST_URI'];
				if ($ip == NULL){
					$ip = 'UnKnow';
				}
				$options = Typecho_Widget::widget('Widget_Options');
				$timeStamp = $options->gmtTime;
				$offset = $options->timezone - $options->serverTimezone;
				$gtime = $timeStamp + $offset;
				$db = Typecho_Db::get();
				$rows = array (
					'bot' => $bot,
					'url' => $url,
					'ip' => $ip,
					'ltime' => $gtime,
					);
				$db->query($db->insert('table.robots_logs')->rows($rows));
			}
		}
  }
}
