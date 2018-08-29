您可以通过以下步骤完成:

1.登录PHPMYADMIN管理界面并打开一个数据库
2.点SQL并将_mysql/_mysql.sql中的内容复制到输入框后点击执行
3.配置网站中的common/incfiles/const.inc.php文件，并依次配置下列参数：
  3.1.$db_host = '127.0.0.1'; //数据库主机地址 
  3.2.$db_username = ''; //用户名
  3.3.$db_password = ''; //密码
  3.4.$db_database = ''; //数据库名称
  
  默认帐号:admin
  默认密码:admin