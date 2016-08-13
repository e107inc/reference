CREATE TABLE reference (
  `ref_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ref_table` varchar(50) NOT NULL DEFAULT '',
  `ref_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `ref_title` varchar(250) NOT NULL DEFAULT '',
  `ref_data` text NOT NULL,
   PRIMARY KEY  (`ref_id`),
   UNIQUE KEY `ref_unq` (`ref_table`,`ref_pid`)
) ENGINE=MyISAM;
