<body cz-shortcut-listen="true" id="backgroundLogin" >
<section class="hbox stretch">
    <section class="vbox">
        <footer id="footer">
            <div class="text-center padder clearfix">
                <p> <small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo get('core_version');?></a> © 2014</small> </p>
            </div>
        </footer>
        <img src="<?php echo img_url($this->instance->tendoo->getBackgroundImage());?>" style="width:100%;float:left">
        <section id="content" class="wrapper-md animated fadeInDown scrollable">
            <section class="wrapper">
                <div class="row m-n">
                    <div class="text-center m-b-lg">
                        <h1 class="title_logo animated bounceInDown" style="font-size:70px"><?php echo get('core_version');?></h1>
                        <img class="animated bounceInDown" style="display:compact" src="<?php echo img_url('tendoo_darken.png');?>" alt="<?php echo get('core_version');?>"></div>
                    <div class="col-sm-8 col-sm-offset-2 animated bounceInLeft">
                        <div class="panel">
                            <div class="panel-body"><p style="text-align:center"><i class="fa fa-thumbs-up"></i> Bienvenue sur tendoo. Si vous voyez cette page, cela signifie que le CMS est présent sur ce domaine, mais pas eninstance install&eacute;.<br>
                                Vous devez proc&eacute;der &agrave; l'installation afin d'utiliser toutes les fonctionnalités du CMS.</p></div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
                        <hr class="line line-dashed">
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 animated bounceInRight text-center"><a class="btn btn-lg btn-info" href="<?php echo $this->instance->url->site_url(array('install'));?>">Installer Tendoo</a></div>
                    <div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
                        <hr class="line line-dashed">
                    </div>
                </div>
            </section>
        </section>
        
        <!-- footer --> 
    </section>
</section>
</body>
</html>