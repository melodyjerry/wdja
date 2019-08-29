SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

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
  `ab_ucode` varchar(50) DEFAULT NULL,
  `ab_hidden` int(1) DEFAULT '0',
  `ab_update` int(1) DEFAULT '0',
  `ab_good` int(1) DEFAULT '0',
  `ab_count` int(9) DEFAULT '0',
  `ab_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`abid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_admin` (
  `aid` int(9) NOT NULL AUTO_INCREMENT,
  `a_name` varchar(50) DEFAULT NULL,
  `a_pword` varchar(50) DEFAULT NULL,
  `a_popedom` varchar(255) DEFAULT NULL,
  `a_lock` int(1) DEFAULT '0',
  `a_lasttime` datetime DEFAULT NULL,
  `a_lastip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_admin_log` (
  `lid` int(9) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(50) DEFAULT NULL,
  `l_time` datetime DEFAULT NULL,
  `l_ip` varchar(50) DEFAULT NULL,
  `l_islogin` int(1) DEFAULT '0',
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `d_ucode` varchar(50) DEFAULT NULL,
  `d_hidden` int(1) DEFAULT '0',
  `d_good` int(1) DEFAULT '0',
  `d_time` datetime DEFAULT NULL,
  `d_count` int(9) DEFAULT '0',
  `d_update` int(1) DEFAULT '0',
  PRIMARY KEY (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_baidupush` (
  `bid` int(9) NOT NULL AUTO_INCREMENT,
  `b_genre` varchar(152) DEFAULT NULL,
  `b_gid` int(9) NOT NULL,
  `b_topic` varchar(255) DEFAULT NULL,
  `b_url` varchar(255) DEFAULT NULL,
  `b_content` text,
  `b_count` int(9) DEFAULT '0',
  `b_type` varchar(25) DEFAULT '0',
  `b_state` varchar(25) DEFAULT '0',
  `b_time` datetime DEFAULT NULL,
  `b_update` datetime DEFAULT NULL,
  `b_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_baidupush_data` (
  `bdid` int(9) NOT NULL AUTO_INCREMENT,
  `bd_bid` int(9) NOT NULL,
  `bd_order` int(9) DEFAULT '0',
  `bd_type` varchar(25) DEFAULT '0',
  `bd_state` varchar(25) DEFAULT '0',
  `bd_content` text,
  `bd_time` datetime DEFAULT NULL,
  `bd_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`bdid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_fields` (
  `fid` int(9) NOT NULL AUTO_INCREMENT,
  `f_genre` varchar(50) DEFAULT NULL,
  `f_topic` varchar(50) DEFAULT NULL,
  `f_type` int(1) DEFAULT '0',
  `f_count` varchar(9) DEFAULT '0',
  `f_starttime` datetime DEFAULT NULL,
  `f_endtime` datetime DEFAULT NULL,
  `f_lock` int(1) DEFAULT '0',
  `f_time` datetime DEFAULT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_fields_data` (
  `fdid` int(9) NOT NULL AUTO_INCREMENT,
  `fd_topic` varchar(50) DEFAULT NULL,
  `fd_fid` int(9) DEFAULT '0',
  `fd_oid` int(9) DEFAULT '0',
  PRIMARY KEY (`fdid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_fields_gid` (
  `fgid` int(9) NOT NULL AUTO_INCREMENT,
  `fg_fid` int(9) DEFAULT '0',
  `fg_gid` varchar(50) DEFAULT NULL,
  `fg_data` varchar(255) DEFAULT NULL,
  `fg_time` datetime DEFAULT NULL,
  PRIMARY KEY (`fgid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_hotwords` (
  `ehid` int(9) NOT NULL AUTO_INCREMENT,
  `eh_topic` varchar(50) DEFAULT NULL,
  `eh_keywords` varchar(152) DEFAULT NULL,
  `eh_description` varchar(252) DEFAULT NULL,
  `eh_image` varchar(255) DEFAULT NULL,
  `eh_content` text,
  `eh_content_images_list` text,
  `eh_cttype` int(1) DEFAULT '0',
  `eh_cp_note` int(1) DEFAULT '0',
  `eh_cp_mode` int(1) DEFAULT '0',
  `eh_cp_type` int(1) DEFAULT '0',
  `eh_cp_num` int(9) DEFAULT '0',
  `eh_time` datetime DEFAULT NULL,
  `eh_cls` text,
  `eh_class` int(9) DEFAULT '0',
  `eh_hidden` int(1) DEFAULT '0',
  `eh_update` int(1) DEFAULT '0',
  `eh_good` int(1) DEFAULT '0',
  `eh_count` int(9) DEFAULT '0',
  PRIMARY KEY (`ehid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_expansion_iplock` (
  `ipid` int(9) NOT NULL AUTO_INCREMENT,
  `ip_area` varchar(50) DEFAULT NULL,
  `ip_robots` varchar(25) DEFAULT NULL,
  `ip_ip` varchar(152) DEFAULT NULL,
  `ip_content` text,
  `ip_lock` int(1) DEFAULT '0',
  `ip_out` int(1) DEFAULT '0',
  `ip_time` datetime DEFAULT NULL,
  `ip_update` datetime DEFAULT NULL,
  `ip_count` int(9) DEFAULT '0',
  `ip_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ipid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_forum_blacklist` (
  `bid` int(9) NOT NULL AUTO_INCREMENT,
  `b_username` varchar(50) DEFAULT NULL,
  `b_sid` int(9) DEFAULT '0',
  `b_admin` varchar(50) DEFAULT NULL,
  `b_time` datetime DEFAULT NULL,
  `b_remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `t_edit_info` varchar(255) DEFAULT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_forum_vote` (
  `vid` int(9) NOT NULL AUTO_INCREMENT,
  `v_topic` varchar(50) DEFAULT NULL,
  `v_type` int(9) DEFAULT '0',
  `v_time` datetime DEFAULT NULL,
  `v_day` int(9) DEFAULT '0',
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_forum_vote_data` (
  `vdid` int(9) NOT NULL AUTO_INCREMENT,
  `vd_topic` varchar(50) DEFAULT NULL,
  `vd_fid` int(9) DEFAULT '0',
  `vd_vid` int(9) DEFAULT '0',
  `vd_count` int(9) DEFAULT '0',
  PRIMARY KEY (`vdid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_forum_vote_voter` (
  `vuid` int(9) NOT NULL AUTO_INCREMENT,
  `vu_fid` int(9) DEFAULT '0',
  `vu_ip` varchar(50) DEFAULT NULL,
  `vu_username` varchar(50) DEFAULT NULL,
  `vu_data` varchar(255) DEFAULT NULL,
  `vu_time` datetime DEFAULT NULL,
  PRIMARY KEY (`vuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_message` (
  `mid` int(9) NOT NULL AUTO_INCREMENT,
  `m_name` varchar(50) DEFAULT NULL,
  `m_ip` varchar(50) DEFAULT NULL,
  `m_sex` int(1) DEFAULT '0',
  `m_mobile` varchar(50) DEFAULT '0',
  `m_email` varchar(50) DEFAULT NULL,
  `m_address` varchar(255) DEFAULT NULL,
  `m_title` varchar(50) DEFAULT NULL,
  `m_content` text,
  `m_time` datetime DEFAULT NULL,
  `m_reply` text,
  `m_replytime` datetime DEFAULT NULL,
  `m_hidden` int(1) DEFAULT '0',
  `m_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `n_ucode` varchar(50) DEFAULT NULL,
  `n_hidden` int(1) DEFAULT '0',
  `n_update` int(1) DEFAULT '0',
  `n_good` int(1) DEFAULT '0',
  `n_count` int(9) DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_passport_friend` (
  `feid` int(9) NOT NULL AUTO_INCREMENT,
  `fe_username` varchar(50) DEFAULT NULL,
  `fe_name` varchar(50) DEFAULT NULL,
  `fe_time` datetime DEFAULT NULL,
  PRIMARY KEY (`feid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `p_infos` varchar(1200) DEFAULT '{:::}{|||}{:::}',
  `p_time` datetime DEFAULT NULL,
  `p_cls` text,
  `p_class` int(9) DEFAULT '0',
  `p_ucode` varchar(50) DEFAULT NULL,
  `p_hidden` int(1) DEFAULT '0',
  `p_update` int(1) DEFAULT '0',
  `p_good` int(1) DEFAULT '0',
  `p_count` int(9) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `s_infos` varchar(1200) DEFAULT '{:::}{|||}{:::}',
  `s_ucode` varchar(50) DEFAULT NULL,
  `s_time` datetime DEFAULT NULL,
  `s_cls` text,
  `s_class` int(9) DEFAULT '0',
  `s_hidden` int(1) DEFAULT '0',
  `s_update` int(1) DEFAULT '0',
  `s_good` int(1) DEFAULT '0',
  `s_count` int(9) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_support_linktext` (
  `lid` int(9) NOT NULL AUTO_INCREMENT,
  `l_topic` varchar(50) DEFAULT NULL,
  `l_url` varchar(255) DEFAULT NULL,
  `l_keyword` varchar(50) DEFAULT NULL,
  `l_intro` varchar(255) DEFAULT NULL,
  `l_hidden` int(1) DEFAULT '0',
  `l_time` datetime DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_support_slide` (
  `sid` int(9) NOT NULL AUTO_INCREMENT,
  `s_topic` varchar(50) DEFAULT NULL,
  `s_url` varchar(255) DEFAULT NULL,
  `s_lng` varchar(50) DEFAULT NULL,
  `s_image` varchar(255) DEFAULT NULL,
  `s_intro` varchar(255) DEFAULT NULL,
  `s_order` int(9) NOT NULL DEFAULT '0',
  `s_hidden` int(1) DEFAULT '0',
  `s_time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wdja_sys_note` (
  `nid` int(9) NOT NULL AUTO_INCREMENT,
  `n_topic` varchar(50) DEFAULT NULL,
  `n_image` varchar(255) DEFAULT NULL,
  `n_content` text,
  `n_content_images_list` text,
  `n_cttype` int(1) DEFAULT '0',
  `n_cp_note` int(1) DEFAULT '0',
  `n_cp_mode` int(1) DEFAULT '0',
  `n_cp_type` int(1) DEFAULT '0',
  `n_cp_num` int(9) DEFAULT '0',
  `n_time` datetime DEFAULT NULL,
  `n_hidden` int(1) DEFAULT '0',
  `n_update` int(1) DEFAULT '0',
  `n_good` int(1) DEFAULT '0',
  `n_count` int(9) DEFAULT '0',
  `n_lng` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `wdja_admin` (`a_name`, `a_pword`, `a_popedom`) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', '-1') ;