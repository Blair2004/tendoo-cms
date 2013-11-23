<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> 
				<?php echo $this->core->notice->parse_notice();?> 
				<?php echo $success;?>
                	<div class="panel">
                    	<div class="panel-heading">
                        	A propos de MODUS
                        </div>
                        <div class="panel-body">
                        MODUS est un th&egrave;me cr&eacute;e par Luiszuno, disponible a cette adresse <a href="http://luiszuno.com/themes/modus/">MODUS</a>. <br /><br />Ce thème qui s'adapte perfaitement aux dimensions des appareils offre un interface professionnel et une navigation aisée.<br />Il est fournie avec plusieurs éléments :
                        <br />
                        <br />
                        <ul>
                        	<li>Caroussel</li>
                            <li>Boites modales</li>
                            <li>Icones</li>
                            <li>Plugin de validation des formulaires</li>
                            <li>Accordions</li>
                            <li>Syst&egrave;me tabs</li>
                            <li>Liens vers les réseaux sociaux</li>
                        </ul>
                        </div>
                    </div>
                </section>
            </section>
        </section>
	</section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
