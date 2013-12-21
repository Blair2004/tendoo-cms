<?php
	$this->core->db->query('DROP TABLE IS EXISTS `hubby_index_manager`');
	$this->core->db->where('MOD_NAMESPACE','hubby_index_manager')->delete('hubby_modules_actions');