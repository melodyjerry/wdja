<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
function pp_check_isregister_close()
{
  global $ngenre, $variable;
  if (ii_get_num($variable[$ngenre . '.register_close']) == 1) mm_imessage(ii_itake('module.register_close', 'lng'), -1);
}

function pp_check_islostpassword_close()
{
  global $ngenre, $variable;
  if (ii_get_num($variable[$ngenre . '.lostpassword_close']) == 1) mm_imessage(ii_itake('module.lostpassword_close', 'lng'), -1);
}

function wdja_cms_module_logindisp()
{
  $tbackurl = $_GET['backurl'];
  if (ii_isnull($tbackurl)) $tbackurl = ii_get_actual_route('./');
  mm_check_valcode($tbackurl);
  $tusername = ii_get_safecode($_POST['username']);
  $tpassword = md5(ii_get_safecode($_POST['password']));
  if (ap_check_username($tusername, $tpassword))
  {
    mm_client_redirect($tbackurl);
  }
  else mm_imessage(ii_itake('global.lng_error.login', 'lng'), $tbackurl);
}

function wdja_cms_module_logoutdisp()
{
  $tbackurl = $_GET['backurl'];
  if (ii_isnull($tbackurl)) $tbackurl = ii_get_actual_route('./');
  header("Set-Cookie:".APP_NAME."user[userid]='';path =".COOKIES_PATH.";expires=".gmdate('D, d M Y H:i:s \G\M\T', time()-1).";",false);
  header("Set-Cookie:".APP_NAME."user[username]='';path =".COOKIES_PATH.";expires=".gmdate('D, d M Y H:i:s \G\M\T', time()-1).";",false);
  header("Set-Cookie:".APP_NAME."user[password]='';path =".COOKIES_PATH.";expires=".gmdate('D, d M Y H:i:s \G\M\T', time()-1).";",false);
  unset($_SESSION[APP_NAME . 'username']);
  mm_client_redirect($tbackurl);
}

