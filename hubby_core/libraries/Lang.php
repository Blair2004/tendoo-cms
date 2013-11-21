<?php
Class Lang
{
	private $current;
	public function __construct()
	{
	}
	public function load($mixed_library)
	{
		switch($mixed_library)
		{
			case 'form_validation':
				$this->current	=	'form_val';
			break;
			case 'date':
				$this->current	=	'date';
			break;
						
			default:
			return $mixed_library;
			break;
		}
	}
	public function line($type)
	{
		if($this->current == 'form_val')
		{
			switch($type)
			{
			case 'required':
			return 'Le champ de texte :"%s" ne doit pas &ecirc;tre vide';
			break;
			
			case 'min_length':
			return 'La longeur de la valeur du champ de texte :"%s" doit avoir au moins "%s" lettre(s)';
			break;
			
			case 'max_length':
			return 'La longeur de la valeur du champ de texte :"%s" ne doit pas exc&eacute;der "%s" lettre(s)';
			break;
			
			case 'valid_email':
			return 'Le champ "%s" ne contient pas une adresse Email valide';
			break;
			
			case 'matches':
			return 'le champ :"%s" ne correspond pas au champ "%s"';
			break;
			
			case 'db':
			return 'le champ :"%s" ne correspond pas au champ "%s"';
			break;
			
			case 'alpha_dash':
			return 'le champ :"%s" ne doit pas avoir d\'espace.';
			break;
			
			default:
			return $type;
			break;
		}
		}
		else if($this->current	==	'date')
		{}
	}
}