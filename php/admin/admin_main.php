<?php
require('../common/incfiles/common.inc.php');
require('../common/incfiles/admin.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
wdja_cms_islogin();
$myhtml = wdja_cms_frame();
echo $myhtml;
?>
