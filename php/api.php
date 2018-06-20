<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
require('common/incfiles/common.inc.php');
require('common/incfiles/api.inc.php');
wdja_cms_module();
function wdja_cms_module_api(){
    $tmpstr .= '{';
    $tmpstr .= '"slide":'.wdja_cms_page_api('support/slide').',';
    $tmpstr .= '"product":'.wdja_cms_list_api('product',4).',';
    $tmpstr .= '"news":'.wdja_cms_list_api('article',6).',';
    $tmpstr .= '"page":'.wdja_cms_singlepage_api('page');
    $tmpstr .= '}';
    echo $tmpstr;
}

function wdja_cms_module(){
  $module = $_GET['module'];
  $id = $_GET['id'];
  switch($_GET['type'])
  {
    case 'list':
      echo wdja_cms_list_api($module);
      break;
    case 'detail':
      echo wdja_cms_detail_api($module,$id);
      break;
    case 'page':
      echo wdja_cms_page_api($module);
      break;
    case 'singlepage':
      echo wdja_cms_singlepage_api($module);
      break;
    case 'form':
      echo wdja_cms_form_api();
      break;
    default:
      echo wdja_cms_module_api();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>