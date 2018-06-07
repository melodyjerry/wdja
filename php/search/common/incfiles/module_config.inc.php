<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
function wdja_cms_module_list()
{
  global $variable;
  global $ngenre, $npagesize, $nlisttopx;
  global $nsearch_genre, $nsearch_field;
  $tshkeyword = ii_get_safecode($_GET['keyword']);
  $toffset = ii_get_num($_GET['offset']);
  if (ii_isnull($tshkeyword)) mm_imessage(ii_itake('module.keyword_error', 'lng'), -1);
  $tshkeywords = explode(' ', $tshkeyword);
  if (count($tshkeywords) > 5) mm_imessage(ii_itake('module.complex_error', 'lng'), -1);
  $font_red = ii_itake('global.tpl_config.font_red', 'tpl');
  $tmpstr = ii_itake('module.list', 'tpl');
  $tmpastr = ii_ctemplate($tmpstr, '{@recurrence_ida}');
    $tmprstr = '';
        $tndatabases = explode(',', $nsearch_genre);
        $tnfields = explode(',', $nsearch_field);
        $tsqlstr = "";
        for ($ti = 0; $ti < count($tndatabases); $ti ++)
        {
            $tndatabase = $tndatabases[$ti];
            $turltype = ii_get_num($variable[ii_cvgenre($tndatabase) . '.nurltype']);
            $tcreatefolder = $variable[ii_cvgenre($tndatabase) . '.ncreatefolder'];
            $tcreatefiletype = $variable[ii_cvgenre($tndatabase) . '.ncreatefiletype'];
            $tdatabase = $variable[ii_cvgenre($tndatabase) . '.ndatabase'];
            $tidfield = $variable[ii_cvgenre($tndatabase) . '.nidfield'];
            $tfpre = $variable[ii_cvgenre($tndatabase) . '.nfpre'];
            $tunion = " union all ";
            $tsqlstr .= "select * from (";
            $tsqlstr .= "select " . $tidfield . " as un_id,";
            foreach ($tnfields as $tnfield)
            {
                $tsqlstr .= ii_cfnames($tfpre, $tnfield) . " as un_" . $tnfield . ",";
            }
            $tsqlstr .= ii_cfnames($tfpre, 'content_images_list') . " as un_content_images_list," . ii_cfnames($tfpre, 'count') . " as un_count," . ii_cfnames($tfpre, 'time') . " as un_time,'" . $tndatabase . "' as un_genre from " . $tdatabase . " where " . ii_cfnames($tfpre, 'hidden') . "=0";
            foreach ($tshkeywords as $key => $val)
            {
                foreach ($tnfields as $tnfield)
                {
                    if($tnfield == 'topic') $tsqlstr .= " and " . ii_cfnames($tfpre, $tnfield) . " like '%" . $val . "%'";
                    else $tsqlstr .= " or " . ii_cfnames($tfpre, $tnfield) . " like '%" . $val . "%'";
                }
            }
            if($ti == count($tndatabases) - 1) $tsqlstr .= " order by " . ii_cfnames($tfpre, 'time') . " desc) as un_" . $tndatabase;
            else $tsqlstr .= " order by " . ii_cfnames($tfpre, 'time') . " desc) as un_" . $tndatabase . $tunion;
        }
        $tcp = new cc_cutepage;
        $tcp -> id = 'un_id';
        $tcp -> pagesize = $npagesize;
        $tcp -> rslimit = $nlisttopx;
        $tcp -> sqlstr = $tsqlstr;
        $tcp -> offset = $toffset;
        $tcp -> init();
        $trsary = $tcp -> get_rs_array();
        if (is_array($trsary))
        {
            foreach($trsary as $trs)
            {
                $tfshkeyword = '';
                $tmptstr = $tmpastr;
                $tfshkeyword = str_replace('{$explain}', $tshkeyword, $font_red);
                $ttopic = ii_htmlencode($trs['un_topic']);
                $tcontent_images_list = $trs['un_content_images_list'];
                $tcontent = $trs['un_content'];
                $tmptstr = str_replace('{$topicstr}', $ttopic, $tmpastr);
                if (!ii_isnull($tfshkeyword)) 
                {
                    $ttopic = str_replace($tshkeyword, $tfshkeyword, $ttopic);
                    $tcontent = str_replace($tshkeyword, $tfshkeyword, $tcontent);
                }
                $tmptstr = str_replace('{$topic}', $ttopic, $tmptstr);
                $tmptstr = str_replace('{$content}', $tcontent, $tmptstr);
                $tmptstr = str_replace('{$content_images_list}', $tcontent_images_list, $tmptstr);
                $tmptstr = str_replace('{$time}', ii_get_date($trs['un_time']), $tmptstr);
                $tmptstr = str_replace('{$count}', ii_get_num($trs['un_count']), $tmptstr);
                $tmptstr = str_replace('{$id}', ii_get_num($trs['un_id']), $tmptstr);
                $tmptstr = str_replace('{$baseurl}', ii_get_actual_route($trs['un_genre']) . '/', $tmptstr);
                $tmprstr .= $tmptstr;
            }
        }
        $tmpstr = str_replace(WDJA_CINFO, $tmprstr, $tmpstr);
        $tmpstr = str_replace('{$urltype}', $turltype, $tmpstr);
        $tmpstr = str_replace('{$createfolder}', $tcreatefolder, $tmpstr);
        $tmpstr = str_replace('{$createfiletype}', $tcreatefiletype, $tmpstr);
        $tmpstr = str_replace('{$cpagestr}', $tcp -> get_pagestr(), $tmpstr);
        $tmpstr = str_replace('{$genre}', $ngenre, $tmpstr);
        $tmpstr = ii_creplace($tmpstr);
        return $tmpstr;
}

function wdja_cms_module_index()
{
  global $ngenre;
  $tmpstr = ii_itake('module.index', 'tpl');
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
    case 'index':
      return wdja_cms_module_index();
      break;
    default:
      return wdja_cms_module_index();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>
