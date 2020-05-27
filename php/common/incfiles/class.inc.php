<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
class cc_cache
{
  public $filename;
  public $cachename;

  function get_file_text()
  {
    return file_get_contents($this -> filename);
  }

  function put_file_text($data)
  {
    return file_put_contents($this -> filename, $data);
  }

  function get_file_array()
  {
    return include_once($this -> filename);
  }

  function set_file_array($data)
  {
    if (!is_array($data))
    {
      return false;
    }
    else
    {
      $tarraytext = 'array(';
      foreach($data as $key => $val)
      {
        if (is_array($val))
        {
          $tarraytext = $tarraytext . '\'' . $key . '\' => ' . $this -> set_file_array($val) . ',';
        }
        else
        {
          $tarraytext = $tarraytext . '\'' . $key . '\' => \'' . $val . '\',';
        }
      }
      $tarraytext = $tarraytext . ')';
      return $tarraytext;
    }
  }

  function put_file_array($data)
  {
    $ttext = '<?php' . chr(13) . chr(10);
    $ttext = $ttext . '$GLOBALS[\'' . $this -> cachename . '\'] = ';
    $ttext = $ttext . $this -> set_file_array($data) . ';' . chr(13) . chr(10);
    $ttext = $ttext . '?>';
    return file_put_contents($this -> filename, $ttext);
  }
}

class cc_cutepage
{
  public $id;
  public $sqlstr;
  public $offset;
  public $pagesize;
  public $rslimit;
  public $listkey;

  function init()
  {
    $trscount = $this -> get_rs_count();
    if (!isset($this -> rslimit)) $this -> rslimit = $trscount;
    else
    {
      if ($trscount < ($this -> rslimit)) $this -> rslimit = $trscount;
    }
  }

  function get_rs_count()
  {
    global $conn;
    $tsqlstr = 'select count(' . $this -> id . ') from (' . $this -> sqlstr .') as sum';
    $trs = ii_conn_query($tsqlstr, $conn);
    $trs = ii_conn_fetch_array($trs);
    return $trs[0];
  }

  function get_rs_array()
  {
    global $conn;
    $toffset = $this -> offset;
    $tpagesize = $this -> pagesize;
    $trslimit = $this -> rslimit;
    if (!($toffset > $trslimit))
    {
      if (($toffset + $tpagesize) > $trslimit) $tpagesize = $trslimit - $toffset;
      $tsqlstr = $this -> sqlstr . ' limit ' . $toffset . ',' . $tpagesize;
      $trs = ii_conn_query($tsqlstr, $conn);
      $ti = 0;
      while ($trow = ii_conn_fetch_array($trs))
      {
        $tarray[$ti] = $trow;
        $ti += 1;
      }
      return $tarray;
    }
  }

