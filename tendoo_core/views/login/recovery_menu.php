    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="fa fa-bar"></span> <span class="fa fa-bar"></span> <span class="fa fa-bar"></span> </button>
            <a class="navbar-brand" href="<?php echo $this->core->url->site_url(array('login','recovery','home'));?>">Syst&egrave;me de r&eacute;cup&eacute;ration des comptes</a> </div>
        
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo $this->core->url->site_url(array('login','recovery','password_lost'));?>">Mot de passe oubli&eacute;</a></li>
                <li><a href="<?php echo $this->core->url->site_url(array('login','recovery','receiveValidation'));?>">Recevoir le mail d'activation</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
