<?php
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news`');
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_comments`');
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_setting`');
$this->core->db->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_category`');
$this->core->db->where('MOD_NAMESPACE','news')->delete('tendoo_modules_actions');
