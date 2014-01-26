<?php
if(count($contact) > 0)
{
	$theme->defineContactAddress($page[0]['PAGE_TITLE'],$page[0]['PAGE_DESCRIPTION']);
	foreach($contact as $c)
	{
		$theme->defineContactAddressItem($c['CONTACT_TYPE'],$c['CONTACT_TEXT']);
	}
}
if(is_array($fields))
{
	foreach($fields as $f)
	{
		if($f['SHOW_NAME']	== '1')
		{
			$theme->defineForm(array(
				'type'				=>	'input',
				'name'				=>	'contact_user_name',
				'subtype'			=>	'text',
				'placeholder'		=>	'Votre nom',
				'value'				=>	$this->core->users_global->isConnected() ? $this->core->users_global->current('PSEUDO') : ''
			));
		}
		if($f['SHOW_MAIL']	== '1')
		{
			$theme->defineForm(array(
				'type'				=>	'input',
				'name'				=>	'contact_user_mail',
				'subtype'			=>	'text',
				'placeholder'		=>	'Votre email',
				'value'				=>	$this->core->users_global->isConnected() ? $this->core->users_global->current('EMAIL') : ''
			));
		}
		if($f['SHOW_WEBSITE']	== '1')
		{
			$theme->defineForm(array(
				'type'				=>	'input',
				'name'				=>	'contact_user_website',
				'subtype'			=>	'text',
				'placeholder'		=>	'Votre site web'
			));
		}
		if($f['SHOW_PHONE']	== '1')
		{
			$theme->defineForm(array(
				'type'				=>	'input',
				'name'				=>	'contact_user_phone',
				'subtype'			=>	'text',
				'placeholder'		=>	'Votre num&eacute;ro de t&eacute;l&eacute;phone'
			));
		}
		if($f['SHOW_COUNTRY']	== '1')
		{
			$theme->defineForm(array(
				'type'				=>	'input',
				'name'				=>	'contact_user_country',
				'subtype'			=>	'text',
				'placeholder'		=>	'Votre pays'
			));
		}
		if($f['SHOW_CITY']	== '1')
		{
			$theme->defineForm(array(
				'type'				=>	'input',
				'name'				=>	'contact_user_city',
				'subtype'			=>	'text',
				'placeholder'		=>	'Votre ville'
			));
		}
	}
}
if($gDescription)
{
	$theme->defineContactContent($gDescription[0]['FIELD_CONTENT']);
}
$theme->defineForm(array(
	'type'				=>	'input',
	'name'				=>	'user_id',
	'subtype'			=>	'hidden',
	'placeholder'		=>	'Votre ville',
	'value'				=>	$this->core->users_global->isConnected() ? $this->core->users_global->current('ID') : 0
));
$theme->defineForm(array(
	'type'	=>	'textarea',
	'name'	=>	'contact_user_content',
	'subtype'=>	'text',
	'placeholder'	=>	'Votre Message'
));
$theme->defineForm(array(
	'type'	=>	'input',
	'name'	=>	'yourField',
	'subtype'=>	'submit',
	'placeholder'	=>	'Votre Message',
	'value'	=>	'Envoyer votre message'
));
$theme->defineContactFormHeader($action="",$enctype="multipart/form-data",$method="POST");
$theme->parseContact();