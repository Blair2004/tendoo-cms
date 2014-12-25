<body cz-shortcut-listen="true" id="backgroundLogin">
<section class="vbox stretch">
    <footer id="footer">
        <div class="text-center padder clearfix">
            <p>
                <small><a href="https://github.com/Blair2004/tendoo-cms"><?php echo get('core_version');?></a> © 2014</small>
            </p>
        </div>
    </footer>
    <img src="<?php echo img_url($this->instance->tendoo->getBackgroundImage());?>" style="width:100%;float:left">
    <section id="content" class="wrapper-md animated fadeInDown scrollable">
        <section class="wrapper">
            <form method="post">
            	<div class="row">
                	<div class="col-lg-8 col-lg-offset-2">
            			<?php echo $installbody;?>
                	</div>
                </div>
            </form>
        </section>
    </section>
</section>
</body>
