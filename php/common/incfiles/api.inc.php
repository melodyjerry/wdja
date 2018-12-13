<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//必须通过根目录下的api.php调用以下所有函数
//调用方式
//单页模块 wdja_cms_singlepage_api(模块文件夹名)
//关于我们模块等无分类的模块 wdja_cms_page_api(模块文件夹名)
//列表页wdja_cms_list_api($module)(模块文件夹名)
//详情页wdja_cms_detail_api($module)(模块文件夹名)调用的页面URL请传递内容?id=
//****************************************************

function getAccessToken(){
  $appid = ii_itake('global.wechat/config:config.appid','lng');
  $secret = ii_itake('global.wechat/config:config.secret','lng');
  $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
  $html = file_get_contents($url);
  $output = json_decode($html, true);
  $access_token = $output['access_token'];
  return $access_token;
}

function getOpenid($code){
    $appid = ii_itake('global.wechat/config:config.appid','lng');
    $secret = ii_itake('global.wechat/config:config.secret','lng');
    $curl = curl_init();
    $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($data);
    $data = get_object_vars($data);
    return $data['openid'];
}

function send_template_message($code,$formid,$time,$name,$mobile,$email,$info){
 $color = '#e3e3e3';
 $templateid = ii_itake('global.wechat/config:config.templateid','lng');
 $templateurl = ii_itake('global.wechat/config:config.templateurl','lng');
 $openid = getOpenid($code);
 $data_arr = array(
  'keyword1' => array( "value" => $time, "color" => $color),
  'keyword2' => array( "value" => $name, "color" => $color),
  'keyword3' => array( "value" => $mobile, "color" => $color),
  'keyword4' => array( "value" => $email, "color" => $color),
  'keyword5' => array( "value" => $info, "color" => $color)
  );
  $post_data = array (
    "touser"           => $openid,
    "template_id"      => $templateid,
    "page"             => $templateurl, // 点击模板消息后跳转到的页面，可以传递参数
    "form_id"          => $formid,
    "data"             => $data_arr,
    "emphasis_keyword" => "" // 需要强调的关键字，会加大居中显示
  );
  $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".getAccessToken();
  $data = urldecode(json_encode($post_data));
  if( empty( $url ) ){
   return ;
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  if( $data != '' && !empty( $data ) ){
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
  }
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);//超时时间
  $res = curl_exec($ch);
  curl_close($ch);
  return $res;
}

function wdja_cms_sort_api($module)
{
  global $conn, $nlng, $variable;
  ii_conn_init();
  ii_get_variable_init();
  $ngenre = $module;
  $ndatabase = $variable['common.sort.ndatabase'];
  $nidfield = $variable['common.sort.nidfield'];
  $nfpre = $variable['common.sort.nfpre'];
  $tsqlstr = "select * from $ndatabase";
  $tsqlstr .= " where " . ii_cfnames($nfpre,'genre') . " = '".$ngenre."'";
  $tsqlstr .= " order by " . ii_cfnames($nfpre,'order') . " desc";
  $trs = ii_conn_query($tsqlstr, $conn);
   while ($trow = ii_conn_fetch_array($trs))
    {
      $tmpstr .= '{';
      foreach ($trow as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
      }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
    }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr = str_replace(array("　","\t","\n","\r"), '', $tmpstr);
      return '['.$tmpstr.']';
}

function wdja_cms_wxlogin_api(){
    $sessionid = $_GET['sessionid'];
    $code = $_GET['code'];
    $appid = ii_itake('global.wechat/config:config.appid','lng');
    $secret = ii_itake('global.wechat/config:config.secret','lng');
    $curl = curl_init();
    $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($data);
    $data = get_object_vars($data);
    $data['appid']=$appid;
    //生成第三方3rd_session
      $session3rd  = null;
      $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
      $max = strlen($strPol)-1;
      for($i=0;$i<16;$i++){
          $session3rd .=$strPol[rand(0,$max)];
      }
      $session3rd = $session3rd;
//
    session_start();
    $_SESSION[$session3rd]=$data['openid'].$data['session_key'];
//
     $data['sessionid']=session_id();
     $data['code'] = "1";
     $data['value'] = $_SESSION[$session3rd];
    $data = json_encode($data);
    return $data;
}

function wdja_cms_wxlogin_code_api(){
session_start();
     $sessionid = $_GET['sessionid'];
     $data['sessionid'] = $sessionid;
    if(session_id($sessionid)){
     $data['code'] = "1";
     $data['value'] = session_id($sessionid);
    }else{
     $data['code'] = "0";
     $data['value'] = session_id($sessionid);
    }
    $data = json_encode($data);
    return $data;
}



