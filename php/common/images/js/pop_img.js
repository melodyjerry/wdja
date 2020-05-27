var pop_html;
pop_html = "<div class=\"popup_mask\" id=\"pop_mask\" style=\"display:none;\"></div>";
pop_html += "<div class=\"popup_page\" id=\"pop_page\" style=\"display:none;\">";
pop_html += "<a href=\"javascript:pop_close();\" target=\"_self\"><span class=\"close\"></span></a>";
pop_html += "<div class=\"content\">";
pop_html += "<div class=\"title\">";
pop_html += "<input type=\"text\" class=\"title\" value=\"图片集上传\">";
pop_html += "</div>";

pop_html += "<div id=\"pop_add\" style=\"display:none;\">";
pop_html += "<table cellpadding=\"10\" cellspacing=\"0\" class=\"tableF\"><tr>";
pop_html += "<th valign=\"top\"><t>图片标题</t></th><td><input style=\"width:350px;\" class=\"i1\" type=\"text\" id=\"img_title\" name=\"img_title\" size=\"25\" value=\"\"></td>";
pop_html += "</tr><tr>";
pop_html += "<th valign=\"top\"><t>图片描述</t></th><td><textarea style=\"width:350px;\" type=\"text\" rows=\"3\" name=\"img_desc\" id=\"img_desc\" cols=\"60\" class=\"t1\"></textarea></td>";
pop_html += "</tr><tr>";
pop_html += "<th valign=\"top\"><t>图片链接</t></th><td><input style=\"width:350px;\" class=\"i1\" type=\"text\" id=\"img_url\" name=\"img_url\" size=\"30\" value=\"\"> <iframe style=\"width:80px;height:30px;vertical-align: middle;margin-top: -2px;\" src=\"?type=upload&upform=form&uptext=img_url&upsimg=0\" style=\"vertical-align: middle;\" width=\"250\" height=\"25\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" align=\"middle\" name=\"upload\" frameborder=\"0\"></iframe></td>";
pop_html += "</tr><tr>";
pop_html += "<th valign=\"top\"><t></t></th><td><a onclick=\"img_info('pop_add');\" style=\"display: inline-block;padding: 6px 16px;border: 0px;line-height: 100%;font-size: 1.4rem;color: #fff;border: #666 1px solid;cursor: pointer;transition: all .1s ease;background-color: #e7505a;border-color: #e7505a;\">OK</a></td>";
pop_html += "</tr></table>";
pop_html += "</div>";


pop_html += "</div>";
pop_html += "</div>";
document.write (pop_html);

function pop_close()
{
  get_id("pop_mask").style.display = 'none';
  get_id("pop_page").style.display = 'none';
  get_id("pop_add").style.display = 'none';
  get_id("pop_mask").className = 'popup_mask';
  get_id("pop_page").className = 'popup_page';
}

function pop_display(strers)
{
  get_id("pop_mask").style.display = 'block';
  get_id("pop_page").style.display = 'block';
  get_id("pop_add").style.display = 'block';
  get_id("pop_mask").className = 'popup_mask on';
  get_id("pop_page").className = 'popup_page on';
}

function img_info(strers){
	var img_title = get_id("img_title").value ;
	var img_desc = get_id("img_desc").value ;
	var img_url = get_id("img_url").value ;
	var opname = img_title ;
	var opvalue = img_title+"#:#"+img_desc+"#:#"+img_url ;
	if (img_title == "" || img_title.length == 0){
		alert('标题不能为空');
	}
	else if (img_url == "" || img_url.length == 0){
		alert('请上传图片');
	}
	else{
		selects.add(get_id("content_images"), opname, opvalue);
		get_id("img_title").value = '';
		get_id("img_desc").value = '';
		get_id("img_url").value = '';
		alert('上传图片成功');
	}
}

function insert_img(strid, strurl, strntype, strtype, strbase)
{
  var tstrtype;
var img_arr = strurl.split("#:#");
var img_arr_len = img_arr.length - 1;
var img_url = img_arr[img_arr_len];
var img_title = img_arr[0];
var img_desc = img_arr[1];
//alert(img_arr);
  if (strtype == -1)
  {tstrtype = strntype;}
  else
  {
    var thtype = request["htype"];
    if (thtype == undefined)
    {tstrtype = strtype;}
    else
    {tstrtype = get_num(thtype);}
  }
  var file_type = get_file_type(strurl);
  switch (tstrtype)
  {
    case 0:
      if(file_type =='mp4' || file_type == 'avi'){
      	editor_insert(strid, "<p style=\"text-align: center;\"><video controls=\"controls\" src=\"" + img_url + "\" id=\"ckplayer_a1\" style=\"width:85%;max-width:750px;margin:0 auto;\" loop=\"loop\" poster=\"\" webkit-playsinline=\"\"></video></p>");
      }else if(file_type =='pdf'){
      	editor_insert(strid, "<p style=\"text-align: left;\"><strong><a href=\"" + img_url + "\" download>" + img_title + "</a></strong></p>");
      }else if(file_type =='zip'|| file_type =='rar'){
      	editor_insert(strid, "<p style=\"text-align: left;\"><strong><a href=\"" + img_url + "\" download>" + img_title + "</a></strong></p>");
      }else{
     	 editor_insert(strid, "<img src=\"" + img_url + "\" title=\"" + img_title + "\" alt=\"" + img_desc + "\" border=\"0\">");
      }
      break;
    case 1:
      itextner(strid, "[img]" + img_url + "[/img]");
      break;
    case 3:
      itextner(strid,  "<img src=\"" + img_url + "\" border=\"0\">");
      break;
  }
}
