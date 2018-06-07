<?php
require('../common/incfiles/common.inc.php');
require('../common/incfiles/admin.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/module_config.inc.php');
wdja_cms_islogin();
$mybody = wdja_cms_manage();
$myhead = wdja_cms_web_head($admin_head);
$myfoot = wdja_cms_web_foot($admin_foot);
$myhtml = $myhead . $mybody . $myfoot;
echo $myhtml;
?>
