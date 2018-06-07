<?php
require('../../common/incfiles/common.inc.php');
require('../../common/incfiles/admin.inc.php');
require('../common/api/user.inc.php');
require('common/incfiles/config.inc.php');
require('common/incfiles/manage_config.inc.php');
wdja_cms_islogin();
wdja_cms_admin_manage_action();
$mybody = wdja_cms_admin_manage();
$myhead = wdja_cms_web_head($admin_head);
$myfoot = wdja_cms_web_foot($admin_foot);
$myhtml = $myhead . $mybody . $myfoot;
echo $myhtml;
?>
