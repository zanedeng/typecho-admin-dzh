<?php
!defined('in_skycaiji2cms') && exit('not in skycaiji2cms');
$scj2cmsHeadFunc=defined('skycaiji2cms_head_func')?constant('skycaiji2cms_head_func'):null;
if(!empty($scj2cmsHeadFunc)){
    if(!function_exists($scj2cmsHeadFunc)){
        exit('not in cms');
    }else{
        //运行cms头部检测函数
        call_user_func($scj2cmsHeadFunc);
    }
}