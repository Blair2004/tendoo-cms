<?php
/*
	Tendoo 0.9.8 Only
	
	Alias des méthodes de l'objet users.php
		user([clé]), alias $this->instance->users_global->current([clé]);
		Recupère les informations de l'utilisateur actuellement connecté.
*/
	function user($info)
	{
		$instance	=	get_instance();
		return $instance->users_global->current($info);
	}
	/**
	*	set_user_data
	**/
	function set_user_data($key,$value)
	{
		return set_data($key,$value, 'from_user_options' );
	}
	/**
	*	get_user_data($key)
	**/
	function get_user_data($key)
	{
		return get_data( $key , 'from_user_options' );
	}
	/**
	*	unset_user_data($key)
	**/
	function unset_user_data($key)
	{
		return unset_data( $key , 'from_user_options' );
	}
	/**
	*	get_user() : recupère un utilisateur
	**/
	function get_user($id_or_pseudo_or_email,$process_type = 'as_pseudo') // add to doc news 1.2
	{
		$Core	=	get_instance();
		if($process_type	==	'as_id')
		{
			$Core->db->where('ID',$id_or_pseudo_or_email);
		}
		else if($process_type == 'as_pseudo')
		{
			$Core->db->where('PSEUDO',$id_or_pseudo_or_email);
		}
		else if($process_type == 'as_mail')
		{
			$Core->db->where('PSEUDO',$id_or_pseudo_or_email);
		}
		$query	=	$Core->db->get('tendoo_users');
		$result	=	$query->result_array();
		/**
		*	Pause jusqu'a la prise en chager des avatars des autes réseaux sociaux.
		**/
		if($result)
		{
			$result[0]['AVATAR']	=	img_url('avatar_default.jpg');
			if($result[0]['AVATAR_TYPE'] == 'system')
			{
				$result[0]['AVATAR'] 	=	$result[0]['AVATAR_LINK'];
			}
			$light_data				=	json_decode($result[0]['LIGHT_DATA'],true);
			$result[0]['BIO']		=	array_key_exists( 'user_bio', $light_data ) ? $light_data[ 'user_bio' ] : false;
		}
		return $result	=	$result == true ? $result[0] : false;
	}