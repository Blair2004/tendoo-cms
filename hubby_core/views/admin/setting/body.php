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
                                    	<form action="#fuseau" method="post" class="panel-body">
                                            <div class="form-group">
                                                <label class="control-label">D&eacute;finir fuseau horaire</label>
                                                <select class="input-sm form-control inline" name="newHoraire">
                                                    <option value="">Choisir...</option>
                                                    <option value='UM12'>(UTC -12:00) Baker/Howland Island</option>
                                                    <option value='UM11'>(UTC -11:00) Samoa  Zone, Niue</option>
                                                    <option value='UM10'>(UTC -10:00) Hawaii-Aleutian </option>
                                                    <option value='UM95'>(UTC -9:30) Marquesas Islands</option>
                                                    <option value='UM9'>(UTC -9:00) Alaska </option>
                                                    <option value='UM8'>(UTC -8:00) Pacifique </option>
                                                    <option value='UM7'>(UTC -7:00) Mountain </option>
                                                    <option value='UM6'>(UTC -6:00) Mexique </option>
                                                    <option value='UM5'>(UTC -5:00) Bogota </option>
                                                    <option value='UM45'>(UTC -4:30) Venezuelan </option>
                                                    <option value='UM4'>(UTC -4:00) Atlantique </option>
                                                    <option value='UM35'>(UTC -3:30) Newfoundland </option>
                                                    <option value='UM3'>(UTC -3:00) Argentina, Brézil</option>
                                                    <option value='UM2'>(UTC -2:00) Georgie du sud</option>
                                                    <option value='UM1'>(UTC -1:00) Azores, Cape Verde Islands</option>
                                                    <option value='UTC' selected='selected'>(UTC) Greenwich Mean </option>
                                                    <option value='UP1'>(UTC +1:00) Europe Centrale</option>
                                                    <option value='UP2'>(UTC +2:00) Afrique Centrale </option>
                                                    <option value='UP3'>(UTC +3:00) Moscou</option>
                                                    <option value='UP35'>(UTC +3:30) Iran </option>
                                                    <option value='UP4'>(UTC +4:00) Azerbaijan </option>
                                                    <option value='UP45'>(UTC +4:30) Afghanistan</option>
                                                    <option value='UP5'>(UTC +5:00) Pakistan</option>
                                                    <option value='UP55'>(UTC +5:30) Inde </option>
                                                    <option value='UP575'>(UTC +5:45) Nepal </option>
                                                    <option value='UP6'>(UTC +6:00) Bangladesh </option>
                                                    <option value='UP65'>(UTC +6:30) Cocos Islands, Myanmar</option>
                                                    <option value='UP7'>(UTC +7:00) Krasnoyarsk , Cambodia</option>
                                                    <option value='UP8'>(UTC +8:00) Autralie de l'ouest</option>
                                                    <option value='UP875'>(UTC +8:45) Australie</option>
                                                    <option value='UP9'>(UTC +9:00) Japon </option>
                                                    <option value='UP95'>(UTC +9:30) Australian Centrale </option>
                                                    <option value='UP10'>(UTC +10:00) Australian Est</option>
                                                    <option value='UP105'>(UTC +10:30) Lord Howe Ile</option>
                                                    <option value='UP11'>(UTC +11:00) Magadan </option>
                                                    <option value='UP115'>(UTC +11:30) Norfolk Iles</option>
                                                    <option value='UP12'>(UTC +12:00) Fiji, Gilbert Iles</option>
                                                    <option value='UP1275'>(UTC +12:45) Chatham Islands</option>
                                                    <option value='UP13'>(UTC +13:00) Phoenix Iles , Tonga</option>
                                                    <option value='UP14'>(UTC +14:00) Line Iles</option>
                                                </select>
                                            </div>
                                            <input class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane" id="sitename">
                                	<div class="wrapper">
                                    	<form method="post" class="panel-body" action="#sitename">
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
                                    	<form method="post" class="panel-body" action="#logo">
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
                                    	<form method="post" class="panel-body" action="#dateformat">
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