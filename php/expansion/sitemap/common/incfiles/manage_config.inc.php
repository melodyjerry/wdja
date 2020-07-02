<?php
//****************************************************
// WDJA CMS Power by wdja.net
// Email: shadoweb@qq.com
// Web: http://www.wdja.net/
//****************************************************
wdja_cms_admin_init();

function pp_get_xml_root()
{
  global $ngenre;
  $tmpstr = ii_get_actual_route($ngenre);
  if (ii_right($tmpstr, 1) != '/') $tmpstr .= '/';
  $tmproot = 'common/language/';
  $tmpstr = $tmpstr . $tmproot;
  return $tmpstr;
}

//输出html地图地址
function pp_get_htmlmap()
{
    global $conn,$variable,$nurlpre;
    $tfield = 'loc,lastmod,changefreq,priority';
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng').'/sitemap.html';
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
    $tfieldary = explode(',', $tfield);
      $tmpstr .= '    <url>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[0] . '>' . $turl . '</' . $tfieldary[0] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[1] . '>' . ii_format_date(ii_now(),1) . '</' . $tfieldary[1] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[2] . '>daily</' . $tfieldary[2] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[3] . '>1.0</' . $tfieldary[3] . '>' . CRLF;
      $tmpstr .= '    </url>' . CRLF;
return $tmpstr;
}

//输出网站首页
function pp_get_home()
{
    global $conn,$variable,$nurlpre;
    $tfield = 'loc,lastmod,changefreq,priority';
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
    $tfieldary = explode(',', $tfield);
      $tmpstr .= '    <url>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[0] . '>' . $turl . '/</' . $tfieldary[0] . '>' . CRLF;
      $tmpstr .= '      <mobile:mobile type="htmladapt"/>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[1] . '>' . ii_format_date(ii_now(),1) . '</' . $tfieldary[1] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[2] . '>daily</' . $tfieldary[2] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[3] . '>1.0</' . $tfieldary[3] . '>' . CRLF;
      $tmpstr .= '    </url>' . CRLF;
return $tmpstr;
}


//输出网站首页
function pp_get_home_html()
{
    global $conn,$variable,$nurlpre;
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
      $tmpstr .= '   <div id="nav">' . CRLF;
      $tmpstr .= '      <a href="' . $turl .'" target="_blank">'.ii_itake('global.module.web_title','lng').'</a>»<a href="' . $turl .'/sitemap.html">站点地图</a>' . CRLF;
      $tmpstr .= '    </div>' . CRLF;
return $tmpstr;
}


//输出所有单页模块
function pp_get_singlepage()
{
    global $conn,$variable,$nurlpre;
    $tfield = 'loc,lastmod,changefreq,priority';
    $tgenre = ii_itake('config.singlepage','lng');
    if(ii_isnull($tgenre)) return;
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
    $tfieldary = explode(',', $tfield);
    $tgenreary = explode(',', $tgenre);
    foreach($tgenreary as $key => $val)
    {
      $npage = $val;
      $tmpstr .= '    <url>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[0] . '>' . $turl . '/' . $npage .'</' . $tfieldary[0] . '>' . CRLF;
      $tmpstr .= '      <mobile:mobile type="htmladapt"/>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[1] . '>' . ii_format_date(ii_now(),1) . '</' . $tfieldary[1] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[2] . '>weekly</' . $tfieldary[2] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[3] . '>0.8</' . $tfieldary[3] . '>' . CRLF;
      $tmpstr .= '    </url>' . CRLF;
    }
return $tmpstr;
}

//输出所有单页模块
function pp_get_singlepage_html()
{
    global $conn,$variable,$nurlpre;
    $tgenre = ii_itake('config.singlepage','lng');
    if(ii_isnull($tgenre)) return;
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
    $tgenreary = explode(',', $tgenre);
    $tmpstr .= '   <div id="content"><li>页面<ul>' . CRLF;
      foreach($tgenreary as $key => $val)
      {
        $npage = $val;
        $tmpstr .= '      <li><a href="' . $turl . '/' . $npage .'" target="_blank">'.ii_itake('global.' . $npage .':module.topic','lng').'</a></li>' . CRLF;
      }
    $tmpstr .= '    </ul></li></div>' . CRLF;
return $tmpstr;
}


