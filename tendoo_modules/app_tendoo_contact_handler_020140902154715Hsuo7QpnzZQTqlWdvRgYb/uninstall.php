<?php
get_db()->query('DROP TABLE IF EXISTS `' . DB_ROOT . 'tendoo_contact_handler`');
get_db()->query('DROP TABLE IF EXISTS `' . DB_ROOT . 'tendoo_contact_handler_option`');
get_db()->query('DROP TABLE IF EXISTS `' . DB_ROOT . 'tendoo_contact_fields`');
get_db()->query('DROP TABLE IF EXISTS `' . DB_ROOT . 'tendoo_contact_aboutUs`');