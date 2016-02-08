--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`type`, `name`) VALUES
('BUTT', 'Button'),
('CHEC', 'Checkbox'),
('DATE', 'Date Select Field'),
('PASS', 'Password Field'),
('RADI', 'Radio Button'),
('SELE', 'Select Field'),
('SUBM', 'Submit Button'),
('TEXT', 'Text Input'),
('TXTA', 'Text Area');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `users_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`users_email`),
  KEY `fk_forms_users_idx` (`users_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `forms_fields`
--

CREATE TABLE IF NOT EXISTS `forms_fields` (
  `forms_id` int(10) unsigned NOT NULL,
  `forms_users_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fields_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `form_order` int(10) unsigned NOT NULL DEFAULT '0',
  `options` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`forms_id`,`forms_users_email`,`fields_type`,`form_order`),
  KEY `fk_forms_has_fields_fields1_idx` (`fields_type`),
  KEY `fk_forms_has_fields_forms1_idx` (`forms_id`,`forms_users_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `fk_forms_users` FOREIGN KEY (`users_email`) REFERENCES `users` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forms_fields`
--
ALTER TABLE `forms_fields`
  ADD CONSTRAINT `fk_forms_has_fields_fields1` FOREIGN KEY (`fields_type`) REFERENCES `fields` (`type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_forms_has_fields_forms1` FOREIGN KEY (`forms_id`, `forms_users_email`) REFERENCES `forms` (`id`, `users_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;
