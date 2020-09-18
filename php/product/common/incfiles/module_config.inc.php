<?php
//****************************************************
// WDJA CMS Power by wdja.net
// Email: shadoweb@qq.com
// Web: http://www.wdja.net/
//****************************************************
function wdja_get_sort_first_id(){
//获取模块第一个分类id
global $conn, $nlng, $ngenre;
global $variable, $sort_database, $sort_idfield, $sort_fpre;
$tsqlstr = 'select * from '. $sort_database.' where ' . ii_cfnames($sort_fpre,'genre') . ' = "' .$ngenre.'" order by '.$sort_idfield.' asc';
$trs = ii_conn_query($tsqlstr, $conn);
$trs = ii_conn_fetch_array($trs);
return $trs[$sort_idfield];
}

function wdja_cms_module_list()
{
  global $conn, $nlng, $ngenre;
  global $nvalidate;
  global $sort_database, $sort_idfield, $sort_fpre;
  $tclassid = ii_get_num($_GET['classid']);
  if($tclassid == 0) $tclassid = wdja_get_sort_first_id();//模块首页使用第一个分类
  $toffset = ii_get_num($_GET['offset']);
  $ttpl = mm_get_sort_field($tclassid,'tpl');
  $tgourl = mm_get_sort_field($tclassid,'gourl');
  if(!ii_isnull($tgourl)){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location:$tgourl");
  	exit;
  }
  global $nclstype, $nlisttopx, $npagesize, $nkeywords, $ndescription;
  global $ndatabase, $nidfield, $nfpre;
  $tclassids = mm_get_sortids($ngenre, $nlng);
  if(!ii_isnull($ttpl)) $tmpstr = ii_itake('module.'.$ttpl, 'tpl');
  else $tmpstr = ii_itake('module.list', 'tpl');
  $tmpastr = ii_ctemplate($tmpstr, '{@recurrence_ida}');
  $tmprstr = '';
  $tsqlstr = "select * from $ndatabase,$sort_database where $ndatabase." . ii_cfname('class') . "=$sort_database.$sort_idfield and $sort_database." . ii_cfnames($sort_fpre, 'lng') . "='$nlng' and $sort_database." . ii_cfnames($sort_fpre, 'genre') . "='$ngenre' and $ndatabase." . ii_cfname('hidden') . "=0 and $ndatabase." . ii_cfname('lng') . "='$nlng'";//更新:不再显示已删除分类的内容
  if ($tclassid != 0)
  {
    if (ii_cinstr($tclassids, $tclassid, ','))
    {
      mm_cntitle(mm_get_sorttext($ngenre, $nlng, $tclassid));
      mm_cnkeywords(mm_get_sortkeywords($ngenre, $nlng, $tclassid));
      mm_cndescription(mm_get_sortdescription($ngenre, $nlng, $tclassid));
      if ($nclstype == 0) $tsqlstr .= " and " . ii_cfname('class') . "=$tclassid";
      else $tsqlstr .= " and (" . ii_cfname('cls') . " like '%|" . $tclassid . "|%' or find_in_set($tclassid," . ii_cfname('class_list') . "))";
    }
  }elseif(ii_isnull($tclassid)){
      mm_cnkeywords($nkeywords);
      mm_cndescription($ndescription);
}else
  {
    if (!ii_isnull($tclassids)) $tsqlstr .= " and (" . ii_cfname('class') . " in ($tclassids) or find_in_set($tclassid," . ii_cfname('class_list') . "))";
  }
  $tgid = api_get_gid();
  if (!ii_isnull($tgid) && !ii_isnull($_GET['type'])) $tsqlstr .= " and $nidfield in ($tgid)";
  $tsqlstr .= " order by " . ii_cfname('time') . " desc";
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
      $tmptstr = $tmpastr;
      foreach ($trs as $key => $val)
      {
        $tkey = ii_get_lrstr($key, '_', 'rightr');
        $GLOBALS['RS_' . $tkey] = $val;
        $tmptstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmptstr);
      }
      $tmptstr = str_replace('{$id}', $trs[$nidfield], $tmptstr);
      $tmptstr = ii_creplace($tmptstr);
      $tmprstr .= $tmptstr;
    }
  }
  $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
  $tmpstr = str_replace('{$cpagestr}', $tcp -> get_pagestr(), $tmpstr);
  $tmpstr = str_replace('{$genre}', $ngenre, $tmpstr);
  $tmpstr = str_replace('{$classid}', $tclassid, $tmpstr);
  $tmpstr = str_replace('{$offset}', $toffset, $tmpstr);
  $tmpstr = mm_cvalhtml($tmpstr, $nvalidate, '{@recurrence_valcode}');
  $tmpstr = ii_creplace($tmpstr);
  return $tmpstr;
}

