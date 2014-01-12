<?php echo $lmenu;?>

<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
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
					<?php echo $this->core->notice->parse_notice();?> 
					<?php echo $success;?>
                    <?php echo validation_errors('<p class="error">', '</p>');?>
                    <?php echo notice_from_url();?>
                    <section class="panel">
                        <header class="panel-heading bg-light">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#fuseau" data-toggle="tab">Fuseau Horaire</a></li>
                                <li><a href="#sitename" data-toggle="tab">Nom du site</a></li>
                                <li><a href="#logo" data-toggle="tab">Logo</a></li>
                                <li><a href="#dateformat" data-toggle="tab">Format de l'heure</a></li>
                                <li><a href="#otherSetting" data-toggle="tab">Autres param&ecirc;tres</a></li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="fuseau">
                                	<div class="wrapper">
                                    	<form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label">D&eacute;finir fuseau horaire</label>
                                                <?php $default	=	$options[0]['SITE_TIMEZONE'] == '' ? 'UTC' : $options[0]['SITE_TIMEZONE'];?>
                                                <select name="newHoraire" class="input-sm form-control">
                                                <?php $fuso		=	$this->core->hubby->getFuseau();
												foreach($fuso as $f)
												{
													if($options[0]['SITE_TIMEZONE'] == $f['Code'])
													{
													?>
                                                    <option selected="selected" value="<?php echo $f['Code'];?>"><?php echo $f['Index'].' - '.$f['States'];?></option>
                                                    <?php
													}
													else
													{
														?>
                                                    <option value="<?php echo $f['Code'];?>"><?php echo $f['Index'].' - '.$f['States'];?></option>
                                                        <?php
													}
												}
												?>
                                                </select>
                                            </div>
                                            <input class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="sitename">
                                	<div class="wrapper">
                                    	<form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label">Nom du site web</label>
                                                <input type="text" name="newName" class="form-control" value="<?php echo $options[0]['SITE_NAME'];?>">
                                            </div>
                                            <input class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="logo">
                                	<div class="wrapper">
                                    	<form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label">Lien vers logo</label>
                                                <input type="text" name="newLogo" class="form-control">
                                            </div>
                                            <input class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="dateformat">
                                	<div class="wrapper">
                                    	<form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label">D&eacute;finir format horaire</label>
                                                <select name="newFormat" class="input-sm form-control inline">
                                                    <option value="">Choisir...</option>
                                                    <option value="type_1">J m A (29 Juin 2013)</option>
                                                    <option value="type_2">J/m/A (29/06/2013)</option>
                                                    <option value="type_3">A/m/J (2013/06/29)</option>
                                                </select>
                                            </div>
                                            <input class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="otherSetting">
                                	<div class="col-lg-6">
										<?php
                                        $checked	=	($options[0]['SHOW_WELCOME'] == "TRUE") ? 'checked="checked"' : "";
                                        ?>
                                    	<form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="label-control">Afficher le message de bienvenue : <input class="input-control" name="show_welcome_msg" type="checkbox" value="TRUE" style="min-width:20px;" <?php echo $checked;?> /></label>                                                
                                            </div>
                                            <input name="other_setting" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                        <form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="label-control">Modifier le thème du système</label>
                                                <select class="form-control" name="them_style">
                                                	<option value="">Choisir le thème</option>
                                                    <option value="0" <?php if((int)$options[0]['ADMIN_THEME'] == 0): ?> selected="selected"<?php endif;?> >Par d&eacute;faut</option>
                                                    <option value="1" <?php if((int)$options[0]['ADMIN_THEME'] == 1): ?> selected="selected"<?php endif;?>>Bubbles Showcase</option>
                                                </select>
                                            </div>
                                            <input name="them_style_button" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                        <form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="label-control">Afficher les widgets</label>
                                                <p>Il s'agit ici des widgets qui s'afficheront à la d'accueil du panneau de contr&ocirc;le de votre site web.</p>
                                                <?php
												if(is_array($getAppAdminWidgets))
												{
													foreach($getAppAdminWidgets as $wid)
													{
														eval($options[0]['ADMIN_WIDGET_CONFIG']);
														if(isset($ACTIVATED_WIDGET))
														{
															foreach($ACTIVATED_WIDGET as $ac_wid)
															{
																if($ac_wid[0]	==	$wid['MODULE_NAMESPACE'] && $ac_wid[1] == $wid['WIDGET_NAMESPACE'])
																{
														?>
                                                        <div class="input-group">
                                                          <span class="input-group-addon">
                                                            <input checked="checked" type="checkbox" name="validWidget[]" value="<?php echo $wid['MODULE_NAMESPACE'].'/'.$wid['WIDGET_NAMESPACE'];?>" />
                                                          </span>
                                                          <?php
														  $module	=	$this->core->hubby_admin->getSpeModuleByNamespace($wid['MODULE_NAMESPACE']);
														  ?>
                                                          <div class="form-control"><h4><?php echo $wid['WIDGET_HUMAN_NAME'];?> - [<?php echo $module[0]['HUMAN_NAME'];?>]</h4><br /><p><?php echo $wid['WIDGET_DESCRIPTION'];?></p></div>
                                                        </div>
                                                        <?php
																}
																else
																{
																	?>
                                                        <div class="input-group">
                                                          <span class="input-group-addon">
                                                            <input type="checkbox" name="validWidget[]" value="<?php echo $wid['MODULE_NAMESPACE'].'/'.$wid['WIDGET_NAMESPACE'];?>" />
                                                          </span>
                                                          <?php
														  $module	=	$this->core->hubby_admin->getSpeModuleByNamespace($wid['MODULE_NAMESPACE']);
														  ?>
                                                          <div class="form-control"><h4><?php echo $wid['WIDGET_HUMAN_NAME'];?> - [<?php echo $module[0]['HUMAN_NAME'];?>]</h4><br /><p><?php echo $wid['WIDGET_DESCRIPTION'];?></p></div>
                                                        </div>
                                                        <?php
																}
															}
														}
														else
														{
														?>
                                                        <div class="input-group">
                                                          <span class="input-group-addon">
                                                            <input type="checkbox" name="validWidget[]" value="<?php echo $wid['MODULE_NAMESPACE'].'/'.$wid['WIDGET_NAMESPACE'];?>" />
                                                          </span>
                                                          <?php
														  $module	=	$this->core->hubby_admin->getSpeModuleByNamespace($wid['MODULE_NAMESPACE']);
														  ?>
                                                          <div class="form-control"><h4><?php echo $wid['WIDGET_HUMAN_NAME'];?> - [<?php echo $module[0]['HUMAN_NAME'];?>]</h4><br /><p><?php echo $wid['WIDGET_DESCRIPTION'];?></p></div>
                                                        </div>
                                                        <?php
														}
													}
												}
												?>
                                            </div>
                                            <input name="admin_widgets" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                        </div>
                                	<div class="col-lg-6">
                                        <form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="label-control">Autoriser les inscription</label>
                                                <select name="allowRegistration" class="form-control">
                                                	<option value="">Choisir...</option>
                                                    <?php
													if($options[0]['ALLOW_REGISTRATION'] == 0)
													{
														?>
                                                    <option value="1">Oui</option>
                                                    <option selected="selected" value="0">Non</option>
                                                        <?php
													}
													else if($options[0]['ALLOW_REGISTRATION'] == 1)
													{
														?>
                                                    <option selected="selected" value="1">Oui</option>
                                                    <option value="0">Non</option>
                                                        <?php
													}
													else
													{
														?>
                                                    <option value="1">Oui</option>
                                                    <option value="0">Non</option>
                                                        <?php
													}
													?>
                                                </select>
                                            </div>
                                            <input name="autoriseRegistration" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
										<?php
                                        $checked	=	($options[0]['ALLOW_PRIVILEGE_SELECTION'] == "1") ? 'checked="checked"' : "";
                                        ?>
                                        <form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="label-control">Autoriser la selection des privilèges: <input class="input-control" name="allow_priv_selection" type="checkbox" value="1" style="min-width:20px;" <?php echo $checked;?> /></label>                                                <p>Vous avez la possibilité de définir parmis les privilèges que vous avez cr&eacute;e, ceux qui sont disponible d&egrave;s l'inscription par les utilisateurs. N'oubliez pas de choisir parmis les privil&egrave;ges que vous avez cr&eacute;es ceux qui seront acc&eacute;sible au public. </p>
                                            </div>
                                            <input name="allow_priv_selection_button" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                        <form method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="label-control">Ouvrir l'acc&egrave;s &agrave; l'administration aux privil&egrave;ges publics</label>
                                                <p>Il est important de savoir que cette option emp&ecirc;che &agrave; tout utilisateur faitsant partie des privil&egrave;ge ouvert au public, d'acc&eacute;der &agrave; l'espace administration, sans consid&eacute;rer le fait que des actions aient &eacute;t&eacute; ajout&eacute;es aux diff&eacute;rents privil&egrave;ges acc&eacute;ssible au public. Pareillement, lorsqu'un privil&egrave;ge cesse s'&ecirc;tre acc&eacute;ssible au public, tout utilisateur faisant partie de ce privil&egrave;ge pourra d&eacute;sormais acc&eacute;der &agrave; l'espace administration.</p>
                                                <select name="publicPrivAccessAdmin" class="form-control">
                                                	<option value="">Choisir...</option>
                                                    <?php
													if($options[0]['PUBLIC_PRIV_ACCESS_ADMIN'] == 0)
													{
														?>
                                                    <option value="1">Oui</option>
                                                    <option selected="selected" value="0">Non</option>
                                                        <?php
													}
													else if($options[0]['PUBLIC_PRIV_ACCESS_ADMIN'] == 1)
													{
														?>
                                                    <option selected="selected" value="1">Oui</option>
                                                    <option value="0">Non</option>
                                                        <?php
													}
													else
													{
														?>
                                                    <option value="1">Oui</option>
                                                    <option value="0">Non</option>
                                                        <?php
													}
													?>
                                                </select>
                                            </div>
                                            <input name="publicPrivAccessAdmin_button" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>