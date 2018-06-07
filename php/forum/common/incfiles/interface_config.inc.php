<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
header("cache-control: no-cache, must-revalidate");
header("pragma: no-cache");

ap_user_init();

function wdja_cms_interface_quote()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $tmpstr = '[quote]';
  $tsid = ii_get_num($_GET['sid'], 0);
  $ttid = ii_get_num($_GET['tid'], 0);
  if (pp_check_forum_popedom($tsid, 0) == 0)
  {
    $tsqlstr = "select * from $ndatabase where " . ii_cfname('hidden') . "=0 and " . ii_cfname('sid') . "=$tsid and $nidfield=$ttid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr .= '[b]' . ii_itake('config.topic_author', 'lng') . ' ' . ii_htmlencode($trs[ii_cfname('author')]) . ' ' . ii_itake('config.releases', 'lng') . ' ' . ii_get_date($trs[ii_cfname('time')]) . '[/b]' . CRLF;
      $tmpstr .= $trs[ii_cfname('content')];
    }
  }
  $tmpstr .= '[/quote]';
  echo $tmpstr;
}

function wdja_cms_interface_reply()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $tsid = ii_get_num($_GET['sid'], 0);
  $ttid = ii_get_num($_GET['tid'], 0);
  if (pp_check_forum_popedom($tsid, 0) == 0)
  {
    $tmpstr = ii_ireplace('interface.reply_list', 'tpl');
    $tmpastr = ii_ctemplate($tmpstr, '{@recurrence_ida}');
    $tmprstr = '';
    $tsqlstr = "select * from $ndatabase where " . ii_cfname('hidden') . "=0 and " . ii_cfname('fid') . "=$ttid order by $nidfield desc limit 0,5";
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = str_replace('{$icon}', ii_get_num($trow[ii_cfname('icon')]), $tmpastr);
      $tmptstr = str_replace('{$content}', ii_left(ii_htmlencode($trow[ii_cfname('content')]), 60), $tmptstr);
      $tmptstr = str_replace('{$time}', ii_get_date($trow[ii_cfname('time')]), $tmptstr);
      $tmptstr = str_replace('{$author}', ii_htmlencode($trow[ii_cfname('author')]), $tmptstr);
      $tmprstr .= $tmptstr;
    }
    if ($tmprstr == '') echo ii_itake('module.noreply', 'lng');
    else
    {
      $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
      echo $tmpstr;
    }
  }
}

function wdja_cms_interface()
{
  switch($_GET['type'])
  {
    case 'quote':
      return wdja_cms_interface_quote();
      break;
    case 'reply':
      return wdja_cms_interface_reply();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
