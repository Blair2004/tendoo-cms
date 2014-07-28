<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo get_page('title');?></title>
<?php echo output('css');?>
</head>

<body cz-shortcut-listen="true" id="backgroundLogin">
<section id="content">
    <div class="row m-n">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="text-center m-b-lg">
                <h1 class="h text-white animated bounceInDown" style="font-size:120px">Erreur</h1>
            </div>
            <?php echo $error;?>
            <div class="list-group m-b-sm bg-white m-b-lg"> 
            	<a href="<?php echo get_instance()->url->main_url();?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> Accueil </a> 
			</div>
        </div>
    </div>
</section>
<!-- footer -->
<?php echo output('js');?>
</body>
<style type="text/css">
    #backgroundLogin{
        background:url(<?php echo img_url(get_instance()->tendoo->getBackgroundImage());?>) ;
        background-position:0 0;
        background-repeat: no-repeat;
    }
</style>
</html>