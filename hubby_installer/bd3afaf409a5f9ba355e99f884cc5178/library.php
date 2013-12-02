<?php
	class widhandler_lib
	{
		public function __construct($data)
		{
			$this->core	=	Controller::instance(); 
			$this->data	=	$data;
		}
		public function getMenu()
		{
			return $this->core->load->view($this->data['module_dir'].'/views/menu',$this->data,true,true);
		}
		public function getAllModulesWidgets()
		{
			$modules	=	$this->core->hubby_admin->get_modules();
		}
		public function createWidget($title,$description,$contenu)
		{
			$query	=	$this->core->db->where('WIDGET_HEAD',$title)->get('hubby_mod_widgets');
			$result	=	$query->result_array();
			if(count($result) == 0)
			{
				$array	=	array(
					'WIDGET_HEAD'				=>	$title,
					'WIDGET_DESCRIPTION'		=>	$description,
					'WIDGET_CONTENT'			=>	$contenu,
					'AUTEUR'					=>	$this->core->users_global->current('ID'),
					'DATE'						=>	$this->core->hubby->datetime(),
					'WIDGET_ORDER'				=>	$this->countWidgets()
				);
				if($this->core->db->insert('hubby_mod_widgets',$array))
				{
					return 'widgetCreated';
				}
				return 'errorOccured';
			}
			return 'widgetAlreadyExists';
		}
		public function createSpecialWidget($title,$description,$widget_ref)
		{
			$data	=	explode('/',$widget_ref);
			$module_namespace	=	$data[0];
			$widget_namespace	=	$data[1];
			$query	=	$this->core->db->where('WIDGET_HEAD',$title)->get('hubby_mod_widgets');
			$result	=	$query->result_array();
			if(count($result) == 0)
			{
				$array	=	array(
					'WIDGET_HEAD'						=>	$title,
					'WIDGET_REFERING_OBJ_NAMESPACE'		=>	$module_namespace,
					'WIDGET_REFERING_NAME'				=>	$widget_namespace,
					'WIDGET_DESCRIPTION'				=>	$description,
					'AUTEUR'							=>	$this->core->users_global->current('ID'),
					'DATE'								=>	$this->core->hubby->datetime(),
					'WIDGET_ORDER'						=>	$this->countWidgets()
				);
				if($this->core->db->insert('hubby_mod_widgets',$array))
				{
					return 'widgetCreated';
				}
				return 'errorOccured';
			}
			return 'widgetAlreadyExists';
		}
		public function countWidgets()
		{
			$query	=	$this->core->db->get('hubby_mod_widgets');
			$result	=	$query->result_array();
			return count($result);
		}
		public function getWidgets($start = null,$end = null,$activated	=	FALSE)
		{
			if(is_numeric($start) && !is_numeric($end))
			{
				$this->core->db->where('ID',$start);
			}
			else if(is_numeric($start) && is_numeric($end))
			{
				$this->core->db->limit($end,$start);
				$this->core->db->order_by('WIDGET_ORDER','asc');
			}
			if($activated	== TRUE)
			{
				$this->core->db->where('WIDGET_ETAT',1);
			}
			$query	=	$this->core->db->get('hubby_mod_widgets');
			$result	=	$query->result_array();
			if(count($result) > 0)
			{
				return $result;
			}
			return false;
		}
		public function editWidget($widget_id,$widget_title,$widget_description,$widget_content)
		{
			$retreiver	=	$this->getWidgets($widget_id);
			if($retreiver)
			{
				return $this->core->db->where('ID',$widget_id)->update('hubby_mod_widgets',array(
					'WIDGET_HEAD'			=>	$widget_title,
					'WIDGET_CONTENT'		=>	$widget_content,
					'WIDGET_DESCRIPTION'	=>	$widget_description,
					'AUTEUR'				=>	$this->core->users_global->current('ID'),
					'DATE'					=>	$this->core->hubby->datetime(),
				));
			}
			return false;
		}
		public function editSpecialWidget($widget_id,$widget_title,$widget_description,$widget_ref)
		{
			$retreiver	=	$this->getWidgets($widget_id);
			if($retreiver)
			{
				$data				=	explode('/',$widget_ref);
				$module_namespace	=	$data[0];
				$widget_namespace	=	$data[1];
				$time				=	$this->core->hubby->datetime();
				return $this->core->db->where('ID',$widget_id)->update('hubby_mod_widgets',array(
					'WIDGET_HEAD'						=>	$widget_title,
					'WIDGET_REFERING_OBJ_NAMESPACE'		=>	$module_namespace,
					'WIDGET_REFERING_NAME'				=>	$widget_namespace,
					'WIDGET_DESCRIPTION'				=>	$widget_description,
					'AUTEUR'							=>	$this->core->users_global->current('ID'),
					'DATE'								=>	$time,
				));
			}
			return false;
		}
		public function activateWidget($widget_id)
		{
			$widget	=	$this->getWidgets($widget_id);
			if($widget)
			{
				if($this->core->db->where('ID',$widget_id)->update('hubby_mod_widgets',array('WIDGET_ETAT'=>1)))
				{
					return 'WidgetActivated';
				}
				return 'error_occured';
			}
			return 'unknowWidget';
		}
		public function disableWidget($widget_id)
		{
			$widget	=	$this->getWidgets($widget_id);
			if($widget)
			{
				if($this->core->db->where('ID',$widget_id)->update('hubby_mod_widgets',array('WIDGET_ETAT'=>0)))
				{
					return 'WidgetDisabled';
				}
				return 'error_occured';
			}
			return 'unknowWidget';
		}
		public function grapWidget($widget_id)
		{
			$w	=	$this->getWidgets($widget_id);
			if($w)
			{
				if((int)$w[0]['WIDGET_ORDER'] != 0)
				{
					$theBefore	=	$this->core->db->where('WIDGET_ORDER',$w[0]['WIDGET_ORDER']-1)->get('hubby_mod_widgets');
					$result		=	$theBefore->result_array();
					
					$this->core->db->where('ID',$result[0]['ID'])->update('hubby_mod_widgets',array('WIDGET_ORDER'=>$w[0]['WIDGET_ORDER']));
					if($this->core->db->where('ID',$w[0]['ID'])->update('hubby_mod_widgets',array('WIDGET_ORDER'=>	$result[0]['WIDGET_ORDER'])))
					{
						return 'graped';
					}
					return 'error_occured';
				}
				return 'grapLimitReach';
			}
			return 'unknowWidget';
		}
		public function deleteWidget($widget_id)
		{
			$widget	=	$this->getWidgets($widget_id);
			if(count($widget) > 0)
			{
				if($this->core->db->where('ID',$widget_id)->delete('hubby_mod_widgets'))
				{
					return 'widgetDeleted';
				}
				return 'error_occured';
			}
			return 'unknowWidget';
		}
		public function retreiveAvailableModuleWidget()
		{
			// HERE
			$allMod	=	$this->core->hubby_admin->get_modules($start = NULL,$end = NULL);
		}
	}
	class widhandler_common
	{
		public function __construct()
		{
			$this->core		=	Controller::instance();
		}
		public function getWidgets($start = null,$end = null)
		{
			if(is_numeric($start) && !is_numeric($end))
			{
				$this->core->db->where('ID',$start);
			}
			else if(is_numeric($start) && is_numeric($end))
			{
				$this->core->db->limit($end,$start);
			}
			$this->core->db->where('WIDGET_ETAT',1); // retreive only activated widgets
			$this->core->db->order_by('WIDGET_ORDER','asc');
			
			$query	=	$this->core->db->get('hubby_mod_widgets');
			$result	=	$query->result_array();
			if(count($result) > 0)
			{
				return $result;
			}
			return false;
		}
	}