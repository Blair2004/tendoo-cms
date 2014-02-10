<body cz-shortcut-listen="true" id="backgroundLogin">    
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp"> 
        <a class="nav-brand" href="<?php echo $this->core->url->main_url();?>"><h3><img style="max-height:80px;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> </h3></a>
        <?php echo $body;?>
         
    </section>
    <!-- footer -->
     <footer id="footer"> <div class="text-center padder clearfix"> <p> <small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo $this->core->tendoo->getVersion();?></a><br>
                © 2014</small> </p>
        </div>
    </footer>
</body>
<style type="text/css">
    #backgroundLogin{
        background-image:url(<?php echo $this->core->tendoo->sochaBackground();?>) ;
        background-position:0 0;
        background-repeat: no-repeat;
            
    }
</style>
</html>