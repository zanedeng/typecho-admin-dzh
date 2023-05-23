CREATE TABLE `typecho_robots_logs` (
  `lid` int(10) unsigned NOT NULL auto_increment,
  `bot` varchar(16) default NULL,
  `url` varchar(64) default NULL,
  `ip` varchar(16) default NULL,
  `ltime` int(10) unsigned default '0',
  PRIMARY KEY  (`lid`)
) ENGINE=MYISAM  DEFAULT CHARSET=%charset%;