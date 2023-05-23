<?php
include 'head.php';
//默认语言包
return array(
    'empty_apikey'=>'未设置密钥',
    'empty_author'=>'未设置作者',
    'empty_plugin_config'=>'未设置插件参数',
    'error_request'=>'请求方式必须为post',
    'error_apikey'=>'密钥错误',
    'error_timeout'=>'请求过期',
    'error_apitype'=>'接口类型错误',
    'error_api_sign'=>'密钥签名错误',
    'error_return'=>'接口>',
    
    'tpl_author'=>'作者（用户名或id，一行一个随机使用）',
    'tpl_apikey'=>'密钥（防止接口被盗用）',
    'tpl_apitype'=>'接口类型',
    'tpl_apitype_'=>'便捷（密钥明文传输有泄露风险）',
    'tpl_apitype_safe'=>'安全（需要签名处理）',
    'tpl_apitype'=>'接口类型',
    'tpl_save'=>'保存',
    
    'tpl_tips_start'=>'<p>该接口可在任何支持远程发布的采集器中使用，在蓝天采集器中体验最佳</p><p>首次使用的用户可以先下载安装<a href="https://www.skycaiji.com/manual/doc/install" target="_blank">蓝天采集器</a>，安装后创建一个<a href="https://www.skycaiji.com/manual/doc/task" target="_blank">任务</a>并编写好<a href="https://www.skycaiji.com/manual/doc/collector" target="_blank">采集规则</a></p>',
    'tpl_tips_end'=>'<p>最后在任务的发布设置中选择发布方式为"调用接口"并填入以下参数：</p>',
    'tpl_tips_safe'=>'<p>接口已开启安全模式，需在任务的采集器设置>获取内容中添加字段：</p>',
    'tpl_f_name'=>'名称',
    'tpl_f_type'=>'获取方式',
    'tpl_f_process'=>'数据处理',
    'tpl_apitime'=>'api时间戳',
    'tpl_apitime_type'=>'时间，勾选：转换成时间戳',
    'tpl_apisign'=>'api签名',
    'tpl_apisign_type'=>'字段组合，输入：[字段:api时间戳]',
    'tpl_apisign_process'=>'处理方式：使用函数>php函数名选择"md5"',
    
    'tpl_api_url'=>'接口地址',
    'tpl_api_type'=>'请求方式',
    'tpl_api_charset'=>'数据编码',
    'tpl_api_data'=>'发送数据',
    
    'tpl_apitime_val'=>'选中"采集字段：api时间戳"',
    'tpl_apisign_val'=>'选中"采集字段：api签名"',
    
    'tpl_required'=>'必填项',
    'tpl_optional'=>'选填项',
    
    'tpl_resp'=>'响应状态',
    'tpl_resp_name'=>'名称',
    'tpl_resp_bind'=>'绑定响应的json数组健名'
);
