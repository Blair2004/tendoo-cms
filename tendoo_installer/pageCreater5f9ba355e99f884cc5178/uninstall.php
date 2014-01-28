<?php
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_pages`');
$this->core->tendoo_admin->delete_controler('hub_page');
$this->core->db->where('MOD_NAMESPACE','Pages_editor')->delete('tendoo_modules_actions');