<body cz-shortcut-listen="true">
<header class="header bg-primary"> <p><a href="<?php echo $this->core->url->main_url();?>"><img style="height:30px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->hubby->getVersion();?></a></p></header>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper"> 
    <div class="row">
        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-heading bg bg-primary text-center">Bienvenue dans l'installation d'Hubby</header>
                <form method="post" class="panel-body">
                    <span>Cette installation se fera en 3 étapes, vous avez donc au moins 4 minutes pour créer votre site web.</span> <br>
                    <br>
                    <div>
                        <ul>
                            <li style="font-size:12px">Premi&egrave;re &eacute;tape : Information sur la base de donn&eacute;e</li>
                            <li style="font-size:12px">Deuxi&egrave;me &eacute;tape : Nom du site</li>
                            <li style="font-size:12px">Troisi&egrave;me &eacute;tape : Fin de l'installation</li>
                        </ul>
                    </div>
                    <div style="font-size:12px;"> <span>Connectez vous &agrave; l'espace administrateur pour modifier les informations de votre site, cr&eacute;er des administrateurs, installer les th&egrave;mes et modules.</span> </div>
                    <div class="line line-dashed"></div>
                    <input type="submit" class="btn btn-info" value="Continuer" style="float:right;" name="submit">
                </form>
            </section>
        </div>
        <div class="col-lg-3">
            <section class="panel">
                <header class="panel-heading bg bg-danger text-center">Hubby pour appareil mobile</header>
                <div class="panel-body">
                        <span>Hubby offre un espace d'administration qui est compatible avec la plus part des supports mobiles. L'interface intuitif vous permet de g&eacute;rer votre site web depuis un terminal mobile. Cet interface s'apadapte correctement aux dimensions de votre appareil, pour que le plaisir de naviguer sur votre appareil mobile soit identique &agrave; celui ressenti depuis un ordinateur.</span>
                </div>
            </section>
        </div>
        <div class="col-lg-2">
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
                <div action="http://flatfull.com/themes/todo/index.html" class="panel-body">
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