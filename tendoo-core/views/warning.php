<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo get_page('title');?></title>
<?php echo output('css');?>
</head>
<body cz-shortcut-listen="true" id="backgroundLogin">
<section class="vbox">
    <section class="wrapper">
        <section class="scrollable">
            <img src="<?php echo img_url(get_instance()->tendoo->getBackgroundImage());?>" style="width:100%;float:left">
            <section id="content">
                <div class="row m-n">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="text-center m-b-lg">
                            <h1 class="h text-white animated bounceInDown" style="font-size:120px">Erreur</h1>
                        </div>
                        <?php echo $error;?>
                        <div class="list-group m-b-sm bg-white m-b-lg">
                            <a href="<?php echo get_instance()->url->main_url();?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> Accueil </a>
                            <?php
                            if( current_user()->isConnected() )
                            {
                                if(get_instance()->users_global->isConnected())
                                {
                                    ?>
                            <a href="<?php echo get_instance()->url->site_url(array('account'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-user"></i> Mon profil </a>
                            <?php
                                    if(get_instance()->users_global->isAdmin())
                                    {
                                        ?>
                            <a href="<?php echo get_instance()->url->site_url(array('admin'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-dashboard"></i> Espace administration </a>
                            <?php					
                                    }
                                }
                                else
                                {
                                    ?>
                            <a href="<?php echo get_instance()->url->site_url(array('login'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-signin"></i> Connexion </a>
                            <?php
                                    if($options[0]['ALLOW_REGISTRATION'] == '1')
                                    {
                                    ?>
                            <a href="<?php echo get_instance()->url->site_url(array('registration'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-group"></i> Inscription </a>
                            <?php
                                    }
                                }
                            }
                            else if(get_instance()->users_global === FALSE)
                            {
                                ?>
                            <a href="<?php echo get_instance()->url->site_url(array('install'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-signin"></i> Installer Tendoo </a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <footer id="footer">
            <div class="text-center padder clearfix">
                <p>
                    <small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo get('core_version');?></a> © 2014</small>
                </p>
            </div>
        </footer>
        <?php echo output('js');?>
    </section>
</section>
</body>
</html>