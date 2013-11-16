<body cz-shortcut-listen="true">
<header class="header bg-primary"> <p><a href="<?php echo $this->core->url->main_url();?>"><img style="height:30px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->hubby->getVersion();?></a></p></header>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper"> 
    <div class="row">
    	<div class="col-lg-4">
            <div class="col-lg-13">
                <section class="panel">
                    <header class="panel-heading bg bg-success text-center">Connexion etablie</header>
                    <div class="panel-body">
                        <p>Hubby peut maintenant se connecter à votre base de donnée. Maintenant vous devez indiquez certaines inforamtions concernant votre nouveau site web.</p>
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
                <header class="panel-heading bg bg-color-yellow text-center">Information de votre site web</header>
                <form class="panel-body" method="post">
                    <div class="form-group">
                        <label class="host_name">Nom du site</label>
                        <input name="site_name" type="text" placeholder="Nom de votre site" class="form-control">
                    </div>
                    <div class="line line-dashed"></div>
                    <button type="submit" class="btn btn-info">Continuer</button>
                </form>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading bg bg-danger text-center">Information</header>
                <form class="panel-body" method="post">
                    Si vous rencontrez des difficult&eacute;s avec votre site, vous pouvez faire la restauration via l'espace administration.
                </form>
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