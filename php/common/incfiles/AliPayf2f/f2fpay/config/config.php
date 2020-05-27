<?php
$config = array (
		//签名方式,默认为RSA2(RSA2048)
		'sign_type' => "RSA2",

		//支付宝公钥
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhrNgTHWeDjTM/ZM2Ump5UMXRqEggbncPJ9Mb6L3Jw2366hg2Kh0sUQh6GLPXH4Bl6YJRGorJVmyz+2hzY3VT8Agr85MhaC4MAyXdRDXi/nntBXOK/joDv6WYVOL/lN/XzAN+8Bj3li1HdNoyfK19o389hX9nFDIPMp3RFrmMV1WZ1zBkvS7qLYEljLrZc+CZoZYL0HXTuYzdrpBmz5MMtbmg+EY6GLQzNoAQFeWWnsTfa35w1nbDDzm3/rwFyHwpIHS25q9y6fc5s8TROH2lFOBuisqKLj12iZZt5cbgLsmjfI5aBkbBx0tEdbIOWrXcl+5yz9AZ4opOB6hSBMYVNwIDAQAB",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEA3idGuND++BTvWktuognCgRX5lb6SI48LPnqgkRub9n4nbY9dQBSmW+pT57W6XaLYPDkvDRBLhjrPFBT+heX1EhR4tIQQoUBjU+Vmj7yykYlxTmewH8aTLN2yqq+omdKxr9Ay39LcUev9OrF9u2guIJ+RTa+aJGI7ZctoQEIjW+oX5GAQU9skNo79yay9R2fOjjVeRSsu3Vdqo1D0XsY/digWIYxiw98Kqjtbi+u4XB+/dWbAZG2JhxpzrToh2ZB8geFdeAm4kFPyv9Jr4bKTVJ+VGn9oUtGmTZmF6VHaUUkbqYmQ8UmXH+in7i9/GJdDrC3MVKs9SYDLchThJgK68wIDAQABAoIBABIXTroUQv8+7TMEO5E0jENo37djGpGMv5Sp9dN7VRsgsONKLoTeaaHIlmajNPcVINjeq0c8EXpv5Zc0Enoi/O8o/Z9ttdD75lrZrp1792rEr5Z7+SrNSAT6VOdzgJ5uOwwfP1Vc3ZZKSofyFlQhqsf7VqDl8P6PhVjH1MiO2kRMyB9lKLpPg+41ana/ALhMLgaeBFMJ9IQrweluJviuG7WLyIThdvB+yfsbSCWYer+0Kzr6b/Qs67oFUl5+2wgXAb2WjmM2oDDwBYtwkFBZtVZ3PxPTMPolBBegsX8SHNIRHPg7jRZix9FjGdzuu+5y0LIkZsF60LErZ3qg5y55jkkCgYEA+JIGwh9BWn2FzTJeJoBeVtoFXhm4tHUsYV59An7BJVKW1/a55dYYvk97fxT7NRNLVJKNXmoR2RAlhUua/hGyezmXk2CsUsOEuig5971H+2rmLxZkQN2DDHQnbkr9qi8ch6CMhJyHixy/7aquR+HjrneY/aRYsaLJIzBSEipjB88CgYEA5MsdxcPFSFItkIRu/gk8fS6MoLZxNFIvoxcQdb6VRbWmupwfAQgrY9C8WPHlm5hQp7/NGz7D4N2/beLuEXW+7jX/ojGaJwg6+tYjqnHuFgKLCUrYM6AwnDeE7/YIBYe5N0AT3XhnYSVQxJ96EzrKdMgfiGw613CbIjxGP021P50CgYBtaWFeKwHKQfwWQThd/B0KX7cDH5FEpVrelQezhHWh5wOMlgZnm2CSzEuQuXyFdTOwSz28tDWc9NV/IbNcaA/G26fTcDcJyxPuGOzDFmbLzNb7HQEN6DLZ1XrRumKDeW82Z73SVU/4NLRqebly3IQqdGw8IQ4FSqD8QzWs10l10wKBgBpvLV1wJRcaB5Gu+3P2dTqxaiYXbjTxWfep7ojsICsRtdXRu/NOklTSBTDxoem8S3VWP8hqFA+jDz8O/RqfVBQJwSNoP7tKxCW/IBfNWgjI+m90ak5sr7Ec6QsgjgS1jbzIdoMcKjWbLh3Jnz0hicq8ZIhKmPHTXNkzxZoCzHIxAoGBAMNwWkJ6mfYkK+y9enzXXgnm5y1aJreY1ogSG5x3gAYCb9QigZO1/PUgPG+K0Y8bkVx3zFswxQYd3tE0QHmnybgHvbdFz9EcO1kMbFS+7Rl+BvO8TTE/diC/PTDXWAfZyi8jItYGhMFzt/Hk5uqW5rehb5G0rvPDP1QkgTZx1i+r",

		//编码格式
		'charset' => "UTF-8",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//应用ID
		'app_id' => "2019062065624606",

		//异步通知地址,只有扫码支付预下单可用
		'notify_url' => "https://www.wdja.cn/",

		//最大查询重试次数
		'MaxQueryRetry' => "10",

		//查询间隔
		'QueryDuration' => "3"
);