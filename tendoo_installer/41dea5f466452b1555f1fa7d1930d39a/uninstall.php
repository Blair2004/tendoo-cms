<?php
	$this->core->db->query('DROP TABLE IS EXISTS `Tendoo_index_manager`');
	$this->core->db->where('MOD_NAMESPACE','Tendoo_index_manager')->delete('tendoo_modules_actions');