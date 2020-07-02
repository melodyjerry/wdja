<?php
//****************************************************
// WDJA CMS Power by wdja.net
// Email: shadoweb@qq.com
// Web: http://www.wdja.net/
//****************************************************
function pp_get_genre_select($module='')
{
  global $variable;
  $tary = ii_get_valid_module();
  if (is_array($tary))
  {
    $tmpstr = '';
    $option_selected = ii_itake('global.tpl_config.option_select', 'tpl');
    $option_unselected = ii_itake('global.tpl_config.option_unselect', 'tpl');
    foreach ($tary as $key => $val)
    {
      if (!ii_isnull($module) && $val == $module) $tmprstr = $option_selected;
      else $tmprstr = $option_unselected;
      if (!ii_isnull($variable[ii_cvgenre($val) . '.nfields'])){
        $tmprstr = str_replace('{$explain}', '(' . mm_get_genre_title($val) . ')' , $tmprstr);
        $tmprstr = str_replace('{$value}', $val, $tmprstr);
      }
      else continue;
      $tmpstr .= $tmprstr;
    }
    return $tmpstr;
  }
}

function api_get_gid(){
  //筛选时取符合条件的商品id合集，格式 1,2,34,56
  //Array ( [c1] => 2 [c3] => 2 [c6] => 3 [c4] => 3 [c5] => 3 )
  global $nurs;
  $fields_arr = convertUrlQuery($nurs);
  $gid_arr = array();
  $gid_narr = array();
  foreach ($fields_arr as $key => $val) {
    $tkey = str_replace('f','',$key);
    $gid_narr = api_get_fields_gid($tkey,$val);
    if(count($gid_arr) > 0) $gid_arr = array_intersect($gid_arr,$gid_narr);
    else $gid_arr = $gid_narr;
    if(count($gid_arr) < 1) return -1;
  }
  $tgid = implode(",", $gid_arr);
  return $tgid;
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

function api_get_fields_gid($oid,$data)
{
  //获取存储的属性对应商品ID
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
  $fid = $oid;
  $tmpstr = '';
  $tsqlstr = 'select '. ii_cfnames($ffpre,"gid") .' from '. $fdatabase.' where '.ii_cfnames($ffpre,"fid").' = '.$fid.' and ('.ii_cfnames($ffpre,"data").' = ' .$data.' or '.ii_cfnames($ffpre,"data").' like \'%|' .$data.'|%\')';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    if($trow){
      $gid[] = $trow[ii_cfnames($ffpre,"gid")];
    }
  }
  return $gid;
}

function api_list_fields_input(){
  //前台列表页固定表单项
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$ngenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $oid = $trow[$fidfield];
    if($type != 3) $tmpstr .= api_list_input($oid);
  }
  return $tmpstr;
}

function api_list_input($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.listinput', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}



function api_list_fields(){
  //前台列表页显示调用
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$ngenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $oid = $trow[$fidfield];
    if($type != 3) $tmpstr .= api_list_fields_radio($oid);
  }
  return $tmpstr;
}

