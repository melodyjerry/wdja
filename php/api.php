<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
require('common/incfiles/common.inc.php');
require('common/incfiles/api.inc.php');

wdja_cms_module();

function wdja_cms_api(){
  $appid = ii_itake('global.wechat/config:config.appid','lng');//"wx0a9e41cd4c4f4502";
  if($appid != $_GET['appid']){
  echo "404";
  exit();
  }
}
function wdja_cms_module_api(){
    $tmpstr .= '{';
    $tmpstr .= '"slide":'.wdja_cms_page_api('wechat/slide').',';
    $tmpstr .= '"product":'.wdja_cms_list_api('wechat/product',4).',';
    $tmpstr .= '"news":'.wdja_cms_list_api('wechat/news',6).',';
    $tmpstr .= '"aboutus":'.wdja_cms_singlepage_api('wechat/aboutus').',';
    $tmpstr .= '"contact":'.wdja_cms_singlepage_api('wechat/contact');
    $tmpstr .= '}';
    echo $tmpstr;
}

function wdja_cms_module(){
  wdja_cms_api();
  $module = $_GET['module'];
  $id = $_GET['id'];
  switch($_GET['type'])
  {
    case 'wxlogin':
      echo wdja_cms_wxlogin_api();
      break;
    case 'wxlogin_code':
      echo wdja_cms_wxlogin_code_api();
      break;
    case 'search':
      echo wdja_cms_search_api($module);
      break;
    case 'sort':
      echo wdja_cms_sort_api($module);
      break;
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