function wdja_cms_search_api($module)
{
  global $conn, $nlng, $variable;
  ii_conn_init();
  ii_get_variable_init();
  $ngenre = $module;
  $tkeywords = $_GET['keywords'];
  $tpage =  ii_get_num($_GET['page'])==0?1:ii_get_num($_GET['page']);
  $tpage_size =  ii_get_num($_GET['page_size']);
  $tclassid =  ii_get_num($_GET['classid']);
  $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];
  $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
  $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
  $nclstype =$variable[ii_cvgenre($ngenre) . '.nclstype'];
  $nlisttopx = $variable[ii_cvgenre($ngenre) . '.nlisttopx'];
  $npagesize = $variable[ii_cvgenre($ngenre) . '.npagesize'];
  if($tpage_size !=0 ) $npagesize = $tpage_size;
  $toffset = ($tpage - 1)*$npagesize;
  $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'hidden') . "=0";
  if(!ii_isnull($tkeywords)) $tsqlstr .= " and " . ii_cfnames($nfpre,'topic') . " like '%" . $tkeywords . "%'";
  $tsqlstr .= " order by " . ii_cfnames($nfpre,'time') . " desc";
  $tcp = new cc_cutepage;
  $tcp -> id = $nidfield;
  $tcp -> pagesize = $npagesize;
  $tcp -> rslimit = $nlisttopx;
  $tcp -> sqlstr = $tsqlstr;
  $tcp -> offset = $toffset;
  $tcp -> listkey = $tclassid;
  $tcp -> init();
  $trsary = $tcp -> get_rs_array();
  if (is_array($trsary))
  {
    foreach($trsary as $trs)
    {
      $tmpstr .= '{';
      foreach ($trs as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
      }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
    }
  }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr = str_replace(array("　","\t","\n","\r"), '', $tmpstr);
      return '['.$tmpstr.']';
}

function wdja_cms_form_api()
{
  global $conn, $variable;
  ii_conn_init();
  ii_get_variable_init();
  $ngenre = 'wechat/gbook';
  $nlng = 'chinese';
  $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];
  $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
  $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
  $topenid = $_GET['openid'];
  $tnickName = $_GET['nickName'];
  $tavatarUrl = $_GET['avatarUrl'];//saveimages($_GET['avatarUrl']);
  $tgender = $_GET['gender'];
  $tcity = $_GET['city'];
  $tname = $_GET['name'];
  $tmobile = $_GET['mobile'];
  $temail = $_GET['email'];
  $tinfo = $_GET['info'];
  $tcode = $_GET['code'];
  $tformid = $_GET['formid'];
  $ttime = ii_now();
    $tsqlstr = "insert into $ndatabase (
    " . ii_cfnames($nfpre,'openid') . ",
    " . ii_cfnames($nfpre,'nickName') . ",
    " . ii_cfnames($nfpre,'avatarUrl') . ",
    " . ii_cfnames($nfpre,'gender') . ",
    " . ii_cfnames($nfpre,'city') . ",
    " . ii_cfnames($nfpre,'name') . ",
    " . ii_cfnames($nfpre,'mobile') . ",
    " . ii_cfnames($nfpre,'email') . ",
    " . ii_cfnames($nfpre,'info') . ",
    " . ii_cfnames($nfpre,'lng') . ",
    " . ii_cfnames($nfpre,'time') . "
    ) values (
    '" . ii_left(ii_cstr($topenid), 50) . "',
    '" . ii_left(ii_cstr($tnickName), 50) . "',
    '" . ii_left(ii_cstr($tavatarUrl), 255) . "',
    '" . ii_get_num($tgender) . "',
    '" . ii_left(ii_cstr($tcity), 50) . "',
    '" . ii_left(ii_cstr($tname), 50) . "',
    '" . ii_get_num($tmobile) . "',
    '" . ii_left(ii_cstr($temail), 50) . "',
    '" . ii_left(ii_cstr($tinfo), 10000) . "',
    '$nlng',
    '$ttime'
    )";
    $trs = ii_conn_query($tsqlstr, $conn);
    if ($trs)
    {
      $status = '1';
      $title ='留言成功';
      send_template_message($tcode,$tformid,$ttime,$tname,$tmobile,$temail,$tinfo);
    }else{
      $status = '0';
      $title ='留言失败';
    }
  $status = '{"status":"'.$status.'","title":"'.$title.'"}';
  return $status;
}

function wdja_cms_detail_api($module,$id)
{
  global $conn, $nlng, $variable;
  ii_conn_init();
  ii_get_variable_init();
  $ngenre = $module;
  $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];
  $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
  $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
  $tid = ii_get_num($id);
  $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr .= '{';
    foreach ($trs as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      $GLOBALS['RS_' . $tkey] = $val;
      $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
    }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr = str_replace(array("　","\t","\n","\r"), '', $tmpstr);
      return '['.$tmpstr.']';
  }
}

