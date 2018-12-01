<?php
/*
require('common/incfiles/common.inc.php');
require('support/shorturl/common/incfiles/config.inc.php');
require('support/shorturl/common/incfiles/module_config.inc.php');
$code = $_GET['code'];
wdja_cms_module_action();
if(ii_isnull($code)){
  $myhtml = wdja_cms_module();
}else{
  $myhtml = wdja_cms_module($code);
}
echo $myhtml;
*/

require('common/incfiles/common.inc.php');
require(USER_FOLDER . '/common/api/user.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
ap_user_init();
$myhtml = wdja_cms_module();
echo $myhtml;
?>