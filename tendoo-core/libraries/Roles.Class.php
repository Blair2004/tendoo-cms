<?php
Class Roles extends Libraries
{
	public function __construct()
	{
		parent::__construct();
		__extends( $this );
	}
	public function count()
	{
		return count($this->get());
	}
	public function get($start = NULL,$end = NULL)
	{
		if(is_numeric( $start ) && is_numeric( $end ) )
		{
			$this->db->limit($end,$start);
		}
		else if($start != NULL && $end == NULL)
		{
			$this->db->where('ID',$start);
		}
		$query	=	$this->db->get('tendoo_roles');
		return $query->result_array();
	}
	public function create($name , $description , $is_selectable)
	{
		$query	=	$this->db->where('NAME',$name)->get('tendoo_roles');
		if(count($query->result_array()) == 0)
		{
			$array	=	array(
				'NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'DATE'			=>	$this->instance->date->datetime(),
				'IS_SELECTABLE'	=>	in_array((int)$is_selectable,array(0,1)) ? $is_selectable : 0
			);
			return $this->db->insert('tendoo_roles',$array);
		}
		return false;
	}
	public function edit($role_id,$name,$description,$is_selectable)
	{
		$query	=	$this->db->where('ID',$role_id)->get('tendoo_roles');
		if(count($query->result_array()) > 0)
		{
			$array	=	array(
				'NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'IS_SELECTABLE'	=>	in_array((int)$is_selectable,array(0,1)) ? $is_selectable : 0
			);
			return $this->db->where('ID',$role_id)->update('tendoo_roles',$array);
		}
		return false;
	}
	public function delete($role_id)
	{
		$query	=	$this->db->where('REF_ROLE_ID', $role_id )->get('tendoo_users');
		if(count($query->result_array()) == 0)
		{
			if($this->db->where('ID',$role_id)->delete('tendoo_roles'))
			{
				return 'done';
			}
			return 'error_occurred';
		}
		return 'cannotDeleteUsedPrivilege';
	}
	public function has_roles()
	{
		$priv	=	$this->get();
		if(count($priv) > 0)
		{
			return true;
		}
		return false;
	}
	public function can( $role_id , $action )
	{
		$roles_permissions	=	get_meta( 'roles_permissions' );
		if( $roles_permissions ) // If Roles exist between saved roles (with permissions)
		{
			if( $permissions	=	riake( $role_id , $roles_permissions ) )
			{
				if( in_array( $action , force_array( $permissions ) ) )
				{
					return true;
				}
			}
		}
		return false;
	}
	public function reset_permissions( $role_id )
	{
		$roles_permissions	=	get_meta( 'roles_permissions' );
		if( $roles_permissions )
		{
			$permissions	=	riake( $role_id , $roles_permissions );
			if( $permissions )
			{
				$roles_permissions[ $role_id ]	=	array();
				return set_meta( 'roles_permissions' , $roles_permissions );
			}
		}
	}
	public function add_permission( $role_id , $action ) // Deprecated
	{
		$role	=	$this->get( $role_id );
		if( $role )
		{
			$roles_permissions	=	get_meta( 'roles_permissions' );

			$permissions	=	riake( $role_id , $roles_permissions , array( $role_id => array() ) );
			if( !in_array( $action , force_array( $permissions ) ) )
			{
				$roles_permissions[ $role_id ][]	=	$action;
				set_meta( 'roles_permissions' , $roles_permissions );
				return true;
			}		
		}
		return false;
	}
	public function get_public_roles()
	{
		$query	=	$this->db->where('IS_SELECTABLE',1)->get('tendoo_roles');
		return $query->result_array();
	}
	public function is_public_role($role_id)
	{
		$priv	=	$this->get_roles($role_id);
		if($priv)
		{
			if($priv[0]['IS_SELECTABLE'] == "1")
			{
				return true;
			}
		}
		return false;
	}
	public function roles_stats()
	{
		$_privilege	=	array();
		$query		=	$this->db->get('tendoo_roles');
		$result		=	$query->result_array();
		if(count($result) > 0)
		{
			foreach($result as $r) // Parcours les privileges
			{
				$_query		=	$this->db->where('REF_ROLE_ID',$r['PRIV_ID'])->get('tendoo_users');
				$_result	=	$_query->result_array();
				$__query	=	$this->db->get('tendoo_users');
				$__result	=	$__query->result_array();
				$_privilege[]	=	array(
					'TOTALUSER'		=>		count($_result),
					'POURCENTAGE'	=>		count($_result) / count($__result) * 100,
					'PRIV_NAME'		=>		$r['NAME']
				);
			}
		}
		return $_privilege;
	}

}