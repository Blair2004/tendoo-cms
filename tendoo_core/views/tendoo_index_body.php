<body cz-shortcut-listen="true" id="backgroundLogin">
<section id="content">
    <div class="row m-n">
    	<div class="text-center m-b-lg">
        	<h1 class="h text-white animated bounceInDown" style="font-size:70px"><?php echo $this->core->tendoo->getVersion();?></h1>
        </div>
        <div class="col-sm-8 col-sm-offset-2 animated bounceInLeft">
        	<p><?php echo Tendoo_info('Bienvenue sur tendoo. Si vous voyez cette page, cela signifie que le CMS est présent sur ce domaine, mais pas encore install&eacute;.<br>
            Vous devez proc&eacute;der &agrave; l\'installation afin d\'utiliser toutes les fonctionnalités du CMS.');?>
            </p>
        </div>
		<div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
        <hr class="line line-dashed">
        </div>
        <div class="col-sm-8 col-sm-offset-2 animated bounceInRight">
        	<div class="list-group m-b-sm bg-white m-b-lg"> <a class="list-group-item" href="<?php echo $this->core->url->site_url(array('install'));?>"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> Installation </a> 
            </div>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
</footer>
</body>
<style type="text/css">
    #backgroundLogin{
        background:url(<?php echo img_url($this->core->tendoo->getBackgroundImage());?>) ;
        background-position:0 0;
        background-repeat: no-repeat;
    }
</style>
