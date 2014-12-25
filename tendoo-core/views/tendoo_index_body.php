<body cz-shortcut-listen="true" id="backgroundLogin" >
<section class="vbox">
    <section class="scrollable">
        <img src="<?php echo img_url($this->instance->tendoo->getBackgroundImage());?>" style="width:100%;float:left;position:absolute;">
        <section id="content" class="wrapper-md animated fadeInDown scrollable">
            <section class="wrapper">
                <div class="row m-n">
                    <div class="text-center m-b-lg">
                        <h1 class="title_logo animated" style="font-size:70px"><?php echo get('core_version');?></h1>
                        <img class="animated" style="display:compact" src="<?php echo img_url('tendoo_darken.png');?>" alt="<?php echo get('core_version');?>">
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 animated fadeIn">
                        <div class="panel">
                            <div class="panel-body">
                                <p style="text-align:center">
                                    <i class="fa fa-thumbs-up"></i><?php _e( 'Welcome. If you see this, it means that tendoo seems to work correctly on your server. Don\'t waste your time reading this... proceed to installation' );?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
                        <hr class="line line-dashed">
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 animated fadeIn text-center">
                        <a class="btn btn-lg btn-info" href="<?php echo $this->instance->url->site_url(array('install'));?>"><i class="fa fa-rocket"></i> <?php _e( 'Launch installation' );?></a>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 animated bounceInTop">
                        <hr class="line line-dashed">
                    </div>
                </div>
            </section>
        </section>
    </section>
    <footer id="footer">
        <div class="text-center padder clearfix">
            <p>
                <small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo get('core_version');?></a> © 2014</small>
            </p>
        </div>
    </footer>
</section>
</body>
</html>