//输出所有模块内容列表
function pp_get_list()
{
    global $conn,$variable,$nurlpre;
    $tfield = 'loc,lastmod,changefreq,priority';
    $tgenre = ii_itake('config.module','lng');
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
    $tfieldary = explode(',', $tfield);
    $tgenreary = explode(',', $tgenre);
    foreach($tgenreary as $key => $val)
    {
      $ngenre = $val;
      $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];//$variable[$ngenre . '.ndatabase'];
      $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
      $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
        $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre, 'hidden') . "=0";
        $trs = ii_conn_query($tsqlstr, $conn);
        while ($trow = ii_conn_fetch_array($trs))
        {
          $tmpstr .= '    <url>' . CRLF;
          $tmpstr .= '      <' . $tfieldary[0] . '>' . $turl . '/' . $ngenre .'/?type=detail&amp;id='. $trow[$nidfield] .'</' . $tfieldary[0] . '>' . CRLF;
          $tmpstr .= '      <mobile:mobile type="htmladapt"/>' . CRLF;
          $tmpstr .= '      <' . $tfieldary[1] . '>' . ii_format_date($trow[ii_cfnames($nfpre, 'time')],1) . '</' . $tfieldary[1] . '>' . CRLF;
          $tmpstr .= '      <' . $tfieldary[2] . '>weekly</' . $tfieldary[2] . '>' . CRLF;
          $tmpstr .= '      <' . $tfieldary[3] . '>0.6</' . $tfieldary[3] . '>' . CRLF;
          $tmpstr .= '    </url>' . CRLF;
        }
    }
return $tmpstr;
}

//输出所有模块内容列表
function pp_get_list_html()
{
    global $conn,$variable,$nurlpre;
    $tgenre = ii_itake('config.module','lng');
    $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
    if(ii_isnull($turl)) $turl = $nurlpre;
    $tmpstr = '';
    $tgenreary = explode(',', $tgenre);
    $tmpstr .= '    <div id="content"><h3>最新文章</h3><ul>' . CRLF;
    foreach($tgenreary as $key => $val)
    {
      $ngenre = $val;
      $ndatabase = $variable[ii_cvgenre($ngenre) . '.ndatabase'];//$variable[$ngenre . '.ndatabase'];
      $nidfield = $variable[ii_cvgenre($ngenre) . '.nidfield'];
      $nfpre = $variable[ii_cvgenre($ngenre) . '.nfpre'];
        $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre, 'hidden') . "=0";
        $trs = ii_conn_query($tsqlstr, $conn);
          while ($trow = ii_conn_fetch_array($trs))
          {
            $tmpstr .= '      <li><a href="' . $turl . '/' . $ngenre .'/?type=detail&amp;id='. $trow[$nidfield] .'" target="_blank">'.$trow[ii_cfnames($nfpre, 'topic')].'</a></li>' . CRLF;
          }
    }
    $tmpstr .= '    </ul></div>' . CRLF;
return $tmpstr;
}


//输出所有分类
function pp_get_sort()
{
  global $conn,$nlng,$nurlpre;
  global $sort_database, $sort_idfield, $sort_fpre;
  $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
  if(ii_isnull($turl)) $turl = $nurlpre;
  $tfield = 'loc,lastmod,changefreq,priority';
  $tfieldary = explode(',', $tfield);
  $tmpstr = '';
  $tarys = Array();
  $tlng = ii_get_safecode($nlng);
  $tsqlstr = "select * from $sort_database where " . ii_cfnames($sort_fpre, 'lng') . "='$tlng' and " . ii_cfnames($sort_fpre, 'hidden') . "=0";
  $trs = ii_conn_query($tsqlstr, $conn);
  while ($trow = ii_conn_fetch_array($trs))
  {
      $tmpstr .= '    <url>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[0] . '>' . $turl . '/' . $trow[ii_cfnames($sort_fpre, 'genre')] . '/?type=list&amp;classid='. $trow[$sort_idfield] .'</' . $tfieldary[0] . '>' . CRLF;
      $tmpstr .= '      <mobile:mobile type="htmladapt"/>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[1] . '>' . ii_format_date($trow[ii_cfnames($sort_fpre, 'time')],1) . '</' . $tfieldary[1] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[2] . '>daily</' . $tfieldary[2] . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[3] . '>1.0</' . $tfieldary[3] . '>' . CRLF;
      $tmpstr .= '    </url>' . CRLF;
  }
return $tmpstr;
}

