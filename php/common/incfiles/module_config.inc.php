<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
function wdja_cms_module_index()
{
  $tweb_title = ii_itake('global.admin/global:seo.topic', 'lng');
  if (ii_isnull($tweb_title)) $tweb_title = ii_itake('global.module.topic', 'lng');
  mm_cntitle($tweb_title);
  $tmpstr = ii_ireplace('module.index', 'tpl');
  return $tmpstr;
}

function wdja_cms_module()
{
    return wdja_cms_module_index();
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