function api_list_fields_radio($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.listradio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
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
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_list_fields_select($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.select', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
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
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_view_fields($id='',$genre=''){
  //前台显示调用
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  if(ii_isnull($id)) $gid = $_GET['id'];
  else $gid = $id;
  if(ii_isnull($genre)) $tgenre = $ngenre;
  else $tgenre = $genre;
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$tgenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $oid = $trow[$fidfield];
    $tmpstr .= api_view_fields_label($type,$oid,$gid) ;
  }
  return $tmpstr;
}

function api_view_fields_label($type,$oid,$gid)
{
  switch($type)
  {
    case 0:
      return api_view_fields_radio($oid,$gid);
      break;
    case 1:
      return api_view_fields_checkbox($oid,$gid);
      break;
    case 2:
      return api_view_fields_select($oid,$gid);
      break;
    case 3:
      return api_view_fields_input($oid,$gid);
      break;
    default:
      return api_view_fields_select($oid,$gid);
      break;
  }
}

function api_view_fields_input($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.viewinput', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid and " . ii_cfnames($ffpre,'gid') . "=$gid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs) $tmpstr = str_replace('{$data}', ii_htmlencode($trs[ii_cfnames($ffpre,'data')]), $tmpstr);
    else $tmpstr = '';
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_view_fields_radio($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.viewradio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      if($trow[ii_cfnames($ffpre,'oid')] == api_get_fields_data($oid,$gid)){
        foreach ($trow as $key => $val)
        {
          $tkey = ii_get_lrstr($key, '_', 'rightr');
          $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
        }
        $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
        $tmprstr .= $tmptstr;
      }
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_view_fields_checkbox($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.viewcheckbox', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      //复选框字符串
      $tdata = api_get_fields_data($oid,$gid);//获取复选框字符串
      $tdata_arr = explode("|", $tdata);
      $tmptstr = $tmpastr;
      foreach($tdata_arr as $akey => $aval){
        if($aval == $trow[ii_cfnames($ffpre,'oid')]){//判断选择的属性
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

function api_view_fields_select($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.viewselect', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      if($trow[ii_cfnames($ffpre,'oid')] == api_get_fields_data($oid,$gid)){
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
//后台管理页引入   require('config/common/incfiles/api_fields.inc.php');
//添加时模板中引入   {$=api_fields_add()}
//编辑时模板中引入   {$=api_fields_edit()}
//添加时代码中引入   api_save_fields($upfid);
//编辑时代码中引入   api_update_fields($tid);
//
function api_update_fields($gid)
{
  //循环保存
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$ngenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    //需判断属性是否已添加过，添加过则更新，没添加过则保存
    if(api_check_fields_data($trow[$fidfield],$gid)) api_update_fields_sql($trow[$fidfield],$gid,$trow[ii_cfnames($ffpre,"type")]);
    else api_save_fields_sql($trow[$fidfield],$gid,$trow[ii_cfnames($ffpre,"type")]);
  }
}

function api_check_fields_data($fid,$gid)
{
  //判断属性是否已添加过
  global $conn;
  $check = false;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"fid").' = '.$fid.' and '.ii_cfnames($ffpre,"gid").' = ' .$gid;
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if($trs)  $check = true;
  return $check;
}

function api_update_fields_sql($id,$gid,$type='0'){
  //更新操作
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
  if($type == '1') {
    $tdata = '|';
    $tdata_arr = $_POST['fields_'.$id];
    foreach ($tdata_arr as $key => $val)
    {
      $tdata .= $val.'|';
    }
  }elseif($type == '3'){
    $tdata = ii_left(ii_cstr($_POST['fields_'.$id]), 250);
  }else{
    $tdata = ii_get_num($_POST['fields_'.$id]);
  }
  $tsqlstr = "update $fdatabase set
      " . ii_cfnames($ffpre,'data') . "='".$tdata."',
      " . ii_cfnames($ffpre,'time') . "='" . ii_now() . "'
      where " . ii_cfnames($ffpre,'fid') . "='" . ii_get_num($id) . "' and ". ii_cfnames($ffpre,'gid') . "=" . ii_get_num($gid);
  $trs = ii_conn_query($tsqlstr, $conn);
}

function api_fields_edit()
{
  //编辑商品时调用
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $gid = $_GET['id'];
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$ngenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $oid = $trow[$fidfield];
    $tmpstr .= api_get_fields_label($type,$oid,$gid) ;
  }
  return $tmpstr;
}

function api_get_fields_label($type,$oid,$gid)
{
  switch($type)
  {
    case 0:
      return api_get_fields_radio($oid,$gid);
      break;
    case 1:
      return api_get_fields_checkbox($oid,$gid);
      break;
    case 2:
      return api_get_fields_select($oid,$gid);
      break;
    case 3:
      return api_get_fields_input($oid,$gid);
      break;
    default:
      return api_get_fields_select($oid,$gid);
      break;
  }
}

function api_get_fields_data($fid,$gid)
{
  //获取存储的属性选项ID
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"fid").' = '.$fid.' and '.ii_cfnames($ffpre,"gid").' = ' .$gid;
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  return $trs[ii_cfnames($ffpre,"data")];
}

function api_get_fields_input($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.getinput', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid and " . ii_cfnames($ffpre,'gid') . "=$gid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs) $tmpstr = str_replace('{$data}', ii_htmlencode($trs[ii_cfnames($ffpre,'data')]), $tmpstr);
    else $tmpstr = str_replace('{$data}','', $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_get_fields_radio($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.getradio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        if($trow[ii_cfnames($ffpre,'oid')] == api_get_fields_data($oid,$gid)) $tmptstr = str_replace('{$checked}','checked', $tmptstr);
        else $tmptstr = str_replace('{$checked}','', $tmptstr);
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_get_fields_checkbox($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.getcheckbox', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
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
        $tdata = api_get_fields_data($oid,$gid);//获取复选框字符串
        $tdata_arr = explode("|", $tdata);
        foreach($tdata_arr as $akey => $aval){
          if($aval == $trow[ii_cfnames($ffpre,'oid')]) $tmptstr = str_replace('{$checked}','checked', $tmptstr);
        }
        $tmptstr = str_replace('{$checked}','', $tmptstr);
        //
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_get_fields_select($oid,$gid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.getselect', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
    $tmpastr = ii_ctemplate($tmpstr, '{@}');
    $tmprstr = '';
    $trs = ii_conn_query($tsqlstr, $conn);
    while ($trow = ii_conn_fetch_array($trs))
    {
      $tmptstr = $tmpastr;
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        if($trow[ii_cfnames($ffpre,'oid')] == api_get_fields_data($oid,$gid)) $tmptstr = str_replace('{$selected}','selected', $tmptstr);
        else $tmptstr = str_replace('{$selected}','', $tmptstr);
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_save_fields($gid)
{
  //循环保存
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$ngenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    api_save_fields_sql($trow[$fidfield],$gid,$trow[ii_cfnames($ffpre,"type")]);
  }
}

function api_save_fields_sql($id,$gid,$type='0'){
  //保存操作
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'gid');
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'gid');
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'gid');
  if($type == '1') {
    $tdata = '|';
    $tdata_arr = $_POST['fields_'.$id];
    foreach ($tdata_arr as $key => $val)
    {
      $tdata .= $val.'|';
    }
  }elseif($type == '3'){
    $tdata = ii_left(ii_cstr($_POST['fields_'.$id]), 250);
  }else{
    $tdata = ii_get_num($_POST['fields_'.$id]);
  }
  $tsqlstr = "insert into $fdatabase (
    " . ii_cfnames($ffpre,'fid') . ",
    " . ii_cfnames($ffpre,'gid') . ",
    " . ii_cfnames($ffpre,'data') . ",
    " . ii_cfnames($ffpre,'time') . "
    ) values (
    '" . ii_get_num($id) . "',
    " . ii_get_num($gid) . ",
    '" . $tdata . "',
    '" . ii_now() . "'
    )";
  $trs = ii_conn_query($tsqlstr, $conn);
}

function api_fields_add()
{
  //添加商品时调用
  global $conn, $ngenre;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tmpstr = '';
  $tsqlstr = 'select * from '. $fdatabase.' where '.ii_cfnames($ffpre,"hidden").'=0 and '.ii_cfnames($ffpre,"genre").'="'.$ngenre.'"';
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
    foreach ($trow as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      if ($tkey == 'type') $type = $val;
    }
    $oid = $trow[$fidfield];
    $tmpstr .= api_fields_label($type,$oid) ;
  }
  return $tmpstr;
}

function api_fields_label($type,$oid)
{
  switch($type)
  {
    case 0:
      return api_fields_radio($oid);
      break;
    case 1:
      return api_fields_checkbox($oid);
      break;
    case 2:
      return api_fields_select($oid);
      break;
    case 3:
      return api_fields_input($oid);
      break;
    default:
      return api_fields_select($oid);
      break;
  }

}

function api_fields_input($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.input', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}
function api_fields_radio($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.radio', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
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
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_fields_checkbox($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.checkbox', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
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
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function api_fields_select($oid)
{
  global $conn;
  $fgenre = 'expansion/fields';
  $fdatabase = mm_cndatabase(ii_cvgenre($fgenre));
  $fidfield = mm_cnidfield(ii_cvgenre($fgenre));
  $ffpre = mm_cnfpre(ii_cvgenre($fgenre));
  $tid = $oid;
  $tmpstr = ii_itake('global.expansion/fields:api.select', 'tpl');
  if (!ii_isnull($tmpstr))
  {
    $tsqlstr = "select * from $fdatabase where $fidfield=$tid";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs)
    {
      $tmpstr = str_replace('{$ctopic}', ii_htmlencode($trs[ii_cfnames($ffpre,'topic')]), $tmpstr);
      $tmpstr = str_replace('{$type}', ii_htmlencode($trs[ii_cfnames($ffpre,'type')]), $tmpstr);
      $tmpstr = str_replace('{$oid}', $trs[$fidfield], $tmpstr);
    }
    $fdatabase = mm_cndatabase(ii_cvgenre($fgenre), 'data');
    $fidfield = mm_cnidfield(ii_cvgenre($fgenre), 'data');
    $ffpre = mm_cnfpre(ii_cvgenre($fgenre), 'data');
    $tsqlstr = "select * from $fdatabase where " . ii_cfnames($ffpre,'fid') . "=$tid order by " . ii_cfnames($ffpre,'oid') . " asc";
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
      $tmptstr = str_replace('{$id}', $trow[ii_cfnames($ffpre,'oid')], $tmptstr);
      $tmprstr .= $tmptstr;
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

//****************************************************
// WDJA CMS Power by wdja.net
// Email: shadoweb@qq.com
// Web: http://www.wdja.net/
//****************************************************
?>