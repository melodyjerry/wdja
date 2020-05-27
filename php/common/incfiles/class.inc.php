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

require('AliPay/config.php');
require('AliPay/AlipayTradeService.php');
require('AliPay/AlipayTradePagePayContentBuilder.php');

class Alipay{
	public $config = CONFIG;
	function return_url()
	{
		/* *
		 * 功能：支付宝页面跳转同步通知页面
		 * 版本：2.0
		 * 修改日期：2017-05-01
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		
		 *************************页面功能说明*************************
		 * 该页面可在本机电脑测试
		 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
		 */
		$arr=$_GET;
		$alipaySevice = new AlipayTradeService($this->config); 
		$result = $alipaySevice->check($arr);
		
		/* 实际验证过程建议商户添加以下校验。
		1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
		2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
		3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
		4、验证app_id是否为该商户本身。
		*/
		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
			//商户订单号
			$out_trade_no = htmlspecialchars($_GET['out_trade_no']);
		
			//支付宝交易号
			$trade_no = htmlspecialchars($_GET['trade_no']);
			return '1';
			echo "验证成功<br />支付宝交易号：".$trade_no;
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
			return '0';
		    echo "验证失败";
		}
		
	}
	
	function notify_url()
	{
		/* *
		 * 功能：支付宝服务器异步通知页面
		 * 版本：2.0
		 * 修改日期：2017-05-01
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		
		 *************************页面功能说明*************************
		 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
		 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
		 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
		 */
		$arr=$_POST;
		$alipaySevice = new AlipayTradeService($this->config); 
		$alipaySevice->writeLog(var_export($_POST,true));
		$result = $alipaySevice->check($arr);
		
		/* 实际验证过程建议商户添加以下校验。
		1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
		2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
		3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
		4、验证app_id是否为该商户本身。
		*/
		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
		
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//商户订单号
		
			$out_trade_no = $_POST['out_trade_no'];
		
			//支付宝交易号
		
			$trade_no = $_POST['trade_no'];
		
			//交易状态
			$trade_status = $_POST['trade_status'];
		
		
		    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
				return '1';
		    }
		    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_amount与通知时获取的total_fee为一致的
					//如果有做过处理，不执行商户的业务程序			
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知
		    }
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
				return '2';
			echo "success";	//请不要修改或删除
			}else {
			    //验证失败
				return '0';
			    echo "fail";
			
			}
	}
	
	function pay($out_trade_no,$subject,$total_amount,$body,$methodname)
	{
		//支付
		//商户订单号，商户网站订单系统中唯一订单号，必填
	    //$out_trade_no = trim($_POST['WIDout_trade_no']);
	
	    //订单名称，必填
	    //$subject = trim($_POST['WIDsubject']);
	
	    //付款金额，必填
	    //$total_amount = trim($_POST['WIDtotal_amount']);
	
	    //商品描述，可空
	    //$body = trim($_POST['WIDbody']);
	
		//构造参数
		$payRequestBuilder = new AlipayTradePagePayContentBuilder();
		$payRequestBuilder->setBody($body);
		$payRequestBuilder->setSubject($subject);
		$payRequestBuilder->setTotalAmount($total_amount);
		$payRequestBuilder->setOutTradeNo($out_trade_no);
		$aop = new AlipayTradeService($this->config);
	
		/**
		 * pagePay 电脑网站支付请求
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @param $return_url 同步跳转地址，公网可以访问
		 * @param $notify_url 异步通知地址，公网可以访问
		 * @return $response 支付宝返回的信息
	 	*/
		$response = $aop->pagePay($payRequestBuilder,$this->config['return_url'],$this->config['notify_url'],$methodname);
	
		//输出表单
		var_dump($response);
	}
	
    function query(){
    	//交易查询
	    //商户订单号，商户网站订单系统中唯一订单号
	    $out_trade_no = trim($_POST['WIDTQout_trade_no']);
	
	    //支付宝交易号
	    $trade_no = trim($_POST['WIDTQtrade_no']);
	    //请二选一设置
	    //构造参数
		$RequestBuilder = new AlipayTradeQueryContentBuilder();
		$RequestBuilder->setOutTradeNo($out_trade_no);
		$RequestBuilder->setTradeNo($trade_no);
		$aop = new AlipayTradeService($this->config);
		
		/**
		 * alipay.trade.query (统一收单线下交易查询)
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @return $response 支付宝返回的信息
	 	 */
		$response = $aop->Query($RequestBuilder);
		var_dump($response);
    }
    
	function close($iswap=false)
	{
		//交易关闭
		//商户订单号，商户网站订单系统中唯一订单号
	    $out_trade_no = trim($_POST['WIDTCout_trade_no']);
	
	    //支付宝交易号
	    $trade_no = trim($_POST['WIDTCtrade_no']);
	    //请二选一设置
	
		//构造参数
		$RequestBuilder=new AlipayTradeCloseContentBuilder();
		$RequestBuilder->setOutTradeNo($out_trade_no);
		$RequestBuilder->setTradeNo($trade_no);
	
		$aop = new AlipayTradeService($this->config);
	
		/**
		 * alipay.trade.close (统一收单交易关闭接口)
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @return $response 支付宝返回的信息
		 */
		$response = $aop->Close($RequestBuilder);
		var_dump($response);
	}
	
	function refund()
	{
		//退款
		//商户订单号，商户网站订单系统中唯一订单号
	    $out_trade_no = trim($_POST['WIDTRout_trade_no']);
	
	    //支付宝交易号
	    $trade_no = trim($_POST['WIDTRtrade_no']);
	    //请二选一设置
	
	    //需要退款的金额，该金额不能大于订单金额，必填
	    $refund_amount = trim($_POST['WIDTRrefund_amount']);
	
	    //退款的原因说明
	    $refund_reason = trim($_POST['WIDTRrefund_reason']);
	
	    //标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传
	    $out_request_no = trim($_POST['WIDTRout_request_no']);
	
	    //构造参数
		$RequestBuilder=new AlipayTradeRefundContentBuilder();
		$RequestBuilder->setOutTradeNo($out_trade_no);
		$RequestBuilder->setTradeNo($trade_no);
		$RequestBuilder->setRefundAmount($refund_amount);
		$RequestBuilder->setOutRequestNo($out_request_no);
		$RequestBuilder->setRefundReason($refund_reason);
	
		$aop = new AlipayTradeService($this->config);
		
		/**
		 * alipay.trade.refund (统一收单交易退款接口)
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @return $response 支付宝返回的信息
		 */
		$response = $aop->Refund($RequestBuilder);
		var_dump($response);
	}
	
	function refundquery()
	{
		//退款查询
		//商户订单号，商户网站订单系统中唯一订单号
	    $out_trade_no = trim($_POST['WIDRQout_trade_no']);
	
	    //支付宝交易号
	    $trade_no = trim($_POST['WIDRQtrade_no']);
	    //请二选一设置
	
	    //请求退款接口时，传入的退款请求号，如果在退款请求时未传入，则该值为创建交易时的外部交易号，必填
	    $out_request_no = trim($_POST['WIDRQout_request_no']);
	
	    //构造参数
		$RequestBuilder=new AlipayTradeFastpayRefundQueryContentBuilder();
		$RequestBuilder->setOutTradeNo($out_trade_no);
		$RequestBuilder->setTradeNo($trade_no);
		$RequestBuilder->setOutRequestNo($out_request_no);
	
		$aop = new AlipayTradeService($this->config);
		
		/**
		 * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @return $response 支付宝返回的信息
		 */
		$response = $aop->refundQuery($RequestBuilder);
		var_dump($response);
	}

	function pay_person($imgurl,$price,$orderid,$id){
	  //个人使用，不支持回调。
	  //生成并保存价格二维码
	  $alipay_uid = ii_itake('global.' . ADMIN_FOLDER . '/global:other.alipay_uid','lng');
	  if(ii_isnull($alipay_uid)) $alipay_uid = '2088202216609811';
	  $alipay_url = urlencode('http://'.$_SERVER['HTTP_HOST'].'/'.USER_FOLDER.'/?type=openalipay&money='. $price .'&num='. $orderid .'&uid='. $alipay_uid);
	  if(!ii_isnull($imgurl) && !ii_isnull($price) && !ii_isnull($orderid) && !ii_isnull($id)){
	    $data = 'alipays://platformapi/startapp?appId=20000067&url='. $alipay_url;
	    $imgPath = $imgurl.'alipay-code/';
		if(!is_dir($imgPath))
		{
		  mkdir($imgPath, 0777,true);
		  chmod($imgPath, 0777);
		}
	    $filename = $imgPath.'alipay-'.$price.'-'.$id.'.png';
	    $errorCorrectionLevel = 'H';
	    $matrixPointSize = 4;
	    if (!file_exists($filename)) QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
	  }else{
	    $filename = ii_itake('global.' . ADMIN_FOLDER . '/global:other.alipay_code','lng');
	  }
	  return $filename;
	}
	
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>