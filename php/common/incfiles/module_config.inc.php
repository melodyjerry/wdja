<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
function wdja_cms_module_index()
{
  $tmpstr = ii_ireplace('module.index', 'tpl');
  return $tmpstr;
}

function wdja_cms_module()
{
  switch($_GET['type'])
  {
    case 'api':
      return wdja_cms_module_api();
      break;
    default:
      return wdja_cms_module_index();
      break;
  }
}

function wdja_cms_module_api(){
    global $nurlpre;
    $tmpstr .= '{';
    $tmpstr .= '"sort":'.file_get_contents($nurlpre.'/page/?type=api').',';
    $tmpstr .= '"slide":'.file_get_contents($nurlpre.'/page/?type=api').',';
    $tmpstr .= '"news":'.file_get_contents($nurlpre.'/page/?type=api').',';
    $tmpstr .= '"article":'.file_get_contents($nurlpre.'/article/?type=api').',';
    $tmpstr .= '"aboutus":'.file_get_contents($nurlpre.'/page/?type=api');
    $tmpstr .= '}';
    echo $tmpstr;
}



//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
