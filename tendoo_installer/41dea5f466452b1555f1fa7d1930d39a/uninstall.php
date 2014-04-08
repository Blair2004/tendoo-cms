<?php
	$this->core->db->query('DROP TABLE IS EXISTS `tendoo_index_manager`');
	$this->core->db->where('MOD_NAMESPACE','tendoo_index_manager')->delete('tendoo_modules_actions');