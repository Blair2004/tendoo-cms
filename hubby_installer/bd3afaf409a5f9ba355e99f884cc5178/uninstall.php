<?php
$this->core->db->query('DROP TABLE IF EXISTS `hubby_widget_administrator`');
$this->core->db->where('MOD_NAMESPACE','hubby_widget_administrator')->delete('hubby_modules_actions');
