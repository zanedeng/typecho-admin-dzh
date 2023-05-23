<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 给文章添加一个投票评分功能。修改自<a href="http://lixinahua.com">绛木子</a>
 *
 * @package TePostRatings
 * @author zane.deng
 * @version 0.0.2
 * @link http://www.zanejs.com
 *
 * 使用方法：
 * 1、在后台启用‘TePostRatings’插件(会在内容表(contents)中新增两个字段：ratingsNum：评分用户数；ratingsAverage：平均评分；)，
 * 2、把 ‘<?php TePostRatings_Plugin::rating();?>’放在模版中需要显示的位置;
 * 3、在页面查看效果
 *
 * 调用排行
 * 在模版中任意位置调用此方法：‘<?php TePostRatings_Plugin::show($config,$pattern);?>’
 * $config = 'order=num|average&sort=desc&limit=10'       //显示参数
 * $pattern = '<li><a href="{permalink}">{title}</a></li>'  //显示样式
 */
class TePostRatings_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        $info = TePostRatings_Plugin::installPlugin();
        //把字段添加到查询中
        Typecho_Plugin::factory('Widget_Archive')->select = array('TePostRatings_Plugin', 'selectHandle');
		//设置展示样式及js
        Typecho_Plugin::factory('Widget_Archive')->header = array('TePostRatings_Plugin', 'setStyle');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('TePostRatings_Plugin', 'setScript');

        //添加评分操作地址
        Helper::addAction('rating', 'TePostRatings_Action');

        return _t($info);
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
        Helper::removeAction('rating');
        $delFields = Typecho_Widget::widget('Widget_Options')->plugin('TePostRatings')->delFields;
        if($delFields){
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $db->query('ALTER TABLE `'. $prefix .'contents` DROP `ratingsNum`;');
            $db->query('ALTER TABLE `'. $prefix .'contents` DROP `ratingsAverage`;');
        }
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        $delFields = new Typecho_Widget_Helper_Form_Element_Radio('delFields',
            array(0=>_t('保留数据'),1=>_t('删除数据'),), '0', _t('卸载设置'),_t('卸载插件后数据是否保留'));
        $form->addInput($delFields);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    protected static function installPlugin(){
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        // ratingsNum:评分次数
        if (!array_key_exists('ratingsNum', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `'. $prefix .'contents` ADD `ratingsNum` INT(10) DEFAULT 0;');
        // ratingsAverage:平均评分
        if (!array_key_exists('ratingsAverage', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `'. $prefix .'contents` ADD `ratingsAverage` DECIMAL(2,1) DEFAULT 0.0;');
        return '成功添加字段，插件启用成功';
    }

    /**
     * 显示评分按钮
     * @param Widget_Archive $archive
     */
	public static function rating($archive=null){
	    $options = Typecho_Widget::widget('Widget_Options');
	    if (!isset($options->plugins['activated']['TePostRatings'])) {
	        echo '<!--`TePostRatings`未启用-->';
	        return;
	    }
	    if(is_null($archive)) $archive = Typecho_Widget::widget('Widget_Archive');

	    if(!isset($archive->cid)) return;

		$cid = $archive->cid;
		$ratingsNum = $archive->ratingsNum;
		$ratingsAverage = $archive->ratingsAverage;
		$isRating = Typecho_Cookie::get('__post_rating_'.$cid);
		$showWidth = $ratingsAverage*20;
		$string = <<<EOT
<div class="rate-holder clearfix" itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating">
	<div class="post-rate" title="评分 {$ratingsNum}, 满分 5 星">
		<div class="rating-stars" style="width:{$showWidth}%">
			<span class="average" itemprop="ratingValue">{$ratingsAverage}</span>
		</div>
	</div>
	<div class="piao"><span itemprop="ratingCount">{$ratingsNum}</span> 票</div>
EOT;
		if(empty($isRating)){
		$string .= <<<EOT
	<div class="rating-combo" data-post-id="{$cid}">
		<a class="rating-toggle" href="javascript:;" rel="nofollow">投票</a>
		<ul>
			<li><a data-rating="5" class="ajax-rating" rel="nofollow"><span class="rating-star"><i class="star-5-0"></i></span></a></li>
			<li><a data-rating="4" class="ajax-rating" rel="nofollow"><span class="rating-star"><i class="star-4-0"></i></span></a></li>
			<li><a data-rating="3" class="ajax-rating" rel="nofollow"><span class="rating-star"><i class="star-3-0"></i></span></a></li>
			<li><a data-rating="2" class="ajax-rating" rel="nofollow"><span class="rating-star"><i class="star-2-0"></i></span></a></li>
			<li><a data-rating="1" class="ajax-rating" rel="nofollow"><span class="rating-star"><i class="star-1-0"></i></span></a></li>
		</ul>
	</div>
EOT;
		}
	   $string .= '<meta content="5" itemprop="bestRating"><meta content="1" itemprop="worstRating"></div>';
	   echo $string;
	}
	/**
	 * 设置评分样式
	 * @param Widget_Archive $archive
	 */
	public static function setStyle($archive){
	    $options = Typecho_Widget::widget('Widget_Options');
	    //插件目录
	    $plugin_path = Typecho_Common::url('TePostRatings', $options->pluginUrl);
	    $string = <<<EOT
<style>
.rate-holder{height:22px;line-height:22px;}
.post-rate,.rating-star,.rating-stars,.star-0-0,.star-1-0,.star-2-0,.star-3-0,.star-4-0,.star-5-0{
display: inline-block;width: 85px;height: 17px;overflow: hidden;vertical-align: middle;background: url({$plugin_path}/img/star.gif) repeat-x 0 -17px;line-height:22px;}
.rating-stars,.star-0-0,.star-1-0,.star-2-0,.star-3-0,.star-4-0,.star-5-0{background-position: 0 0;vertical-align: top;}
.post-rate{position:relative;z-index:8}
.rating-stars{display:block;position:absolute;left:0;top:0;z-index:10;}
.rating-stars .average{display:none;}
.rating-combo{display:block;display:inline-block;position:relative}
.rating-toggle{background:#eee;color:#555;padding:2px 4px;position:relative;z-index:2;font-size:12px;text-decoration:none;border-radius:3px}
.piao{display:inline-block;margin:0 5px;font-size:12px;}
.rating-combo ul{background:#eee;padding:2px;margin:0;position:absolute;z-index:1;left:0;top:23px;display:none;border-radius:0 3px 3px 3px;list-style:none;}
.rating-combo li{list-style:none outside none;line-height:1.2;list-style:none;margin:0;}
.rating-combo li a{cursor:pointer;display:inline-block;padding:0 5px}
.rating-combo li a:hover{background:#EEEECC}
.rating-combo:hover ul{display:block;}
.rating-star{position:relative}
.star-1-0{width:17px}
.star-2-0{width:34px;}
.star-3-0{width:51px;}
.star-4-0{width:68px;}
.star-5-0{width:85px;}
</style>
EOT;
	    echo $string;
	}
	/**
	 * 设置评分js
	 * @param Widget_Archive $archive
	 */
	public static function setScript($archive){
	    $options = Typecho_Widget::widget('Widget_Options');
	    //ajax 请求地址
	    $url = Typecho_Common::url('/action/rating?do=addrating', $options->index);
	    $string = <<<EOT
<script>!window.jQuery && document.write("<script src=\"http://apps.bdimg.com/libs/jquery/1.11.1/jquery.min.js\">"+"</scr"+"ipt>");</script>
<script>
	$(function(){
		$('.rating-combo .ajax-rating').click(function(){
			var that = $(this), url = '{$url}';
			var rating = that.data('rating');
            var rate_holder = that.parents('.rate-holder');
			var post_id = that.parents('.rating-combo').data('post-id');
			$.post(url,'post_id='+post_id+'&rating='+rating).success(function(rs){
				if(rs.status==1){
					rate_holder.find('.post-rate').attr('title','评分 '+rs.info.average+', 满分 5 星').find('.rating-stars').css('width',rs.info.average*20+'%');
					rate_holder.find('.piao span').text(rs.info.num);
					rate_holder.find('.rating-stars .average').text(rs.info.average);
			         rate_holder.find('.rating-combo').remove();
				}else{
					alert(rs.info===undefined ? '评分出错!':rs.info);
				}
			});
			return false;
		});
	});
</script>
EOT;
	    echo $string;
	}
    /**
     * 展示评分
     * @param string $option 配置
     * @param string $pattern 样式
     */
    public static function show($config=array(),$pattern='<li><a href="{permalink}">{title}{date}</a></li>'){
        $options = Typecho_Widget::widget('Widget_Options');
        if (!isset($options->plugins['activated']['TePostRatings'])) {
            echo '<!--`TePostRatings`未启用-->';
            return;
        }
        Typecho_Widget::widget('Widget_Contents_Post_TPRList',$config)->to($list);
        $output = '';
        while($list->next()){
             $categories = $list->categories;
             $result = array();
             foreach ($categories as $category) {
                 $result[] = '<a href="' . $category['permalink'] . '">'
                     . $category['name'] . '</a>';
             }
             $categories = implode(',', $result);

             $output .=str_replace(
                    array('{title}','{permalink}','{category}','{date}','{commentsNum}','{viewsNum}','{ratings_users}','{ratings_average}'),
                    array($list->title,$list->permalink,$categories,date($options->postDateFormat,$list->created),$list->commentsNum,$list->viewsNum,$list->fields->ratings_users,$list->fields->ratings_average),
                    $pattern);
        }
        echo $output;
    }
    /**
     *
     * @param Widget_Archive $archive
     * @return Ambigous <Typecho_Db_Query, Typecho_Db_Query>
     */
    public static function selectHandle($archive){
        $user = Typecho_Widget::widget('Widget_User');
		if ('post' == $archive->parameter->type || 'page' == $archive->parameter->type) {
            if ($user->hasLogin()) {
                $select = $archive->select()->where('table.contents.status = ? OR table.contents.status = ? OR
                        (table.contents.status = ? AND table.contents.authorId = ?)',
                        'publish', 'hidden', 'private', $user->uid);
            } else {
                $select = $archive->select()->where('table.contents.status = ? OR table.contents.status = ?',
                        'publish', 'hidden');
            }
        } else {
            if ($user->hasLogin()) {
                $select = $archive->select()->where('table.contents.status = ? OR
                        (table.contents.status = ? AND table.contents.authorId = ?)', 'publish', 'private', $user->uid);
            } else {
                $select = $archive->select()->where('table.contents.status = ?', 'publish');
            }
        }
        $select->where('table.contents.created < ?', Typecho_Date::gmtTime());
        $select->cleanAttribute('fields');
        return $select;
    }
}
/**
 * 获取评分数据类
 *
 */
class Widget_Contents_Post_TPRList extends Widget_Abstract_Contents{
    /**
     * 执行函数
     *
     * @access public
     * @return void
     */
    public function execute()
    {
        $this->parameter->setDefault(
            array(
                'order'=>'num', //排序字段 num：评分数量;average：平均评分
                'sort'=>'DESC',
                'limit'=>10,
            ));
        $order = $this->parameter->order=='num' ? 'ratingsNum' : 'ratingsAverage';
        $sort = $this->parameter->sort =='DESC' ? 'DESC' : 'ASC' ;
        $this->db->fetchAll($this->select()
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.created < ?', $this->options->gmtTime)
            ->where('table.contents.type = ?', 'post')
            ->order('table.contents.'.$order, $sort)
            ->limit($this->parameter->limit), array($this, 'push'));
    }
}
