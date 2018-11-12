<?php
function ap_check_code($code)
{
  global $ngenre;
  global $conn;
  global $ndatabase, $nidfield, $nfpre;
  $ncode = ii_get_safecode($code);
  $tsqlstr = "select * from $ndatabase where " . ii_cfnames($nfpre, 'code') . "='$ncode'";
  $trs = ii_conn_query($tsqlstr, $conn);
  $trs = ii_conn_fetch_array($trs);
  if ($trs)
  {
    $treturn = 1;
  }
  else $treturn = 0;
  return $treturn;
}


function getUrlInfo($url) {
//function shorturl($url,$domain = 'https://wdja.cn/') {
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $key = "jiuqiwan";
        $urlhash = md5($key . $url);
        $len = strlen($urlhash);
        #将加密后的串分成4段，每段4字节，对每段进行计算，一共可以生成四组短连接
        for ($i = 0; $i < 4; $i++) {
            $urlhash_piece = substr($urlhash,  $i * $len / 4, $len / 4);
            #将分段的位与0x3fffffff做位与，0x3fffffff表示二进制数的30个1，即30位以后的加密串都归零
            $hex = hexdec($urlhash_piece) & 0x3fffffff; #此处需要用到hexdec()将16进制字符串转为10进制数值型，否则运算会不正常
            $short_url = '';//$domain;
            #生成6位短连接
            for ($j = 0; $j < 6; $j++) {
                #将得到的值与0x0000003d,3d为61，即charset的坐标最大值
                $short_url .= $charset[$hex & 0x0000003d];
                #循环完以后将hex右移5位
                $hex = $hex >> 5;
            }
 
            $short_url_list[] = $short_url;
        }
        $data['url']=$url;
        $data['code']=$short_url_list[0];
        $data['topic']=getTitle($url);
        $data['http_status']=getHttpStatus($url);
        $data['status']=ap_check_code($short_url_list[0]);
        $data['ip']=ii_get_client_ip();//获取用户IP
        return $data;
    }


function getTitle($url) {
// 你要什么标签
$tag = 'title';
// CURL 方式
$ch = curl_init();
// 设置选项
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,
    ]);
$data = curl_exec($ch); 
// 关闭此次连接
curl_close($ch);  
// 匹配下你要的标签
preg_match('/<'.$tag.'.*>\s*(.*)\s*<\/'.$tag.'>/',$data,$str);
if(ii_isnull($str[1])) $str[1] = "NULL";
return $str[1]; 
}

function getHttpStatus($url) {
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_NOBODY,1);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_TIMEOUT,5);
    curl_exec($curl);
    $re = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
    return  $re;
}

?>