CREATE TABLE IF NOT EXISTS `oc_circloid_settings` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

INSERT INTO `oc_circloid_settings` (`id`, `name`, `value`) VALUES
(1, 'out_stock', '1'),
(2, 'low_stock', '1'),
(3, 'low_stock_count', '10'),
(4, 'menu_event_type', 'click');
