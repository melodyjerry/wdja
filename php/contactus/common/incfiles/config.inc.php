<?php
/*
判断是否作为网站首页使用
*/
if(ii_strlen(dirname($_SERVER['PHP_SELF']))>1){
  $nroute = 'node';
  $ngenre = ii_get_actual_genre(__FILE__, $nroute);
}else{
  $nroute = '';
  $ngenre = 'contactus';
}
wdja_cms_init($nroute);
$nhead = $variable[$ngenre . '.nhead'];
$nfoot = $variable[$ngenre . '.nfoot'];
if (ii_isnull($nhead)) $nhead = $default_head;
if (ii_isnull($nfoot)) $nfoot = $default_foot;
$nuppath = $variable[$ngenre . '.nuppath'];
$nuptype = $variable[$ngenre . '.nuptype'];
$nurltype = $variable[$ngenre . '.nurltype'];
$nclstype = $variable[$ngenre . '.nclstype'];
$nbasehref = $variable[$ngenre . '.nbasehref'];
$nsaveimages = $variable[$ngenre . '.nsaveimages'];
$nupsimg = $variable[$ngenre . '.thumbnail.upsimg'];
$nupsimgs = $variable[$ngenre . '.thumbnail.upsimgs'];
$ncreatefolder = $variable[$ngenre . '.ncreatefolder'];
$ncreatefiletype = $variable[$ngenre . '.ncreatefiletype'];
//$ntitle = ii_itake('module.channel_title', 'lng');
?>