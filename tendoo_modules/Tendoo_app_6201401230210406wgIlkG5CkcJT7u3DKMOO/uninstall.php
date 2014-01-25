<?php
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_contact_handler`');
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_contact_handler_option`');
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_contact_fields`');
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_contact_aboutUs`');
$this->core->db->where('MOD_NAMESPACE','Tendoo_widget_administrator')->delete('Tendoo_modules_actions');
