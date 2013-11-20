<?php echo $menu;?>
    <div class="container">
        <div class="row">
        	<div class="col-lg-6 col-md-offset-3">
				<?php echo validation_errors();?>
	            <?php echo $this->core->notice->parse_notice();?>
            </div>
            <div class="col-lg-6 col-md-offset-3">
                <section class="panel">
                    <header class="panel-heading">Recevoir un mail d'activation</header>
                    <section class="chat-list panel-body">
                    	<form method="post" class="panel-body">
                        	<div class="form-group">
                                <label class="control-label">Email</label>
                                <input name="email_valid" type="text" class="form-control" />
                            </div>
                            <div class="form-group">
                            	<p>Veuillez entrer l'adresse mail du compte pour lequel vous souhaitez recevoir un mail d'activation. Si ce mail est attribu&eacute; &agrave; un compte alors l'envoi du mail d'activation sera effectu&eacute; sans probl&egrave;me.<br />Les mails d'activations ne sont valide que pour 48h, pass&eacute; ce delai, un autre mail d'activation devra &ecirc;tre envoy&eacute; en suivant la m&ecirc;me proc&eacute;dure.</p>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Recevoir le mail d'activation" class="btn btn-primary" />
                            </div>
                        </form>
                    </section>
                </section>
            </div>
        </div>
    </div>
