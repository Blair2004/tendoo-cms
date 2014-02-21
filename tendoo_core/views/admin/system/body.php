<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <div class="wrapper">
                <div class="panel">
                    <div class="panel-heading">
                    	D&eacute;tails sur le syst&egrave;me
                    </div>
                    <div class="wrapper">
                    	<h3>Tendoo CMS <small>Version : <?php echo TENDOO_VERSION;?></small></h3>
                        <br />
                        <p><i>Un cms conçu dans l'optique d'am&eacute;liorer la cr&eacute;ation de site web et d'application web. Exc&egrave;le dans la rapidit&eacute;, l'ergonomie, la prise en main et la maintenance.</i>
                        </p>
                        <br />
                        <h4>Licence</h4>
                        <p>Un bon nombre de produits sont utilisé afin de permettre &ag Tendoo de fonctionner correctement : 
                        	<ul>
	                        	<li>TODO interface administration</li>
    	                        <li>Jquery</li>
                                <li>CK Editor</li>
                                <li>Bootstrap</li>
							</ul>
                        </p>
                        <p><small>Ubber Enterprises 2013. <br />Tous droits reserv&eacute;s.</small></p>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>