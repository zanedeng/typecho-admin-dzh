<?php
include 'head.php';
$pluginConfig=$scj2cms->pluginConfig;
$pluginLang=$scj2cms->pluginLang;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $scj2cms->pluginUrl;?>skycaiji2cms/css.css"/>
<div>
	<?php if($scj2cms->openForm){?>
    <form method="post" action="<?php echo $scj2cms->formUrl;?>">
      <?php echo $scj2cms->formHeadHtml;?>
        <input type="hidden" name="formsub" value="1" />
        <div class="app-form-group">
          <div><label><?php echo $pluginLang['tpl_author'];?></label></div>
          <textarea name="author" class="app-form-control" rows="3"><?php echo $pluginConfig['author'];?></textarea>
        </div>
        <div class="app-form-group">
          <div><label><?php echo $pluginLang['tpl_apikey'];?></label></div>
          <input name="apikey" type="text" class="app-form-control" value="<?php echo $pluginConfig['apikey'];?>" />
        </div>
        <div class="app-form-group">
          <div><label><?php echo $pluginLang['tpl_apitype'];?></label></div>
          <select name="apitype" class="app-form-control">
            <option value=""<?php echo empty($pluginConfig['apitype'])?' selected="selected"':'';?>><?php echo $pluginLang['tpl_apitype_'];?></option>
            <option value="safe"<?php echo $pluginConfig['apitype']=='safe'?' selected="selected"':'';?>><?php echo $pluginLang['tpl_apitype_safe'];?></option>
          </select>
        </div>
        <div class="app-form-group">
          <button type="submit" class="app-btn app-btn-primary app-btn-block"><?php echo $pluginLang['tpl_save'];?></button>
        </div>
    </form>
    <?php }?>
  <?php if(!empty($pluginConfig)&&!empty($pluginConfig['apikey'])){ ?>
    <div class="app-alert app-alert-warning">
    <?php echo $pluginLang['tpl_tips_start'];?>
		<?php if($pluginConfig['apitype']=='safe'){ echo $pluginLang['tpl_tips_safe']; ?>
	</div>
	<table class="app-table">
	<tr>
		<td><?php echo $pluginLang['tpl_f_name'];?></td>
		<td><?php echo $pluginLang['tpl_f_type'];?></td>
		<td><?php echo $pluginLang['tpl_f_process'];?></td>
	</tr>
	<tr>
		<td><?php echo $pluginLang['tpl_apitime'];?></td>
		<td><?php echo $pluginLang['tpl_apitime_type'];?></td>
		<td></td>
	</tr>
	<tr>
		<td><?php echo $pluginLang['tpl_apisign'];?></td>
		<td><?php echo $pluginLang['tpl_apisign_type'].$pluginConfig['apikey'];?></td>
		<td><?php echo $pluginLang['tpl_apisign_process'];?></td>
	</tr>
	</table>
	<div class="app-alert app-alert-warning">
		<?php }?>
    <?php echo $pluginLang['tpl_tips_end'];?>
    </div>
	<table class="app-table">
		<tr>
			<td width="100"><?php echo $pluginLang['tpl_api_url'];?></td>
			<td><?php echo $scj2cms->apiUrl.($pluginConfig['apitype']=='safe'?'':((strpos($scj2cms->apiUrl,'?')===false?'?':'&').'apikey='.md5($pluginConfig['apikey']))); ?></td>
		</tr>
		<tr>
			<td><?php echo $pluginLang['tpl_api_type'];?></td>
			<td>POST</td>
		</tr>
		<tr>
			<td><?php echo $pluginLang['tpl_api_charset'];?></td>
			<td><?php echo $scj2cms->charset;?></td>
		</tr>
		<tr>
			<td><?php echo $pluginLang['tpl_api_data'];?></td>
			<td>
				<table class="app-table">
					<tr><td colspan="2"><b style="color:red"><?php echo $pluginLang['tpl_required'];?></b></td></tr>
					<?php if($pluginConfig['apitype']=='safe'){?>
					<tr><td>api_time</td><td><?php echo $pluginLang['tpl_apitime_val'];?></td></tr>
					<tr><td>api_sign</td><td><?php echo $pluginLang['tpl_apisign_val'];?></td></tr>
					<?php
                        }
                        if(is_array($scj2cms->formRequired)){
                            foreach ($scj2cms->formRequired as $k=>$v){
					?>
					<tr><td><?php echo $k;?></td><td><?php echo $v;?></td></tr>
					<?php }}?>
					<tr><td colspan="2"><b style="color:green"><?php echo $pluginLang['tpl_optional'];?></b></td></tr>
					<?php
                        if(is_array($scj2cms->formOptional)){
                            foreach ($scj2cms->formOptional as $k=>$v){
					?>
					<tr><td><?php echo $k;?></td><td><?php echo $v;?></td></tr>
					<?php }}?>
				</table>
			</td>
		</tr>
		<tr>
			<td><?php echo $pluginLang['tpl_resp'];?></td>
			<td>
				<table class="app-table">
    				<tr>
    					<td><?php echo $pluginLang['tpl_resp_name'];?></td>
    					<td><?php echo $pluginLang['tpl_resp_bind'];?></td>
    				</tr>
    				<tr>
    					<td>id</td>
    					<td>id</td>
    				</tr>
    				<tr>
    					<td>target</td>
    					<td>target</td>
    				</tr>
    				<tr>
    					<td>desc</td>
    					<td>desc</td>
    				</tr>
    				<tr>
    					<td>error</td>
    					<td>error</td>
    				</tr>
    			</table>
			</td>
		</tr>
	</table>
    <?php echo $scj2cms->bodyEndHtml;?>
<?php }?>
</div>
