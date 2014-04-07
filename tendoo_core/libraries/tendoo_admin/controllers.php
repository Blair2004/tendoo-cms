<?php
class tendoo_controllers
{
	private $reservedControllers		=	array('admin','install','login','logoff','account','registration','error');
	public function __construct()
	{
		__extends($this);
	}
	public function countPages()
	{
		$query	=	$this->db->get('tendoo_controllers');
		return $query->num_rows();
	}
	public function get_pages($e= '')
	{
		return $this->tendoo->getPage($e);
	}
	public function controller($name,$cname,$mod,$title,$description,$main,$obj = 'create',$id = '',$visible	=	'TRUE',$childOf= 'none',$page_link	=	'',$keywords = '')
	{
		if(in_array($cname,$this->reservedControllers)): return 'cantUserReservedCNames'; endif; // ne peut utiliser les cname reservés.
		if($childOf == strtolower($cname)) : return 'cantHeritFromItSelf' ;endif; // Ne peut être sous menu de lui même
		$currentPosition=	$childOf;
		if($obj == 'update')
		{
			$_xquery	=	$this->db->where('PAGE_CNAME',$cname)->get('tendoo_controllers');
			$_xresult	=	$_xquery->result_array();
			if(count($_xresult) > 0)
			{
				if($_xresult[0]['ID'] != $id)
				{
					return 'c_name_already_found';
				}
			}
			$_xquery	=	$this->db->where('PAGE_NAMES',$name)->get('tendoo_controllers');
			$_xresult	=	$_xquery->result_array();
			if(count($_xresult) > 0)
			{
				if($_xresult[0]['ID'] != $id)
				{
					return 'name_already_found';
				}
			}
		}
		if($childOf != 'none') // Si ce controleur est l'enfant d'un autre.
		{
			for($i=0;$i<= $this->tendoo->get_menu_limitation();$i++)
			{
				$firstQuery	=	$this	->db->select('*')
							->from('tendoo_controllers')
							->where('ID',$currentPosition);
				$data		=	$firstQuery->get();
				$result		=	$data->result_array();
				if(count($result) > 0)
				{
					if($this->tendoo->get_menu_limitation() == $i && $result[0]['PAGE_PARENT'] != 'none') // Si le dernier menu, compte tenu de la limitation en terme de sous menu est atteinte, et pourtant le menu nous dis qu'il y a encore un autre menu, nous déclarons qu'il ne peut plus y avoir de sous menu.
					{
						return 'subMenuLevelReach';
					}
					$currentPosition = $result[0]['PAGE_PARENT']; // Affecte le nouveau parent, pour remonter la source.
				}
				else
				{
					if($i == 0) // Nous sommes au premier niveau de la boucle, ici nous vérifions que le contrôleur désigné comme parent existe effectivement
					{
						return 'unkConSpeAsParent';
					}
				}
				
			}
		}
		if($main == 'TRUE' && $childOf != 'none'):return 'cantSetChildAsMain';endif; // Il ne faut pas définir un sous menu comme page principale
		
		$this	->db->select('*')
					->from('tendoo_controllers');
		$query		=	$this->db->get();
		
		if($query->num_rows > 0)
		{
			foreach($query->result_array() as $q)
			{
				if(strtolower($q['PAGE_CNAME'])	==	strtolower($cname) && $obj == 'create')
				{
					return 'c_name_already_found';
				}
				if(strtolower($q['PAGE_NAMES']) == strtolower($name) && $obj == 'create')
				{
					return 'name_already_found';
				}
				if($q['PAGE_MAIN'] == 'TRUE' && $main == 'TRUE')
				{
					if($main == 'TRUE' && $childOf == 'none')
					{
						$e['PAGE_MAIN']	=	'FALSE';
						$this 	->db->where('ID',$q['ID'])
										->update('tendoo_controllers',$e);
					}
				}
			}
		}
		$options				=	$this->tendoo->getOptions();
		$e['PAGE_CNAME']		=	strtolower($cname);
		$e['PAGE_NAMES']		=	strtolower($name);
		$e['PAGE_TITLE']		=	$title;
		$e['PAGE_DESCRIPTION']	=	$description;
		$e['PAGE_MAIN']			=	$query->num_rows > 0 ? $main == 'TRUE' && $childOf != 'none' ? 'FALSE' : $main : 'TRUE'; // Les sous menu ne devriat pas intervenir en tant que principale.
		$e['PAGE_MODULES']		=	$mod; // SI le controleur doit rediriger vers une page, alors on enregistre la page sinon on enregistre le module.
		$e['PAGE_VISIBLE']		=	$visible;
		$e['PAGE_PARENT']		=	$childOf == $name ? 'none' : $childOf;
		$e['PAGE_LINK']			=	$page_link;
		$e['PAGE_KEYWORDS']		=	$keywords;
		if($childOf == 'none')
		{
			$sub_query	=	$this->db->where('PAGE_PARENT','none')->get('tendoo_controllers');
			$result		=	$sub_query->result_array();
			$e['PAGE_POSITION']		=	count($result);
		}
		else
		{
			$sub_query	=	$this->db->where('PAGE_PARENT',$e['PAGE_PARENT'])->get('tendoo_controllers');
			$result		=	$sub_query->result_array();
			$e['PAGE_POSITION']		=	count($result);
		}
		if($obj == 'create')
		{
			if($this		->db->insert('tendoo_controllers',$e))
			{
				$query			=	$this->db->where('PAGE_MAIN','TRUE')->get('tendoo_controllers');
				if($query->num_rows == 0) : 		return "no_main_controller_created";endif;
				return 'controler_created';
			}
			else
			{
				return 'error_occured';
			}
		}
		else if($obj == 'update')
		{
			$query = $this	->db->where('ID',$id)
								->update('tendoo_controllers',$e);
			if($query)
			{
				return 'controler_edited';
			}
			else
			{
				return 'error_occured';
			}
		}
	}
	public function upController($id) // Change l'emplacement d'un menu et le poussant vers le haut.
	{
		$query	=	$this->db->where('ID',$id)->get('tendoo_controllers');
		$result	=	$query->result_array();
		if($result)
		{
			$parent	=	$result[0]['PAGE_PARENT'];
			if($parent == 'none')
			{
				if($result[0]['PAGE_POSITION'] != '0')
				{
					$this->db->where('PAGE_PARENT','none')->where('PAGE_POSITION',$result[0]['PAGE_POSITION']-1)->update('tendoo_controllers',array(
						'PAGE_POSITION'			=>		$result[0]['PAGE_POSITION'] // Mise à jour du controlleur précédent.
					));
					return $this->db->where('ID',$id)->where('PAGE_PARENT','none')->update('tendoo_controllers',array(
						'PAGE_POSITION'			=>		(int) $result[0]['PAGE_POSITION'] - 1
					));
				}
			}
		}
		else
		{
			echo '<script>tendoo.notice.alert("Une erreur est survenue durant la modification de l\'ordre des contr&ocirc;leurs","danger");</script>';
		}
	}
	public function delete_controler($name)
	{
		$this	->db->select('*')
					->from('tendoo_controllers')
					->where('PAGE_CNAME',$name);
		$query 		= $this->db->get();
		$result 	= $query->result_array();
		if($result[0]['PAGE_MAIN'] == 'TRUE')
		{
			return 'cant_delete_mainpage';
		}
		else
		{
			if($this->db->where('PAGE_CNAME',$name)->delete('tendoo_controllers'))
			{
				return 'controler_deleted';
			}
			return 'error_occured';
		}
	}
	public function getChildren($curent_level,$child)
	{
		if(is_array($child))
		{
			foreach($child as $_g)
			{
				?>
			<tr>
				<td><?php echo $curent_level;?></td>
				<td><a href="<?php echo $this->url->site_url('admin/pages/edit/'.$_g['PAGE_CNAME']);?>" data-toggle="modal"><?php echo $_g['PAGE_NAMES'];?></a></td>
				<td><?php echo $_g['PAGE_TITLE'];?></td>
				<td><?php echo $_g['PAGE_DESCRIPTION'];?></td>
				<td><?php echo ($_g['PAGE_MAIN'] == 'TRUE') ? 'Oui' : 'Non';?></td>
				<td><?php echo $_g['PAGE_MODULES'] === FALSE ? 'Aucun module' : is_string($_g['PAGE_MODULES']) ? $_g['PAGE_MODULES'] : $_g['PAGE_MODULES'][0]['HUMAN_NAME'];?></td>
				<td><a onclick="if(!confirm('voulez-vous supprimer ce contrôleur ?')){return false}" href="<?php echo $this->url->site_url('admin/pages/delete/'.$_g['PAGE_CNAME']);?>">Supprimer</a></td>
				<td><?php echo count($_g['PAGE_CHILDS']);?></td>
			</tr>
				<?php
				$this->getChildren($curent_level+1,$_g['PAGE_CHILDS']);
			}
		}
	}
}