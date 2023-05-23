<?php
class TePostRatings_Action extends Typecho_Widget implements Widget_Interface_Do{
	
	private $db;
	/**
	 * ajax 增加评分数据
	 */
	public function addRating(){
		$cid = $this->request->filter('int')->get('post_id');
        $rating = $this->request->filter('int')->get('rating');
		$rs['status'] = 1;
		$isRating = Typecho_Cookie::get('__post_rating_'.$cid);
		//已经评分则直接返回
		if(!empty($isRating)){
			$this->response->throwJson(array('status'=>0,'info'=>'已经对该文章进行了评分!'));
		}
		if($rating>5 || $rating<1){
			$rs['status'] = 0;
			$rs['info'] = '评分数据错误!';
		}else{
			$sql = $this->db->select('cid,ratingsNum,ratingsAverage')->from('table.contents')->where('table.contents.cid = ?', $cid);
			$post = $this->db->fetchRow($sql);
			if(!$post){
				$rs['status'] = 0;
				$rs['info'] = '文章不存在!';
			}
		}

		if($rs['status']!=0){
		    //总积分
		    $score = $post['ratingsNum']*$post['ratingsAverage']+$rating;
			$post['ratingsNum'] +=1;
			$post['ratingsAverage'] = sprintf("%.1f",$score/$post['ratingsNum']);
			
			$this->db->query($this->db->update('table.contents')->rows($post)->where('table.contents.cid = ?',$post['cid']));

			$rs['info'] = array(
				'num'=>$post['ratingsNum'],
				'average'=>$post['ratingsAverage'],
			);
			Typecho_Cookie::set('__post_rating_'.$cid, $rating); //记录评分信息
		}
		$this->response->throwJson($rs);
    }
	
	/* (non-PHPdoc)
     * @see Widget_Interface_Do::action()
     */
    public function action()
    {
		if (!$this->request->isAjax()) {
            $this->response->goBack();
        }
        $this->db = Typecho_Db::get();
		$this->on($this->request->is('do=addrating'))->addRating();
    }

}