<?php
$this->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_pages`');
$this->db->where('MOD_NAMESPACE','Pages_editor')->delete('tendoo_modules_actions');