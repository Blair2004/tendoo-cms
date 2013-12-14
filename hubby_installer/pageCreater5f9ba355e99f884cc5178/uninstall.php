<?php
$this->core->db->query('DROP TABLE IF EXISTS `hubby_pages`');
$this->core->hubby_admin->delete_controler('hub_page');
$this->core->db->where('MOD_NAMESPACE','Pages_editor')->delete('hubby_modules_actions');