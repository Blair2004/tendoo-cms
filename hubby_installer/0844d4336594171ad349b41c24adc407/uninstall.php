<?php
$this->core->db->query('DROP TABLE IF EXISTS `hubby_news`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_comments`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_news_setting`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_news_category`');
$this->core->db->where('MODULE_NAMESPACE','news')->delete('hubby_admin_widgets');
$this->core->db->where('MODULE_NAMESPACE','news')->delete('hubby_admin_widgets');