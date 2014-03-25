<?php
	class widhandler_lib
	{
		public function __construct()
		{
			__extends($this);
		}
		public function tewi_creating_widgets($tewi_code)
		{
			$widget_section		=	array();
			$tewi_code			=	preg_replace('#`#','"',$tewi_code);
			// Section 1
			$root				=	explode(']',$tewi_code);
			$code_1				=	substr($root[0],1);
			$widget_section[]	=	$this->tewi_widget_generate($code_1);
			// Section 2
			$code_2				=	substr($root[1],2);
			$widget_section[]	=	$this->tewi_widget_generate($code_2);
			// Section 2
			
			$code_3				=	substr($root[2],2);			
			$widget_section[]	=	$this->tewi_widget_generate($code_3);
			
			$this->db->where('ID !=',0)->delete('tendoo_widget_administrator_left');
			$this->db->where('ID !=',0)->delete('tendoo_widget_administrator_right');
			$this->db->where('ID !=',0)->delete('tendoo_widget_administrator_bottom');
			echo '<pre>';
			print_r($widget_section);
			echo '</pre>';
			$_li	=	0;
			foreach($widget_section as $widget_s) // first element is left section considering DOM order. refer to active-widget attribute.
			{
				if(is_array($widget_s))
				{
					foreach($widget_s as $wl) // widget Line
					{
						$side_list	=	array('left','right','bottom');
						//
						$woo	=	json_decode($wl,TRUE);
						$date	=	$this->tendoo->datetime();
						if($woo['widget_namespace'] == 'texte' && $woo['widget_modnamespace'] == 'system')
						{
							$this->db->insert('tendoo_widget_administrator_'.$side_list[$_li],array(
								'WIDGET_TITLE'						=>		$woo['widget_title'],
								'WIDGET_PARAMETERS'					=>		$woo['widget_params'],
								'WIDGET_HUMAN_NAME'					=>		$woo['widget_human_name'],
								'WIDGET_NAMESPACE'					=>		$woo['widget_namespace'],
								'WIDGET_MODNAMESPACE'				=>		$woo['widget_modnamespace'],
								'WIDGET_ETAT'						=>		1,
								'AUTEUR'							=>		$this->users_global->current('ID'),
								'DATE'								=>		$date
							));

						}
						else
						{
							$this->db->insert('tendoo_widget_administrator_'.$side_list[$_li],array(
								'WIDGET_TITLE'						=>		$woo['widget_title'],
								'WIDGET_PARAMETERS'					=>		$woo['widget_params'],
								'WIDGET_HUMAN_NAME'					=>		$woo['widget_human_name'],
								'WIDGET_NAMESPACE'					=>		$woo['widget_namespace'],
								'WIDGET_MODNAMESPACE'				=>		$woo['widget_modnamespace'],
								'WIDGET_ETAT'						=>		1,
								'AUTEUR'							=>		$this->users_global->current('ID'),
								'DATE'								=>		$date
							));
						}
						//
					}
				}
				$_li++;
			}
		}
		public function save_widgets($e)
		{
			if(is_array($e))
			{
				$this->db->where('ID >',0)->delete('tendoo_widget_administrator_left');
				$this->db->where('ID >',0)->delete('tendoo_widget_administrator_right');
				$this->db->where('ID >',0)->delete('tendoo_widget_administrator_bottom');
				foreach($e as $key	=>	$value)
				{
					if(in_array((string)$key,array('LEFT','RIGHT','BOTTOM')))
					{
						$table	=	strtolower($key);
						foreach($value as $w_key	=>	$w_content)
						{
							if(array_key_exists('params',$w_content))
							{
								if(is_array($w_content['params']))
								{
									$line_code	=	'$WIDGET_PARAMS	=	array();';
									foreach($w_content['params'] as $p_key	=>	$p_value)
									{
										$line_code	.=	'$WIDGET_PARAMS["'.$p_key.'"]	=	"'.addslashes($p_value).'";';
									}
									$isCode		=	1;
								}
								else
								{
									$isCode		=	0;
									$line_code	=	$w_content['params'];
								}
							}
							else
							{
								$isCode		=	0;
								$line_code	=	'';
							}
							$date						=		$this->tendoo->datetime();
							$this->db->insert('tendoo_widget_administrator_'.$table,array(
								'WIDGET_TITLE'			=>		$w_content['title'],
								'WIDGET_NAMESPACE'		=>		$w_content['namespace'],
								'WIDGET_MODNAMESPACE'	=>		$w_content['modnamespace'],
								'WIDGET_HUMAN_NAME'		=>		$w_content['human_name'],
								'WIDGET_ETAT'			=>		1,
								'WIDGET_PARAMETERS'		=>		$line_code,
								'AUTEUR'				=>		$this->users_global->current('ID'),
								'DATE'					=>		$date,
								'IS_CODE'				=>		$isCode
							));
						}
					}
					else
					{
						break; // we just jump when there is a failure.
					}
				}
			}
		}
		public function tewi_getWidgets($section = 'left')
		{
			if(in_array($section,array('left','right','bottom')))
			{
				$query	=	$this->db->get('tendoo_widget_administrator_'.$section);
				return $query->result_array();
			}
			return false;
		}
		public function getWidgetHTMLCode($widget_datas,$zone,$index) // 
		{
			/*
				- Chaque code additionnelle doit nécessairement avoir dans les champs des forumlaiers 
				un code testera l'existence dans la variable $TEWI;
				
				- Lorsqu'un le widget en question dispose plus d'un paramètre additionnel, l'utilisateur pour effectuer un eval sur la clé "WIDGET_PARAMS"
				qui créera un nouveau tableau avec pour clé les valeurs correspondant au nom de chaque champs tels qu'ils ont été défini sur le meta
				"meta_widgetParamsName".
			*/
			if(in_array($zone,array('LEFT','RIGHT','BOTTOM')))
			{
				$zone	=	strtoupper($zone);
			}
			else
			{
				return 'unknowSection';
			}
			$modnamespace				=	$widget_datas['WIDGET_MODNAMESPACE'];
			if($modnamespace == 'system')
			{
				if($widget_datas['WIDGET_NAMESPACE'] == 'texte')
				{
				?>
				<div class="panel widget_item" 
					widget="" 
					widget-namespace="<?php echo $widget_datas['WIDGET_NAMESPACE'];?>" 
					widget-modnamespace="<?php echo $modnamespace;?>" 
					widget-human_name="<?php echo $widget_datas['WIDGET_HUMAN_NAME'];?>">
					<header class="panel-heading text-center"><ul class="nav nav-pills pull-left"><li><a class="tewi_remover" href="javascript:void(0)"><i class="fa fa-times"></i></a></li></ul><ul class="nav nav-pills pull-right"><li><a class="panel-toggle text-muted active" href="javascript:void(0)"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a></li></ul><?php echo $widget_datas['WIDGET_HUMAN_NAME'];?></header>
					<div widget-hidden_content="" style="display:none">
						<div class="form-group">
							<textarea class="form-control" meta_widgetparams=""></textarea>
						</div>
					</div>
				<div tewi_meta="">
					<input meta_modnamespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][modnamespace]" value="system" type="hidden">
					<input meta_namespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][namespace]" value="texte" type="hidden">
					<input meta_human_name="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][human_name]" value="Widget Texte" type="hidden">
					<div class="panel-body">
						<div class="form-group">
							<input meta_title="" value="<?php echo $widget_datas['WIDGET_TITLE'];?>" placeholder="Titre du widget" class="form-control" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][title]" type="text">
						</div>
						<div class="form-group">
							<textarea name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][params]" class="form-control" meta_widgetparams=""><?php echo $widget_datas['WIDGET_PARAMETERS'];?></textarea>
						</div>
					</div></div></div>
				<?php
				}
			}
			else
			{
				$this->data['modules']		=	$this->tendoo_admin->getSpeModuleByNamespace($modnamespace);
				$this->data['finalMod']		=	array();
				foreach($this->data['modules']	as $module)
				{
					if($module['HAS_WIDGET']	==	1)
					{
						$widget_config_file		=	MODULES_DIR.$module['ENCRYPTED_DIR'].'/config/widget_config.php';
						if(file_exists($widget_config_file))
						{
							include($widget_config_file);
							if(isset($WIDGET_CONFIG))
							{
								foreach($WIDGET_CONFIG as $wc)
								{
									$this->data['finalMod'][]	=	$wc;
								}
							}
						}
					}
				}
				// var_dump($this->data['finalMod']);
				?>
				<div class="panel widget_item" 
					widget="" 
					widget-namespace="<?php echo $widget_datas['WIDGET_NAMESPACE'];?>" 
					widget-modnamespace="<?php echo $modnamespace;?>" 
					widget-human_name="<?php echo $widget_datas['WIDGET_HUMAN_NAME'];?>">
					<header class="panel-heading text-center"><ul class="nav nav-pills pull-left"><li><a class="tewi_remover" href="javascript:void(0)"><i class="fa fa-times"></i></a></li></ul><ul class="nav nav-pills pull-right"><li><a class="panel-toggle text-muted active" href="javascript:void(0)"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a></li></ul><?php echo $widget_datas['WIDGET_HUMAN_NAME'];?></header>
					<div widget-hidden_content="" style="display:none">
						<div class="form-group">
							<textarea class="form-control" meta_widgetparams=""></textarea>
						</div>
					</div>
					<div tewi_meta="">
						<input meta_modnamespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][modnamespace]" value="<?php echo $widget_datas['WIDGET_MODNAMESPACE'];?>" type="hidden">
						<input meta_namespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][namespace]" value="<?php echo $widget_datas['WIDGET_NAMESPACE'];?>" type="hidden">
						<input meta_human_name="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][human_name]" value="<?php echo $widget_datas['WIDGET_HUMAN_NAME'];?>" type="hidden">
						<div class="panel-body">
							<div class="form-group">
								<input meta_title="" value="<?php echo $widget_datas['WIDGET_TITLE'];?>" placeholder="Titre du widget" class="form-control" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][title]" type="text">
							</div>
							<?php
							foreach($this->data['finalMod'] as $f)
							{
								if($f['WIDGET_NAMESPACE'] == $widget_datas['WIDGET_NAMESPACE'] && $f['MODULE_NAMESPACE'] == $widget_datas['WIDGET_MODNAMESPACE'])
								{
									// Compare parmis les options disponible pour retrouver les parametres correct.
									if(array_key_exists('WIDGET_MORE',$f))
									{
										$cur_module	=	$this->tendoo_admin->getSpeMod($f['MODULE_NAMESPACE'],FALSE);
										if($cur_module)
										{
											$module_dir	=	MODULES_DIR.$cur_module[0]['ENCRYPTED_DIR'];
											if(is_file($module_dir.$f['WIDGET_MORE']))
											{
												include_once($module_dir.$f['WIDGET_MORE']);
												if(class_exists($f['WIDGET_NAMESPACE'].'_'.$f['MODULE_NAMESPACE'].'_moreClass'))
												{
													eval('$WMORE = new '.$f['WIDGET_NAMESPACE'].'_'.$f['MODULE_NAMESPACE'].'_moreClass;');
													if($widget_datas['IS_CODE'] == 1)
													{
														eval($widget_datas['WIDGET_PARAMETERS']);
														$parameters	=	$WIDGET_PARAMS;
													}
													else
													{
														$parameters	=	$widget_datas['WIDGET_PARAMETERS'];
													}
													/*
														$name added to fill "more" input.
													*/
													$hidden_content	=	$WMORE->get($parameters,$zone,$index);
													?>
													<?php echo $hidden_content;?>
													<?php
												}													
											}
										}
									}
								}
							}
							?>
						</div>
					</div>
				</div>
				<?php
				
			}
		}
	}
	class widhandler_common
	{
		public function __construct($data)
		{
			__extends($this);
			$this->data		=&	$data;
		}
		public function getWidgets($zone)
		{
			if(in_array($zone,array('LEFT','RIGHT','BOTTOM')))
			{
				$query	=	$this->db->get('tendoo_widget_administrator_'.strtolower($zone));
				return $widgets	=	$query->result_array();				
			}
			return false;
		}
	}