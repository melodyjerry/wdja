<?php
require('AllPay/include.php');

function allpay_config($type){
  ii_conn_init();
	$alipay_config = [
	    // 沙箱模式
	    'debug'       => true,
	    // 应用ID
	    'appid'       => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.alipay_appid','lng'),
	    // 支付宝公钥(1行填写)
	    'public_key'  => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.alipay_public_key','lng'),
	    // 支付宝私钥(1行填写)
	    'private_key' => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.alipay_private_key','lng'),
	    // 支付成功通知地址
	    'notify_url'  => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.alipay_notify_url','lng'),
	    // 网页支付回跳地址
	    'return_url'  => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.alipay_return_url','lng'),
	];
	
	$wxpay_config = [
	    'token'          => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_token','lng'),
	    'appid'          => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_appid','lng'),
	    'appsecret'      => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_appsecret','lng'),
	    'encodingaeskey' => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_encodingaeskey','lng'),
	    // 配置商户支付参数（可选，在使用支付功能时需要）
	    'mch_id'         => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_mch_id','lng'),
	    'mch_key'        => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_mch_key','lng'),
	    // 配置商户支付双向证书目录（可选，在使用退款|打款|红包时需要）
	    'ssl_key'        => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_ssl_key','lng'),
	    'ssl_cer'        => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_ssl_cer','lng'),
	    // 缓存目录配置（可选，需拥有读写权限）
	    'cache_path'     => ii_itake('global.' . ADMIN_FOLDER . '/global:extend.wxpay_cache_path','lng'),
	];
	switch($type){
	    default:
	    case 'alipay':
	    return $alipay_config;
	    break;
	    case 'wxpay':
	    return $wxpay_config;
	    break;
	}
}
function alipay($out_trade_no,$subject,$total_amount,$body){
	$config = allpay_config('alipay');
	
	try {
	    
	    // 实例支付对象
	    if (ii_isMobileAgent()) $pay = We::AliPayWap($config);
	    else $pay = We::AliPayWeb($config);
	    // $pay = new \AliPay\Web($config);
	    
	    // 参考链接：https://docs.open.alipay.com/api_1/alipay.trade.page.pay
	    //$torderid,$tid,$tprice,$tid,$methodname
	    $result = $pay->apply([
	        'out_trade_no' => $out_trade_no, // 商户订单号
	        'total_amount' => $total_amount,    // 支付金额
	        'subject'      => $body, // 支付订单描述
	    ]);
	    
	    return $result; // 直接输出HTML（提交表单跳转)
	    
	} catch (Exception $e) {
	
	    // 异常处理
	    echo $e->getMessage();
	    
	}

}


function alipay_notify(){
	$config = allpay_config('alipay');
	$bool = false;
	try {
	    // 实例支付对象
	    // $pay = \We::AliPayApp($config);
	    // $pay = new \AliPay\App($config);
	    $pay = We::AliPayApp($config);;
	
	    $data = $pay->notify();
	    if (in_array($data['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
	        // @todo 更新订单状态，支付完成
        	$bool = true;
	        //file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
	        //file_put_contents('notify.txt', '订单号：' . $data['out_trade_no'] . "\r\n", FILE_APPEND);
	        //file_put_contents('notify.txt', '订单金额：' . $data['total_amount'] . "\r\n\r\n", FILE_APPEND);
	    } else {
        	$bool = false;
	        //file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
	    }
	} catch (Exception $e) {
	    // 异常处理
     	$bool = false;
	    //echo $e->getMessage();
	}
	return $bool;
}

function alipay_return(){
	$config = allpay_config('alipay');
	$bool = false;
	try {
	    // 实例支付对象
	    // $pay = \We::AliPayApp($config);
	    // $pay = new \AliPay\App($config);
	    $pay = We::AliPayApp($config);;
	
	    $data = $pay->return();
	    if (in_array($data['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
	        // @todo 更新订单状态，支付完成
        	$bool = true;
	        //file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
	        //file_put_contents('notify.txt', '订单号：' . $data['out_trade_no'] . "\r\n", FILE_APPEND);
	        //file_put_contents('notify.txt', '订单金额：' . $data['total_amount'] . "\r\n\r\n", FILE_APPEND);
	    } else {
        	$bool = false;
	        //file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
	    }
	} catch (Exception $e) {
	    // 异常处理
     	$bool = false;
	    //echo $e->getMessage();
	}
	return $bool;
}

function wxpay($out_trade_no,$subject,$total_amount,$body){
	$config = allpay_config('wxpay');
		
	$wechat = new \WeChat\Pay($config);
	  
	  // 组装参数，可以参考官方商户文档
	  $options = [
	      'body'             => $body,
	      'out_trade_no'     => $out_trade_no,
	      'total_fee'        => $total_amount,
	      'openid'           => 'o38gpszoJoC9oJYz3UHHf6bEp0Lo',
	      'trade_type'       => 'JSAPI',
	      'notify_url'       => 'http://www.domain.com/user/wxpay_notify.php',
	      'spbill_create_ip' => '127.0.0.1',
	  ];
	    
	try {
	
	    // 生成预支付码
	    $result = $wechat->createOrder($options);
	    
	    // 创建JSAPI参数签名
	    $options = $wechat->createParamsForJsApi($result['prepay_id']);
	    
	    // @todo 把 $options 传到前端用js发起支付就可以了
	    
	} catch (Exception $e) {
	
	    // 出错啦，处理下吧
	    echo $e->getMessage() . PHP_EOL;
	    
	}

}

function wxpay_notify(){
	$config = allpay_config('wxpay');
     	$bool = false;
	try {
	
	    // 3. 创建接口实例
	     $wechat = new \WeChat\Pay($config);
	    // $wechat = \We::WeChatPay($config);
	    //$wechat = \WeChat\Pay::instance($config);
	
	    // 4. 获取通知参数
	    $data = $wechat->getNotify();
	    if ($data['return_code'] === 'SUCCESS' && $data['result_code'] === 'SUCCESS') {
	        // @todo 去更新下原订单的支付状态
	     	$bool = true;
	        //$order_no = $data['out_trade_no'];
	
	        // 返回接收成功的回复
	        //ob_clean();
	        //echo $wechat->getNotifySuccessReply();
	    }
	
	} catch (Exception $e) {
	
	    // 出错啦，处理下吧
	     	$bool = false;
	    //echo $e->getMessage() . PHP_EOL;
	
	}
	return $bool;
}
