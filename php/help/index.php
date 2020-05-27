<?php
require('../common/incfiles/common.inc.php');
require('../'.USER_FOLDER.'/common/api/user.inc.php');
require('../expansion/fields/common/incfiles/api.inc.php');
require('../expansion/tags/common/incfiles/api.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
ap_user_init();//add
$myhtml = wdja_cms_module();
echo $myhtml;
?>
