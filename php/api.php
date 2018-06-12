<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
require('common/incfiles/common.inc.php');
require('common/incfiles/api.inc.php');
wdja_cms_module_api();
function wdja_cms_module_api(){
    $tmpstr .= '{';
    $tmpstr .= '"slide":'.wdja_cms_page_api('support/slide').',';
    $tmpstr .= '"product":'.wdja_cms_list_api('product').',';
    $tmpstr .= '"news":'.wdja_cms_list_api('article').',';
    $tmpstr .= '"page":'.wdja_cms_singlepage_api('page');
    $tmpstr .= '}';
    echo $tmpstr;
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
