<?php
$this->core->db->query('DROP TABLE IF EXISTS `tendoo_contact_handler`');
$this->core->db->query('DROP TABLE IF EXISTS `tendoo_contact_handler_option`');
$this->core->db->query('DROP TABLE IF EXISTS `tendoo_contact_fields`');
$this->core->db->query('DROP TABLE IF EXISTS `tendoo_contact_aboutUs`');
$this->core->db->where('MOD_NAMESPACE','tendoo_widget_administrator')->delete('tendoo_modules_actions');
