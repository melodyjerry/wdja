<?php
require('common/incfiles/common.inc.php');
require(USER_FOLDER . '/common/api/user.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
$ip = ii_get_client_ip();
$ip_res = mm_ip_map($ip,1);
ap_user_init();
$myhtml = wdja_cms_module();
echo $myhtml;
echo '<p style="width:100%;margin:0 auto;text-align: center;">您来自'.$ip_res.',感谢访问本站!</p>';
?>