<?php
require('../common/incfiles/common.inc.php');
require('../common/incfiles/wxlogin.inc.php');
require('common/incfiles/config.inc.php');
global $nwxtoken,$nwxappid,$nwxappsecret,$nwxnotifyurl;
define("WEIXIN_TOKEN", $nwxtoken);
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
?>