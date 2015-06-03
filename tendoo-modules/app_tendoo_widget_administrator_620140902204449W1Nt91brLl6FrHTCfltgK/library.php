<?php
	class widhandler_lib extends Libraries
	{
		public function __construct()
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			parent::__construct();
			__extends($this);
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$this->instance	=	get_instance();
		}
		public function save_widgets($e)
		{
			$notice	=	array();
			$notice['error']	=	0;
			$notice['success']	=	0;
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
							// var_dump($w_content);
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
							// When there is no used connecte, the one  who creating widget is the super administrator.
							$user_id		=	$this->users_global->isConnected() ? $this->users_global->current('ID') : 1;
							//
							$date						=		$this->instance->date->datetime();
							if($this->db->insert('tendoo_widget_administrator_'.$table,array(
								'WIDGET_TITLE'			=>		$w_content['title'],
								'WIDGET_NAMESPACE'		=>		$w_content['namespace'],
								'WIDGET_MODNAMESPACE'	=>		$w_content['modnamespace'],
								'WIDGET_NAME'		=>		$w_content['name'],
								'WIDGET_ETAT'			=>		1,
								'WIDGET_PARAMETERS'		=>		$line_code,
								'AUTEUR'				=>		$user_id,
								'DATE'					=>		$date,
								'IS_CODE'				=>		$isCode
							)))
							{
								$notice['success']++;
							}
							else
							{
								$notice['error']++;
							}
						}
					}
					else
					{
						$notice['error']++;
					}
				}
				return $notice;
			}
			return 'arrayExpected';
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
					widget-name="<?php echo $widget_datas['WIDGET_NAME'];?>">
					<header class="panel-heading text-center"><ul class="nav nav-pills pull-left"><li><a class="tewi_remover" href="javascript:void(0)"><i class="fa fa-times"></i></a></li></ul><ul class="nav nav-pills pull-right"><li><a class="panel-toggle text-muted active" href="javascript:void(0)"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a></li></ul><?php echo $widget_datas['WIDGET_NAME'];?></header>
					<div widget-hidden_content="" style="display:none">
						<div class="form-group">
							<textarea class="form-control" meta_widgetparams=""></textarea>
						</div>
					</div>
				<div tewi_meta="">
					<input meta_modnamespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][modnamespace]" value="system" type="hidden">
					<input meta_namespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][namespace]" value="texte" type="hidden">
					<input meta_name="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][name]" value="Widget Texte" type="hidden">
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
				$this->data['modules']		=	get_modules( 'filter_active_namespace' , $modnamespace );
				$this->data['finalMod']		=	array();
				if( riake( 'has_widget' , $this->data['modules'] )	==	true)
				{
					$widget_config_file		=	$this->data['modules']['uri_path'].'/config/widget_config.php';
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
				// var_dump($this->data['finalMod']);
				?>
				<div class="panel widget_item" 
					widget="" 
					widget-namespace="<?php echo $widget_datas['WIDGET_NAMESPACE'];?>" 
					widget-modnamespace="<?php echo $modnamespace;?>" 
					widget-name="<?php echo $widget_datas['WIDGET_NAME'];?>">
					<header class="panel-heading text-center"><ul class="nav nav-pills pull-left"><li><a class="tewi_remover" href="javascript:void(0)"><i class="fa fa-times"></i></a></li></ul><ul class="nav nav-pills pull-right"><li><a class="panel-toggle text-muted active" href="javascript:void(0)"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a></li></ul><?php echo $widget_datas['WIDGET_NAME'];?></header>
					<div widget-hidden_content="" style="display:none">
						<div class="form-group">
							<textarea class="form-control" meta_widgetparams=""></textarea>
						</div>
					</div>
					<div tewi_meta="">
						<input meta_modnamespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][modnamespace]" value="<?php echo $widget_datas['WIDGET_MODNAMESPACE'];?>" type="hidden">
						<input meta_namespace="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][namespace]" value="<?php echo $widget_datas['WIDGET_NAMESPACE'];?>" type="hidden">
						<input meta_name="" name="tewi_wid[<?php echo $zone;?>][<?php echo $index;?>][name]" value="<?php echo $widget_datas['WIDGET_NAME'];?>" type="hidden">
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
										$cur_module	=	get_modules( 'filter_active_namespace' , $f['MODULE_NAMESPACE'] );
										if($cur_module)
										{
											$module_dir	=	$cur_module[ 'uri_path' ];
											if(is_file( $module_dir . $f['WIDGET_MORE'] ))
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
	class widhandler_common extends Libraries
	{
		public function __construct($data)
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			parent::__construct();
			__extends($this);
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
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