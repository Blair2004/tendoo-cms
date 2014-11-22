<?php echo get_core_vars( 'inner_head' );?>

<section id="content">
<section class="hbox stretch">
    <?php echo get_core_vars( 'lmenu' );?>
    <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted">
                            <?php echo get_page('description');?>
                        </p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/les-privileges-et-les-actions" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i> </a>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f">
                    <?php echo output('notice');?> <?php echo validation_errors('<p class="error">', '</p>');?> <?php echo fetch_error_from_url();?>
                    <section class="panel">
                        <header class="panel-heading bg-light">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#home" data-toggle="tab">Action syst&egrave;me</a></li>
                                <li class=""><a href="#profile" data-toggle="tab">Action communes</a></li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane table-responsive active" id="home">
                                    <ul class="list-group system_action_list" data-role="accordion" style="float:left;width:100%;">
                                        <?php
									if(count($get_roles) > 0)
									{
								foreach($get_roles as $p)
								{
									$values		=	array();
									$values['gestpa']		=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('system','gestpa',$p['PRIV_ID']);	
									$values['toolsaccess']	=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('system','toolsaccess',$p['PRIV_ID']);	
									$values['gestapp']		=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('system','gestapp',$p['PRIV_ID']);	
									$values['gestheme']		=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('system','gestheme',$p['PRIV_ID']);	
									$values['gestmo']		=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('system','gestmo',$p['PRIV_ID']);	
									$values['gestset']		=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('system','gestset',$p['PRIV_ID']);	
							?>
                                        <li class="list-group-item" data-form-name="<?php echo $p['PRIV_ID'];?>">
                                            <h4 class="panel-heading"><?php echo $p['NAME'];?></h4>
                                            <div class="panel-body">
                                                <ul class="nav nav-pills listview fluid">
                                                    <li data-name="gestpa" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestpa']))
											{
												echo ($values['gestpa']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>"> <a href="javascript:void(0)" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestpa']))
											{
												echo ($values['gestpa']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                        <h4 class="list-group-item-heading">Gestion des pages</h4>
                                                        <p class="list-group-item-text">
                                                            Créer, modifier, suppimer, affecter un module.
                                                        </p>
                                                        </a> </li>
                                                    <li data-name="toolsaccess" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['toolsaccess']))
											{
												echo ($values['toolsaccess']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>"> <a href="javascript:void(0)" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['toolsaccess']))
											{
												echo ($values['toolsaccess']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                        <h4 class="list-group-item-heading">Accès aux outils</h4>
                                                        <p class="list-group-item-text">
                                                            Permet d'accéder aux différents outils disponible. Ceci inclu l'affichage des statistiques à la page d'accueil.
                                                        </p>
                                                        </a> </li>
                                                    <li data-name="gestapp" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestapp']))
											{
												echo ($values['gestapp']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>"> <a href="javascript:void(0)" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestapp']))
											{
												echo ($values['gestapp']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                        <h4 class="list-group-item-heading">Installer une application</h4>
                                                        <p class="list-group-item-text">
                                                            Installation d'application de type module ou th&egrave;me.
                                                        </p>
                                                        </a> </li>
                                                    <li class="
											" data-name="gestheme" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestheme']))
											{
												echo ($values['gestheme']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>"> <a href="javascript:void(0)" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestheme']))
											{
												echo ($values['gestheme']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                        <h4 class="list-group-item-heading">Gestion des th&egrave;mes</h4>
                                                        <p class="list-group-item-text">
                                                            D&eacute;finir un th&egrave;me par d&eacute;faut, d&eacute;installer un th&egrave;me.
                                                        </p>
                                                        </a> </li>
                                                    <li class="
											" data-name="gestmo" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestmo']))
											{
												echo ($values['gestmo']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>"> <a href="javascript:void(0)" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestmo']))
											{
												echo ($values['gestmo']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                        <h4 class="list-group-item-heading">Gestion des modules</h4>
                                                        <p class="list-group-item-text">
                                                            Affichage et suppresion d'un module.
                                                        </p>
                                                        </a> </li>
                                                    <?php
											if(false == true)
											{
												?>
                                                    <li class="
											" data-name="gestset" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestset']))
											{
												echo ($values['gestset']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>"> <a href="javascript:void(0)" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestset']))
											{
												echo ($values['gestset']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                        <h4 class="list-group-item-heading">Gestion des param&egrave;tres</h4>
                                                        <p class="list-group-item-text">
                                                            Gestion des param&egrave;tres syst&egrave;me.
                                                        </p>
                                                        </a> </li>
                                                    <?php
											}
											?>
                                                </ul>
                                            </div>
                                        </li>
                                        <?php
								}
							}
									else
									{
								?>
                                        <li class="list-group-item"> <a href="#">Aucun privil&egrave; enregistr&eacute;</a>
                                            <div>
                                                Aucun privil&egrave;ge enregistr&eacute;
                                            </div>
                                        </li>
                                        <?php
							}
                            		?>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="profile">
                                    <div class="common_action_list" >
                                        <?php
                                if(count($getModules) > 0)
                                {
                                    foreach($getModules as $g)
                                    {
                                        ?>
                                        <section class="panel pos-rlt clearfix">
                                            <header class="panel-heading">
                                                <ul class="nav nav-pills pull-right">
                                                    <li> <a href="#" class="panel-toggle text-muted active"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
                                                </ul>
                                                Action du module <strong><?php echo $g['name'];?></strong></header>
                                            <div class="panel-body clearfix collapse">
                                                <?php
                                        foreach($get_roles as $p)
                                        {
                                            $action	=	$this->instance->tendoo_admin->getModuleAction($g['namespace']);
                                            if(is_array($action))
                                            {
                                    ?>
                                                <h4>pour le privil&egrave;ge : <strong><?php echo $p['NAME'];?></strong></h4>
                                                <li class="list-group-item" data-form-name="<?php echo $p['PRIV_ID'];?>" data-additionnal="<?php echo $g['namespace'];?>">
                                                    <ul class="nav nav-pills listview fluid">
                                                        <?php
                                                foreach($action as $a)
                                                {
                                                    $values		=	array();
                                                    $values[$a['ACTION']]	=	$this->instance->tendoo_admin->getValueForPrivNameAndSystem('modules',$a['ACTION'],$p['PRIV_ID']);	
                                                    ?>
                                                        <li data-name="<?php echo $a['ACTION'];?>" data-value="<?php
                                            if(array_key_exists('REF_ACTION_VALUE',$values[$a['ACTION']]))
                                            {
                                                echo ($values[$a['ACTION']]['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
                                            }
                                            else 
                                            {
                                                echo 'false';
                                            }
                                            ?>"> <a href="javascript:void(0)" class="
                                            <?php
                                            if(array_key_exists('REF_ACTION_VALUE',$values[$a['ACTION']]))
                                            {
                                                echo ($values[$a['ACTION']]['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
                                            }
                                            ?> list-group-item">
                                                            <h4><?php echo $a['ACTION_NAME'];?></h4>
                                                            <p>
                                                                <?php echo $a['ACTION_DESCRIPTION'];?>
                                                            </p>
                                                            </a> </li>
                                                        <?php
                                                }
                                                    ?>
                                                    </ul>
                                                </li>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <h5> Aucune action enregistr&eacute;e pour ce module. Ce module est ouvert &agrave; tout administrateur. </h5>
                                                <?php
                                            }
                                        }
                                    ?>
                                            </div>
                                        </section>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <div class="no_common_action">
                                            Aucune module install&eacute;, aucune action enregistr&eacute;e.
                                        </div>
                                        <?php
                                }
                                ?>
                                    </div>
                                    <footer class="footer bg-white b-t">
                                        <div class="row m-t-sm text-center-xs">
                                            <div class="col-sm-4">
                                            </div>
                                            <div class="col-sm-4 text-center">
                                            </div>
                                            <div class="col-sm-4 text-right text-center-xs">
                                                <ul class="pagination pagination-sm m-t-none m-b-none">
                                                    <?php 
                                            if(is_array($paginate[4]))
                                            {
                                                foreach($paginate[4] as $p)
                                                {
                                                    ?>
                                                    <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
                                                    <?php
                                                }
                                            }
                                        ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </div>
                        </div>
                    </section>
                    <script type="text/javascript">
						$(document).ready(function(){
							$('.listview li a').each(function(){
								$(this).bind('click',function(){
									if($(this).hasClass('active'))
									{
										$(this).removeClass('active');
										$(this).closest('li').attr('data-value','false');
									}
									else
									{
										$(this).addClass('active');
										$(this).closest('li').attr('data-value','true');
									}
								});
							});
							var list	=	[];
							$('.update_system_action').bind('click',function(){
								var evaluable	=	'$EVALUABLE	=	array();';
								$('.system_action_list *[data-form-name]').each(function(){
									evaluable += '$EVALUABLE["'+$(this).attr('data-form-name')+'"]	= array();';
									if($(this).find('*[data-value]').length > 0)
									{
										$(this).find('*[data-value]').each(function(){
											evaluable	+=	'$EVALUABLE["'+$(this).closest('*[data-form-name]').attr('data-form-name')+'"]["'+$(this).attr('data-name')+'"]	=	"'+$(this).attr('data-value')+'";';
										});
									}
								});
								$.ajax({
									type	:	'POST',
									timeout	:	20000,
									dataType:	'script',
									data	:	{'QUERY'	:	evaluable},
									success	:	function(data){
										 
									},
									url		:	'<?php echo $this->instance->url->site_url(array('admin','system','ajax_manage_system_actions'));?>'
								});
							});
							$('.update_common_action').bind('click',function(){
								var evaluable	=	'$EVALUABLE	=	array();';
								$('.common_action_list *[data-form-name]').each(function(){
									evaluable += '$EVALUABLE["'+$(this).attr('data-form-name')+'"]["'+$(this).attr('data-additionnal')+'"] = array();';
									if($(this).find('li[data-value]').length > 0)
									{
										$(this).find('li[data-value]').each(function(){
											evaluable	+=	'$EVALUABLE["'+$(this).closest('li[data-form-name]').attr('data-form-name')+'"]["'+$(this).closest('li[data-form-name]').attr('data-additionnal')+'"]["'+$(this).attr('data-name')+'"]	=	"'+$(this).attr('data-value')+'";';
										});
									}
								});
								$.ajax({
									type	:	'POST',
									timeout	:	20000,
									dataType:	'script',
									data	:	{
										'QUERY_2'	:	evaluable
									},
									success	:	function(data){
										 
									},
									url		:	'<?php echo $this->instance->url->site_url(array('admin','system','ajax_manage_common_actions'));?>'
								});
							});
						});
						</script>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-3">
                    <input type="button" class="form-control <?php echo theme_class();?> inline update_system_action" value="Mettre &agrave; jour les actions syst&egrave;me" />
                </div>
                <div class="col-sm-3">
                    <input type="button" class="form-control bg-info inline update_common_action" value="Mettre &agrave; jour les actions communes" />
                </div>
            </div>
        </footer>
    </section>
</section>
