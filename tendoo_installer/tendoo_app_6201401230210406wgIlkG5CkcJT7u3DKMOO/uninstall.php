<?php
$this->db->query('DROP TABLE IF EXISTS `tendoo_contact_handler`');
$this->db->query('DROP TABLE IF EXISTS `tendoo_contact_handler_option`');
$this->db->query('DROP TABLE IF EXISTS `tendoo_contact_fields`');
$this->db->query('DROP TABLE IF EXISTS `tendoo_contact_aboutUs`');
$this->db->where('MOD_NAMESPACE','tendoo_widget_administrator')->delete('tendoo_modules_actions');
