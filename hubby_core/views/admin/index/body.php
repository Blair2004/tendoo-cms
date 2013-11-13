<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Administration<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <?php
                    if($options[0]['SHOW_WELCOME'] == 'TRUE')
                    {
                    ?>
                    <p><h2>Bienvenue sur <strong><?php echo $this->core->hubby->getVersion();?></strong>, votre outil de gestion de site web. </h2></p><br /><p style="font-size:15px;line-height:25px;">Faites vos Premiers pas en tant que <a href="#">développeurs</a> ou en tant que <a href="#">simple utilisateur</a>, vous y trouverez un manuel adapt&eacute; &agrave; vos demandes. Si c'est votre premiere connexion, vous pouvez modifier les <a href="<?php echo $this->core->url->site_url('admin/setting');?>">param&ecirc;tres</a> de votre site web</p>
                    <p><h2>Aperçu des fonctionnalit&eacute;s</h2></p>
                    <p style="font-size:15px;line-height:25px;">
                        Hubby vous permet de rapidement cr&eacute;er votre site web, sans avoir n&eacute;cessairement besoin d'un expert. La cr&eacute;ation et la gestion d'un site web ne pourra pas &ecirc;tre plus facile. Si vous d&eacute;butez, <a href="#">vous devez savoir ceci</a>, cependant si vous &ecirc;tes un habitu&eacute; de CMS, ce petit aperçu vous sera utile.
                    </p>
                    <?php
                    }
                    ?>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>