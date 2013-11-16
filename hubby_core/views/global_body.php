<body cz-shortcut-listen="true">
    <header class="header bg-primary"> <p><a href="<?php echo $this->core->url->main_url();?>"><img style="height:30px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->core->url->img_url("logo_4.png");?>"> <?php echo $this->core->hubby->getVersion();?></a></p></header>
    <?php echo $body;?>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder clearfix">
            <p> <small><?php echo $this->core->hubby->getVersion();?><br>
                © 2013</small> </p>
        </div>
    </footer>
</body>
</html>