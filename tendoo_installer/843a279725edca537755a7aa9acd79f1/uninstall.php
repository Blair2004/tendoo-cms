<?php
$this->core->db->query('DROP TABLE IF EXISTS `tendoo_contents`');
$this->core->db->where('MOD_NAMESPACE','tendoo_contents')->delete('tendoo_modules_actions');