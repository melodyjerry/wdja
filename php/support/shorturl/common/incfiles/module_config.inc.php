<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************

function wdja_cms_module_adddisp()
{
  global $ngenre;
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $turl = $_GET['url'];
  $data = getUrlInfo($turl);
  $tdata['code'] = $data['code'];
  $tdata['http_status'] = $data['http_status'];
  if($data['http_status'] == '200'){//正常的链接进行保存操作
    if(ap_check_code($data['code']))
    {//已保存过的链接
      $tdata['status'] = '1';
      echo json_encode($tdata);
      exit();
    }
    if (!(ii_isnull($data['code'])))
    {
      $tsqlstr = "insert into $ndatabase (
      " . ii_cfname('topic') . ",
      " . ii_cfname('url') . ",
      " . ii_cfname('code') . ",
      " . ii_cfname('intro') . ",
      " . ii_cfname('ip') . ",
      " . ii_cfname('time') . "
      ) values (
      '" . ii_left($data['topic'], 50) . "',
      '" . ii_left(ii_cstr($turl), 255) . "',
      '" . ii_left(ii_cstr($data['code']), 50) . "',
      '" . ii_left(ii_cstr($data['intro']), 255) . "',
      '" . ii_left(ii_cstr($data['ip']), 20) . "',
      '" . ii_get_date(ii_cstr($data['time'])) . "'
      )";
      $trs = ii_conn_query($tsqlstr, $conn);
      if ($trs) $tdata['status'] = '1';
      else $tdata['status'] = '2';
    }else{
     $tdata['status'] = '3';
    }
  }elseif($data['http_status'] == '301'){
    $tdata['status'] = '4';
  }else{
  $tdata['status'] = '5';
  }
 echo json_encode($tdata);
}

function wdja_cms_module_search()
{
  global $conn, $ngenre;
  global $ndatabase, $nidfield, $nfpre, $nupre;
  $tcode = str_replace($nupre,'',$_GET['nurl']);
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('code') . "='".$tcode."'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
  $tdata['status'] = '1';
  $tdata['url'] = $trs[ii_cfnames($nfpre.'url')];
  }
 echo json_encode($tdata);
}

function wdja_cms_module_action()
{
  global $ndatabase, $nidfield, $nfpre, $ncontrol;
  switch($_GET['action'])
  {
    case 'add':
      return wdja_cms_module_adddisp();
      break;
    case 'search':
      return wdja_cms_module_search();
      break;
    default:
      return wdja_cms_module();
      break;
  }
}

function wdja_cms_module_detail($code)
{
  global $conn, $ngenre;
  global $ndatabase, $nidfield, $nfpre, $nupre;
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('code') . "='".$code."'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $mysqlstr = "update $ndatabase set " . ii_cfnames($nfpre, 'count') . "=" . ii_cfnames($nfpre, 'count') . "+1 where " . ii_cfname('code') . "='".$code."'";
    @ii_conn_query($mysqlstr, $conn);
    
      $url = $trs[ii_cfnames($nfpre.'url')];
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: '.$url);
    
  }else{
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: '.$nupre);
  }
}

function wdja_cms_module_index()
{
  global $ngenre, $nupre;
  $tmpstr = ii_ireplace('module.index', 'tpl');
  if (!ii_isnull($tmpstr)) 
  {
    return $tmpstr;
  }else{
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: '.$nupre);
       }
}

function wdja_cms_module()
{
  $code = $_GET['code'];
  if(!ii_isnull($code)){
      return wdja_cms_module_detail($code);
  }elseif($code == ''){
    echo wdja_cms_module_index();
  }else{
      header('HTTP/1.1 301 Moved Permanently');
      header('Location: '.$nupre);
  }
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
