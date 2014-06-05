<body cz-shortcut-listen="true" id="backgroundLogin">
<section id="content">
    <div class="row m-n">
        <div class="text-center m-b-lg">
            <h1 class="title_logo animated bounceInDown" style="font-size:70px"> <?php echo $this->core->tendoo->getVersion();?> </h1>
            <img class="animated bounceInDown" style="display:compact" src="<?php echo img_url('tendoo_darken.png');?>" alt="<?php echo $this->core->tendoo->getVersion();?>"> </div>
        <div class="col-sm-8 col-sm-offset-2 animated bounceInLeft">
        	<div class="panel">
                <div class="panel-body">
                <i class="fa fa-thumbs-up"></i>
                Bienvenue sur tendoo. Si vous voyez cette page, cela signifie que le CMS est présent sur ce domaine, mais pas encore install&eacute;.<br>
                Vous devez proc&eacute;der &agrave; l'installation afin d'utiliser toutes les fonctionnalités du CMS.
                </div>
            </div>
        </div>
        <div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
            <hr class="line line-dashed">
        </div>
        <div class="col-sm-8 col-sm-offset-2 animated bounceInRight text-center"> <a class="btn btn-lg btn-info" href="<?php echo $this->core->url->site_url(array('install'));?>">Installer Tendoo</a> </div>
        <div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
            <hr class="line line-dashed">
        </div>
    </div>
    </div>
</section>
<!-- footer -->
<footer id="footer"> </footer>
</body>
<style type="text/css">
.title_logo {
	font-size: 170px;
	font-weight: 300;
	background-image: -webkit-linear-gradient(92deg, #000, #CCC);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}
#backgroundLogin {
 background:url(<?php echo img_url($this->core->tendoo->getBackgroundImage());
?>);
	background-position: 0 0;
	background-repeat: no-repeat;
}
</style>
