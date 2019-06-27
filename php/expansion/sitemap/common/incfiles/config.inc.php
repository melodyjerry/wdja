<?php
$nroute = 'child';
$ngenre = ii_get_actual_genre(__FILE__, $nroute);
wdja_cms_init($nroute);
$nhead = $variable[$ngenre . '.nhead'];
$nfoot = $variable[$ngenre . '.nfoot'];
if (ii_isnull($nhead)) $nhead = $default_head;
if (ii_isnull($nfoot)) $nfoot = $default_foot;
?>