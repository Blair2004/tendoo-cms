<?php 
	if($section == 'main')
	{
		$theme->definePageTitle($fileContent[0]['TITLE']);
		$theme->definePageDescription($fileContent[0]['DESCRIPTION']);
		$theme->defineUnique($fileContent[0]['CONTENT']);
		$theme->parseUnique();
	}