function wdja_cms_module_registerdisp()
{
  global $ctype;
  $ctype = 'register';
  global $Err;
  if (!mm_ck_valcode()) $Err[count($Err)] = ii_itake('global.lng_error.valcode', 'lng');
  $tckstr = 'username:' . ii_itake('config.username', 'lng') . ',password:' . ii_itake('config.password', 'lng') . ',email:' . ii_itake('config.email', 'lng') . ',city:' . ii_itake('config.city', 'lng') . ',sex:' . ii_itake('config.sex', 'lng') . ',old:' . ii_itake('config.old', 'lng');
  $tary = explode(',', $tckstr);
  foreach ($tary as $key => $val)
  {
    $tvalary = explode(':', $val);
    if (ii_isnull($_POST[$tvalary[0]])) $Err[count($Err)] = str_replace('[]', '[' . $tvalary[1] . ']', ii_itake('global.lng_error.insert_empty', 'lng'));
  }
  $tRegUserName = stripslashes($_POST['username']);
  $tRegLimit = '&,\',<,>,#,+,-,/,*,@,$,%,^,' . chr(32) . ',' . chr(9) . ',;';
  $tRegLimitAry = explode(',', $tRegLimit);
  foreach ($tRegLimitAry as $key => $val)
  {
    if (is_numeric(strpos($tRegUserName, $val)))
    {
      $Err[count($Err)] = ii_itake('module.insert_limit', 'lng');
      continue;
    }
  }
  if (ii_strlen($tRegUserName) < 2 || ii_strlen($tRegUserName) > 16) $Err[count($Err)] = ii_itake('module.insert_length', 'lng');
  if ($_POST['password'] != $_POST['cpassword']) $Err[count($Err)] = ii_itake('module.insert_checkout', 'lng');
  if (!ii_isvalidemail($_POST['email'])) $Err[count($Err)] = ii_itake('module.insert_email', 'lng');
  if (!is_array($Err))
  {
    global $conn;
    global $ndatabase, $nidfield, $nfpre;
    $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$tRegUserName'";
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    if ($trs) $Err[count($Err)] = ii_itake('module.insert_exist', 'lng');
    else
    {
      $tsqlstr = "insert into $ndatabase (
      " . ii_cfname('username') . ",
      " . ii_cfname('password') . ",
      " . ii_cfname('email') . ",
      " . ii_cfname('openid') . ",
      " . ii_cfname('nickname') . ",
      " . ii_cfname('headimgurl') . ",
      " . ii_cfname('face_u') . ",
      " . ii_cfname('face_url') . ",
      " . ii_cfname('city') . ",
      " . ii_cfname('sex') . ",
      " . ii_cfname('old') . ",
      " . ii_cfname('name') . ",
      " . ii_cfname('qq') . ",
      " . ii_cfname('msn') . ",
      " . ii_cfname('phone') . ",
      " . ii_cfname('homepage') . ",
      " . ii_cfname('code') . ",
      " . ii_cfname('address') . ",
      " . ii_cfname('time') . "
      ) values (
      '$tRegUserName',
      '" . ii_md5($_POST['password']) . "',
      '" . ii_left(ii_cstr($_POST['email']), 50) . "',
      '" . ii_left(ii_cstr($_POST['openid']), 250) . "',
      '" . ii_left(ii_cstr($_POST['nickname']), 50) . "',
      '" . ii_left(ii_cstr($_POST['headimgurl']), 255) . "',
      '" . ii_get_num($_POST['face_u']) . "',
      '" . ii_left(ii_cstr($_POST['face_url']), 255) . "',
      '" . ii_left(ii_cstr($_POST['city']), 50) . "',
      '" . ii_left(ii_cstr($_POST['sex']), 50) . "',
      '" . ii_left(ii_cstr($_POST['old']), 50) . "',
      '" . ii_left(ii_cstr($_POST['name']), 50) . "',
      '" . ii_left(ii_cstr($_POST['qq']), 50) . "',
      '" . ii_left(ii_cstr($_POST['msn']), 50) . "',
      '" . ii_left(ii_cstr($_POST['phone']), 50) . "',
      '" . ii_left(ii_cstr($_POST['homepage']), 255) . "',
      '" . ii_left(ii_cstr($_POST['code']), 50) . "',
      '" . ii_left(ii_cstr($_POST['address']), 255) . "',
      '" . ii_now() . "'
      )";
      $trs = ii_conn_query($tsqlstr, $conn);
      if ($trs)
      {
        $userid = ii_conn_insert_id($conn);
        header("Set-Cookie:".APP_NAME."user[userid]=".$userid.";path =".COOKIES_PATH.";httpOnly;SameSite=Strict;expires=".COOKIES_EXPIRES.";",false);
        header("Set-Cookie:".APP_NAME."user[username]=".$tRegUserName.";path =".COOKIES_PATH.";httpOnly;SameSite=Strict;expires=".COOKIES_EXPIRES.";",false);
        header("Set-Cookie:".APP_NAME."user[password]=".md5($_POST['password']).";path =".COOKIES_PATH.";httpOnly;SameSite=Strict;expires=".COOKIES_EXPIRES.";",false);
        $_SESSION[APP_NAME . 'username'] = $tRegUserName;
        header('location: ' . ii_get_actual_route('./'));
      }
      else mm_imessage(ii_itake('global.lng_public.sudd', 'lng'), '-1');
    }
  }
}

function wdja_cms_module_lostpassworddisp()
{
  $tbackurl = $_GET['backurl'];
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $tusername = ii_get_safecode($_POST['username']);
  $temail = ii_get_safecode($_POST['email']);
  $tname = ii_get_safecode($_POST['name']);
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$tusername' and " . ii_cfname('email') . "='$temail' and " . ii_cfname('name') . "='$tname'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tpassword = ii_random(8);
    $tmd5password = md5($tpassword);
    $ttopic = ii_itake('module.lostpassword_topic', 'lng');
    $ttopic = str_replace('[]', '[' . ii_itake('global.module.web_title', 'lng') . ']', $ttopic);
    $tbody = ii_itake('module.lostpassword_body', 'lng');
    $tbody = str_replace('[name]', ii_htmlencode($tname), $tbody);
    $tbody = str_replace('[username]', ii_htmlencode($tusername), $tbody);
    $tbody = str_replace('[password]', ii_htmlencode($tpassword), $tbody);
    if (mm_sendemail($temail, $ttopic, $tbody))
    {
      $tsqlstr = "update $ndatabase set " . ii_cfname('password') . "='$tmd5password' where " . ii_cfname('username') . "='$tusername'";
      ii_conn_query($tsqlstr, $conn);
      mm_imessage(ii_itake('module.lostpassword_emailok', 'lng'));
    }
    else mm_imessage(ii_itake('module.lostpassword_emailerror', 'lng'));
  }
  else mm_imessage(ii_itake('module.lostpassword_infoerror', 'lng'), $tbackurl);
}

