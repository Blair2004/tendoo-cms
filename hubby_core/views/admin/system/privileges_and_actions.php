<?php echo $lmenu;?>
<section id="content">
<section class="vbox"><?php echo $inner_head;?>
    
    <section class="scrollable" id="pjax-container">
        <header>
            <div class="row b-b m-l-none m-r-none">
                <div class="col-sm-4">
                    <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                    <p class="block text-muted"><?php echo $pageDescription;?></p>
                </div>
            </div>
        </header>
        <section class="vbox">
            <section class="wrapper w-f"> 
            	<div id="appendNoticeHere"></div>
				<?php echo $this->core->notice->parse_notice();?> 
				<?php echo $success;?> 
				<?php echo validation_errors('<p class="error">', '</p>');?> <?php echo notice_from_url();?>
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
								<li class="list-group-item" data-form-name="<?php echo $p['PRIV_ID'];?>">
									<h4 class="panel-heading"><?php echo $p['HUMAN_NAME'];?></h4>
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
											?>">
                                                <a href="#" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestpa']))
											{
												echo ($values['gestpa']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                  <h4 class="list-group-item-heading">Gestion des pages</h4>
                                                  <p class="list-group-item-text">Créer, modifier, suppimer, affecter un module.</p>
                                                </a>
											</li>
											<li data-name="gestapp" data-value="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestapp']))
											{
												echo ($values['gestapp']['REF_ACTION_VALUE'] == 'true') ? 'true'	:	'false';
											}
											else
											{
												echo 'false';
											}
											?>">
												<a href="#" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestapp']))
											{
												echo ($values['gestapp']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                  <h4 class="list-group-item-heading">Installer une application</h4>
                                                  <p class="list-group-item-text">Installation d'application de type module ou th&egrave;me.</p>
                                                </a>
											</li>
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
											?>">
                                            	<a href="#" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestheme']))
											{
												echo ($values['gestheme']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                  <h4 class="list-group-item-heading">Gestion des th&egrave;mes</h4>
                                                  <p class="list-group-item-text">D&eacute;finir un th&egrave;me par d&eacute;faut, d&eacute;installer un th&egrave;me.</p>
                                                </a>
											</li>
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
											?>">
                                            	<a href="#" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestmo']))
											{
												echo ($values['gestmo']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                  <h4 class="list-group-item-heading">Gestion des modules</h4>
                                                  <p class="list-group-item-text">Affichage et suppresion d'un module.</p>
                                                </a>
											</li>
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
											?>">
                                            	<a href="#" class="<?php
											if(array_key_exists('REF_ACTION_VALUE',$values['gestset']))
											{
												echo ($values['gestset']['REF_ACTION_VALUE'] == 'true') ? 'active'	:	'';
											}
											?> list-group-item">
                                                  <h4 class="list-group-item-heading">Gestion des param&egrave;tres</h4>
                                                  <p class="list-group-item-text">Gestion des param&egrave;tres syst&egrave;me.</p>
                                                </a>
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
                                <li class="list-group-item">
                                	<a href="#">Aucun privil&egrave; enregistr&eacute;</a>
                                    <div>Aucun privil&egrave;ge enregistr&eacute;</div>
                                </li>
                                <?php
							}
                            		?>
                        		</ul>
                            </div>
                            <div class="tab-pane" id="profile">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <td width="200">Privil&egrave;</td>
                                            <td>Action</td>
                                            <td>Module</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
									if(count($getModules) > 0)
									{
										foreach($getModules as $g)
										{
											foreach($getPrivileges as $p)
											{
												$action	=	$this->core->hubby_admin->getModuleAction($g['NAMESPACE']);
												if(is_array($action))
												{
													foreach($action as $a)
													{
														
														$values		=	array();
														$values[$a['ACTION']]	=	$this->core->hubby_admin->getValueForPrivNameAndSystem('modules',$a['ACTION'],$p['PRIV_ID']);	
														?>
                                        <tr class="<?php
												if(array_key_exists('REF_ACTION_VALUE',$values[$a['ACTION']]))
												{
													echo ($values[$a['ACTION']]['REF_ACTION_VALUE'] == 'true') ? 'bg-success'	:	'';
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
                                            <td><span data-form-name="<?php echo $p['PRIV_ID'];?>" data-additionnal="<?php echo $g['NAMESPACE'];?>"><?php echo $p['HUMAN_NAME'];?></span></td>
                                            <td><?php echo $a['ACTION_DESCRIPTION'];?></td>
                                            <td><?php echo $a['ACTION_NAME'];?></td>
                                        </tr>
                                        <?php
													}
												}
												else
												{
													?>
                                        <tr>
                                            <td colspan="5"><?php echo $p['HUMAN_NAME'];?> Aucune action enregistré pour ce module. Ce module est ouvert &agrave; tout administrateur.</td>
                                        </tr>
                                        <?php
												}
											}
										}
									}
									else
									{
										?>
                                        <tr>
                                            <td colspan="5">Aucun module installer, aucune action enregistr&eacute;e</td>
                                        </tr>
                                        <?php
									}
									?>
                                    </tbody>
                                </table>
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
            </section>
        </section>
    </section>
    <footer class="footer bg-white b-t">
        <div class="row m-t-sm text-center-xs">
            <div class="col-sm-3">
                <input type="button" class="form-control bg-primary inline update_system_action" value="Mettre &agrave; jour les actions syst&egrave;mes" />
            </div>
            <div class="col-sm-3">
                <input type="button" class="form-control bg-info inline update_common_action" value="Mettre &agrave; jour les actions communes" />
            </div>
        </div>
    </footer>
</section>