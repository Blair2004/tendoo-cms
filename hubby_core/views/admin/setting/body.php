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
                <section class="scrollable wrapper w-f"> 
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
                                	<div class="wrapper">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav">EEE</a> </section>