SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `qun_huoma`;
CREATE TABLE `qun_huoma` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `hm_id` varchar(32) DEFAULT NULL COMMENT '活码id',
  `title` varchar(32) DEFAULT NULL COMMENT '标题',
  `qun_qrcode` text COMMENT '群二维码',
  `wx_qrcode` text COMMENT '微信二维码',
  `creat_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` varchar(32) DEFAULT '' COMMENT '更新时间',
  `wxid` varchar(32) DEFAULT NULL COMMENT '微信号',
  `page_view` varchar(32) DEFAULT '0' COMMENT '访问量',
  `biaoqian` varchar(32) DEFAULT NULL COMMENT '标签',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

