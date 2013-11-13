<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Mon profil<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('index'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
            	<div class="grid">
                	<div class="row">
                    	<div class="span5 padding10 bg-color-purple fg-color-white">
                        	<div class="float_box" style="min-height:305px">
                                <h2 class="fg-color-white">Informations d'identification</h2>
                                <br />
                                <div class="span2">
                                    <p>Nom	:</p>
                                    <p>Pr&eacute;nom	:</p>
                                    <p>Pseudo	:</p>
                                    <p>Sexe	:</p>
                                </div>
                                <div class="span2">
                                    <p><?php echo $this->core->users_global->current('NAME');?></p>
                                    <p><?php echo $this->core->users_global->current('SURNAME');?></p>
                                    <p><?php echo $this->core->users_global->current('PSEUDO');?></p>
                                    <p><?php echo $this->core->users_global->current('SEX');?></p>
                                </div>
							</div>
                            <div class="float_box_100">
                                <i class="icon-user-2" style="font-size:40px;margin-left:5px;bottom:0px;float:right;position:relative;"></i>
                            </div>
                        </div>
                        <div class="span5 padding10 bg-color-orange fg-color-white">
                        	<h2 class="fg-color-white">Informations de contact</h2>
                            <br />
                            <div class="span2">
                                <p>Email	:</p>
                                <p>T&eacute;l.	:</p>
                            </div>
                            <div class="span2">
                                <p><?php echo $this->core->users_global->current('EMAIL');?></p>
                                <p><?php echo $this->core->users_global->current('PHONE');?></p>
                            </div>
                            <div class="float_box_100">
                                <i class="icon-list" style="font-size:40px;margin-left:5px;margin-bottom:0px;float:right;"></i>
                            </div>
                        </div>
                        <div class="span5 padding10 bg-color-greenDark fg-color-white">
                        	<h2 class="fg-color-white">Informations de localisation</h2>
                            <br />
                            <div class="span2">
                                <p>Pays	:</p>
                                <p>Ville	:</p>
                            </div>
                            <div class="span2">
                                <p><?php echo $this->core->users_global->current('STATE');?></p>
                                <p><?php echo $this->core->users_global->current('TOWN');?></p>
                            </div>
                            <div class="float_box_100">
                                <i class="icon-earth" style="font-size:40px;margin-left:5px;margin-bottom:0px;float:right;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>