function wdja_cms_module_manage_informationdisp()
{
  $tbackurl = $_GET['backurl'];
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$nusername'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tsqlstr = "update $ndatabase set
    " . ii_cfname('email') . "='" . ii_left(ii_cstr($_POST['email']), 50) . "',
    " . ii_cfname('city') . "='" . ii_left(ii_cstr($_POST['city']), 50) . "',
    " . ii_cfname('sex') . "=" . ii_get_num($_POST['sex']) . ",
    " . ii_cfname('old') . "=" . ii_get_num($_POST['old']) . ",
    " . ii_cfname('name') . "='" . ii_left(ii_cstr($_POST['name']), 50) . "',
    " . ii_cfname('qq') . "=" . ii_get_num($_POST['qq']) . ",
    " . ii_cfname('msn') . "='" . ii_left(ii_cstr($_POST['msn']), 50) . "',
    " . ii_cfname('phone') . "='" . ii_left(ii_cstr($_POST['phone']), 50) . "',
    " . ii_cfname('homepage') . "='" . ii_left(ii_cstr($_POST['homepage']), 255) . "',
    " . ii_cfname('code') . "=" . ii_get_num($_POST['code']) . ",
    " . ii_cfname('address') . "='" . ii_left(ii_cstr($_POST['address']), 255) . "'
    where " . ii_cfname('username') . "='$nusername'";
    $trs = ii_conn_query($tsqlstr, $conn);
    if ($trs) mm_imessage(ii_itake('global.lng_public.edit_succeed', 'lng'), $tbackurl);
    else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), $tbackurl);
  }
  else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), $tbackurl);
}

function wdja_cms_module_manage_passworddisp()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  $tbackurl = $_GET['backurl'];
  $tpassword = md5($_POST['password']);
  $tnpassword = md5($_POST['npassword']);
  $tncpassword = md5($_POST['ncpassword']);
  if ($tnpassword != $tncpassword) mm_imessage(ii_itake('module.insert_checkout', 'lng'), $tbackurl);
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$nusername' and " . ii_cfname('password') . "='$tpassword'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tsqlstr = "update $ndatabase set " . ii_cfname('password') . "='$tnpassword' where " . ii_cfname('username') . "='$nusername'";
    $trs = ii_conn_query($tsqlstr, $conn);
    if ($trs)
    {
      header("Set-Cookie:".APP_NAME."user[password]=".$tnpassword.";path =".COOKIES_PATH.";httpOnly;SameSite=Strict;expires=".COOKIES_EXPIRES.";",false);
      mm_imessage(ii_itake('global.lng_public.edit_succeed', 'lng'), $tbackurl);
    }
    else mm_imessage(ii_itake('global.lng_public.sudd', 'lng'), $tbackurl);
  }
  else mm_imessage(ii_itake('module.insert_password', 'lng'), $tbackurl);
}

