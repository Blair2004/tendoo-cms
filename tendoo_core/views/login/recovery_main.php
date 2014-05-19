    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <section class="panel">
                    <header class="panel-heading"><h4>D&eacute;tails sur le syst&egrave;me de r&eacute;cup&eacute;ration de compte</h4></header>
                    <section class="chat-list panel-body">
                    	<p>Le syst&egrave;me de r&eacute;cup&eacute;ration de compte vous permet de recup&eacute;rer un compte d&eacute;j&agrave; existant, lorsqu'il s'av&egrave;re que : </p>
                        <ul>
                        	<li>Le compte n'est pas encore actif</li>
                            <li>Le mot de passe à été oublié</li>
                        </ul>
                        <p>Utilisez l'option "Recevoir mail d'activation" lorsque vous n'avez jamais été connecté &agrave; votre compte et n'avez pas re&ccedil;u le mail d'activation dans la boite email avec laquelle vous vous &ecirc;tes inscrit, et l'option "Mot de passe oubli&eacute;" lorsque vous ne vous rappellez plus du mot de passe de votre compte.</p>
                        <br />
                        <div class="line line-dashed"></div>
                        <a href="<?php echo $this->core->url->site_url(array('login','recovery','password_lost'));?>" class="btn btn-primary">Mot de passe oubli&eacute;</a>
                        <a href="<?php echo $this->core->url->site_url(array('login','recovery','receiveValidation'));?>" class="btn btn-info">Recevoir mail d'activation</a>
                    </section>
                </section>
            </div>
        </div>
    </div>
