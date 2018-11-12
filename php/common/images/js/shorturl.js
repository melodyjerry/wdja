function getUrlInfo()
{
  var url = $("#url").val();
  if(typeof url == "undefined" || url == null || url == ""){
     alert("链接不能为空");
   }else{
    $.ajax({
      url: '/support/shorturl/api.php',
      data:{"url":$("#url").val()},
      type: 'GET',
      success: function (res) {
        //console.log(res); 
        var obj = JSON.parse(res);
        console.log(obj); 
        var http_status = obj.http_status;
        var status = obj.status;
        var topic = obj.topic;
        var code = obj.code;
        var ip = obj.ip;
        if(http_status == '200'){
          $("#status").val(status);
          $("#topic").val(topic);
          $("#code").val(code);
          $("#nurl").val('https://wdja.cn/'+code);
          $("#ip").val(ip);
        }else if(http_status == '301'){
          alert("不支持链接跳转");
        }else{
          alert("请检查链接有效性");
        }
      }
    });
   }}
function getShortUrl()
{
  var url = $("#url").val();
  if(typeof url == "undefined" || url == null || url == ""){
     alert("链接不能为空");
   }else{
    $.ajax({
      url: '/support/shorturl/index.php',
      data:{"action":"add","url":$("#url").val()},
      type: 'GET',
      success: function (res) {
        //console.log(res); 
        var obj = JSON.parse(res);
        console.log(obj); 
        var http_status = obj.http_status;
        var status = obj.status;
        var topic = obj.topic;
        var code = obj.code;
        var ip = obj.ip;
        if(http_status == '200'){
          $("#status").val(status);
          $("#topic").val(topic);
          $("#code").val(code);
          $("#nurl").val('https://wdja.cn/'+code);
          $("#ip").val(ip);
        }else if(http_status == '301'){
          alert("不支持链接跳转");
        }else{
          alert("请检查链接有效性");
        }
      }
    });
   }}
function getUrl()
{
  var nurl = $("#nurl").val();
  if(typeof nurl == "undefined" || nurl == null || nurl == ""){
     alert("短网址不能为空");
   }else{
    $.ajax({
      url: '/support/shorturl/index.php',
      data:{"action":"search","nurl":$("#nurl").val()},
      type: 'GET',  
      success: function (res) {
        console.log(res); 
        var obj = JSON.parse(res);
        console.log(obj); 
        var status = obj.status;
        var url = obj.url;
        if(status == '1'){
          $("#url").val(url);
        }else{
          alert("请检查短网址有效性");
        }
      }
    });
   }
}