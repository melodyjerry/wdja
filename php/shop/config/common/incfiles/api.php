<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
function api_get_sid($nurs){
  //筛选时取符合条件的商品id合集，格式 1,2,34,56
  //Array ( [c1] => 2 [c3] => 2 [c6] => 3 [c4] => 3 [c5] => 3 )
  $config_arr = convertUrlQuery($nurs);
  $sid_arr = array();
  $sid_narr = array();
  foreach ($config_arr as $key => $val) {
    $tkey = str_replace('c','',$key);
    $sid_narr = api_get_config_sid($tkey,$val);
    if(count($sid_arr) > 0) $sid_arr = array_intersect($sid_arr,$sid_narr);
    else $sid_arr = $sid_narr;
    if(count($sid_arr) < 1) return -1;
  }
  $tsid = implode(",", $sid_arr);
  return $tsid;
}

function convertUrlQuery($query)
{
  $queryParts = explode('&', $query);
  $params = array();
  foreach ($queryParts as $param) {
    $item = explode('=', $param);
    if($item[0] != 'type' and $item[0] != 'classid' and $item[0] != 'offset') $params[$item[0]] = $item[1];
  }
  return $params;
}

function api_get_config_sid($cid,$data)
{
  //获取存储的属性对应商品ID
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'shopid');
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'shopid');
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'shopid');
  $fid = $cid;
  $tmpstr = '';
  $tsqlstr = 'select '. ii_cfnames($nfpre,"sid") .' from '. $ndatabase.' where '.ii_cfnames($nfpre,"fid").' = '.$fid.' and ('.ii_cfnames($nfpre,"data").' = ' .$data.' or '.ii_cfnames($nfpre,"data").' like \'%|' .$data.'|%\')';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    if($trow){
      $sid[] = $trow[ii_cfnames($nfpre,"sid")];
    }
  }
  return $sid;
}

function api_list_config_input(){
  //前台详情页显示调用
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $cid = $trow[$nidfield];
    $tmpstr .= api_list_input($cid);
  }
  return $tmpstr;
}

function api_list_input($cid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.listinput', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}



function api_list_config(){
  //前台详情页显示调用
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $cid = $trow[$nidfield];
    $tmpstr .= api_list_config_radio($cid);
  }
  return $tmpstr;
}

function api_list_config_radio($cid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.listradio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_list_config_select($cid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.select', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_view_config(){
  //前台详情页显示调用
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $shopid = $_GET['id'];
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $cid = $trow[$nidfield];
    $tmpstr .= api_view_config_label($type,$cid,$shopid) ;
  }
  return $tmpstr;
}

function api_view_config_label($type,$cid,$shopid)
{
  switch($type)
  {
    case 0:
      return api_view_config_radio($cid,$shopid);
      break;
    case 1:
      return api_view_config_checkbox($cid,$shopid);
      break;
    case 2:
      return api_view_config_select($cid,$shopid);
      break;
    default:
      return api_view_config_select($cid,$shopid);
      break;
  }
}

function api_view_config_radio($cid,$sid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.viewradio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      if($trow[ii_cfnames($nfpre,'cid')] == api_get_config_data($cid,$sid)){
        foreach ($trow as $key => $val)
        {
          $tkey = ii_get_lrstr($key, '_', 'rightr');
          $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
        }
        $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
        $tmprstr .= $tmptstr;
      }
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_view_config_checkbox($cid,$sid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.viewcheckbox', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      //复选框字符串
      $tdata = api_get_config_data($cid,$sid);//获取复选框字符串
      $tdata_arr = explode("|", $tdata);
      $tmptstr = $tmpastr;
      foreach($tdata_arr as $akey => $aval){
        if($aval == $trow[ii_cfnames($nfpre,'cid')]){//判断选择的属性
          foreach ($trow as $key => $val)
          {
            $tkey = ii_get_lrstr($key, '_', 'rightr');
            $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
          }
          $tmprstr .= $tmptstr;
        }
      }
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_view_config_select($cid,$sid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.viewselect', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      if($trow[ii_cfnames($nfpre,'cid')] == api_get_config_data($cid,$sid)){
        foreach ($trow as $key => $val)
        {
          $tkey = ii_get_lrstr($key, '_', 'rightr');
          $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
        }
        $tmprstr .= $tmptstr;
      }
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}


//以下为后台商城模块接入使用
//后台管理页引入   require('config/common/incfiles/api_config.inc.php');
//添加时模板中引入   {$=api_config()}
//编辑时模板中引入   {$=api_get_config()}
//添加时代码中引入   api_save_config($upfid);
//编辑时代码中引入   api_update_config($tid);
//
function api_update_config($shopid)
{
  //循环保存
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    //需判断属性是否已添加过，添加过则更新，没添加过则保存
    if(api_check_config_data($trow[$nidfield],$shopid)) api_update_config_sql($trow[$nidfield],$shopid,$trow[ii_cfnames($nfpre,"type")]);
    else api_save_config_sql($trow[$nidfield],$shopid,$trow[ii_cfnames($nfpre,"type")]);
  }
}

function api_check_config_data($fid,$sid)
{
  //判断属性是否已添加过
  global $conn;
  $check = false;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'shopid');
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'shopid');
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'shopid');
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"fid").' = '.$fid.' and '.ii_cfnames($nfpre,"sid").' = ' .$sid;
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if($trs)  $check = true;
  return $check;
}

