<?php
		$db['hostname'] = 'localhost';
		$db['username'] = 'ubbercmc_eben';
		$db['password'] = 'Afromaster_2004';
		$db['database'] = 'try_tendoo';
		$db['dbdriver'] = 'mysql';
		$db['dbprefix'] = 'td_';
		$db['pconnect'] = FALSE;
		$db['db_debug'] = TRUE;
		$db['cache_on'] = FALSE;
		$db['cachedir'] = '';
		$db['char_set'] = 'utf8';
		$db['dbcollat'] = 'utf8_general_ci';
		$db['swap_pre'] = '';
		$db['autoinit'] = TRUE;
		$db['stricton'] = FALSE;
		if(!defined('DB_ROOT'))
		{
			define('DB_ROOT',$db['dbprefix']);
		}
		