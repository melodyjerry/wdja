<?php
$nroute = 'child';
$ngenre = ii_get_actual_genre(__FILE__, $nroute);
wdja_cms_init($nroute);
$JS_timeout = ii_get_num($variable[ii_cvgenre($ngenre) . '.timeout']);
?>