//输出所有分类
function pp_get_sort_html()
{
  global $conn,$nlng,$nurlpre;
  global $sort_database, $sort_idfield, $sort_fpre;
  $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
  if(ii_isnull($turl)) $turl = $nurlpre;
  $tfield = 'loc,lastmod,changefreq,priority';
  $tfieldary = explode(',', $tfield);
  $tmpstr = '';
  $tarys = Array();
  $tlng = ii_get_safecode($nlng);
  $tsqlstr = "select * from $sort_database where " . ii_cfnames($sort_fpre, 'lng') . "='$tlng' and " . ii_cfnames($sort_fpre, 'hidden') . "=0";
  $trs = ii_conn_query($tsqlstr, $conn);
      $tmpstr .= '    <div id="content"><li>分类目录<ul>' . CRLF;
  while ($trow = ii_conn_fetch_array($trs))
  {
      $tmpstr .= '      <li><a href="' . $turl . '/' . $trow[ii_cfnames($sort_fpre, 'genre')] . '/?type=list&amp;classid='. $trow[$sort_idfield] .'" target="_blank">'.$trow[ii_cfnames($sort_fpre, 'sort')].'</a></li>' . CRLF;
  }
      $tmpstr .= '    </ul></div>' . CRLF;
return $tmpstr;
}

function wdja_cms_admin_manage_createdisp()
{
  global $nsaveimages,$nurlpre;
  $sort = ii_itake('config.sort','lng');
  $save = ii_itake('config.save','lng');
  $tbackurl = $_GET['backurl'];
  $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
  if(ii_isnull($turl)) $turl = $nurlpre;
  if($save == 1) $tburl = ii_get_actual_route('./') . 'sitemap.xml';//保存在根目录
  else $tburl = pp_get_xml_root() . 'sitemap.xml';//保存在插件语言文件夹
  if (!file_exists($tburl)) fopen($tburl,'w');
  if (file_exists($tburl))
  {
    $tmpstr = '';
   // $tmode = ii_get_xrootatt($tburl, 'mode');
    $tfieldary = explode(',', $tfield);
    $torderary = explode(',', $torder);
    $tub = count($tfieldary);
    $tmpstr .= '<?xml version="1.0" encoding="' . CHARSET . '"?>' . CRLF;
    $tmpstr .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . CRLF . ' xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/">' . CRLF;
    //开始输出html地图地址
    $tmpstr .= pp_get_htmlmap();
    //开始输出首页
    if(!ii_isnull($turl)) $tmpstr .= pp_get_home();
    //开始输出分类
    if($sort == 1) $tmpstr .= pp_get_sort();
    //开始输出模块内容列表
    $tmpstr .= pp_get_list();
    //开始输出单页
    $tmpstr .= pp_get_singlepage();
    //
    $tmpstr .= '</urlset>';
    wdja_cms_admin_manage_createdisp_html();
    if (file_put_contents($tburl, $tmpstr)) wdja_cms_admin_msg(ii_itake('global.lng_public.succeed', 'lng'), $tbackurl, 1);
    else wdja_cms_admin_msg(ii_itake('global.lng_public.failed', 'lng'), $tbackurl, 1);
  }
}


function wdja_cms_admin_manage_createdisp_html()
{
  global $nsaveimages,$nurlpre;
  $sort = ii_itake('config.sort','lng');
  $save = ii_itake('config.save','lng');
  $tbackurl = $_GET['backurl'];
  $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
  if(ii_isnull($turl)) $turl = $nurlpre;
  if($save == 1) $tburl = ii_get_actual_route('./') . 'sitemap.html';//保存在根目录
  else $tburl = pp_get_xml_root() . 'sitemap.html';//保存在插件语言文件夹
  if (!file_exists($tburl)) fopen($tburl,'w');
  if (file_exists($tburl))
  {
    $tmpstr = '';
    $tfieldary = explode(',', $tfield);
    $torderary = explode(',', $torder);
    $tub = count($tfieldary);
    $tmpstr .= ii_ireplace('module.header' , 'tpl') . CRLF;
    //开始输出首页
    if(!ii_isnull($turl)) $tmpstr .= pp_get_home_html();
    //开始输出分类
    if($sort == 1) $tmpstr .= pp_get_sort_html();
    //开始输出模块内容列表
    $tmpstr .= pp_get_list_html();
    //开始输出单页
    $tmpstr .= pp_get_singlepage_html();
    //
    $tmpstr .= ii_ireplace('module.footer' , 'tpl');
    file_put_contents($tburl, $tmpstr);
  }
}

