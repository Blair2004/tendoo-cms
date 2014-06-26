<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
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
                        <p><i>Un cms conçu dans l'optique d'am&eacute;liorer et de simplifier la cr&eacute;ation de site web et d'application web. Exc&egrave;le dans la rapidit&eacute;, l'ergonomie, la prise en main et la maintenance.</i>
                        </p>
                        <br />
                        <h4>Licence</h4>
                        <p>Liste des outils utilisés sur Tendoo : 
                        	<ul>
	                        	<li>TODO interface administration 1.2.1 (2014)</li>
    	                        <li>Jquery</li>
                                <li>CK Editor</li>
                                <li>Bootstrap (3.1)</li>
								<li><a href="https://github.com/dbushell/Nestable">Nestable</a> Jquery plugin</li>
                                <li>Jquery Ui</li>
							</ul>
                        </p>
                        <p><small>Ubber Enterprises 2014. <br />Tous droits reserv&eacute;s.</small></p>
                    </div>
                </div>
            </div>
        </section>
    </section>
</section>