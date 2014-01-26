<?php echo $menu;?>
    <div class="container">
		<?php echo validation_errors();?>
        <?php echo $this->core->notice->parse_notice();?>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <section class="panel">
                    <header class="panel-heading">Changer votre mot de passe</header>
                    <section class="chat-list panel-body">
                    	<form method="post" class="panel-body">
                        	<div class="form-group">
                                <label class="control-label">Nouveau mot de passe</label>
                                <input type="password" name="password_new" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Confirmer le mot de passe</label>
                                <input type="password" name="password_new_confirm" class="form-control" />
                            </div>
                            <div class="form-group">
                            	<p>Votre nouveau mot de passe ne doit pas être identique &agrave; l'ancien.</p>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Lancer la proc&eacute;dure en recup&eacute;ration de mot de passe" class="btn btn-primary" />
                            </div>
                        </form>
                    </section>
                </section>
            </div>
        </div>
    </div>
