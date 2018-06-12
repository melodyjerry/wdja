<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************

function wdja_cms_detail_api($module)
{
   global $conn, $nlng, $variable;
  $ngenre = $module;
  $nroute = 'child';
  wdja_cms_init($nroute);
  $ndatabase = $variable[$ngenre . '.ndatabase'];
  $nidfield = $variable[$ngenre . '.nidfield'];
  $nfpre = $variable[$ngenre . '.nfpre'];
  $tid = ii_get_num($_GET['id']);
  $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre.'hidden') . "=0 and $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
     $tmpstr .= '{';
    foreach ($trs as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      $GLOBALS['RS_' . $tkey] = $val;
        $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
    }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
      $tmpstr = substr($tmpstr,0,-1); 
      return '['.$tmpstr.']';
  }
}

function wdja_cms_list_api($module)
{
   global $conn, $nlng, $variable;
  $ngenre = $module;
  $nroute = 'root';//root,child,node
  $toffset =  ii_get_num($_GET['offset']);//'0';
  $tclassid =  ii_get_num($_GET['classid']);//'99';
  wdja_cms_init($nroute);
  $ndatabase = $variable[$ngenre . '.ndatabase'];
  $nidfield = $variable[$ngenre . '.nidfield'];
  $nfpre = $variable[$ngenre . '.nfpre'];
  $nclstype =$variable[$ngenre . '.nclstype'];
  $nlisttopx = $variable[$ngenre . '.nlisttopx'];
  $npagesize = $variable[$ngenre . '.npagesize'];
  $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre.'hidden') . "=0";
    if ($tclassid != 0)
  {
    if (ii_cinstr($tclassids, $tclassid, ','))
    {
      if ($nclstype == 0) $tsqlstr .= " and " . ii_cfname('class') . "=$tclassid";
      else $tsqlstr .= " and " . ii_cfname('cls') . " like '%|" . $tclassid . "|%'";
    }
  }
  else
  {
    if (!ii_isnull($tclassids)) $tsqlstr .= " and " . ii_cfname('class') . " in ($tclassids)";
  }
  $tsqlstr .= " order by " . ii_cfnames($nfpre.'time') . " desc";
  $tcp = new cc_cutepage;
  $tcp -> id = $nidfield;
  $tcp -> pagesize = $npagesize;
  $tcp -> rslimit = $nlisttopx;
  $tcp -> sqlstr = $tsqlstr;
  $tcp -> offset = $toffset;
  $tcp -> listkey = $tclassid;
  $tcp -> init();
  $trsary = $tcp -> get_rs_array();
  if (is_array($trsary))
  {
    foreach($trsary as $trs)
    {
      $tmpstr .= '{';
      foreach ($trs as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmpstr .= "\"".$tkey."\":\"".addslashes($val)."\",";
      }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
    }
  }
      $tmpstr = substr($tmpstr,0,-1); 
      return '['.$tmpstr.']';
}

function wdja_cms_page_api($module)
{
  $ngenre = $module;//'page';
  $trootstr = '../../'.ii_get_actual_route($ngenre).'/common/language/module.wdja';
  if (file_exists($trootstr))
  {
    $tdoc = new DOMDocument();
    $tdoc -> load($trootstr);
    $txpath = new DOMXPath($tdoc);
    $tquery = '//xml/configure/node';
    $tnode = $txpath -> query($tquery) -> item(0) -> nodeValue;
    $tquery = '//xml/configure/field';
    $tfield = $txpath -> query($tquery) -> item(0) -> nodeValue;
    $tquery = '//xml/configure/base';
    $tbase = $txpath -> query($tquery) -> item(0) -> nodeValue;
    $tfieldary = explode(',', $tfield);
    $tlength = count($tfieldary) - 1;
    $tquery = '//xml/' . $tbase . '/' . $tnode;
    $trests = $txpath -> query($tquery);
    $tmpstr .= '{';
    foreach ($trests as $trest)
    {
      $tnodelength = $trest -> childNodes -> length;
      for ($i = 0; $i <= $tlength; $i += 1)
      {
        $ti = $i * 2 + 1;
        if ($ti < $tnodelength)
        {
          $nodeValue = $trest -> childNodes -> item($ti) -> nodeValue;
        }
        if($i < $tlength) $k = ii_htmlencode($nodeValue);
        if($i == $tlength) {
          if(ii_isnull($GLOBALS['RS_' . $k])) $GLOBALS['RS_' . $k] = $nodeValue;
          $tmpstr .= "\"".$k."\":\"".addslashes($nodeValue).$tclass."\",";
        }
      }
    }
      $tmpstr = substr($tmpstr,0,-1); 
      $tmpstr .= '},';
      $tmpstr = substr($tmpstr,0,-1); 
      echo '['.$tmpstr.']';
  }
}

//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