  function get_pagestr()
  {
    global $nurltype, $ncreatefolder, $ncreatefiletype;
    $toffset = $this -> offset;
    $tpagesize = $this -> pagesize;
    $trslimit = $this -> rslimit;
    $tlistkey = $this -> listkey;
    $tpagenums = ceil($trslimit / $tpagesize);
    $tnpagenum = ceil($toffset / $tpagesize) + 1;
    if ($tnpagenum > $tpagenums) $tnpagenum = $tpagenums;
    $txpagenum = $tnpagenum + 1;
    if ($txpagenum > $tpagenums) $txpagenum = $tpagenums;
    $tstate1 = ($toffset > 0) ? 1 : 0;
    $tstate2 = (($toffset + $tpagesize) < $trslimit) ? 1 : 0;
    $tmpstr = ii_itake('global.tpl_common.cutepage', 'tpl');
    $tpl_firstpage = ii_ctemplate($tmpstr, '{@firstpage}');
    $tary = explode('{|}', $tpl_firstpage);
    if ($tstate1)
    {
      $tstr = $tary[1];
      $tstr = str_replace('{$URLfirst}', ii_iurl('listpage', 0, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey), $tstr);
    }
    else $tstr = $tary[0];
    $tmpstr = str_replace(WDJA_CINFO, $tstr, $tmpstr);
    $tpl_prepage = ii_ctemplate($tmpstr, '{@prepage}');
    $tary = explode('{|}', $tpl_prepage);
    if ($tstate1)
    {
      $tstr = $tary[1];
      $tstr = str_replace('{$URLpre}', ii_iurl('listpage', $toffset - $tpagesize, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey), $tstr);
    }
    else $tstr = $tary[0];
    $tmpstr = str_replace(WDJA_CINFO, $tstr, $tmpstr);
    $tpl_nextpage = ii_ctemplate($tmpstr, '{@nextpage}');
    $tary = explode('{|}', $tpl_nextpage);
    if ($tstate2)
    {
      $tstr = $tary[1];
      $tstr = str_replace('{$URLnext}', ii_iurl('listpage', $toffset + $tpagesize, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey), $tstr);
    }
    else $tstr = $tary[0];
    $tmpstr = str_replace(WDJA_CINFO, $tstr, $tmpstr);
    $tpl_lastpage = ii_ctemplate($tmpstr, '{@lastpage}');
    $tary = explode('{|}', $tpl_lastpage);
    if ($tstate2)
    {
      $tlastoffset = $trslimit - (($trslimit - $toffset) % $tpagesize);
      if ($tlastoffset == $trslimit) $tlastoffset = $trslimit - $tpagesize;
      $tstr = $tary[1];
      $tstr = str_replace('{$URLlast}', ii_iurl('listpage', $tlastoffset, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey), $tstr);
    }
    else $tstr = $tary[0];
    $tmpstr = str_replace(WDJA_CINFO, $tstr, $tmpstr);
    $tmpstr = str_replace('{$npagenum}', $tnpagenum, $tmpstr);
    $tmpstr = str_replace('{$pagenums}', $tpagenums, $tmpstr);
    $tmpstr = str_replace('{$xpagenum}', $txpagenum, $tmpstr);
    $tmpstr = str_replace('{$pagesize}', $tpagesize, $tmpstr);
    $tmpstr = str_replace('{$goURL}', ii_iurl('listpage', '\' + cc_cutepage(get_id(\'go-page-num\').value) + \'', $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey), $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
function get_pagenum() 
    {
        global $nurltype, $ncreatefolder, $ncreatefiletype;
        $maxlength = 10;
    $toffset = $this -> offset;
    $tpagesize = $this -> pagesize;
    $trslimit = $this -> rslimit;
    $tlistkey = $this -> listkey;
    $tpagenums = ceil($trslimit / $tpagesize);
    $tnpagenum = ceil($toffset / $tpagesize) + 1;
    if ($tnpagenum > $tpagenums) $tnpagenum = $tpagenums;
    $txpagenum = $tnpagenum + 1;
    if ($txpagenum > $tpagenums) $txpagenum = $tpagenums;
    $tstate1 = ($toffset > 0) ? 1 : 0;
    $tstate2 = (($toffset + $tpagesize) < $trslimit) ? 1 : 0;
        $tmpstr = '';
        if($tpagenums > 1)
        {
            $tmpstr = ii_itake('global.tpl_common.pagenum', 'tpl');
            $tmpastr = ii_ctemplate($tmpstr, '{@}');
            $tmprstr = '';
            $tstr = $tary[1];
            for($ti = 0;$ti < $tpagenums; $ti++)
            {
                $tmptstr = $tmpastr;
                $tmptstr = str_replace('{$pageurl}', ii_iurl('listpage', $ti*$tpagesize, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey), $tmptstr);
                $tmptstr = str_replace('{$pagenum}', $ti + 1, $tmptstr);
                $tmptstr = $ti + 1 == $tnpagenum ?  str_replace('{$current}', ' class="current-page"', $tmptstr) : str_replace('{$current}', '', $tmptstr);
                if(($ti > $tpagenums - $maxlength - 1 || $ti > $tnpagenum - 6) && ($ti < $tnpagenum + $maxlength - 5 || $ti < $maxlength)) $tmprstr .= $tmptstr;
            }
            if ($tstate1)
            {
                $tmpstr = str_replace('{$pre}', '<a class="np-page" href="' . ii_iurl('listpage', $toffset - $tpagesize, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey) . '">' . ii_itake('global.lng_cutepage.prepage', 'lng') . '</a>', $tmpstr);
            }
            else $tmpstr = str_replace('{$pre}', '', $tmpstr);
            if ($tstate2)
            {
                $tmpstr = str_replace('{$next}', '<a class="np-page" href="' . ii_iurl('listpage', $toffset + $tpagesize, $nurltype, 'folder=' . $ncreatefolder . ';filetype=' . $ncreatefiletype . ';listkey=' . $tlistkey) . '">' . ii_itake('global.lng_cutepage.nextpage', 'lng') . '</a>', $tmpstr);
            }
            else $tmpstr = str_replace('{$next}', '', $tmpstr);
            $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
            $tmpstr = str_replace('{$npagenum}', $tnpagenum, $tmpstr);
            $tmpstr = str_replace('{$pagenums}', $tpagenums, $tmpstr);
            $tmpstr = str_replace('{$xpagenum}', $txpagenum, $tmpstr);
            $tmpstr = str_replace('{$pagesize}', $tpagesize, $tmpstr);
            $tmpstr = ii_creplace($tmpstr);
        }
    return $tmpstr;
    }

}

require('PHPMailer/Exception.php');
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class cc_socketmail
{
  public $server;
  public $port;
  public $username;
  public $password;
  public $from;
  public $to;
  public $subject;
  public $message;

  function send_mail()
  {
    $tserver = $this -> server;
    $tport = $this -> port;
    $tcharset = $this -> charset;
    $tusername = $this -> username;
    $tpassword = $this -> password;
    $tfrom = $this -> from;
    $tto = $this -> to;
    $tsubject = $this -> subject;
    $tmessage = $this -> message;

    if (empty($tsubject) || empty($tmessage)) {
        return ['result' => false, 'msg' => '参数错误'];
    }
    $fromAddress = $tfrom;
    $pwd =  $tpassword;
    $toAddress = $tto;

    $mail = new PHPMailer();
    //告诉PHPMailer使用SMTP
    $mail->isSMTP();
    //启用SMTP调试
    // 0 =关闭（供生产使用）
    // 1 =客户端消息
    // 2 =客户端和服务器消息
    $mail->SMTPDebug = 0 ;
    //设置邮件服务器的主机名
    $mail->Host = $tserver;
    //使用
    // $ mail-> Host = gethostbyname（'smtp.gmail.com'）;
    //如果您的网络不支持SMTP over IPv6
    //设置SMTP端口号 -  587用于经过身份验证的TLS，即RFC4409 SMTP提交
    $mail->Port = $tport;
    //设置加密系统使用 -  ssl（不建议使用）或tls
    $mail->SMTPSecure = 'ssl';
    //是否使用SMTP身份验证
    $mail->SMTPAuth = true ;
    //用于SMTP身份验证的用户名 - 使用gmail的完整电子邮件地址
    $mail->Username = $fromAddress;
    //用于SMTP身份验证的密码(企业邮箱的话为登录密码)
    $mail->Password = $pwd;
    //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->CharSet = $tcharset;
    //设置要从中发送消息的人员
    $mail->setFrom($fromAddress,$tusername);
    //设置备用回复地址
    //$mail->addReplyTo('***@qq.com','腾讯');
    //设置要将消息发送给谁
    $mail->addAddress($toAddress,$toAddress);
    //设置主题行
    $mail->Subject = $tsubject;
    //从外部文件中读取HTML邮件正文，将引用的图像转换为嵌入式图像
    //将HTML转换为基本的纯文本替代正文
    //$mail->msgHTML(file_get_contents(' contents.html '),__DIR__);
    //用手动创建的纯文本正文替换
    $mail->AltBody  = 'This is the body in plain text for non-HTML mail clients';
    $mail->Body  = $tmessage;
    $result = $mail->send();
  }
}


//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>