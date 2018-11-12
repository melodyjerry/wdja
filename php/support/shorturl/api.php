<?php
require('../../common/incfiles/common.inc.php');
require('common/incfiles/shorturl.php');
require('common/incfiles/config.inc.php');

echo json_encode(getUrlInfo($_GET['url']));

?>