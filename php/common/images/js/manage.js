function bsearch(id,obj){
  get_id(id).value=obj.value;
  get_id('btn_search').click();
}
function insert_images(strid, strurl, strntype, strtype, strbase)
{
  var tstrtype;
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
      	editor_insert(strid, "<p style=\"text-align: center;\"><video controls=\"controls\" src=\"" + strurl + "\" id=\"ckplayer_a1\" style=\"width:85%;max-width:750px;margin:0 auto;\" loop=\"loop\" poster=\"\" webkit-playsinline=\"\"></video></p>");
      }else if(file_type =='pdf'){
      	editor_insert(strid, "<p style=\"text-align: left;\"><strong><a href=\"" + strurl + "\" download>Download PDF</a></strong></p>");
      }else if(file_type =='zip'|| file_type =='rar'){
      	editor_insert(strid, "<p style=\"text-align: left;\"><strong><a href=\"" + strurl + "\" download>Download ZIP</a></strong></p>");
      }else{
     	 editor_insert(strid, "<img src=\"" + strurl + "\" border=\"0\" data-mce-src=\"" + strurl + "\">");
      }
      break;
    case 1:
      itextner(strid, "[img]" + strurl + "[/img]");
      break;
    case 3:
      itextner(strid,  "<img src=\"" + strurl + "\" border=\"0\">");
      break;
  }
}

function insert_cutepagestr(strid, strers, strntype, strtype)
{
  var tstrtype;
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
  if (!(tstrtype == 0))
  {
    itextner(strid, strers);
  }
  else
  {
    editor_insert(strid, strers);
  }
}