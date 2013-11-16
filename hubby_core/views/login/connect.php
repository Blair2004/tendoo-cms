<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper"> 
    <div class="row">
    	<div class="col-lg-4 col-sm-offset-4">
            <div class="list-group m-b-sm bg-white m-b-lg">
            	<header class="panel-heading bg bg-color-green text-center">Connexion</header>
                <div class="panel-body">
                    <form method="post" class="panel-body">
                        <div class="form-group">
                        	<label class="control-label">Pseudo</label>
                            <input type="text" name="admin_pseudo" placeholder="Pseudo" class="form-control">
                        </div>
                        <div class="form-group">
                        	<label class="control-label">Mot de passe</label>
                            <input type="password" name="admin_password" placeholder="Mot de passe" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-info">Connexion</button>
                        <input type="reset" class="btn btn-info" value="Annuler" />
                    </form>
                    <?php echo form_error('admin_pseudo');?><br />
					<?php echo form_error('admin_password');?><br />
                    <?php echo $this->core->notice->parse_notice();?>     
                </div>
			</div>
        </div>
        <div class="col-lg-4 col-sm-offset-4">
            <div class="list-group m-b-sm bg-white m-b-lg">
            	<header class="panel-heading bg bg-color-red text-center">Soyez &agrave; jour</header>
                <div class="panel-body">
                    <p>Avez-vous la derni&egrave;re version d'Hubby ? connectez-vous au <a href="#" class="fg-color-orange">Store</a> et t&eacute;l&eacute;charger gratuitement la derni&egrave;re version d'Hubby.</p>
                </div>
			</div>
        </div>
        <div class="col-lg-4 col-sm-offset-4">
            <div class="list-group m-b-sm bg-white m-b-lg">
            	<header class="panel-heading bg bg-color-blue text-center">T&eacute;l&eacute;charger des applications</header>
                <div class="panel-body">
                    <p>Besoin de modules et de th&egrave;mes ? connectez-vous au <a href="#" class="fg-color-orange">Store</a> et t&eacute;l&eacute;charger des applications pour votre site web.</p>
                </div>
			</div>
        </div>
    </div>
</section>