function wdja_cms_module_manage_usersetdisp()
{
  $tbackurl = $_GET['backurl'];
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$nusername'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    global $face_width_max, $face_height_max;
    $tface_width = ii_get_num($_POST['face_width']);
    $tface_height = ii_get_num($_POST['face_height']);
    if ($tface_width > $face_width_max) $tface_width = $face_width_max;
    if ($tface_height > $face_height_max) $tface_height = $face_height_max;

    $tsqlstr = "update $ndatabase set
    " . ii_cfname('face') . "=" . ii_get_num($_POST['face']) . ",
    " . ii_cfname('face_u') . "=" . ii_get_num($_POST['face_u']) . ",
    " . ii_cfname('face_url') . "='" . ii_left(ii_cstr($_POST['face_url']), 255) . "',
    " . ii_cfname('face_width') . "=$tface_width,
    " . ii_cfname('face_height') . "=$tface_height,
    " . ii_cfname('sign') . "='" . ii_left(ii_cstr($_POST['sign']), 100) . "'
    where " . ii_cfname('username') . "='$nusername'";
    $trs = ii_conn_query($tsqlstr, $conn);
    if ($trs) mm_imessage(ii_itake('global.lng_public.edit_succeed', 'lng'), $tbackurl);
    else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), $tbackurl);
  }
  else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), $tbackurl);
}

function wdja_cms_module_managedisp()
{
  switch($_GET['mtype'])
  {
    case 'information':
      wdja_cms_module_manage_informationdisp();
      break;
    case 'password':
      wdja_cms_module_manage_passworddisp();
      break;
    case 'userset':
      wdja_cms_module_manage_usersetdisp();
      break;
  }
}

function wdja_cms_module_action()
{
  switch($_GET['action'])
  {
    case 'login':
      wdja_cms_module_logindisp();
      break;
    case 'logout':
      wdja_cms_module_logoutdisp();
      break;
    case 'register':
      pp_check_isregister_close();
      return wdja_cms_module_registerdisp();
      break;
    case 'lostpassword':
      pp_check_islostpassword_close();
      return wdja_cms_module_lostpassworddisp();
      break;
    case 'manage':
      wdja_cms_module_managedisp();
      break;
  }
}


function wdja_cms_module_shopcart_detail()
{
  global $conn,  $variable;
  $nshop = 'shop';
  $ndatabase = $variable['shopcart.ndatabase'];
  $nidfield = $variable['shopcart.nidfield'];
  $nfpre = $variable['shopcart.nfpre'];
  $tid = ii_get_num($_GET['id']);
  $tbackurl = $_GET['backurl'];
  $tsqlstr = "select * from $ndatabase where $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr = ii_itake('module.shopcart_detail', 'tpl');
    $tprolist = $trs[ii_cfnames($nfpre, 'fid')];
    $tdatabase = mm_cndatabase($nshop);
    $tidfield = mm_cnidfield($nshop);
    $tfpre = mm_cnfpre($nshop);
    $tmpastr = ii_ctemplate($tmpstr, '{@recurrence_ida}');
    $tmprstr = '';
    $tmerchandiseprice = 0;
    if (!ii_isnull($tprolist))
    {
      $tary = explode(',', $tprolist);
      if (is_array($tary))
      {
        foreach ($tary as $key => $val)
        {
          $tid = ii_get_num(ii_get_lrstr($val, ':', 'left'), 0);
          if ($tid != 0)
          {
            $tsqlstr2 = "select * from $tdatabase where " . ii_cfnames($tfpre, 'hidden') . "=0 and $tidfield=$tid";
            $trs2 = ii_conn_query($tsqlstr2, $conn);
            $trs2 = ii_conn_fetch_array($trs2);
            if ($trs2)
            {
              $tnum = ii_get_num(ii_get_lrstr($val, ':', 'right'), 0);
              $tprice = ii_get_num($trs2[ii_cfnames($tfpre, 'price')], 0);
              $twprice = ii_get_num($trs2[ii_cfnames($tfpre, 'wprice')], 0);
              $tmerchandiseprice = $tmerchandiseprice + ($twprice * $tnum);
              $tmptstr = $tmpastr;
              $tmptstr = str_replace('{$id}', $trs2[$tidfield], $tmptstr);
              $tmptstr = str_replace('{$num}', $tnum, $tmptstr);
              $tmptstr = str_replace('{$price}', $tprice, $tmptstr);
              $tmptstr = str_replace('{$wprice}', $twprice, $tmptstr);
              $tmptstr = str_replace('{$topic}', ii_htmlencode($trs2[ii_cfnames($tfpre, 'topic')]), $tmptstr);
              $tmptstr = str_replace('{$limitnum}', ii_get_num($trs2[ii_cfnames($tfpre, 'limitnum')], 0), $tmptstr);
              $tmprstr .= $tmptstr;
            }
          }
        }
      }
    }
    $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
    $tmpstr = str_replace('{$tallprice}', $tmerchandiseprice, $tmpstr);
    foreach ($trs as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      $GLOBALS['RS_' . $tkey] = $val;
      if($tkey=='expressid' && ii_htmlencode($val) == 0 ) $tmpstr = str_replace('{$' . $tkey . '}', '', $tmpstr);
      else $tmpstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmpstr);
    }
    $tmpstr = str_replace('{$id}', $trs[$nidfield], $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
  else
  {
    mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), -1);
  }
}


