<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************

function wdja_cms_module_editdisp()
{
  global $ctype, $Err;
  $ctype = 'edit';
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nlng, $nuri;
  $tckstr = 'name:' . ii_itake('manage.name', 'lng') . ',address:' . ii_itake('manage.address', 'lng') . ',phone:' . ii_itake('manage.phone', 'lng');
  $tary = explode(',', $tckstr);
  foreach ($tary as $key => $val)
  {
    $tvalary = explode(':', $val);
    if (ii_isnull($_POST[$tvalary[0]])) $Err[count($Err)] = str_replace('[]', '[' . $tvalary[1] . ']', ii_itake('global.lng_error.insert_empty', 'lng'));
  }
  if (!is_array($Err))
  {
  $tid = ii_get_num($_GET['id']);
  $tbackurl = $_GET['backurl'];
  $tname = ii_get_safecode($_POST['name']);
  $taddress = ii_get_safecode($_POST['address']);
  $tcode = ii_get_safecode($_POST['code']);
  $tphone = ii_get_safecode($_POST['phone']);
  $temail = ii_get_safecode($_POST['email']);
  $ttime = ii_now();
  $tsqlstr = "update $ndatabase set " . ii_cfname('name') . "='$tname'," . ii_cfname('address') . "='$taddress'," . ii_cfname('code') . "='$tcode'," . ii_cfname('phone') . "='$tphone'," . ii_cfname('email') . "='$temail'," . ii_cfname('time') . "='$ttime' where ".$nidfield."=".$tid;
  $trs = ii_conn_query($tsqlstr, $conn);
  if ($trs)
  {
    mm_imessage(ii_itake('manage.editsucceed', 'lng'),$nuri);
  }
  else
  {
    mm_imessage(ii_itake('manage.editerr', 'lng'), $tbackurl);
  }
  }
}

function wdja_cms_module_adddisp()
{
  global $ctype, $Err;
  $ctype = 'add';
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  global $nlng, $nuri;
  $tckstr = 'name:' . ii_itake('manage.name', 'lng') . ',address:' . ii_itake('manage.address', 'lng') . ',phone:' . ii_itake('manage.phone', 'lng');
  $tary = explode(',', $tckstr);
  foreach ($tary as $key => $val)
  {
    $tvalary = explode(':', $val);
    if (ii_isnull($_POST[$tvalary[0]])) $Err[count($Err)] = str_replace('[]', '[' . $tvalary[1] . ']', ii_itake('global.lng_error.insert_empty', 'lng'));
  }
  if (!is_array($Err))
  {
    $tsqlstr = "insert into $ndatabase (
    " . ii_cfname('name') . ",
    " . ii_cfname('address') . ",
    " . ii_cfname('code') . ",
    " . ii_cfname('phone') . ",
    " . ii_cfname('email') . ",
    " . ii_cfname('lng') . ",
    " . ii_cfname('time') . ",
    " . ii_cfname('username') . "
    ) values (
    '" . ii_left(ii_cstr($_POST['name']), 50) . "',
    '" . ii_left(ii_cstr($_POST['address']), 200) . "',
    '" . ii_left(ii_cstr($_POST['code']), 50) . "',
    '" . ii_left(ii_cstr($_POST['phone']), 50) . "',
    '" . ii_left(ii_cstr($_POST['email']), 50) . "',
    '$nlng',
    '" . ii_now() . "',
    '$nusername'
    )";
    $trs = ii_conn_query($tsqlstr, $conn);
    if ($trs) mm_imessage(ii_itake('manage.addsucceed', 'lng'), $nuri);
    else mm_imessage(ii_itake('global.lng_public.sudd', 'lng'), '-1');
  }
}


function wdja_cms_module_deletedisp()
{
  global $conn, $slng;
  global $ndatabase, $nidfield, $nfpre;
  $tid = ii_get_num($_GET['id']);
  $tbackurl = $_GET['backurl'];
  $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
        mm_dbase_delete($ndatabase, $nidfield, $tid);
        mm_imessage(ii_itake('manage.deletesucceed', 'lng'), $tbackurl);
  }
  else
  {
    mm_imessage(ii_itake('manage.deleteerr', 'lng'), $tbackurl);
  }
}

function wdja_cms_module_action()
{
  switch(mm_ctype($_GET['action']))
  {
    case 'add':
      wdja_cms_module_adddisp();
      break;
    case 'edit':
      wdja_cms_module_editdisp();
      break;
    case 'delete':
      wdja_cms_module_deletedisp();
      break;
  }
}

