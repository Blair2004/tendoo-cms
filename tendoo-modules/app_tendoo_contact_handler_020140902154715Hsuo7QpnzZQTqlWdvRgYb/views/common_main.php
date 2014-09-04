<?php
set_contact_page( array( 
	'about_us_title'	=>	$page[0]['PAGE_TITLE'],
	'about_us'			=>	$gDescription,
	'addresses'			=>	$contact,
	'adresses_title'	=>	'Nos adresses'
) );
if(is_array($fields))
{
	foreach($fields as $f)
	{
		if($f['SHOW_NAME']	== '1')
		{
			set_form( 'contact_form' , array(
				'type'			=>	'text',
				'name'			=>	'contact_user_name',
				'value'			=>	$this->instance->users_global->isConnected() ? $this->instance->users_global->current('PSEUDO') : '',
				'placeholder'	=>	'Votre nom',
				'text'			=>	'Votre nom'
			) );
		}
		if($f['SHOW_MAIL']	== '1')
		{
			set_form( 'contact_form' , array(
				'type'			=>	'text',
				'name'			=>	'contact_user_mail',
				'value'			=>	$this->instance->users_global->isConnected() ? $this->instance->users_global->current('EMAIL') : '',
				'placeholder'	=>	'Votre email',
				'text'			=>	'Votre email'
			) );
		}
		if($f['SHOW_WEBSITE']	== '1')
		{
			set_form( 'contact_form' , array(
				'type'			=>	'text',
				'name'			=>	'contact_user_website',
				'placeholder'	=>	'Votre site web',
				'text'			=>	'Votre site web'
			) );
		}
		if($f['SHOW_PHONE']	== '1')
		{
			set_form( 'contact_form' , array(
				'type'			=>	'text',
				'name'			=>	'contact_user_phone',
				'placeholder'	=>	'Votre num&eacute;ro de t&eacute;l&eacute;phone',
				'text'			=>	'Votre num&eacute;ro de t&eacute;l&eacute;phone'
			) );
		}
		if($f['SHOW_COUNTRY']	== '1')
		{
			set_form( 'contact_form' , array(
				'type'			=>	'text',
				'name'			=>	'contact_user_country',
				'placeholder'	=>	'Votre pays',
				'text'			=>	'Votre pays'
			) );
		}
		if($f['SHOW_CITY']	== '1')
		{
			set_form( 'contact_form' , array(
				'type'			=>	'text',
				'name'			=>	'contact_user_city',
				'placeholder'	=>	'Votre Ville',
				'text'			=>	'Votre Ville'
			) );
		}
	}
}
set_form( 'contact_form' , array(
	'type'			=>	'hidden',
	'name'			=>	'user_id',
	'value'			=>	$this->instance->users_global->isConnected() ? $this->instance->users_global->current('ID') : 0
) );
set_form( 'contact_form' , array(
	'type'			=>	'textarea',
	'name'			=>	'contact_user_content',
	'placeholder'	=>	'Votre Message',
	'text'			=>	'Votre Message'
) );
set_form( 'contact_form' , array(
	'type'			=>	'submit',
	'name'			=>	'yourField',
	'value'			=>	'Envoyer un message'
) );
get_core_vars( 'active_theme_object' )->include_template( 'contact' );