function wdja_cms_list_api($module,$num='')
{
  global $conn, $nlng, $variable;
  ii_conn_init();
  ii_get_variable_init();
  $ngenre = $module;
  $toffset =  ii_get_num($_GET['offset']);
  $tpage =  ii_get_num($_GET['page'],'');
  $tpage_size =  ii_get_num($_GET['page_size'],'');
  $tnum =  ii_get_num($num,'');
  $tclassid =  ii_get_num($_GET['classid']);
  $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];
  $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
  $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
  $nclstype =$variable[ii_cvgenre($ngenre) . '.nclstype'];
  $nlisttopx = $variable[ii_cvgenre($ngenre) . '.nlisttopx'];
  if(!ii_isnull($tnum)){
    $npagesize = $tnum;
  }elseif(!ii_isnull($tpage) && !ii_isnull($tpage_size)){
    $toffset = ($tpage - 1)*$tpage_size;
    $npagesize = $tpage_size;
  }else{
    $npagesize = $variable[$ngenre . '.npagesize'];
  }
  $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre,'hidden') . "=0";
  if ($tclassid != 0)
  {
      $tsqlstr .= " and " . ii_cfnames($nfpre,'cls') . " like '%|" . $tclassid . "|%'";
  }
  $tsqlstr .= " order by " . ii_cfnames($nfpre,'time') . " desc";
  $tcp = new cc_cutepage;
  $tcp -> id = $nidfield;
  $tcp -> pagesize = $npagesize;
  $tcp -> rslimit = $nlisttopx;
  $tcp -> sqlstr = $tsqlstr;
  $tcp -> offset = $toffset;
  $tcp -> listkey = $tclassid;
  $tcp -> init();
  $trsary = $tcp -> get_rs_array();
  if (is_array($trsary))
  {
    foreach($trsary as $trs)
    {
      $tmpstr .= '{';
      foreach ($trs as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
      }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
    }
  }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr = str_replace(array("　","\t","\n","\r"), '', $tmpstr);
      return '['.$tmpstr.']';
}

function wdja_cms_page_api($module)
{
   global $conn, $nlng, $variable;
  ii_conn_init();
  ii_get_variable_init();
  $ngenre = $module;
  $toffset = '0';
  $tid =  ii_get_num($_GET['id'],'');
  $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];
  $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
  $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];;
  $npagesize = $variable[ii_cvgenre($ngenre) . '.npagesize'];
  $tsqlstr = "select * from $ndatabase";
  if(!ii_isnull($tid)) $tsqlstr .= "where " . $nidfield . " = ".$tid;
  $tsqlstr .= " order by " . ii_cfnames($nfpre,'time') . " desc";
  $tcp = new cc_cutepage;
  $tcp -> id = $nidfield;
  $tcp -> sqlstr = $tsqlstr;
  $tcp -> offset = $toffset;
  $tcp -> pagesize = $npagesize;
  $tcp -> init();
  $trsary = $tcp -> get_rs_array();
  if (is_array($trsary))
  {
    foreach($trsary as $trs)
    {
      $tmpstr .= '{';
      foreach ($trs as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
      }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
    }
  }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr = str_replace(array("　","\t","\n","\r"), '', $tmpstr);
      return '['.$tmpstr.']';
}

function wdja_cms_singlepage_api($module)
{
  $ngenre = $module;
  $trootstr = ii_get_actual_route($ngenre).'/common/language/module.wdja';
  if (file_exists($trootstr))
  {
    $tdoc = new DOMDocument();
    $tdoc -> load($trootstr);
    $txpath = new DOMXPath($tdoc);
    $tquery = '//xml/configure/node';
    $tnode = $txpath -> query($tquery) -> item(0) -> nodeValue;
    $tquery = '//xml/configure/field';
    $tfield = $txpath -> query($tquery) -> item(0) -> nodeValue;
    $tquery = '//xml/configure/base';
    $tbase = $txpath -> query($tquery) -> item(0) -> nodeValue;
    $tfieldary = explode(',', $tfield);
    $tlength = count($tfieldary) - 1;
    $tquery = '//xml/' . $tbase . '/' . $tnode;
    $trests = $txpath -> query($tquery);
    $tmpstr .= '{';
    foreach ($trests as $trest)
    {
      $tnodelength = $trest -> childNodes -> length;
      for ($i = 0; $i <= $tlength; $i += 1)
      {
        $ti = $i * 2 + 1;
        if ($ti < $tnodelength)
        {
          $nodeValue = $trest -> childNodes -> item($ti) -> nodeValue;
        }
        if($i < $tlength) $k = ii_htmlencode($nodeValue);
        if($i == $tlength) {
          if(ii_isnull($GLOBALS['RS_' . $k])) $GLOBALS['RS_' . $k] = $nodeValue;
          $tmpstr .= "\"".$k."\":\"".addslashes($nodeValue).$tclass."\",";
        }
      }
    }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
      $tmpstr = substr($tmpstr,0,-1);
      $tmpstr = str_replace(array("　","\t","\n","\r"), '', $tmpstr);
      return '['.$tmpstr.']';
  }
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>