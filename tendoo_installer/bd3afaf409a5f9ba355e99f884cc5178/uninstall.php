<?php
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_widget_administrator_bottom`');
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_widget_administrator_left`');
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_widget_administrator_right`');
$this->core->db->where('MOD_NAMESPACE','tendoo_widget_administrator')->delete('tendoo_modules_actions');
