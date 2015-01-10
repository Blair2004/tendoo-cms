<?php
/*
	Tendoo 0.9.8 Only
	
	Alias des méthodes de l'objet users.php
		user([clé]), alias $this->instance->users_global->current([clé]);
		Recupère les informations de l'utilisateur actuellement connecté.
*/
	/**
	*	current_user
	*	Renvoi les informations à propos de l'utilisateur actuel.
	**/
	function current_user( $input = false )
	{
		if( $input != false ){
			$instance	=	get_instance();
			if(isset($instance->users_global))
			{
				switch(strtolower($input))
				{
					case "menu"	:
					return $instance->users_global->getUserMenu();
					break;
					case "isconnected"	:
					return $instance->users_global->isConnected();
					break;
					case "isadmin"	:
					return $instance->users_global->isAdmin();
					break;
					case "issuperadmin"	:
					return $instance->users_global->isSuperAdmin();
					break;
					case "show_menu"	:
					return $instance->users_global->setMenuStatus('show_menu');
					break;
					case "hide_menu"	:
					return $instance->users_global->setMenuStatus('hide_menu');
					break;
					case "top_margin"	:
					return $instance->users_global->isConnected() ? 'style="margin-top:38px"' : '';
					break;
					case "top_offset"	:	
					return $instance->users_global->isConnected() ? 'style="top:38px"' : '';
					break;
					default :
						if(method_exists($instance->users_global,$input))
						{
							return $instance->users_global->$input();
						}
						else
						{
							return $instance->users_global->current($input);	
						}
					break;
				}
			}
		} else {
			return get_instance()->users_global;
		}		
	}
	/**
	*	set_user_meta
	**/
	function set_user_meta($key,$value)
	{
		return set_meta($key,$value, 'from_user_meta' );
	}
	/**
	*	get_user_meta($key)
	**/
	function get_user_meta( $key , $id_or_pseudo = null , $filter = 'as_id' )
	{
		if( $id_or_pseudo != null ){
			$user	=	get_user( $id_or_pseudo , $filter );
			if( $key != 'all' ){
				if( $user ){
					$query	=	get_db()->where( 'USER' , $user[ 'PSEUDO' ] )->where( 'KEY' , $key )->get( 'tendoo_meta' );
				}
			} else {
				$query	=	get_db()->where( 'USER' , $user[ 'PSEUDO' ] )->get( 'tendoo_meta' );
				$new_array	=	array();
				foreach( $result	=	$query->result_array() as $_key => $_result ){
					if( json_decode( $_result[ 'VALUE' ] ) != null ){
						$new_array[ $_result [ 'KEY' ] ] = json_decode( $_result[ 'VALUE' ] , TRUE );
					} else if( in_array( strtolower(  $_result[ 'VALUE' ] ) , array( 'true' , 'false' ) ) ){
						$new_array[ $_result [ 'KEY' ] ] = $_result[ 'VALUE' ] == 'true' ? true : false ;
					} else {
						$new_array[ $_result [ 'KEY' ] ] = $_result[ 'VALUE' ];
					}
				}
				return $new_array;
			}
			$result	=	$query->result_array();
			if( $result ){
				$_returned	=	$result[0][ 'VALUE' ];
				if( json_decode( $_returned ) != null ){
					return json_decode( $_returned , TRUE );
				} else if( in_array( strtolower( $_returned ) , array( 'true' , 'false' ) ) ){
					return $_returned == 'true' ? true : false ;
				} else {
					return $_returned;
				}
			}
			return false; // Key Doesn't exist
		} else {
			return get_meta( $key , 'from_user_meta' );
		}
	}
	/**
	*	unset_user_meta($key)
	**/
	function unset_user_meta($key)
	{
		return unset_meta( $key , 'from_user_meta' );
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
		// Special Case of "avatar_link"
		
		// Adding Meta to retreived data
		if( $result ){
			$result[0][ 'avatar_link' ]		=	img_url( 'avatar_default.jpg' );
			$all_meta_query	=	get_db()->where( 'USER' , $result[0][ 'PSEUDO' ] )->get( 'tendoo_meta' );
			$all_meta 		=	$all_meta_query->result_array();
			if( $all_meta ){
				foreach( $all_meta  as $meta_key => $meta_value ){
					$_returned	=	$meta_value[ 'VALUE' ];
					if( json_decode( $_returned ) != null ){
						$_returned = json_decode( $_returned , TRUE );
					} else if( in_array( strtolower( $_returned ) , array( 'true' , 'false' ) ) ){
						$_returned =  ( $_returned == 'true' ) ? true : false ;
					} 
					$result[0][ $meta_value[ 'KEY' ] ] = $meta_value[ 'VALUE' ];
				}
			}
		}
		/**
		*	Pause jusqu'a la prise en chager des avatars des autes réseaux sociaux.
		**/
		return $result	=	$result == true ? $result[0] : false;
	}
