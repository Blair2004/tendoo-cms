<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
		<footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
            	<div class="col-sm-2" id="ajaxLoading">
                </div>
                <div class="col-sm-10 text-right text-center-xs">
                    <button id="controller_form_submiter" class="btn btn-sm btn-primary">Modifier le contr&ocirc;leur</button>
					<input class="btn btn-sm btn-red" value="Annuler" type="reset" />
                </div>
				<script>
					$('#controller_form_submiter').bind('click',function(){
						$('#controller_form').submit();
					});
				</script>
            </div>
        </footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> 
					<?php echo $this->core->notice->parse_notice();?>
                    <?php echo $success;?>
                    <div class="row">
                    	<div class="col-lg-7">
                        	<section class="panel">
								<div class="panel-heading">
									Cr&eacute;er un contr&ocirc;leur
								</div>
                                <form id="controller_form" fjax action="<?php echo $this->core->url->site_url(array('admin','ajax','edit_controller'));?>" method="post" class="panel-body">
								<div class="form-group">
									<div class="row">
									  <div class="col-xs-4">
										<label class="control-label">Nom du contr&ocirc;leur</label> 
										<div class="input-group">
											<input type="text" value="<?php echo $get_pages[0]['PAGE_NAMES'];?>" placeholder="Nom de la page" name="page_name" class="form-control"> 
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="bottom" 
													data-content="<div style='width:200px'>Ce nom sera affiché comme texte dans les liens.</div>" 
													title="" 
													data-original-title="Nom du contrôleur">?</button>
											</span>
										</div>
									  </div>
									  <div class="col-xs-4">
										<label class="control-label">Code du contr&ocirc;leur</label> 
										<div class="input-group">
											<input type="text" value="<?php echo $get_pages[0]['PAGE_CNAME'];?>" placeholder="Code du contr&ocirc;leur" name="page_cname" class="form-control"> 
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="bottom" 
													data-content="<div style='width:250px'>Ce texte sera utilisé dans l'adresse URL. Le mot ne doit pas contenir d'espace ou de caractères spéciaux. les tirets et underscore sont accept&eacute;s. <br>Exemple : <?php echo $this->core->url->main_url();?>index.php/<strong>nouvelle-page</strong> ou <?php echo $this->core->url->main_url();?>index.php/<strong>blog</strong></div>" 
													title="" 
													data-original-title="Code du contrôleur">?</button>
											</span>
										</div>
									  </div>
									  <div class="col-xs-4">
										<label class="control-label">Titre du contr&ocirc;leur</label> 
										<div class="input-group">
											<input type="text" value="<?php echo $get_pages[0]['PAGE_TITLE'];?>" placeholder="D&eacute;signation du contr&ocirc;leur" name="page_title" class="form-control"> 
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="bottom" 
													data-content="<div style='width:250px'>Ce texte sera utilisé dans le titre de la page.</div>" 
													title="" 
													data-original-title="Titre du contrôleur">?</button>
											</span>
										</div>
									  </div>
									</div>
								</div>
                                    <div class="form-group"> 
                                        <label class="control-label">Description du contr&ocirc;leur</label> 
                                        <textarea name="page_description" class="form-control" placeholder="Description de la page"><?php echo $get_pages[0]['PAGE_DESCRIPTION'];?></textarea>
                                    </div>
									<div class="form-group"> 
										<label>Mots cl&eacute;s</label>
                                        <textarea name="page_keywords" class="form-control" placeholder="Mots clés de la page"><?php echo $get_pages[0]['PAGE_KEYWORDS'];?></textarea>
                                    </div>
								<div class="form-group">
									<div class="row">
									  <div class="col-xs-4">
										<label class="control-label">Emplacement du contr&ocirc;leur</label> 
										<div class="input-group">
											<select class="form-control inline" name="page_parent">
												<option value="">Empiler dans </option>
												<option value="none" <?php echo $get_pages[0]['PAGE_PARENT'] == 'none' ? 'selected="selected"' : '';?>>A la racine</option>
												<?php
												foreach($createC as $xc) 
												{
													if($get_pages[0]['ID']	!=	$xc['ID'])
													{
														if($get_pages[0]['PAGE_PARENT'] == $xc['ID'])
														{
														?>
														<option selected="selected" value="<?php echo $xc['ID'];?>"><?php echo $xc['PAGE_NAMES'];?></option>
														<?php
														}
														else
														{
														?>
														<option value="<?php echo $xc['ID'];?>"><?php echo $xc['PAGE_NAMES'];?></option>
														<?php
														}
													}
												}
												?>
											</select>
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'>Modifier l'emplacement d'un contrôleur vous permet de modifier sa position dans le menu. Vous pouvez choisir de l'empiler sous un autre contrôleur, ou de le laisser à la racine du menu principal.</div>" 
													title="" 
													data-original-title="Emplacement du contrôleur">?</button>
											</span>
										</div>
									  </div>
									  <div class="col-xs-4">
										<label class="control-label">Lien vers une page</label> 
										<div class="input-group">
											<input value="<?php echo $get_pages[0]['PAGE_LINK'];?>" name="page_link" class="form-control" placeholder="Lien vers une page" />
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'>Vous pouvez choisir plutôt de créer un menu qui redirigera vers une autre page, au lieu d'exécuter un module. Veuillez entrer le lien vers une page.</div>" 
													title="" 
													data-original-title="Emplacement du contrôleur">?</button>
											</span>
										</div>
									  </div>
									  <div class="col-xs-4">
										<label class="control-label">Visibilit&eacute; sur le menu</label>
										<div class="input-group">
											<select class="form-control inline" name="page_visible">
												<option value="">Visibilit&eacute; de la page</option>
												<?php
											if($get_pages[0]['PAGE_VISIBLE'] == 'TRUE')
											{
												?>
												<option selected="selected" value="TRUE">Visible</option>
												<option value="FALSE">Cachée</option>
												<?php
											}
											else
											{
												?>
												<option value="TRUE">Visible</option>
												<option selected="selected" value="FALSE">Cachée</option>
												<?php
											}
											?>
											</select>
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'>Il s'agit de savoir un lien, donnant accès au contrôleur, peut être disponible sur le menu.</div>" 
													title="" 
													data-original-title="Visibilit&eacute; du contrôleur">?</button>
											</span>
										</div>
									  </div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
                                    <div class="form-group"> 
										<div class="input-group">
											<select class="form-control inline" name="page_module">
												<option value="">Affecter un module</option>
												<option value="#LINK#">Attacher un lien</option>
												<?php
                                            foreach($get_mod as $g) 
                                            {
												if(is_array($get_pages[0]['PAGE_MODULES']))
												{
													if($g['NAMESPACE']	==	$get_pages[0]['PAGE_MODULES'][0]['NAMESPACE'])
													{
													?>
													<option selected="selected" value="<?php echo $g['NAMESPACE'];?>"><?php echo $g['HUMAN_NAME'];?></option>
													<?php
													}
													else
													{
													?>
                                                    <option value="<?php echo $g['NAMESPACE'];?>"><?php echo $g['HUMAN_NAME'];?></option>
                                                    <?php
													}
												}
												else 
												{
                                                ?>
                                                <option value="<?php echo $g['NAMESPACE'];?>"><?php echo $g['HUMAN_NAME'];?></option>
                                                <?php
												}
                                            }
                                            ?>
											</select>
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'>Le contrôleur doit necessairement exécuter un module. Veuillez choisir le module que vous souhaitez faire exécuter dans ce nouveau contrôleur.</div>" 
													title="" 
													data-original-title="Module attach&eacute; au contrôleur">?</button>
											</span>
										</div>
                                    </div>
                                    </div>
									<div class="col-lg-6">
									<div class="form-group"> 
										<div class="input-group">
											<select name="page_priority" class="form-control inline">
												<option value="">D&eacute;finir comme principale</option>
												<?php
												if($get_pages[0]['PAGE_MAIN'] == 'TRUE')
												{
													?>
												<option selected="selected" value="TRUE">Oui</option>
												<option value="FALSE">Non</option>
												<?php
												}
												else
												{
													?>
												<option value="TRUE">Oui</option>
												<option selected="selected" value="FALSE">Non</option>
													<?php
												}
												?>
											</select>
											<span class="input-group-btn">
												<button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'>Il s'agit ici de choisir si ce nouveau contrôleur sera l'index de votre site. En choissisant 'Oui', le statut des autres pages sera modifié.</div>" 
													title="" 
													data-original-title="Définir comme page principale">?</button>
											</span>
											<input type="hidden" name="page_id" value="<?php echo $get_pages[0]['ID'];?>" />
										</div>
                                    </div>
									</div>
								</form>
                            </section>
                        </div>
                        <div class="col-lg-5">
                        	<?php
    $field_1	=	(form_error('page_name')) ;
    $field_2	=	(form_error('page_cname')) ;
    $field_3	=	(form_error('page_title')) ;
    $field_4	=	(form_error('page_module')) ;
    $field_5	=	(form_error('page_priority')) ;
    $field_6	=	(form_error('page_description')) ;
	$field_7	=	(form_error('page_visible')) ;
	$field_8	=	(form_error('page_parent')) ;

    ?>
    						<section class="panel">
								<header class="panel-heading text-center">
									Plus d'information
								</header>
                            	<div class="wrapper" id="controller_creation_error_contener">
                            <p><?php echo $field_1; ?></p>
                            <p><?php echo $field_2; ?></p>
                            <p><?php echo $field_3; ?></p>
                            <p><?php echo $field_6; ?></p>
                            <p><?php echo $field_8; ?></p>
                            <p><?php echo $field_7; ?></p>
                            <p><?php echo $field_4; ?></p>
                            <p><?php echo $field_5; ?></p>
                            	</div>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>
