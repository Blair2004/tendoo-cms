<body cz-shortcut-listen="true">
<header class="header bg-primary"> <p><a href="<?php echo $this->core->url->main_url();?>"><img style="height:30px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->hubby->getVersion();?></a></p></header>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper"> 
    <div class="row">
    	<div class="col-lg-6 col-sm-offset-3">
        	<header class="panel-heading bg bg-color-green text-center">Installation termin&eacute;e</header>
            <div class="panel-body">
            	<p>En d&eacute;cidant de continuer, il ne sera plus possible de d'acc&eacute;der &agrave; cette page d'installation, par cons&eacute;quent de modifier les informations peronnelles de votre site web. En cas d'irr&eacute;gularité dans votre site web, vous ne pourrez faire des modifications qu'&agrave; partir de la <cite><strong>page d'administration</strong></cite>. En ce qui concerne les informations de connexion &agrave; la base de donn&eacute;e, compte tenu de l'importance de ces informations, leurs modifications est impossible. Seul la re-installation du site corrigera le probl&egrave;me.</p>
            </div>
            <div class="list-group m-b-sm bg-white m-b-lg">
            	<form method="post">
                    <button name="admin_access" style="width:100%" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-home"></i> Espace administration </button> 
                    <button name="web_access" style="width:100%" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-home"></i> Index du site </button> 
                </form>
			</div>
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