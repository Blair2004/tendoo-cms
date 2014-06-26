    <div class="container">
        <div class="row">
			<?php echo output('notice');?>
            <?php echo validation_errors();?>
            <div class="col-lg-6 col-lg-offset-3">
                <section class="panel">
                    <header class="panel-heading"><h4>Mot de passe perdu</h4></header>
                    <section class="chat-list panel-body">
                    	<form method="post" class="panel-body">
                        	<div class="form-group">
                                <label class="control-label">Email</label>
                                <input name="email_valid" type="text" class="form-control" />
                            </div>
                            <div class="form-group">
                            	<p>Veuillez entrer l'adresse email du compte pour lequel vous souhaitez restaurer le mot de passe. Le changement de mot de passe n'est valide que pour 3h, pass&eacute; ce delai, une autre proc&eacute;dure de recup&eacute;ration de mot de passe devra &ecirc;tre lanc&eacute;e.</p>
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
