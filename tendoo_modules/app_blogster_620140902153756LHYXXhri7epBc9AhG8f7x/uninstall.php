<?php
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news`');
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_comments`');
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_setting`');
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_category`');
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_ref_category`');
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_keywords`');
get_db()->query('DROP TABLE IF EXISTS `'.DB_ROOT.'tendoo_news_ref_keywords`');
get_db()->where('MOD_NAMESPACE','news')->delete('tendoo_modules_actions');
