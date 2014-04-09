<?php
$this->db->query('DROP TABLE IF EXISTS `tendoo_contents`');
$this->db->where('MOD_NAMESPACE','tendoo_contents')->delete('tendoo_modules_actions');