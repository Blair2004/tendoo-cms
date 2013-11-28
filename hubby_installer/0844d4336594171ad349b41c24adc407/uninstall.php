<?php
$this->core->db->query('DROP TABLE IF EXISTS `hubby_news`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_comments`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_news_setting`');
$this->core->db->query('DROP TABLE IF EXISTS `hubby_news_category`');
$this->core->db->where('MOD_NAMESPACE','news')->delete('hubby_modules_actions');
