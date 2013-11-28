<body cz-shortcut-listen="true">
<header class="header bg-primary"> <p><a href="<?php echo $this->core->url->main_url();?>"><img style="height:30px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->hubby->getVersion();?></a></p></header>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper"> 
    <div class="row">
    	<div class="col-lg-5">
        <div class="col-lg-13">
            <section class="panel">
                <header class="panel-heading bg bg-primary text-center">Connexion &agrave; la base de donn&eacute;es</header>
                <div class="panel-body">
                    Nous allons procéder à la création de votre site web. vous devez spécifier toutes les informations d'accès à la base de données. <br><br>La base de donn&eacute;e que vous devez fournir doit exister. Dans le cas contraire, le site ne pourra &ecirc;tre installé. <br><br>Verifiez que le nom de la base de donn&eacute;e, de l'h&ocirc;te et le mot de passe correspondent &agrave; ceux que vous sp&eacute;cifiez ci-apr&egrave;s.
                </div>
            </section>
        </div>
		<?php 
        $form_response	=	validation_errors('<li>', '</li>');
        ob_start();
        $this->core->notice->parse_notice();
        $query_error	=	strip_tags(ob_get_contents());
        ob_end_clean();
        if($form_response)
        {
            ?>
        <div class="col-lg-13">
            <section class="panel">
                <header class="panel-heading bg bg-color-green text-center">Erreur sur le formulaire</header>
                    <div class="panel-body">
                        <?php echo $form_response;?>
                    </div>
            </section>
        </div>
            <?php
        }
        else if($query_error)
        {
            ?>
        <div class="col-lg-13">
            <section class="panel">
                <header class="panel-heading bg bg-color-red text-center">Erreur sur le formulaire</header>
                    <div class="panel-body">
                        <?php echo $query_error;?>
                    </div>
            </section>
        </div>
            <?php
        }
        ?>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading bg bg-danger text-center">Information de connexion</header>
                <form class="panel-body" method="post">
                    <div class="form-group">
                        <label class="host_name">Identifiant de l'h&ocirc;te</label>
                        <input name="host_name" type="text" placeholder="exemple : localhost" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="user_name">Nom de l'utilisateur</label>
                        <input name="user_name" type="text" placeholder="Nom de l'utilisateur" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="host_password">Mot de passe de l'utilisateur</label>
                        <input name="host_password" type="text" placeholder="Entrez le mot de passe" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="db_name">Nom de la base de donn&eacute;e</label>
                        <input name="db_name" type="text" placeholder="Base de donn&eacute;e" class="form-control">
                    </div>
                    <div class="form-group">
                        <select class="input-sm form-control input-s-sm inline" name="db_type" style="color:#333;background:#FFF;">
                            <option value="" style="color:#333">Type de la base de donn&eacute;e</option>
                            <option value="mysql" style="color:#333">Mysql</option>
                            <option value="mysqli" style="color:#333">Mysql Lite</option>
                            <option value="sqlite" style="color:#333">Sql Lite</option>
                        </select>
                    </div>
                    <div class="line line-dashed"></div>
                    <button type="submit" class="btn btn-info">Continuer</button>
                </form>
            </section>
        </div>
        <div class="col-lg-3">
            <section class="panel">
                <header class="panel-heading bg bg-color-yellow text-center">Hubby Community</header>
                <div action="http://flatfull.com/themes/todo/index.html" class="panel-body">
                    Besoin d'aide et d'assitance ? connectez-vous &agrave; la communaut&eacute; et exposer vos probl&egrave;mes li&eacute; &agrave; l'utilisation du CMS hubby.
                </div>
            </section>
        </div>
        <div class="col-lg-3">
            <section class="panel">
                <header class="panel-heading bg bg-color-green text-center">Hubby e-commerce</header>
                <div class="panel-body">
                    Hubby simplifie votre espace administration et par cons&eacute;quent l'administration des produits que vous souhaitez commercialiser.
                </div>
            </section>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder clearfix">
        <p> <small><?php echo $this->core->hubby->getVersion();?><br>
            © 2013</small> </p>
    </div>
</footer>
</body>
</html>