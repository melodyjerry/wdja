<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
header("cache-control: no-cache, must-revalidate");
header("pragma: no-cache");

function wdja_cms_interface_list()
{
  $tkeyword = ii_get_safecode($_GET['keyword']);
  $tfid = ii_get_num($_GET['fid']);
  echo ap_review_output_note($tkeyword, $tfid, 5);
}

function wdja_cms_interface()
{
  switch($_GET['type'])
  {
    case 'list':
      return wdja_cms_interface_list();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
