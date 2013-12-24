<?php
	if($section == 'main')
	{
		if($fileContent)
		{
			$theme->definePageTitle($fileContent[0]['TITLE']);
			$theme->definePageDescription($fileContent[0]['DESCRIPTION']);
			$theme->defineUnique($fileContent[0]['CONTENT']);
		}
		else
		{
			$theme->definePageTitle('Erreur');
			$theme->definePageDescription('Le contenu attach&eacute; &agrave; cette page est introuvable !!!');
			$theme->defineUnique('Le contenu attach&eacute; &agrave; cette page est introuvable !!!<br>Connectez-vous &agrave; l\'espace administrateur pour attribuer &agrave; ce contr&ocirc;leur un contenu valide.');
		}
		$theme->parseUnique();
	}
