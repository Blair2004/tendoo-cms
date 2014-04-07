<?php
class tendoo_privileges
{
	public function __construct()
	{
		__extends($this);
	}
	public function get_global_info()
	{
		// About Controllers;
		$this	->db->select('*')
					->from('tendoo_controllers');
		$query = $this->db->get();
		// About Themes
		$tendoo_themes_request		=	$this->db->where('ACTIVATED','TRUE')->get('tendoo_themes');
		// Array Error Contener
		$array	=	array();
		if(count($tendoo_themes_request->result_array()) == 0)
		{
			$array[]	= 'no_theme_selected';
		}
		if($query->num_rows == 0)
		{
			$array[]	= 'no_page_set';
		}
		else
		{
			foreach($query->result() as $r)
			{
				$result[]	=	$r->PAGE_MAIN;
			}
			if(!in_array('TRUE',$result))
			{
				$array[]	=	'no_main_page_set';
			}
		}
		$priv	=	$this->getPrivileges();
		if(count($priv) == 0)
		{
			$array[]		=	'no_priv_created';
		}
		return $array;					
	}
	public function countPrivileges()
	{
		return count($this->getPrivileges());
	}
	public function getPrivileges($start = NULL,$end = NULL)
	{
		if($start != NULL && $end != NULL)
		{
			$this->db->limit($end,$start);
		}
		else if($start != NULL && $end == NULL)
		{
			$this->db->where('PRIV_ID',$start);
		}
		$query	=	$this->db->get('tendoo_admin_privileges');
		return $query->result_array();
	}
	public function create_privilege($name,$description,$priv_id,$is_selectable)
	{
		$query	=	$this->db->where('HUMAN_NAME',$name)->get('tendoo_admin_privileges');
		if(count($query->result_array()) == 0)
		{
			$array	=	array(
				'HUMAN_NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'DATE'			=>	$this->tendoo->datetime(),
				'PRIV_ID'		=>	$priv_id,
				'IS_SELECTABLE'	=>	in_array((int)$is_selectable,array(0,1)) ? $is_selectable : 0
			);
			return $this->db->insert('tendoo_admin_privileges',$array);
		}
		return false;
	}
	public function edit_privilege($priv_id,$name,$description,$is_selectable)
	{
		$query	=	$this->db->where('PRIV_ID',$priv_id)->get('tendoo_admin_privileges');
		if(count($query->result_array()) > 0)
		{
			$array	=	array(
				'HUMAN_NAME'	=>	$name,
				'DESCRIPTION'	=>	$description,
				'IS_SELECTABLE'	=>	in_array((int)$is_selectable,array(0,1)) ? $is_selectable : 0
			);
			return $this->db->where('PRIV_ID',$priv_id)->update('tendoo_admin_privileges',$array);
		}
		return false;
	}
	public function deletePrivilege($privid)
	{
		$query	=	$this->db->where('PRIVILEGE',$privid)->get('tendoo_users');
		if(count($query->result_array()) == 0)
		{
			if($this->db->where('PRIV_ID',$privid)->delete('tendoo_admin_privileges'))
			{
				return 'done';
			}
			return 'error_occured';
		}
		return 'cannotDeleteUsedPrivilege';
	}
	public function getPrivId()
	{
		while(true)
		{
			$id	=	rand(0,9).rand(0,9).'-'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).'-'.rand(0,9).rand(0,9).rand(0,9);
			$query	=	$this->db->where('PRIVILEGE',$id)->get('tendoo_users');
			if(count($query->result_array()) == 0)
			{
				break;
			}
		}		
		return $id;
	}
	public function hasPriv()
	{
		$priv	=	$this->getPrivileges();
		if(count($priv) > 0)
		{
			return true;
		}
		return false;
	}
	public function addActionToPriv($query,$context)
	{
		eval($query);
		if(count($EVALUABLE) > 0)
		{
			foreach($EVALUABLE as $key	=> $value)
			{
				$type_namespace	=	$context;
				$type_ref_priv	=	$key;
				foreach($value as $_key =>	$_value)
				{
					$type_action	=	$_key;
					$type_action_v	=	$value;
					$query	=	$this->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->get('tendoo_privileges_actions');
					if(count($query->result_array()) > 0)
					{
						$this->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->update('tendoo_privileges_actions',array(
							'TYPE_NAMESPACE'	=>	$type_namespace,
							'REF_TYPE_ACTION'	=>	$_key,
							'REF_ACTION_VALUE'	=>	$_value,
							'REF_PRIVILEGE'		=>	$type_ref_priv
						));
					}
					else
					{
						$this->db->insert('tendoo_privileges_actions',array(
							'TYPE_NAMESPACE'	=>	$type_namespace,
							'REF_TYPE_ACTION'	=>	$_key,
							'REF_ACTION_VALUE'	=>	$_value,
							'REF_PRIVILEGE'		=>	$type_ref_priv
						));
					}														
				}
			}
			return true;
		}
		return false;
	}
	public function addActionToPriv_MTW($query,$context)
	{
		eval($query);
		if(count($EVALUABLE) > 0)
		{
			foreach($EVALUABLE as $key	=> $value)
			{
				$type_namespace	=	$context;
				$type_ref_priv	=	$key;
				foreach($value as $__key	=>	$__value) // $__key is object_namespace
				{
					foreach($__value as $_key =>	$_value)
					{
						$type_action	=	$_key;
						$type_action_v	=	$value;
						$query	=	$this->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->where('OBJECT_NAMESPACE',$__key)->get('tendoo_privileges_actions');
						if(count($query->result_array()) > 0)
						{
							$this->db->where('TYPE_NAMESPACE',$type_namespace)->where('REF_TYPE_ACTION',$type_action)->where('REF_PRIVILEGE',$type_ref_priv)->update('tendoo_privileges_actions',array(
								'TYPE_NAMESPACE'	=>	$type_namespace,
								'REF_TYPE_ACTION'	=>	$_key,
								'REF_ACTION_VALUE'	=>	$_value,
								'OBJECT_NAMESPACE'	=>	$__key,
								'REF_PRIVILEGE'		=>	$type_ref_priv
							));
						}
						else
						{
							$this->db->insert('tendoo_privileges_actions',array(
								'TYPE_NAMESPACE'	=>	$type_namespace,
								'REF_TYPE_ACTION'	=>	$_key,
								'REF_ACTION_VALUE'	=>	$_value,
								'OBJECT_NAMESPACE'	=>	$__key,
								'REF_PRIVILEGE'		=>	$type_ref_priv
							));
						}	
					}
				}
			}
			return true;
		}
		return false;
	}
	public function adminAccess($action_namespace,$action,$privilege,$object_namespace = '')
	{
		$query	=	$this->db->where('OBJECT_NAMESPACE',$object_namespace)->where('TYPE_NAMESPACE',$action_namespace)->where('REF_TYPE_ACTION',$action)->where('REF_PRIVILEGE',$privilege)->get('tendoo_privileges_actions');
		$result = $query->result_array();
		if(count($result) > 0)
		{
			if($result[0]['REF_ACTION_VALUE']	== 'true')
			{
				return true;
			}
			return false;
		}
	}
	public function getValueForPrivNameAndSystem($system,$action,$priv)
	{
		$query	=	$this->db->where('TYPE_NAMESPACE',$system)->where('REF_TYPE_ACTION',$action)->where('REF_PRIVILEGE',$priv)->get('tendoo_privileges_actions');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return $result[0];
		}
		return array();
	}
	public function getModuleAction($mod_namespace)
	{
		$query	=	$this->db->where('MOD_NAMESPACE',$mod_namespace)->get('tendoo_modules_actions');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return $result;
		}
		return false;
	}
	public function createModuleAction($mod_namespace,$action,$action_name,$action_description) // Create action for modules
	{
		$query	=	$this->db
			->where('MOD_NAMESPACE',$mod_namespace)
			->where('ACTION',$action)
			->get('tendoo_modules_actions');
		$result	=	$query->result_array();
		if(count($result) > 0)
		{
			return $this->db
			->where('MOD_NAMESPACE',$mod_namespace)
			->where('ACTION',$action)
			->update('tendoo_modules_actions',array(
				'ACTION_NAME'			=>	$action_name,
				'ACTION_DESCRIPTION'	=>	$action_description
			));
		}
		return $this->db->insert('tendoo_modules_actions',array(
			'MOD_NAMESPACE'			=>	$mod_namespace,
			'ACTION'				=>	$action,
			'ACTION_NAME'			=>	$action_name,
			'ACTION_DESCRIPTION'	=>	$action_description
		));
	}
	public function getPublicPrivilege()
	{
		$query	=	$this->db->where('IS_SELECTABLE',1)->get('tendoo_admin_privileges');
		return $query->result_array();
	}
	public function isPublicPriv($priv_id)
	{
		$priv	=	$this->getPrivileges($priv_id);
		if($priv)
		{
			if($priv[0]['IS_SELECTABLE'] == "1")
			{
				return true;
			}
		}
		return false;
	}
	public function actionAccess($action,$module_namespace) // Vérifie si l'utilisateur actuel peut acceder au module par l'action
	{
		if(!$this->users_global->isSuperAdmin()	&& !$this->adminAccess('modules',$action,$this->users_global->current('PRIVILEGE'),$module_namespace))
		{
			return false;
		}
		return true;
	}
	
	public function privilegeStats()
	{
		$_privilege	=	array();
		$query		=	$this->db->get('tendoo_admin_privileges');
		$result		=	$query->result_array();
		if(count($result) > 0)
		{
			foreach($result as $r) // Parcours les privileges
			{
				$_query		=	$this->db->where('PRIVILEGE',$r['PRIV_ID'])->get('tendoo_users');
				$_result	=	$_query->result_array();
				$__query	=	$this->db->get('tendoo_users');
				$__result	=	$__query->result_array();
				$_privilege[]	=	array(
					'TOTALUSER'		=>		count($_result),
					'POURCENTAGE'	=>		count($_result) / count($__result) * 100,
					'PRIV_NAME'		=>		$r['HUMAN_NAME']
				);
			}
		}
		return $_privilege;
	}
}