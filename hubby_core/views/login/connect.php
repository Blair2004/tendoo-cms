<div id="body" class="padding20" style="background:inherit">
	<br>
    <br>
    <br>
    <div class="grid">
        <div class="row">
            <div class="span2 padding10"></div>
            <div class="span2 padding10">
            	<div class="tile" style="vertical-align:middle;">
                	<img src="<?php echo $this->core->url->img_url('start_logo.png');?>" style="width:100%;display:compact;margin-top:18px;">
                </div>
            </div>
            <div class="span4 padding10">
            	<form method="post">
                	<div class="input-control text">
                        <input type="text" name="admin_pseudo" placeholder="Pseudo" />
                    </div>
                    <div class="input-control text">
                        <input type="password" name="admin_password" placeholder="Mot de passe"/>
                    </div>
                    <input type="submit" value="Connexion" />
                    <input type="reset" value="Annuler" />
                </form>
            </div>
            <div class="span4 fg-color-white padding10">
            	<div class="tile bg-color-greenDark double image-slider" data-role="tile-slider" data-param-direction="left" data-param-period="8000" data-param-duration="1000">
                	<div class="tile-content">
	                    <div class="padding10">Besoin de modules et de th&egrave;mes ? connectez-vous au <a href="#" class="fg-color-orange">Store</a> et t&eacute;l&eacute;charger des modules pour votre site web</div>
					</div>
                    <div class="tile-content">
	                    <div class="padding10">Avez-vous la derni&egrave;re version d'Hubby ? connectez-vous au <a href="#" class="fg-color-orange">Store</a> et t&eacute;l&eacute;charger gratuitement la derni&egrave;re version d'Hubby.</div>
					</div>
				</div>
            </div>
        </div>
    </div>
    <div class="grid">
    	<div class="row">
        	<div class="span2 padding10"></div>
            <div class="span10 padding10">
            	<div>
					<?php echo form_error('admin_pseudo');?><br />
					<?php echo form_error('admin_password');?><br />
                    <?php echo $this->core->notice->parse_notice();?>                	
                </div>
            </div>
        </div>
    </div>
</div>