function wdja_cms_module_shopcart_list()
{
  global $conn,$variable;
  $ndatabase = $variable['shopcart.ndatabase'];
  $nidfield = $variable['shopcart.nidfield'];
  $nfpre = $variable['shopcart.nfpre'];
  $npagesize = $variable['shopcart.npagesize'];
  $nlisttopx = $variable['shopcart.nlisttopx'];
  $toffset = ii_get_num($_GET['offset']);
  $tusername = ii_get_safecode($_COOKIE[APP_NAME . 'user']['username']);
  $tmpstr = ii_itake('module.shopcart_list', 'tpl');
  $tmpastr = ii_ctemplate($tmpstr, '{@recurrence_idb}');
  $tmprstr = '';
  $tsqlstr = "select * from $ndatabase where $nidfield>0";
  if (!ii_isnull($tusername)) $tsqlstr .= " and " . ii_cfnames($nfpre,'username') . "='" . $tusername."'";
  $tsqlstr .= " order by " . ii_cfnames($nfpre,'time') . " desc";
  $tcp = new cc_cutepage;
  $tcp -> id = $nidfield;
  $tcp -> sqlstr = $tsqlstr;
  $tcp -> offset = $toffset;
  $tcp -> pagesize = $npagesize;
  $tcp -> rslimit = $nlisttopx;
  $tcp -> init();
  $trsary = $tcp -> get_rs_array();
  if (is_array($trsary))
  {
    foreach($trsary as $trs)
    {
      $tname = ii_htmlencode($trs[ii_cfnames($nfpre,'name')]);
      $tmptstr = str_replace('{$username}', ii_htmlencode($trs[ii_cfnames($nfpre,'username')]), $tmpastr);
      $tmptstr = str_replace('{$name}', $tname, $tmptstr);
      $tmptstr = str_replace('{$namestr}', ii_encode_scripts(ii_htmlencode($trs[ii_cfnames($nfpre,'name')])), $tmptstr);
      $tmptstr = str_replace('{$orderid}', ii_htmlencode($trs[ii_cfnames($nfpre,'orderid')]), $tmptstr);
      $tmptstr = str_replace('{$allprice}', ii_get_num($trs[ii_cfnames($nfpre,'allprice')]), $tmptstr);
      $tmptstr = str_replace('{$paystate}', ii_itake('global.shopcart:sel_paystate.' . ii_get_num($trs[ii_cfnames($nfpre,'prepaid')]), 'lng'), $tmptstr);
      $tmptstr = str_replace('{$state}', ii_itake('global.shopcart:sel_state.' . ii_get_num($trs[ii_cfnames($nfpre,'state')]), 'lng'), $tmptstr);
      $tmptstr = str_replace('{$time}', ii_get_date($trs[ii_cfnames($nfpre,'time')]), $tmptstr);
      $tmptstr = str_replace('{$id}', ii_get_num($trs[$nidfield]), $tmptstr);
      $tmprstr .= $tmptstr;
    }
  }
  $tmpstr = str_replace('{$cpagestr}', $tcp -> get_pagestr(), $tmpstr);
  $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
  $tmpstr = ii_creplace($tmpstr);
  return $tmpstr;
}

