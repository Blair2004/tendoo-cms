<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $pageTitle;?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','system'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div class="hub_table">
                        <div>
                            <?php echo validation_errors('<p class="error">', '</p>');?>
                            <?php $this->core->notice->parse_notice();?>
                            <?php echo notice_from_url();?>
                        </div>
                        <script type="text/javascript">
						$(document).ready(function(){
							$('.listview li').each(function(){
								$(this).bind('click',function(){
									if($(this).hasClass('selected'))
									{
										$(this).removeClass('selected');
										$(this).attr('data-value','false');
									}
									else
									{
										$(this).addClass('selected');
										$(this).attr('data-value','true');
									}
								});
							});
							var list	=	[];
							$('.update_system_action').bind('click',function(){
								var evaluable	=	'$EVALUABLE	=	array();';
								$('.system_action_list *[data-form-name]').each(function(){
									evaluable += '$EVALUABLE["'+$(this).attr('data-form-name')+'"]	= array();';
									if($(this).find('li[data-value]').length > 0)
									{
										$(this).find('li[data-value]').each(function(){
											evaluable	+=	'$EVALUABLE["'+$(this).closest('li[data-form-name]').attr('data-form-name')+'"]["'+$(this).attr('data-name')+'"]	=	"'+$(this).attr('data-value')+'";';
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
									url		:	'<?php echo $this->core->url->site_url(array('admin','system','ajax_manage_system_actions'));?>'
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
									url		:	'<?php echo $this->core->url->site_url(array('admin','system','ajax_manage_common_actions'));?>'
								});
							});
						});
						</script>
                        <h2>Actions syst&egrave;me</h2>
                        <input type="button" class="update_system_action bg-color-green fg-color-white" value="Mettre &agrave; jour les actions syst&egrave;mes" />
                        <ul class="accordion system_action_list" data-role="accordion" style="float:left;width:100%;">
                        <?php
							if(count($getPrivileges) > 0)
							{
								foreach($getPrivileges as $p)
								{
									$values		=	array();
									$values['gestpa']	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('system','gestpa',$p['PRIV_ID']);	
									$values['gestapp']	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('system','gestapp',$p['PRIV_ID']);	
									$values['gestheme']	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('system','gestheme',$p['PRIV_ID']);	
									$values['gestmo']	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('system','gestmo',$p['PRIV_ID']);	
									$values['gestset']	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('system','gestset',$p['PRIV_ID']);	
							?>
								<li data-form-name="<?php echo $p['PRIV_ID'];?>">
									<a href="#"><?php echo $p['HUMAN_NAME'];?></a>
									<div>
										<ul class="listview fluid">
											<li class="
											<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestpa']))
											{
												echo ($values['gestpa']['REF_ACTION_VALUE'] == 'true') ? 'selected'	:	'';
											}
											?>" data-name="gestpa" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestpa']))
											{
												echo ($values['gestpa']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>">
												<div class="icon">
												   <div class="icon-book" style="font-size:40px;"></div>
												</div>
												<div class="data">
													<h4>Gestion des pages</h4>
													<p>Créer, modifier, suppimer, affecter un module.</p>
												</div>
											</li>
											<li class="
											<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestapp']))
											{
												echo ($values['gestapp']['REF_ACTION_VALUE'] == 'true') ? 'selected'	:	'';
											}
											?>" data-name="gestapp" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestapp']))
											{
												echo ($values['gestapp']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>">
												<div class="icon">
												   <div class="icon-cube" style="font-size:40px;"></div>
												</div>
												<div class="data">
													<h4>Installer une application</h4>
													<p>Installation d'application de type module ou th&egrave;me.</p>
												</div>
											</li>
											<li class="
											<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestheme']))
											{
												echo ($values['gestheme']['REF_ACTION_VALUE'] == 'true') ? 'selected'	:	'';
											}
											?>" data-name="gestheme" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestheme']))
											{
												echo ($values['gestheme']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>">
												<div class="icon">
												   <div class="icon-finder" style="font-size:40px;"></div>
												</div>
												<div class="data">
													<h4>Gestion des th&egrave;mes</h4>
													<p>D&eacute;finir un th&egrave;me par d&eacute;faut, d&eacute;installer un th&egrave;me.</p>
												</div>
											</li>
											<li class="
											<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestmo']))
											{
												echo ($values['gestmo']['REF_ACTION_VALUE'] == 'true') ? 'selected'	:	'';
											}
											?>" data-name="gestmo" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestmo']))
											{
												echo ($values['gestmo']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>">
												<div class="icon">
												   <div class="icon-tab" style="font-size:40px;"></div>
												</div>
												<div class="data">
													<h4>Gestion des modules</h4>
													<p>Affichage et suppresion d'un module</p>
												</div>
											</li>
											<li class="
											<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestset']))
											{
												echo ($values['gestset']['REF_ACTION_VALUE'] == 'true') ? 'selected'	:	'';
											}
											?>" data-name="gestset" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestset']))
											{
												echo ($values['gestset']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>">
												<div class="icon">
												   <div class="icon-equalizer" style="font-size:40px;"></div>
												</div>
												<div class="data">
													<h4>Gestion des param&egrave;tres</h4>
													<p>Gestion des param&egrave;tres syst&egrave;me.</p>
												</div>
											</li>
										</ul>
									</div>
								</li>
							<?php
								}
							}
							else
							{
								?>
                                <li>
                                	<a href="#">Aucun privil&egrave; enregistr&eacute;</a>
                                    <div>Aucun privil&egrave;ge enregistr&eacute;</div>
                                </li>
                                <?php
							}
                            ?>
                        </ul>
                        <h2>Actions commune</h2>
                        <input type="button" class="update_common_action bg-color-green fg-color-white" value="Mettre &agrave; jour les actions communes" />
                        <div class="grid common_action_list">
                            <div class="row">
                            	
								<?php
								if(count($getModules) > 0)
								{
									foreach($getModules as $g)
									{
										?>
									<h3>Privil&egrave;ges et actions pour le module : <?php echo $g['HUMAN_NAME'];?></h3>
									<ul class="accordion" data-role="accordion">
										<?php
										foreach($getPrivileges as $p)
										{
											$action	=	$this->core->hubby_admin->getModuleAction($g['NAMESPACE']);
											if(is_array($action))
											{
									?>
										<li data-form-name="<?php echo $p['PRIV_ID'];?>" data-additionnal="<?php echo $g['NAMESPACE'];?>">
											<a href="#"><?php echo $p['HUMAN_NAME'];?></a>
											<div>
												<ul class="listview fluid">
													<?php
												foreach($action as $a)
												{
													$values		=	array();
													$values[$a['ACTION']]	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('modules',$a['ACTION'],$p['PRIV_ID']);	
													?>
													<li class="
											<?php
											if(array_key_exists('REF_ACTION_VALUE',$values[$a['ACTION']]))
											{
												echo ($values[$a['ACTION']]['REF_ACTION_VALUE'] == 'true') ? 'selected'	:	'';
											}
											?>" data-name="<?php echo $a['ACTION'];?>" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values[$a['ACTION']]))
											{
												echo ($values[$a['ACTION']]['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else 
											{
												echo 'false';
											}
											?>">
														<div class="icon">
														   <div class="icon-plus" style="font-size:40px;"></div>
														</div>
														<div class="data">
															<h4><?php echo $a['ACTION_NAME'];?></h4>
															<p><?php echo $a['ACTION_DESCRIPTION'];?></p>
														</div>
													</li>
													<?php
												}
													?>                                                
												</ul>
											</div>
										</li>
									<?php
											}
											else
											{
												?>
										<li>
											<a href="#"><?php echo $p['HUMAN_NAME'];?></a>
											<div>
												Aucune action enregistré pour ce module. Ce module est ouvert &agrave; tout administrateur.
											</div>
										</li>
												<?php
											}
										}
									}
								}
								else
								{
									?>
                                    <div class="no_common_action">Aucune module install&eacute;, aucune action enregistr&eacute;e.</div>
                                    <?php
								}
                                ?>
                                </ul>
                                <div class="span12">
                                    <div>Page :
                                    <?php
                                    if(is_array($paginate[4]))
                                    {
                                        foreach($paginate[4] as $p)
                                        {
                                        ?>
                                        <input style="min-width:20px;width:auto;padding:4px;" class="<?php echo $p['state'];?>" type="button" value="<?php echo $p['text'];?>" button_ref="<?php echo $p['link'];?>" />
                                        <?php
                                        }
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>