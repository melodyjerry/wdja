<?php
require('../common/incfiles/common.inc.php');
require('../' . USER_FOLDER . '/common/api/user.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
ap_user_init();
ap_user_islogin();
wdja_cms_module_action();
$myhtml = wdja_cms_module();
echo $myhtml;
?>
