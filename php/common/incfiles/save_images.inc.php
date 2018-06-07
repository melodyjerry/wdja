<?php
/**
        post发送请求
    **/
    function pget($url,$head=false){
            $curl = curl_init(); // 启动一个CURL会话
      //以下三行代码解决https图片访问受限问题
     $dir = pathinfo($url);//以数组的形式返回图片路径的信息
     $host = $dir['dirname'];//图片路径
     $ref = $host.'/';
            curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址    
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
            if($ref){
              curl_setopt($curl, CURLOPT_REFERER, $ref);//带来的Referer
            }else{
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
            }
            curl_setopt($curl, CURLOPT_HTTPGET, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
            curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
            $tmpInfo = curl_exec($curl); // 执行操作
            if (curl_errno($curl)) {
                    echo 'Errno'.curl_error($curl);
            }
            if($head){ $data['head']=curl_getinfo($curl);}
            curl_close($curl); // 关键CURL会话
            $data['data']=$tmpInfo;
            return $data; // 返回数据
    }
//远程图片本地化
function saveimages($content){
  global $upbasefolder,$nuppath,$ngenre;
  $iport = $_SERVER["SERVER_PORT"];
  if($iport == '443') $basehost = "https://".$_SERVER["HTTP_HOST"]; 
  else  $basehost = "http://".$_SERVER["HTTP_HOST"]; 
  $img_array = array();
  $content = stripslashes($content);
  preg_match_all("/src=[\"|'|\s]([^\"|^\'|^\s]*?)/isU",$content,$img_array);
  $img_array = array_unique($img_array[1]);
  if (ii_isnull($nuppath)) $imgPath = ii_format_date(ii_now(), 2);
  else $imgPath = $nuppath . ii_format_date(ii_now(), 2);
  if(!is_dir($imgPath.'/'))
  {
    mkdir($imgPath, 0777,true);
    chmod($imgPath, 0777);
  }
  foreach($img_array as $key=>$value){
        if(preg_match("#".$basehost."#i", $value)) 
        {
            continue; 
        }
        if(!preg_match("#^(http|https):\/\/#i", $value))
        {
            continue; 
        }
    $http=pget($value,'$value',true);
    $itype=($http['head']['content_type']);
    $icode =($http['head']['http_code']);//图片状态码
    if($icode != '200'){ continue; }
    if(!preg_match("#\.(jpg|gif|png)#i", $itype))
    {
      if($itype=='image/gif')
      {
        $itype = ".gif";
      }
      else if($itype=='image/png')
      {
        $itype = ".png";
      }
      else if($itype=='image/jpeg')
      {
        $itype = ".jpg";
      }
      else
      {
        $itype = '.jpg';
      }
    }
    $runds=md5(time()).$key;
    $rndFileName=$imgPath."/".$runds.$itype;
    $tp = fopen($rndFileName, 'w');
    fwrite($tp, $http['data']);//图片二进制数据写入图片文件
    fclose($tp);
    if(file_exists($rndFileName))
    {
      $sqlurl='/'.$ngenre.'/'.$rndFileName;
      $content = str_replace($value, $sqlurl, $content);
    }
  }
  return $content;
}
?>