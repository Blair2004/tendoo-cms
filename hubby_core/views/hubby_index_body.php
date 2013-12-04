<body style="" cz-shortcut-listen="true">
<section id="content">
    <div class="row m-n">
    	<div class="text-center m-b-lg">
        	<h1 class="h text-white animated bounceInDown" style="font-size:70px"><?php echo $this->core->hubby->getVersion();?></h1>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
        	<?php echo hubby_info('Bienvenue sur Hubby. Si vous voyez cette page, cela signifie que le CMS est présent sur ce domaine, mais pas encore install&eacute;.<br>
            Vous devez proc&eacute;der &agrave; l\'installation afin d\'utiliser toutes les fonctionnalités du CMS.');?>
            <div class="list-group m-b-sm bg-white m-b-lg"> <a class="list-group-item" href="<?php echo $this->core->url->site_url(array('install'));?>"> <i class="icon-chevron-right"></i> <i class="icon-home"></i> Installation </a> 
            </div>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
</footer>
</body>