function wdja_cms_module_list()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre, $npagesize;
  global $slng;
  $toffset = ii_get_num($_GET['offset']);
  $tmpstr = ii_itake('module.list', 'tpl');
  $tmpastr = ii_ctemplate($tmpstr, '{@recurrence_idb}');
  $tmprstr = '';
  $tsqlstr = "select * from $ndatabase where $nidfield>0";
  $tsqlstr .= " order by " . $nidfield . " asc";
  $tcp = new cc_cutepage;
  $tcp -> id = $nidfield;
  $tcp -> sqlstr = $tsqlstr;
  $tcp -> offset = $toffset;
  $tcp -> pagesize = $npagesize;
  $tcp -> init();
  $trsary = $tcp -> get_rs_array();
  $font_disabled = ii_itake('global.tpl_config.font_disabled', 'tpl');
  $tdeletenotice = ii_itake('manage.deletenotice', 'lng');
  if (is_array($trsary))
  {
    foreach($trsary as $trs)
    {
      $tmptstr = str_replace('{$name}', $trs[ii_cfname('name')], $tmpastr);
      $tmptstr = str_replace('{$address}', $trs[ii_cfname('address')], $tmptstr);
      $tmptstr = str_replace('{$code}', $trs[ii_cfname('code')], $tmptstr);
      $tmptstr = str_replace('{$phone}', $trs[ii_cfname('phone')], $tmptstr);
      $tmptstr = str_replace('{$email}', $trs[ii_cfname('email')], $tmptstr);
      $tmptstr = str_replace('{$username}', $trs[ii_cfname('username')], $tmptstr);
      $tmptstr = str_replace('{$time}', $trs[ii_cfname('time')], $tmptstr);
      $tmptstr = str_replace('{$id}', $trs[$nidfield], $tmptstr);
      $tmprstr .= $tmptstr;
    }
  }
  $tmpstr = str_replace('{$cpagestr}', $tcp -> get_pagestr(), $tmpstr);
  $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
  $tmpstr = str_replace('{$id}', $tid, $tmpstr);
  $tmpstr = ii_creplace($tmpstr);
  return $tmpstr;
}


function wdja_cms_module_detail()
{
  global $conn;
  global $nusername;
  global $ndatabase, $nidfield, $nfpre;
  $tid = ii_get_num($_GET['id']);
  $tsqlstr = "select * from $ndatabase where (" . ii_cfname('recipients') . "='$nusername' or " . ii_cfname('addresser') . "='$nusername') and $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    if ($trs[ii_cfname('recipients')] == $nusername && $trs[ii_cfname('read')] == 0)
    {
      $tsqlstr = "update $ndatabase set " . ii_cfname('read') . "=1 where $nidfield=$tid";
      ii_conn_query($tsqlstr, $conn);
    }
    $tmpstr = ii_itake('module.detail', 'tpl');
    foreach ($trs as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      $GLOBALS['RS_' . $tkey] = $val;
      $tmpstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmpstr);
    }
    $tmpstr = str_replace('{$id}', $trs[$nidfield], $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
  else mm_imessage(ii_itake('global.lng_public.sudd', 'lng'));
}

function wdja_cms_module_edit()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $tid = ii_get_num($_GET['id']);
  $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr = ii_itake('module.edit', 'tpl');
    $tmpstr = str_replace('{$id}', $trs[$nidfield], $tmpstr);
    $tmpstr = str_replace('{$name}', $trs[ii_cfname('name')], $tmpstr);
    $tmpstr = str_replace('{$address}', $trs[ii_cfname('address')], $tmpstr);
    $tmpstr = str_replace('{$code}', $trs[ii_cfname('code')], $tmpstr);
    $tmpstr = str_replace('{$phone}', $trs[ii_cfname('phone')], $tmpstr);
    $tmpstr = str_replace('{$email}', $trs[ii_cfname('email')], $tmpstr);
    $tmpstr = str_replace('{$username}', $trs[ii_cfname('username')], $tmpstr);
    $tmpstr = str_replace('{$time}', $trs[ii_cfname('time')], $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
  else
  {
    mm_client_alert(ii_itake('manage.editerr', 'lng'), -1);
  }
}

function wdja_cms_module_add()
{
    $tmpstr = ii_itake('module.add', 'tpl');
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
}

function wdja_cms_module()
{
  switch(mm_ctype($_GET['type']))
  {
    case 'list':
      return wdja_cms_module_list();
      break;
    case 'add':
      return wdja_cms_module_add();
      break;
    case 'edit':
      return wdja_cms_module_edit();
      break;
    case 'detail':
      return wdja_cms_module_detail();
      break;
    default:
      return wdja_cms_module_list();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
