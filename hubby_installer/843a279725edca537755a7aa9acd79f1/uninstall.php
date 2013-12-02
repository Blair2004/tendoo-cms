<?php
$this->core->db->query('DROP TABLE IF EXISTS `hubby_contents`');
$this->core->db->where('MOD_NAMESPACE','hubby_contents')->delete('hubby_modules_actions');