function api_update_config_sql($id,$sid,$type='0'){
  //更新操作
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'shopid');
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'shopid');
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'shopid');
  if($type == '1') {
    $tdata = '|';
    $tdata_arr = $_POST['config_'.$id];
    foreach ($tdata_arr as $key => $val)
    {
      $tdata .= $val.'|';
    }
  }else{
    $tdata = ii_get_num($_POST['config_'.$id]);
  }
  $tsqlstr = "update $ndatabase set
      " . ii_cfnames($nfpre,'data') . "='".$tdata."',
      " . ii_cfnames($nfpre,'time') . "='" . ii_now() . "'
      where " . ii_cfnames($nfpre,'fid') . "='" . ii_get_num($id) . "' and ". ii_cfnames($nfpre,'sid') . "=" . ii_get_num($sid);
  $trs = ii_conn_query($tsqlstr, $conn);
}

function api_get_config()
{
  //编辑商品时调用
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $shopid = $_GET['id'];
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $cid = $trow[$nidfield];
    $tmpstr .= api_get_config_label($type,$cid,$shopid) ;
  }
  return $tmpstr;
}

function api_get_config_label($type,$cid,$shopid)
{
  switch($type)
  {
    case 0:
      return api_get_config_radio($cid,$shopid);
      break;
    case 1:
      return api_get_config_checkbox($cid,$shopid);
      break;
    case 2:
      return api_get_config_select($cid,$shopid);
      break;
    default:
      return api_get_config_select($cid,$shopid);
      break;
  }
}

function api_get_config_data($fid,$sid)
{
  //获取存储的属性选项ID
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'shopid');
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'shopid');
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'shopid');
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"fid").' = '.$fid.' and '.ii_cfnames($nfpre,"sid").' = ' .$sid;
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  return $trs[ii_cfnames($nfpre,"data")];
}

function api_get_config_radio($cid,$sid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.getradio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        if($trow[ii_cfnames($nfpre,'cid')] == api_get_config_data($cid,$sid)) $tmptstr = str_replace('{$checked}','checked', $tmptstr);
        else $tmptstr = str_replace('{$checked}','', $tmptstr);
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_get_config_checkbox($cid,$sid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.getcheckbox', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        //复选框字符串
        $tdata = api_get_config_data($cid,$sid);//获取复选框字符串
        $tdata_arr = explode("|", $tdata);
        foreach($tdata_arr as $akey => $aval){
          if($aval == $trow[ii_cfnames($nfpre,'cid')]) $tmptstr = str_replace('{$checked}','checked', $tmptstr);
        }
        $tmptstr = str_replace('{$checked}','', $tmptstr);
        //
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_get_config_select($cid,$sid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.getselect', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        if($trow[ii_cfnames($nfpre,'cid')] == api_get_config_data($cid,$sid)) $tmptstr = str_replace('{$selected}','selected', $tmptstr);
        else $tmptstr = str_replace('{$selected}','', $tmptstr);
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_save_config($shopid)
{
  //循环保存
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    api_save_config_sql($trow[$nidfield],$shopid,$trow[ii_cfnames($nfpre,"type")]);
  }
}

function api_save_config_sql($id,$sid,$type='0'){
  //保存操作
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'shopid');
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'shopid');
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'shopid');
  if($type == '1') {
    $tdata = '|';
    $tdata_arr = $_POST['config_'.$id];
    foreach ($tdata_arr as $key => $val)
    {
      $tdata .= $val.'|';
    }
  }else{
    $tdata = ii_get_num($_POST['config_'.$id]);
  }
  $tsqlstr = "insert into $ndatabase (
    " . ii_cfnames($nfpre,'fid') . ",
    " . ii_cfnames($nfpre,'sid') . ",
    " . ii_cfnames($nfpre,'data') . ",
    " . ii_cfnames($nfpre,'time') . "
    ) values (
    '" . ii_get_num($id) . "',
    " . ii_get_num($sid) . ",
    '" . $tdata . "',
    '" . ii_now() . "'
    )";
  $trs = ii_conn_query($tsqlstr, $conn);
}

function api_config()
{
  //添加商品时调用
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $ndatabase.' where '.ii_cfnames($nfpre,"lock").'=1';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $cid = $trow[$nidfield];
    $tmpstr .= api_config_label($type,$cid) ;
  }
  return $tmpstr;
}

function api_config_label($type,$cid)
{
  switch($type)
  {
    case 0:
      return api_config_radio($cid);
      break;
    case 1:
      return api_config_checkbox($cid);
      break;
    case 2:
      return api_config_select($cid);
      break;
    default:
      return api_config_select($cid);
      break;
  }

}

function api_config_radio($cid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.radio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_config_checkbox($cid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.checkbox', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_config_select($cid)
{
  global $conn;
  $ngenre = 'shop/config';
  $ndatabase = mm_cndatabase(ii_cvgenre($ngenre));
  $nidfield = mm_cnidfield(ii_cvgenre($ngenre));
  $nfpre = mm_cnfpre(ii_cvgenre($ngenre));
  $tid = $cid;
  $tmpstr = ii_itake('global.shop/config:api.select', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($nfpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($nfpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$cid}', $trs[$nidfield], $tmpstr);
    }
    $ndatabase = mm_cndatabase(ii_cvgenre($ngenre), 'data');
    $nidfield = mm_cnidfield(ii_cvgenre($ngenre), 'data');
    $nfpre = mm_cnfpre(ii_cvgenre($ngenre), 'data');
    $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'fid') . "=$tid order by " . ii_cfnames($nfpre,'cid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($nfpre,'cid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