function wdja_cms_admin_manage_configdisp()
{
  global $nsaveimages,$nurlpre;
  $tbackurl = $_GET['backurl'];
  $tburl = pp_get_xml_root() .'config' . XML_SFX;
  $tnode = 'item';
  $tfield = 'disinfo,chinese';
  $tbase = 'language_list';
  $torder = 'url,sort,module,singlepage,save,';
  if (ii_right($torder, 1) == ',') $torder = ii_left($torder, (strlen($torder) - 1));
  if (file_exists($tburl) && (!ii_isnull($tnode)) && (!ii_isnull($tfield)) && (!ii_isnull($tbase)))
  {
    $tmpstr = '';
    $tmode = ii_get_xrootatt($tburl, 'mode');
    $tfieldary = explode(',', $tfield);
    $torderary = explode(',', $torder);
    $tub = count($tfieldary);
    $tmpstr .= '<?xml version="1.0" encoding="' . CHARSET . '"?>' . CRLF;
    $tmpstr .= '<xml mode="' . $tmode . '" author="wdja">' . CRLF;
    $tmpstr .= '  <configure>' . CRLF;
    $tmpstr .= '    <node>' . $tnode . '</node>' . CRLF;
    $tmpstr .= '    <field>' . $tfield . '</field>' . CRLF;
    $tmpstr .= '    <base>' . $tbase . '</base>' . CRLF;
    $tmpstr .= '  </configure>' . CRLF;
    $tmpstr .= '  <' . $tbase . '>' . CRLF;
    foreach($torderary as $key => $val)
    {
      $tmpstr .= '    <' . $tnode . '>' . CRLF;
      $tmpstr .= '      <' . $tfieldary[0] . '><![CDATA[' . $val . ']]></' . $tfieldary[0] . '>' . CRLF;
      if($nsaveimages == '1' && $val == 'content') $tmpstr .= '      <' . $tfieldary[1] . '><![CDATA[' . saveimages($_POST[$val]) . ']]></' . $tfieldary[1] . '>' . CRLF;
      elseif($val == 'url' && ii_isnull(ii_itake('global.expansion/sitemap:config.url', 'lng'))) $tmpstr .= '      <' . $tfieldary[1] . '><![CDATA[' . $nurlpre . ']]></' . $tfieldary[1] . '>' . CRLF;
      else $tmpstr .= '      <' . $tfieldary[1] . '><![CDATA[' . $_POST[$val] . ']]></' . $tfieldary[1] . '>' . CRLF;
      $tmpstr .= '    </' . $tnode . '>' . CRLF;
    }
    $tmpstr .= '  </' . $tbase . '>' . CRLF;
    $tmpstr .= '</xml>' . CRLF;
    if (file_put_contents($tburl, $tmpstr)) wdja_cms_admin_msg(ii_itake('global.lng_public.succeed', 'lng'), $tbackurl, 1);
    else wdja_cms_admin_msg(ii_itake('global.lng_public.failed', 'lng'), $tbackurl, 1);
  }
}

function wdja_cms_admin_manage_action()
{
  switch($_GET['action'])
  {
    case 'config':
      return wdja_cms_admin_manage_configdisp();
      break;
    case 'create':
      return wdja_cms_admin_manage_createdisp();
      break;
  }
}

function wdja_cms_admin_manage_config()
{
  global $conn,$nurlpre,$ngenre;
  global $ndatabase, $nidfield, $nfpre;
  $save = ii_itake('config.save','lng');
  $trootstr = pp_get_xml_root() . 'config'. XML_SFX;
  $turl = ii_itake('global.expansion/sitemap:config.url', 'lng');
  if(ii_isnull($turl)) $turl = $nurlpre;
  if (file_exists($trootstr))
  {
    $tmpstr = ii_itake('manage.config' , 'tpl');
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
          if($k == 'url' && ii_isnull($nodeValue)) $nodeValue = $nurlpre;
          if(ii_isnull($GLOBALS['RS_' . $k])) $GLOBALS['RS_' . $k] = $nodeValue;
          $tmpstr = str_replace('{$'.$k.'}', ii_htmlencode($nodeValue), $tmpstr);
        }
      }
    }
    if($save == 1) {
      $sitemap = $turl . '/sitemap.xml';
      $sitemap_html = $turl . '/sitemap.html';
    }else{
      $sitemap = $turl .'/'.ii_get_actual_route($ngenre). '/common/language/sitemap.xml';
      $sitemap_html = $turl .'/'.ii_get_actual_route($ngenre). '/common/language/sitemap.html';
    }
    $sitemap = str_replace('../', '', $sitemap);
    $sitemap_html = str_replace('../', '', $sitemap_html);
    $tmpstr = str_replace('{$sitemap}', $sitemap, $tmpstr);
    $tmpstr = str_replace('{$sitemap_html}', $sitemap_html, $tmpstr);
    $tmpstr = ii_creplace($tmpstr);
    return $tmpstr;
  }
  else mm_client_alert(ii_itake('manage.notexists', 'lng'), -1);
}

function wdja_cms_admin_manage()
{
  switch($_GET['type'])
  {
    case 'config':
      return wdja_cms_admin_manage_config();
      break;
    default:
      return wdja_cms_admin_manage_config();
      break;
  }
}
//****************************************************
// WDJA CMS Power by wdja.net
// Email: shadoweb@qq.com
// Web: http://www.wdja.net/
//****************************************************
?>