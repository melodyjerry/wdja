<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091200496803",
		//商户私钥
		'merchant_private_key' => "MIIEpQIBAAKCAQEAw/c72XWdpeLQ7I5Wa6noF8RVwPRgNAf2CzsmkAz4cs/W+ifPGC2ayRgI+m7FnofYqi+BH+OeOL1oMU1GC7d+5oN02LREaDUixVXTeF8n53MgdsKY8HX5wb4nwasI3oZz/P+vTqeCCbpAXldt2AJzmLFk8PJ8RZfrIz4V6ZgZ5XL7qfGfZvytJRf9f5jNwf9Vuy/Y7C1aSasofqXMsjK0ZI2HBz2cp39C9CJm8QuGEQnX1WLm1IDZYYRCP3KUhpRxSfOl7np3aCiUTh0k0x0YhquZ6to0Mm+zT9FBhOjTd+kfiKefBZGLSEvq/TzTNYjYasuZ1rXPm8dDjzzAh3g3DQIDAQABAoIBAQCdPYIOaSuH8clGJqf9V6XdfDJ60xtmZITuWhYFPAMWzOJocwzfD6jFdr2thLiZDdOyKs/nMJLCYGh8Ns7fk+sFN7HIOE0zeH9f7A/05BV2x4/i+x4Qw/kVlmj8IyrIswXamaam7A2RlJsVl/2Rd9YdTSn7k/ZXOSD5dFXMy7jru8EW/FS1ffXt5SYRwHVIOAbtawPKMjCugMZ5bwf95zD6XkPYMMp7/aRumgiYg9PQzmLppDNl9OMsp9YuBm9MMUKn3xMN7lyn/n8zqjDLLV2hguRsba+1yGjZ2gKp7BgJwr6DjoBYw+qaPcvZ3HCA57mdHe0vVYztxof4K4+rbBiZAoGBAPAhK6znraJymqa1CzEMjUKui7UlXE7a0WxbUNVKrfFwn+aO6buivisTpkCZjPmus/0D7Hr246+TqfLLoGfS09kMXM81ZKH14/Dyzj/0pIKvZ0LmbrA7MbAVGcr/MgtTP4VV1pEfGdbtEzELkudzo83+YRrKbgCfwBdjQZ6O6ipfAoGBANDq12V8RIn7d/l0ElWKubqdtttmW5v6CRQTki6idQrqvaAMlMnaDzTj6PBXQjNK7ZG3ie2X11y31/C6M+IMxRG+6OmRXQ2LwyDFV0Pe1xpIAyUkDZjh2chfEXvHwyM1cb47SEmAIuw5JGLw36oMpl/gRaR1fSI5ei42iZ3Nxi4TAoGBANIf9JwEz4gLSRD/858kIKhtHIuS+cd26zMqZP1/r95Kc2HJRPaQXmBLfXuh4h7KpW2N9W1UhcCqMljnnqG7du3DR6N6UWj4RlId5iVI6nwBCRcdlVZZNg2jKULdNOl8G2WNy4iJ8o6EPfr46b/nDTvAkTBkWwXoxKqyjEU3Qel5AoGBAJLrE98CrRB8D7sVrW8Kx+I810MjkHj4NToxKTQyeyzaN9A+CMSK3PbM8BtUwfFgWAGJmS3FAmbpwqo/yAzH/i6kmxbmaxIDn42EOgI4y/xneA6+c/F3orgOYzUxHkG8a+jjt8o4mlaVOMl7q07i5n22MkOdfAp9cTbek5iuBRiRAoGAQZUOmywiAj3qi+SDQjtyqP2TCWoxD44wJg06YvVQFmqSzfUOWJDIVT4kzfAv/1RGSuY535Rs/QhDQzHjra5yotMFa0Vh+bJewpJy1RnzyMywnHG1/lbRtzAWDaQeVM1Ii/21tY/44yqcGEaSWGs9OHUN2ZcQYSjfEw8JrVrTNN8=",
		//异步通知地址
		'notify_url' => "http://demo.wdja.net/user/alipay_notify.php",
		
		//同步跳转
		'return_url' => "http://demo.wdja.net/user/alipay_return.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关https://openapi.alipay.com/gateway.do
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqSZkm93kc33ODZKVWqm/NTt7pzGgSFSe+KmKabdsxZFyHUst/kQSh8evLRegF1xSyhNwiM13Ci9ZlmECQEBppZcS8MyHhIVBOrD00P8/Y/2tRTpuw2KjsLoSWQwIMkBYRGJRovsBwJSVihAlhj2BTvbYzs8gj0jyHwqR4c369rSw3oflr+gFrKEozm5kNJzdau0rXZsfGyCvNcscopHMX9oh4xaapeXKrTprVt0ZGt6R/86T2iSCaqu54i6urtU3PYj65jSuBIMWzH4CHaGe/nfwckK6qIzOUM0/sDQ6ArKn2mwnSPMc9QE96m4O7BqT+USBxJmUGvH8PfZ2ZqTY2wIDAQAB",
);
define('CONFIG', $config);