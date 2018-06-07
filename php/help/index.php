<?php
require('../common/incfiles/common.inc.php');
require('../'.USER_FOLDER.'/common/api/user.inc.php');//add
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
ap_user_init();//add
$myhtml = wdja_cms_module();
echo $myhtml;
?>