function wdja_cms_module_weixin_notify()
{
  $tbackurl = $_GET['backurl'];
  if (ii_isnull($tbackurl)) $tbackurl = ii_get_actual_route('./');
  mm_check_valcode($tbackurl);
    $userInfo = wxlogin_notify();
    //判断openid是否存在,如存在则生成登录信息和有效期
    //不存在则进行注册绑定
	if(is_array($userInfo)){
		$openid = $userInfo['openid'];
		if(wxlogin_check_isuser($openid)) mm_client_redirect($tbackurl);
	    else return wdja_cms_module_weixin_register($userInfo);
	}
	else  mm_client_redirect($tbackurl);
}

function wdja_cms_module_login()
{
  global $nvalidate;
  $tmpstr = ii_ireplace('module.login', 'tpl');
  $tmpstr = mm_cvalhtml($tmpstr, $nvalidate, '{@recurrence_valcode}');
  return $tmpstr;
}

function wdja_cms_module_user_detail()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $tusername = ii_get_safecode($_GET['username']);
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$tusername'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr = ii_itake('module.user_detail', 'tpl');
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
  else mm_client_alert(ii_itake('global.lng_public.not_exist', 'lng'), -1);
}

function wdja_cms_module_lostpassword()
{
  return ii_ireplace('module.lostpassword', 'tpl');
}

function wdja_cms_module_weixin_register($userInfo)
{
  global $nvalidate;
  $topenid = $userInfo['openid'];
  $tnickname = $userInfo['nickname'];
  $theadimgurl = $userInfo['headimgurl'];
  $tmpstr = ii_itake('module.weixin_register', 'tpl');
  $tmpstr = str_replace('{$openid}', $topenid, $tmpstr);
  $tmpstr = str_replace('{$nickname}', $tnickname, $tmpstr);
  $tmpstr = str_replace('{$headimgurl}', $theadimgurl, $tmpstr);
  $tmpstr = mm_cvalhtml($tmpstr, $nvalidate, '{@recurrence_valcode}');
  $tmpstr = ii_creplace($tmpstr);
  return $tmpstr;
}

function wdja_cms_module_register()
{
  global $nvalidate;
  $tmpstr = ii_itake('module.register', 'tpl');
  $tmpstr = mm_cvalhtml($tmpstr, $nvalidate, '{@recurrence_valcode}');
  $tmpstr = ii_creplace($tmpstr);
  return $tmpstr;
}

function wdja_cms_module_manage_member()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$nusername'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr = ii_itake('module.manage_member', 'tpl');
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
  else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), -1);
}

function wdja_cms_module_manage_information()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$nusername'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr = ii_itake('module.manage_information', 'tpl');
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
  else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), -1);
}

function wdja_cms_module_manage_password()
{
  return ii_ireplace('module.manage_password', 'tpl');
}

function wdja_cms_module_manage_userset()
{
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  global $nusername;
  $tsqlstr = "select * from $ndatabase where " . ii_cfname('username') . "='$nusername'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tmpstr = ii_itake('module.manage_userset', 'tpl');
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
  else mm_client_alert(ii_itake('global.lng_public.sudd', 'lng'), -1);
}

function wdja_cms_module_manage()
{
  switch(mm_ctype($_GET['mtype'], 1))
  {
    case 'member':
      return wdja_cms_module_manage_member();
      break;
    case 'information':
      return wdja_cms_module_manage_information();
      break;
    case 'password':
      return wdja_cms_module_manage_password();
      break;
    case 'userset':
      return wdja_cms_module_manage_userset();
      break;
    default:
      return wdja_cms_module_manage_member();
      break;
  }
}

function wdja_cms_module_premise()
{
  return ii_ireplace('module.premise', 'tpl');
}

