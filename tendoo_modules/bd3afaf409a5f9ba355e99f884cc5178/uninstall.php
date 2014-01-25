<?php
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_widget_administrator`');
$this->core->db->where('MOD_NAMESPACE','Tendoo_widget_administrator')->delete('Tendoo_modules_actions');
