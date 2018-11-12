<?php
/*
判断是否作为网站首页使用
*/
if(ii_strlen(dirname($_SERVER['PHP_SELF']))>1){
$nroute = 'child';
$ngenre = ii_get_actual_genre(__FILE__, $nroute);
}else{
  $nroute = '';
  $ngenre = 'support/shorturl';
}
wdja_cms_init($nroute);
$nhead = $variable[$ngenre . '.nhead'];
$nfoot = $variable[$ngenre . '.nfoot'];
if (ii_isnull($nhead)) $nhead = $default_head;
if (ii_isnull($nfoot)) $nfoot = $default_foot;
$ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];
$nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
$nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
$nupre = $variable[ii_cvgenre($ngenre) . '.nupre'];
$npagesize = $variable[ii_cvgenre($ngenre) . '.npagesize'];
?>
