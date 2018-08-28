<?php
/*
require('common/incfiles/common.inc.php');
require('page/common/incfiles/config.inc.php');
require('page/common/incfiles/module_config.inc.php');
$myhtml = wdja_cms_module();
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