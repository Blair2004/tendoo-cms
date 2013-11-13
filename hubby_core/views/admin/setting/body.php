<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Param&ecirc;tres et configurations<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div class="grid">
                        <h2>Configurations</h2>
                        <div>
                        <?php echo validation_errors('<p class="error">', '</p>');?>
                        <?php $this->core->notice->parse_notice();?>
                        <?php echo notice_from_url();?>
                        </div>
                        <br />
                    	<div class="row">
                        	<div class="span4 padding10 bg-color-teal fg-color-white">
                            	<form method="post">
                                    <div class="input-control text">
                                        <h3 class="fg-color-white">Nom du site web</h3>
                                        <input type="text" name="newName">
                                    </div>
                                    <input type="submit" value="Enregistrer" class="bg-color-purple" />
                                </form>
							</div>
                            <div class="span4 padding10 bg-color-greenLight">
                                <form method="post">
                                    <div class="input-control text">
                                        <h3 class="fg-color-white">Lien vers logo</h3>
                                        <input type="text" name="newLogo">
                                    </div>
                                    <input type="submit" value="Enregistrer" />
                                </form>
							</div>
                            <div class="span4 padding10 bg-color-blueDark fg-color-white">
                                <form method="post">
                                    <div class="input-control text">
                                        <h3 class="fg-color-white">D&eacute;finir fuseau horaire</h3>
                                        <select name="newHoraire">
                                            <option value="">Choisir...</option>
                                            <option value='UM12'>(UTC -12:00) Baker/Howland Island</option>
                                            <option value='UM11'>(UTC -11:00) Samoa  Zone, Niue</option>
                                            <option value='UM10'>(UTC -10:00) Hawaii-Aleutian  </option>
                                            <option value='UM95'>(UTC -9:30) Marquesas Islands</option>
                                            <option value='UM9'>(UTC -9:00) Alaska  </option>
                                            <option value='UM8'>(UTC -8:00) Pacifique  </option>
                                            <option value='UM7'>(UTC -7:00) Mountain  </option>
                                            <option value='UM6'>(UTC -6:00) Mexique  </option>
                                            <option value='UM5'>(UTC -5:00) Bogota  </option>
                                            <option value='UM45'>(UTC -4:30) Venezuelan  </option>
                                            <option value='UM4'>(UTC -4:00) Atlantique  </option>
                                            <option value='UM35'>(UTC -3:30) Newfoundland  </option>
                                            <option value='UM3'>(UTC -3:00) Argentina, Brézil</option>
                                            <option value='UM2'>(UTC -2:00) Georgie du sud</option>
                                            <option value='UM1'>(UTC -1:00) Azores, Cape Verde Islands</option>
                                            <option value='UTC' selected='selected'>(UTC) Greenwich Mean </option>
                                            <option value='UP1'>(UTC +1:00) Europe Centrale</option>
                                            <option value='UP2'>(UTC +2:00) Afrique Centrale </option>
                                            <option value='UP3'>(UTC +3:00) Moscou</option>
                                            <option value='UP35'>(UTC +3:30) Iran  </option>
                                            <option value='UP4'>(UTC +4:00) Azerbaijan  </option>
                                            <option value='UP45'>(UTC +4:30) Afghanistan</option>
                                            <option value='UP5'>(UTC +5:00) Pakistan</option>
                                            <option value='UP55'>(UTC +5:30) Inde  </option>
                                            <option value='UP575'>(UTC +5:45) Nepal </option>
                                            <option value='UP6'>(UTC +6:00) Bangladesh  </option>
                                            <option value='UP65'>(UTC +6:30) Cocos Islands, Myanmar</option>
                                            <option value='UP7'>(UTC +7:00) Krasnoyarsk , Cambodia</option>
                                            <option value='UP8'>(UTC +8:00) Autralie de l'ouest</option>
                                            <option value='UP875'>(UTC +8:45) Australie</option>
                                            <option value='UP9'>(UTC +9:00) Japon  </option>
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
                                    <input type="submit" value="Enregistrer" class="bg-color-red" />
                                </form>
                            </div>
                            <div class="span4 padding10 bg-color-greenPureDark fg-color-white">
                                <form method="post">
                                    <div class="input-control text">
                                        <h3 class="fg-color-white">D&eacute;finir format horaire</h3>
                                        <select name="newFormat">
                                            <option value="">Choisir...</option>
                                            <option value="type_1">J m A (29 Juin 2013)</option>
                                            <option value="type_2">J/m/A (29/06/2013)</option>
                                            <option value="type_3">A/m/J (2013/06/29)</option>
                                        </select>
                                    </div>
                                    <input type="submit" value="Enregistrer" class="bg-color-bluePureDark" />
                                </form>
                            </div>
						</div>
					</div>
                    <h2>Param&ecirc;tres</h2>
                    <div class="grid">
                    	<div class="row">
                            <div class="span4">
                                <form method="post">
                                    <div class="padding10 bg-color-yellowPureDark fg-color-white">
                                    	<div class="input-control text">
                                            <h3 class="fg-color-white">Autres param&egrave;tres</h3>
                                            <span style="float:left;min-width:180px;">Afficher le message de bienvenue : </span>	
                                            <?php
                                            $checked	=	($options[0]['SHOW_WELCOME'] == "TRUE") ? 'checked="checked"' : "";
                                            ?>
                                            <input name="show_welcome_msg" type="checkbox" value="TRUE" style="min-width:20px;" <?php echo $checked;?> />
                                            <?php echo $setting_notice_3->parse_notice();?>
										</div>
                                        <input class="bg-color-redPureDark" type="submit" value="Enregistrer les modif." name="other_setting"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>