function wdja_cms_module_pay()
{
  global $nvalidate;
  global $global_images_route, $nskin;
  $tpayid = $_GET['payid'];//支付方式ID
  $tprice = $_GET['price'];//价格
  $torderid = $_GET['orderid'];//订单号
  $tid = $_GET['id'];//订单ID
  $timg_url_pre = $global_images_route . 'theme/' . $nskin . '/';
  switch($tpayid)
  {
    case '1':
      return  wxpay($torderid,$tid,$tprice,$tid);//微信二维码
      break;
    case '2':
      return  alipay($torderid,$tid,$tprice,$tid);//$talipay -> pay($torderid,$tid,$tprice,$tid,$methodname);//支付宝二维码
      break;
    default:
      return  alipay($torderid,$tid,$tprice,$tid);//支付宝二维码
      break;
  }
  $tmpstr = ii_itake('module.pay', 'tpl');
  $tmpstr = str_replace('{$img}', $timg, $tmpstr);
  $tmpstr = str_replace('{$alipaycode}', $tcode, $tmpstr);
  $tmpstr = str_replace('{$price}', $tprice, $tmpstr);
  $tmpstr = str_replace('{$orderid}', $torderid, $tmpstr);
  $tmpstr = str_replace('{$id}', $tid, $tmpstr);
  $tmpstr = ii_creplace($tmpstr);
  return $tmpstr;
}

function wdja_cms_module_openalipay()
{
  return ii_ireplace('module.openalipay', 'tpl');
}

function wdja_cms_module_alipay_notify()
{
    global $conn,  $variable;
    $ndatabase = $variable['shopcart.ndatabase'];
    $nidfield = $variable['shopcart.nidfield'];
    $nfpre = $variable['shopcart.nfpre'];
	$talipay = new alipay;
	$res = $talipay -> notify_url();
	if($res == '1'){
		//print_r($_POST);
	  $torderid = $_POST['out_trade_no'];
      $tsqlstr = "update $ndatabase set " . ii_cfnames($nfpre,'prepaid') . "=1 where " . ii_cfnames($nfpre, 'orderid') . "='$torderid'";
      ii_conn_query($tsqlstr, $conn);
	}else if ($res == '2'){
		echo '22';
	}else{
		echo '00';
	}
}

function wdja_cms_module_alipay_return()
{
    global $conn,  $variable;
    $tbackurl = $_GET['backurl'];
    if (ii_isnull($tbackurl)) $tbackurl = ii_get_actual_route('./').'user/?type=shopcart_list';
    $ndatabase = $variable['shopcart.ndatabase'];
    $nidfield = $variable['shopcart.nidfield'];
    $nfpre = $variable['shopcart.nfpre'];
	$talipay = new alipay;
	$res = $talipay -> return_url();
	if($res == '1'){
	  $torderid = $_GET['out_trade_no'];
      $tsqlstr = "update $ndatabase set " . ii_cfnames($nfpre,'prepaid') . "=1 where " . ii_cfnames($nfpre, 'orderid') . "='$torderid'";
      ii_conn_query($tsqlstr, $conn);
      mm_imessage(ii_itake('global.lng_public.edit_succeed', 'lng'), $tbackurl);
	}else{
		echo $res.'00';
	}
}

function wdja_cms_module()
{
  $wxlogin_switch = ii_itake('global.' . ADMIN_FOLDER . '/global:weixin.wxlogin_switch','lng');
  switch(mm_ctype($_GET['type']))
  {
    case 'login':
      if(is_weixin() && $wxlogin_switch == 1) return wxlogin();
      else return wdja_cms_module_login();
      break;
    case 'wxnotify':
      return wdja_cms_module_weixin_notify();
      break;
    case 'user_detail':
      ap_user_islogin();
      return wdja_cms_module_user_detail();
      break;
    case 'lostpassword':
      pp_check_islostpassword_close();
      return wdja_cms_module_lostpassword();
      break;
    case 'register':
      pp_check_isregister_close();
      return wdja_cms_module_register();
      break;
    case 'shopcart_list':
      ap_user_islogin();
      return wdja_cms_module_shopcart_list();
      break;
    case 'shopcart_detail':
      ap_user_islogin();
      return wdja_cms_module_shopcart_detail();
      break;
    case 'manage':
      ap_user_islogin();
      return wdja_cms_module_manage();
      break;
    case 'pay':
      ap_user_islogin();
      return wdja_cms_module_pay();
      break;
    case 'openalipay':
      return wdja_cms_module_openalipay();
      break;
    default:
      ap_user_islogin();
      return wdja_cms_module_manage();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>