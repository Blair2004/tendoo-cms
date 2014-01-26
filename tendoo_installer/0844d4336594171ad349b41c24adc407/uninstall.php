<?php
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_news`');
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_comments`');
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_news_setting`');
$this->core->db->query('DROP TABLE IF EXISTS `Tendoo_news_category`');
$this->core->db->where('MOD_NAMESPACE','news')->delete('Tendoo_modules_actions');
