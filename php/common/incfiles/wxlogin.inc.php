<?php
require('AllPay/include.php');
//通过微信用户openid判断是否存在注册用户
function wxlogin_check_isuser($openid)
{
  global $conn;
  $tdatabase = mm_cndatabase(USER_FOLDER);
  $tidfield = mm_cnidfield(USER_FOLDER);
  $tfpre = mm_cnfpre(USER_FOLDER);
  $topenid = ii_get_safecode($openid);
  $tsqlstr = "select * from $tdatabase where " . ii_cfnames($tfpre, 'openid') . "='$openid'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
  	$tusername = $trs[ii_cfnames($tfpre, 'username')];
  	$tpassword = $trs[ii_cfnames($tfpre, 'password')];
    setcookie(APP_NAME . 'user[userid]', $trs[$tidfield], 0, COOKIES_PATH);
    setcookie(APP_NAME . 'user[username]', $tusername, 0, COOKIES_PATH);
    setcookie(APP_NAME . 'user[password]', $tpassword, 0, COOKIES_PATH);
    $tsqlstr = "update $tdatabase set " . ii_cfnames($tfpre, 'pretime') . "=" . ii_cfnames($tfpre, 'lasttime') . "," . ii_cfnames($tfpre, 'lasttime') . "='" . ii_now() . "' where " . ii_cfnames($tfpre, 'username') . "='$tusername'";
    $trs = ii_conn_query($tsqlstr, $conn);
    $_SESSION[APP_NAME . 'username'] = $tusername;
    return true;
  }
  else return false;
}

function is_weixin(){
	$bool = true;
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($user_agent, 'MicroMessenger') === false) {
		// 非微信浏览器禁止浏览
		$bool = false;
	} else {
		$bool = true;
		// 获取版本号
		//preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);
		//echo '<br>Version:'.$matches[2];
     }
	return $bool;
}

function wxlogin()
{
  global $nwxtoken,$nwxappid,$nwxappsecret,$nwxnotifyurl;
	$config = [
	    'token'          => $nwxtoken,
	    'appid'          => $nwxappid,
	    'appsecret'      => $nwxappsecret,
	];
    $redirect_uri = $nwxnotifyurl;
    $state = md5("ws" . date("YmdH"));
	try {
	    // 3. 创建接口实例
	     $wechat = new \WeChat\Oauth($config);
	     $url = $wechat->getOauthRedirect($redirect_uri, $state = $state, $scope = 'snsapi_base');//snsapi_userinfo
	     //echo $url;exit;
         header('location:' . $url);
         //return $url;
	} catch (Exception $e) {
	
	    // 出错啦，处理下吧
	    //echo $e->getMessage() . PHP_EOL;
	
	}
}

function wxlogin_notify()
{
  global $nwxtoken,$nwxappid,$nwxappsecret;
	$config = [
	    'token'          => $nwxtoken,
	    'appid'          => $nwxappid,
	    'appsecret'      => $nwxappsecret,
	];
	$res = $_REQUEST;
	if (empty($res['code'])) {
	die('获取Code失败');
	}
	try {
	
	    // 3. 创建接口实例
	     $wechat = new \WeChat\Oauth($config);
	     $data = $wechat->getOauthAccessToken();
	     $access_token = $data['access_token'];
	     $openid = $data['openid'];
	
		if($wechat->checkOauthAccessToken($access_token, $openid))
		{
			//$refresh_token = $access_token;
			//$wechat->getOauthRefreshToken($refresh_token);
          return $wechat->getUserInfo($access_token, $openid, $lang = 'zh_CN');
		}
	     
	} catch (Exception $e) {
	
	    // 出错啦，处理下吧
	    //echo $e->getMessage() . PHP_EOL;
	
	}
}

class wechatCallbackapiTest
{
	public function valid()
  {
    $echoStr = $_GET["echostr"];


    //valid signature , option
    if($this->checkSignature()){
    	echo $echoStr;
    	exit;
    }
  }


  public function responseMsg()
  {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];


   	//extract post data
		if (!empty($postStr)){
       
       	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";      
				if(!empty( $keyword ))
        {
       		$msgType = "text";
        	$contentStr = "Welcome to wechat world!";
        	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        	echo $resultStr;
        }else{
        	echo "Input something...";
        }


    }else {
    	echo "";
    	exit;
    }
  }
		
	private function checkSignature()
	{
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];	
    		
		$token = WEIXIN_TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}