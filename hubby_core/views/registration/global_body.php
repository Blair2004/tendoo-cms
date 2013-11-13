    <body class="metrouicss">
        <div id="header" class="nav-bar" style="background:inherit;">
            <div class="nav-bar-inner padding10">
                <span class="element brand">
                    <img src="<?php echo $this->core->url->img_url("logo_4.png");?>" style="float:left;height:40px;position:relative;top:-10px;">
                    <?php echo $this->core->hubby->getVersion();?>
                </span>
            </div>
        </div> 
        <?php echo $body;?>
        <div class="" id="footer">
            <div class="nav-bar-inner padding10" style="margin-right:20px;float:right">
                <a href="<?php echo $this->core->url->site_url(array('index'));?>"><i class="icon-arrow-right-3" style="font-size:25px;color:white" title="Retour au site"></i></a>
            </div>
        </div>
    </body>
</html>