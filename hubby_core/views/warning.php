<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->core->hubby->getTitle();?></title>
<?php echo $this->core->file->css_load();?>
</head>

<body style="" cz-shortcut-listen="true">
<section id="content">
    <div class="row m-n">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="text-center m-b-lg">
                <h1 class="h text-white animated bounceInDown" style="font-size:120px">Erreur</h1>
            </div>
            <?php echo $error;?>
            <div class="list-group m-b-sm bg-white m-b-lg"> 
            	<a href="<?php echo $this->core->url->main_url();?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-home"></i> Accueil </a> 
			</div>
        </div>
    </div>
</section>
<!-- footer -->
<?php echo $this->core->file->js_load();?>
<footer id="footer">
</footer>
</body>
</html>