function wdja_cms_module_detail()
{
  global $conn, $ngenre;
  global $nvalidate;
  $tid = ii_get_num($_GET['id']);
  $tpage = ii_get_num($_GET['page']);
  $tucode = ii_cstr($_GET['ucode']);
  global $ndatabase, $nidfield, $nfpre;
  if(!ii_isnull($tucode)) $tsqlstr = "select * from $ndatabase where " . ii_cfname('hidden') . "=0 and " . ii_cfname('ucode') . "='$tucode'";
  else $tsqlstr = "select * from $ndatabase where " . ii_cfname('hidden') . "=0 and $nidfield=$tid";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $tcount = $trs[ii_cfname('count')] + 1;
    mm_update_field($ngenre,$trs[$nidfield],'count',$tcount);
    $tmpstr = ii_itake('module.detail', 'tpl');
    mm_cntitle(ii_htmlencode($trs[ii_cfname('topic')]));
    mm_cnkeywords(ii_htmlencode($trs[ii_cfname('keywords')]));
    mm_cndescription(ii_htmlencode($trs[ii_cfname('description')]));
    
    $tmpastr = ii_ctemplate_infos($tmpstr, '{@recurrence_ida}');
    $tmprstr = '';
    $tinfos = $trs[ii_cfname('infos')];
    if (!ii_isnull($tinfos))
    {
      $tinfosary = explode('{|||}', $tinfos);
      $tinfoscount = count($tinfosary);
      for ($i = 1; $i <= $tinfoscount; $i ++)
      {
        $tinfostr = $tinfosary[$i - 1];
        if (!ii_isnull($tinfostr))
        {
          $tinfostrary = explode('{:::}', $tinfostr);
          if (count(array_filter($tinfostrary)) == 2)
          {
            $tmptstr = str_replace('{$infos_topic}', $tinfostrary[0], $tmpastr);
            $tmptstr = str_replace('{$infos_link}', $tinfostrary[1], $tmptstr);
            $tmprstr .= $tmptstr;
          }
        }
      }
    }
    $tmpstr = str_replace(WDJA_CINFO_INFOS, $tmprstr, $tmpstr);
    foreach ($trs as $key => $val)
    {
      $tkey = ii_get_lrstr($key, '_', 'rightr');
      $GLOBALS['RS_' . $tkey] = $val;
      $tmpstr = str_replace('{$' . $tkey . '}', ii_htmlencode($val), $tmpstr);
    }
    $tmpstr = str_replace('{$id}', $trs[$nidfield], $tmpstr);
    $tmpstr = str_replace('{$genre}', $ngenre, $tmpstr);
    $tmpstr = str_replace('{$page}', $tpage, $tmpstr);
    $tmpstr = mm_cvalhtml($tmpstr, $nvalidate, '{@recurrence_valcode}');
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
}

function wdja_cms_module_index()
{
  global $ngenre;
  global $nvalidate;
  $tmpstr = ii_itake('module.index', 'tpl');
  $tmpstr = str_replace('{$genre}', $ngenre, $tmpstr);
  $tmpstr = mm_cvalhtml($tmpstr, $nvalidate, '{@recurrence_valcode}');
  $tmpstr = ii_creplace($tmpstr);
  if (!ii_isnull($tmpstr)) return $tmpstr;
  else return wdja_cms_module_list();
}

function wdja_cms_module()
{
  switch($_GET['type'])
  {
    case 'list':
      return wdja_cms_module_list();
      break;
    case 'api':
      return wdja_cms_module_api();
      break;
    case 'detail':
      return wdja_cms_module_detail();
      break;
    case 'index':
      return wdja_cms_module_index();
      break;
    default:
      return wdja_cms_module_index();
      break;
  }
}

//****************************************************
// WDJA CMS Power by wdja.net
// Email: shadoweb@qq.com
// Web: http://www.wdja.net/
//****************************************************
?>