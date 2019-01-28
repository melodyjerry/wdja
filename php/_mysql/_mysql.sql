
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `wdja_aboutus`
--

DROP TABLE IF EXISTS `wdja_aboutus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_aboutus` (
  `abid` int(9) NOT NULL AUTO_INCREMENT,
  `ab_topic` varchar(50) DEFAULT NULL,
  `ab_keywords` varchar(152) DEFAULT NULL,
  `ab_description` varchar(252) DEFAULT NULL,
  `ab_image` varchar(255) DEFAULT NULL,
  `ab_content` text,
  `ab_content_images_list` text,
  `ab_cttype` int(1) DEFAULT '0',
  `ab_cp_note` int(1) DEFAULT '0',
  `ab_cp_mode` int(1) DEFAULT '0',
  `ab_cp_type` int(1) DEFAULT '0',
  `ab_cp_num` int(9) DEFAULT '0',
  `ab_time` datetime DEFAULT NULL,
  `ab_hidden` int(1) DEFAULT '0',
  `ab_update` int(1) DEFAULT '0',
  `ab_good` int(1) DEFAULT '0',
  `ab_count` int(9) DEFAULT '0',
  `ab_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`abid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_admin`
--

DROP TABLE IF EXISTS `wdja_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_admin` (
  `aid` int(9) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(50) DEFAULT NULL,
  `a_pword` varchar(50) DEFAULT NULL,
  `a_popedom` varchar(255) DEFAULT NULL,
  `a_lock` int(1) DEFAULT '0',
  `a_lasttime` datetime DEFAULT NULL,
  `a_lastip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wdja_admin`
--

LOCK TABLES `wdja_admin` WRITE;
/*!40000 ALTER TABLE `wdja_admin` DISABLE KEYS */;
INSERT INTO `wdja_admin` VALUES (1,'admin','926b4f1d65e19d81680d8f2b7449e627','-1',0,'2019-01-28 10:47:04','116.25.135.91');
/*!40000 ALTER TABLE `wdja_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wdja_admin_log`
--

DROP TABLE IF EXISTS `wdja_admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_admin_log` (
  `lid` int(9) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(50) DEFAULT NULL,
  `l_time` datetime DEFAULT NULL,
  `l_ip` varchar(50) DEFAULT NULL,
  `l_islogin` int(1) DEFAULT '0',
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_article`
--

DROP TABLE IF EXISTS `wdja_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_article` (
  `aid` int(9) NOT NULL AUTO_INCREMENT,
  `a_topic` varchar(50) DEFAULT NULL,
  `a_keywords` varchar(152) DEFAULT NULL,
  `a_description` varchar(252) DEFAULT NULL,
  `a_image` varchar(255) DEFAULT NULL,
  `a_content` text,
  `a_content_images_list` text,
  `a_cttype` int(1) DEFAULT '0',
  `a_cp_note` int(1) DEFAULT '0',
  `a_cp_mode` int(1) DEFAULT '0',
  `a_cp_type` int(1) DEFAULT '0',
  `a_cp_num` int(9) DEFAULT '0',
  `a_time` datetime DEFAULT NULL,
  `a_cls` text,
  `a_class` int(9) DEFAULT '0',
  `a_hidden` int(1) DEFAULT '0',
  `a_update` int(1) DEFAULT '0',
  `a_good` int(1) DEFAULT '0',
  `a_count` int(9) DEFAULT '0',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_download`
--

DROP TABLE IF EXISTS `wdja_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_download` (
  `did` int(9) NOT NULL AUTO_INCREMENT,
  `d_topic` varchar(50) DEFAULT NULL,
  `d_keywords` varchar(152) DEFAULT NULL,
  `d_description` varchar(252) DEFAULT NULL,
  `d_cls` text,
  `d_class` int(9) DEFAULT '0',
  `d_scont` text,
  `d_image` varchar(255) DEFAULT NULL,
  `d_cttype` int(1) DEFAULT '0',
  `d_content` text,
  `d_content_images_list` text,
  `d_size` float DEFAULT '0',
  `d_runco` varchar(255) DEFAULT NULL,
  `d_star` int(9) DEFAULT '0',
  `d_accredit` int(9) DEFAULT '0',
  `d_lng` int(9) DEFAULT '0',
  `d_link` varchar(255) DEFAULT NULL,
  `d_author` varchar(255) DEFAULT NULL,
  `d_urls` text,
  `d_hidden` int(1) DEFAULT '0',
  `d_good` int(1) DEFAULT '0',
  `d_time` datetime DEFAULT NULL,
  `d_count` int(9) DEFAULT '0',
  `d_update` int(1) DEFAULT '0',
  PRIMARY KEY (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_expansion_js`
--

DROP TABLE IF EXISTS `wdja_expansion_js`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_expansion_js` (
  `jid` int(9) NOT NULL AUTO_INCREMENT,
  `j_topic` varchar(50) DEFAULT NULL,
  `j_content` text,
  `j_retimetype` int(1) DEFAULT '0',
  `j_retimevalue` int(9) DEFAULT '0',
  `j_retime` datetime DEFAULT NULL,
  `j_time` datetime DEFAULT NULL,
  PRIMARY KEY (`jid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_forum_blacklist`
--

DROP TABLE IF EXISTS `wdja_forum_blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_forum_blacklist` (
  `bid` int(9) NOT NULL AUTO_INCREMENT,
  `b_username` varchar(50) DEFAULT NULL,
  `b_sid` int(9) DEFAULT '0',
  `b_admin` varchar(50) DEFAULT NULL,
  `b_time` datetime DEFAULT NULL,
  `b_remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_forum_sort`
--

DROP TABLE IF EXISTS `wdja_forum_sort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_forum_sort` (
  `sid` int(9) NOT NULL AUTO_INCREMENT,
  `s_sort` varchar(50) DEFAULT NULL,
  `s_fid` varchar(255) DEFAULT NULL,
  `s_fsid` int(9) DEFAULT '0',
  `s_lng` varchar(50) DEFAULT NULL,
  `s_order` int(9) DEFAULT '0',
  `s_type` int(9) DEFAULT '0',
  `s_mode` int(9) DEFAULT '0',
  `s_ispop` int(9) DEFAULT '0',
  `s_popedom` varchar(50) DEFAULT NULL,
  `s_images` varchar(255) DEFAULT NULL,
  `s_admin` varchar(255) DEFAULT NULL,
  `s_rule` varchar(255) DEFAULT NULL,
  `s_explain` varchar(255) DEFAULT NULL,
  `s_attestation` varchar(255) DEFAULT NULL,
  `s_hidden` int(1) DEFAULT '0',
  `s_ntopic` int(9) DEFAULT '0',
  `s_nnote` int(9) DEFAULT '0',
  `s_today_ntopic` int(9) DEFAULT '0',
  `s_today_date` datetime DEFAULT NULL,
  `s_last_topic` varchar(50) DEFAULT NULL,
  `s_last_tid` int(9) DEFAULT '0',
  `s_last_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_forum_topic`
--

DROP TABLE IF EXISTS `wdja_forum_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_forum_topic` (
  `tid` int(9) NOT NULL AUTO_INCREMENT,
  `t_sid` int(9) DEFAULT '0',
  `t_fid` int(9) DEFAULT '0',
  `t_icon` int(9) DEFAULT '0',
  `t_topic` varchar(50) DEFAULT NULL,
  `t_color` varchar(50) DEFAULT NULL,
  `t_b` int(1) DEFAULT '0',
  `t_author` varchar(50) DEFAULT NULL,
  `t_authorip` varchar(50) DEFAULT NULL,
  `t_content` text,
  `t_content_files_list` text,
  `t_voteid` int(9) DEFAULT '0',
  `t_ubb` int(1) DEFAULT '0',
  `t_reply` int(9) DEFAULT '0',
  `t_count` int(9) DEFAULT '0',
  `t_time` datetime DEFAULT NULL,
  `t_htop` int(1) DEFAULT '0',
  `t_top` int(1) DEFAULT '0',
  `t_lock` int(1) DEFAULT '0',
  `t_elite` int(1) DEFAULT '0',
  `t_hidden` int(1) DEFAULT '0',
  `t_lasttime` datetime DEFAULT NULL,
  `t_lastuser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_forum_vote`
--

DROP TABLE IF EXISTS `wdja_forum_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_forum_vote` (
  `vid` int(9) NOT NULL AUTO_INCREMENT,
  `v_topic` varchar(50) DEFAULT NULL,
  `v_type` int(9) DEFAULT '0',
  `v_time` datetime DEFAULT NULL,
  `v_day` int(9) DEFAULT '0',
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_forum_vote_data`
--

DROP TABLE IF EXISTS `wdja_forum_vote_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_forum_vote_data` (
  `vdid` int(9) NOT NULL AUTO_INCREMENT,
  `vd_topic` varchar(50) DEFAULT NULL,
  `vd_fid` int(9) DEFAULT '0',
  `vd_vid` int(9) DEFAULT '0',
  `vd_count` int(9) DEFAULT '0',
  PRIMARY KEY (`vdid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_forum_vote_voter`
--

DROP TABLE IF EXISTS `wdja_forum_vote_voter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_forum_vote_voter` (
  `vuid` int(9) NOT NULL AUTO_INCREMENT,
  `vu_fid` int(9) DEFAULT '0',
  `vu_ip` varchar(50) DEFAULT NULL,
  `vu_username` varchar(50) DEFAULT NULL,
  `vu_data` varchar(255) DEFAULT NULL,
  `vu_time` datetime DEFAULT NULL,
  PRIMARY KEY (`vuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_help`
--

DROP TABLE IF EXISTS `wdja_help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_help` (
  `hid` int(9) NOT NULL AUTO_INCREMENT,
  `h_topic` varchar(50) DEFAULT NULL,
  `h_keywords` varchar(50) DEFAULT NULL,
  `h_description` varchar(250) DEFAULT NULL,
  `h_image` varchar(255) DEFAULT NULL,
  `h_content` text,
  `h_content_images_list` text,
  `h_cttype` int(1) DEFAULT '0',
  `h_cp_note` int(1) DEFAULT '0',
  `h_cp_mode` int(1) DEFAULT '0',
  `h_cp_type` int(1) DEFAULT '0',
  `h_cp_num` int(9) DEFAULT '0',
  `h_time` datetime DEFAULT NULL,
  `h_cls` text,
  `h_class` int(9) DEFAULT '0',
  `h_top` int(1) DEFAULT '0',
  `h_hidden` int(1) DEFAULT '0',
  `h_update` int(1) DEFAULT '0',
  `h_good` int(1) DEFAULT '0',
  `h_count` int(9) DEFAULT '0',
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_news`
--

DROP TABLE IF EXISTS `wdja_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_news` (
  `nid` int(9) NOT NULL AUTO_INCREMENT,
  `n_topic` varchar(50) DEFAULT NULL,
  `n_keywords` varchar(152) DEFAULT NULL,
  `n_description` varchar(252) DEFAULT NULL,
  `n_image` varchar(255) DEFAULT NULL,
  `n_content` text,
  `n_content_images_list` text,
  `n_cttype` int(1) DEFAULT '0',
  `n_cp_note` int(1) DEFAULT '0',
  `n_cp_mode` int(1) DEFAULT '0',
  `n_cp_type` int(1) DEFAULT '0',
  `n_cp_num` int(9) DEFAULT '0',
  `n_time` datetime DEFAULT NULL,
  `n_cls` text,
  `n_class` int(9) DEFAULT '0',
  `n_hidden` int(1) DEFAULT '0',
  `n_update` int(1) DEFAULT '0',
  `n_good` int(1) DEFAULT '0',
  `n_count` int(9) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_passport`
--

DROP TABLE IF EXISTS `wdja_passport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_passport` (
  `pid` int(9) NOT NULL AUTO_INCREMENT,
  `p_username` varchar(50) DEFAULT NULL,
  `p_password` varchar(50) DEFAULT NULL,
  `p_email` varchar(50) DEFAULT NULL,
  `p_city` varchar(50) DEFAULT NULL,
  `p_sex` varchar(50) DEFAULT NULL,
  `p_old` varchar(50) DEFAULT NULL,
  `p_name` varchar(50) DEFAULT NULL,
  `p_qq` varchar(50) DEFAULT NULL,
  `p_msn` varchar(50) DEFAULT NULL,
  `p_phone` varchar(50) DEFAULT NULL,
  `p_homepage` varchar(255) DEFAULT NULL,
  `p_code` varchar(50) DEFAULT NULL,
  `p_address` varchar(255) DEFAULT NULL,
  `p_emoney` int(9) DEFAULT '0',
  `p_integral` int(9) DEFAULT '0',
  `p_topic` int(9) DEFAULT '0',
  `p_face` int(9) DEFAULT '0',
  `p_face_u` int(1) DEFAULT '0',
  `p_face_url` varchar(255) DEFAULT NULL,
  `p_face_width` int(9) DEFAULT '0',
  `p_face_height` int(9) DEFAULT '0',
  `p_sign` varchar(255) DEFAULT NULL,
  `p_forum_admin` int(1) DEFAULT '0',
  `p_utype` int(9) DEFAULT '0',
  `p_lock` int(1) DEFAULT '0',
  `p_time` datetime DEFAULT NULL,
  `p_lasttime` datetime DEFAULT NULL,
  `p_pretime` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_passport_address`
--

DROP TABLE IF EXISTS `wdja_passport_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_passport_address` (
  `addressid` int(9) NOT NULL AUTO_INCREMENT,
  `address_name` varchar(50) DEFAULT NULL,
  `address_address` varchar(255) DEFAULT NULL,
  `address_code` varchar(50) DEFAULT NULL,
  `address_phone` varchar(50) DEFAULT NULL,
  `address_email` varchar(50) DEFAULT NULL,
  `address_username` varchar(50) DEFAULT NULL,
  `address_lng` varchar(50) DEFAULT NULL,
  `address_order` int(9) DEFAULT '0',
  `address_time` datetime DEFAULT NULL,
  PRIMARY KEY (`addressid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_passport_friend`
--

DROP TABLE IF EXISTS `wdja_passport_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_passport_friend` (
  `feid` int(9) NOT NULL AUTO_INCREMENT,
  `fe_username` varchar(50) DEFAULT NULL,
  `fe_name` varchar(50) DEFAULT NULL,
  `fe_time` datetime DEFAULT NULL,
  PRIMARY KEY (`feid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_passport_message`
--

DROP TABLE IF EXISTS `wdja_passport_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_passport_message` (
  `mid` int(9) NOT NULL AUTO_INCREMENT,
  `m_topic` varchar(50) DEFAULT NULL,
  `m_content` text,
  `m_read` int(1) DEFAULT '0',
  `m_time` datetime DEFAULT NULL,
  `m_len` int(9) DEFAULT '0',
  `m_addresser` varchar(50) DEFAULT NULL,
  `m_recipients` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_product`
--

DROP TABLE IF EXISTS `wdja_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_product` (
  `pid` int(9) NOT NULL AUTO_INCREMENT,
  `p_snum` varchar(50) DEFAULT NULL,
  `p_topic` varchar(50) DEFAULT NULL,
  `p_keywords` varchar(152) DEFAULT NULL,
  `p_description` varchar(252) DEFAULT NULL,
  `p_image` varchar(255) DEFAULT NULL,
  `p_content` text,
  `p_content_images_list` text,
  `p_cttype` int(1) DEFAULT '0',
  `p_time` datetime DEFAULT NULL,
  `p_cls` text,
  `p_class` int(9) DEFAULT '0',
  `p_hidden` int(1) DEFAULT '0',
  `p_update` int(1) DEFAULT '0',
  `p_good` int(1) DEFAULT '0',
  `p_count` int(9) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_shop`
--

DROP TABLE IF EXISTS `wdja_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_shop` (
  `sid` int(9) NOT NULL AUTO_INCREMENT,
  `s_snum` varchar(50) DEFAULT NULL,
  `s_topic` varchar(50) DEFAULT NULL,
  `s_keywords` varchar(152) DEFAULT NULL,
  `s_description` varchar(252) DEFAULT NULL,
  `s_image` varchar(255) DEFAULT NULL,
  `s_price` float DEFAULT '0',
  `s_wprice` float DEFAULT '0',
  `s_limitnum` int(9) DEFAULT '0',
  `s_unit` varchar(50) DEFAULT NULL,
  `s_content` text,
  `s_content_images_list` text,
  `s_cttype` int(1) DEFAULT '0',
  `s_time` datetime DEFAULT NULL,
  `s_cls` text,
  `s_class` int(9) DEFAULT '0',
  `s_hidden` int(1) DEFAULT '0',
  `s_update` int(1) DEFAULT '0',
  `s_good` int(1) DEFAULT '0',
  `s_count` int(9) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_shopcart`
--

DROP TABLE IF EXISTS `wdja_shopcart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_shopcart` (
  `scid` int(9) NOT NULL AUTO_INCREMENT,
  `sc_fid` text,
  `sc_allprice` float DEFAULT '0',
  `sc_merchandiseprice` float DEFAULT '0',
  `sc_trafficprice` float DEFAULT '0',
  `sc_name` varchar(50) DEFAULT NULL,
  `sc_address` varchar(255) DEFAULT NULL,
  `sc_code` varchar(50) DEFAULT NULL,
  `sc_phone` varchar(50) DEFAULT NULL,
  `sc_email` varchar(50) DEFAULT NULL,
  `sc_remark` text,
  `sc_payment` int(9) DEFAULT '0',
  `sc_traffic` int(9) DEFAULT '0',
  `sc_orderid` varchar(50) DEFAULT NULL,
  `sc_prepaid` int(20) DEFAULT '0',
  `sc_payid` varchar(50) DEFAULT NULL,
  `sc_state` int(1) DEFAULT '0',
  `sc_express` int(1) DEFAULT '0',
  `sc_expressid` varchar(30) DEFAULT '0 ',
  `sc_time` datetime DEFAULT NULL,
  `sc_dtime` datetime DEFAULT NULL,
  `sc_username` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`scid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_support_gbook`
--

DROP TABLE IF EXISTS `wdja_support_gbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_gbook` (
  `gid` int(9) NOT NULL AUTO_INCREMENT,
  `g_author` varchar(50) DEFAULT NULL,
  `g_authorip` varchar(50) DEFAULT NULL,
  `g_sex` int(1) DEFAULT '0',
  `g_qq` int(12) DEFAULT '0',
  `g_face` int(9) DEFAULT '0',
  `g_email` varchar(50) DEFAULT NULL,
  `g_homepage` varchar(255) DEFAULT NULL,
  `g_topic` varchar(50) DEFAULT NULL,
  `g_content` text,
  `g_time` datetime DEFAULT NULL,
  `g_reply` text,
  `g_replytime` datetime DEFAULT NULL,
  `g_hidden` int(1) DEFAULT '0',
  `g_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_support_linktext`
--

DROP TABLE IF EXISTS `wdja_support_linktext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_linktext` (
  `lid` int(9) NOT NULL AUTO_INCREMENT,
  `l_topic` varchar(50) DEFAULT NULL,
  `l_url` varchar(255) DEFAULT NULL,
  `l_keyword` varchar(50) DEFAULT NULL,
  `l_intro` varchar(255) DEFAULT NULL,
  `l_time` datetime DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_support_review`
--

DROP TABLE IF EXISTS `wdja_support_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_review` (
  `rid` int(9) NOT NULL AUTO_INCREMENT,
  `r_author` varchar(50) DEFAULT NULL,
  `r_authorip` varchar(50) DEFAULT NULL,
  `r_content` text,
  `r_time` datetime DEFAULT NULL,
  `r_keyword` varchar(50) DEFAULT NULL,
  `r_fid` int(9) DEFAULT '0',
  `r_hidden` int(1) DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_support_shorturl`
--

DROP TABLE IF EXISTS `wdja_support_shorturl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_shorturl` (
  `sid` int(9) NOT NULL AUTO_INCREMENT,
  `s_topic` varchar(50) DEFAULT NULL,
  `s_url` varchar(255) DEFAULT NULL,
  `s_code` varchar(50) DEFAULT NULL,
  `s_count` int(11) NOT NULL DEFAULT '0',
  `s_intro` varchar(255) DEFAULT NULL,
  `s_ip` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  `s_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`),
  KEY `s_code` (`s_code`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `wdja_support_slide`
--

DROP TABLE IF EXISTS `wdja_support_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_slide` (
  `sid` int(9) NOT NULL AUTO_INCREMENT,
  `s_topic` varchar(50) DEFAULT NULL,
  `s_url` varchar(255) DEFAULT NULL,
  `s_lng` varchar(50) DEFAULT NULL,
  `s_image` varchar(255) DEFAULT NULL,
  `s_intro` varchar(255) DEFAULT NULL,
  `s_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_support_vote`
--

DROP TABLE IF EXISTS `wdja_support_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_vote` (
  `vid` int(9) NOT NULL AUTO_INCREMENT,
  `v_topic` varchar(50) DEFAULT NULL,
  `v_type` int(1) DEFAULT '0',
  `v_count` varchar(9) DEFAULT '0',
  `v_starttime` datetime DEFAULT NULL,
  `v_endtime` datetime DEFAULT NULL,
  `v_lock` int(1) DEFAULT '0',
  `v_time` datetime DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_support_vote_data`
--

DROP TABLE IF EXISTS `wdja_support_vote_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_vote_data` (
  `vdid` int(9) NOT NULL AUTO_INCREMENT,
  `vd_topic` varchar(50) DEFAULT NULL,
  `vd_fid` int(9) DEFAULT '0',
  `vd_vid` int(9) DEFAULT '0',
  `vd_count` int(9) DEFAULT '0',
  PRIMARY KEY (`vdid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_support_vote_voter`
--

DROP TABLE IF EXISTS `wdja_support_vote_voter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_support_vote_voter` (
  `vuid` int(9) NOT NULL AUTO_INCREMENT,
  `vu_fid` int(9) DEFAULT '0',
  `vu_ip` varchar(50) DEFAULT NULL,
  `vu_username` varchar(50) DEFAULT NULL,
  `vu_data` varchar(255) DEFAULT NULL,
  `vu_time` datetime DEFAULT NULL,
  PRIMARY KEY (`vuid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_sys_sort`
--

DROP TABLE IF EXISTS `wdja_sys_sort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_sys_sort` (
  `sortid` int(9) NOT NULL AUTO_INCREMENT,
  `sort_pid` int(9) NOT NULL DEFAULT '0',
  `sort_sort` varchar(50) DEFAULT NULL,
  `sort_keywords` varchar(50) DEFAULT NULL,
  `sort_description` varchar(250) DEFAULT NULL,
  `sort_image` varchar(255) DEFAULT NULL,
  `sort_fid` varchar(255) DEFAULT NULL,
  `sort_fsid` int(9) DEFAULT '0',
  `sort_lid` int(9) DEFAULT '0',
  `sort_genre` varchar(50) DEFAULT NULL,
  `sort_lng` varchar(50) DEFAULT NULL,
  `sort_hidden` int(1) DEFAULT '0',
  `sort_order` int(9) DEFAULT '0',
  `sort_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sortid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_sys_upload`
--

DROP TABLE IF EXISTS `wdja_sys_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_sys_upload` (
  `upid` int(9) NOT NULL AUTO_INCREMENT,
  `up_genre` varchar(50) DEFAULT NULL,
  `up_upident` varchar(50) DEFAULT NULL,
  `up_filename` varchar(255) DEFAULT NULL,
  `up_field` varchar(50) DEFAULT NULL,
  `up_fid` int(9) DEFAULT '0',
  `up_time` datetime DEFAULT NULL,
  `up_user` varchar(50) DEFAULT NULL,
  `up_valid` int(1) DEFAULT '0',
  `up_voidreason` int(1) DEFAULT '0',
  PRIMARY KEY (`upid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_wechat_gbook`
--

DROP TABLE IF EXISTS `wdja_wechat_gbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_wechat_gbook` (
  `gid` int(9) NOT NULL AUTO_INCREMENT,
  `g_openid` varchar(50) DEFAULT NULL,
  `g_nickName` varchar(50) DEFAULT NULL,
  `g_avatarUrl` varchar(255) DEFAULT NULL,
  `g_gender` int(6) DEFAULT '0',
  `g_city` varchar(50) DEFAULT NULL,
  `g_name` varchar(50) DEFAULT NULL,
  `g_mobile` int(12) DEFAULT '0',
  `g_email` varchar(50) DEFAULT NULL,
  `g_topic` varchar(50) DEFAULT NULL,
  `g_info` text,
  `g_time` datetime DEFAULT NULL,
  `g_reply` text,
  `g_replytime` datetime DEFAULT NULL,
  `g_hidden` int(1) DEFAULT '0',
  `g_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_wechat_news`
--

DROP TABLE IF EXISTS `wdja_wechat_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_wechat_news` (
  `nid` int(9) NOT NULL AUTO_INCREMENT,
  `n_topic` varchar(50) DEFAULT NULL,
  `n_keywords` varchar(152) DEFAULT NULL,
  `n_description` varchar(252) DEFAULT NULL,
  `n_image` varchar(255) DEFAULT NULL,
  `n_content` text,
  `n_content_images_list` text,
  `n_cttype` int(1) DEFAULT '0',
  `n_cp_note` int(1) DEFAULT '0',
  `n_cp_mode` int(1) DEFAULT '0',
  `n_cp_type` int(1) DEFAULT '0',
  `n_cp_num` int(9) DEFAULT '0',
  `n_time` datetime DEFAULT NULL,
  `n_cls` text,
  `n_class` int(9) DEFAULT '0',
  `n_hidden` int(1) DEFAULT '0',
  `n_update` int(1) DEFAULT '0',
  `n_good` int(1) DEFAULT '0',
  `n_count` int(9) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_wechat_product`
--

DROP TABLE IF EXISTS `wdja_wechat_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_wechat_product` (
  `pid` int(9) NOT NULL AUTO_INCREMENT,
  `p_snum` varchar(50) DEFAULT NULL,
  `p_topic` varchar(50) DEFAULT NULL,
  `p_keywords` varchar(152) DEFAULT NULL,
  `p_description` varchar(252) DEFAULT NULL,
  `p_image` varchar(255) DEFAULT NULL,
  `p_content` text,
  `p_content_images_list` text,
  `p_cttype` int(1) DEFAULT '0',
  `p_time` datetime DEFAULT NULL,
  `p_cls` text,
  `p_class` int(9) DEFAULT '0',
  `p_hidden` int(1) DEFAULT '0',
  `p_update` int(1) DEFAULT '0',
  `p_good` int(1) DEFAULT '0',
  `p_count` int(9) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wdja_wechat_slide`
--

DROP TABLE IF EXISTS `wdja_wechat_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wdja_wechat_slide` (
  `sid` int(9) NOT NULL AUTO_INCREMENT,
  `s_topic` varchar(50) DEFAULT NULL,
  `s_url` varchar(255) DEFAULT NULL,
  `s_lng` varchar(50) DEFAULT NULL,
  `s_image` varchar(255) DEFAULT NULL,
  `s_intro` varchar(255) DEFAULT NULL,
  `s_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
