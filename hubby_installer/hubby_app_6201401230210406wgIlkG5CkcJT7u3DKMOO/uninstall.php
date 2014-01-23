<?php
$this->core->db->query('DROP TABLE IF EXISTS `hubby_contact_handler`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_contact_handler_option`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_contact_fields`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_contact_aboutUs`');
$this->core->db->where('MOD_NAMESPACE','hubby_widget_administrator')->delete('hubby_modules_actions');
