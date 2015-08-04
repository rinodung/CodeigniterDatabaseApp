CREATE TABLE `dbapp_columnselect` (
  `dbapp_columnselect_id` int(11) NOT NULL AUTO_INCREMENT,
  `dbapp_columnselect_database` varchar(255) NOT NULL,
  `dbapp_columnselect_table` varchar(255) NOT NULL,
  `dbapp_columnselect_column` varchar(255) NOT NULL,
  `dbapp_columnselect_values` text NOT NULL,
  PRIMARY KEY (`dbapp_columnselect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `dbapp_users_records` (
  `dbapp_users_records_id` int(11) NOT NULL AUTO_INCREMENT,
  `dbapp_users_records_userid` int(11) unsigned NOT NULL DEFAULT '1',
  `dbapp_users_records_database` varchar(255) NOT NULL,
  `dbapp_users_records_table` varchar(255) NOT NULL,
  `dbapp_users_records_recordid` varchar(255) NOT NULL,
  PRIMARY KEY (`dbapp_users_records_id`),
  KEY `dbapp_users_userid` (`dbapp_users_records_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dbapp_users_records`
--
ALTER TABLE `dbapp_users_records`
  ADD CONSTRAINT `dbapp_users_records_ibfk_1` FOREIGN KEY (`dbapp_users_records_userid`) REFERENCES `dbapp_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `dbapp_groups` ADD `default` INT( 1 ) NOT NULL DEFAULT '0'

