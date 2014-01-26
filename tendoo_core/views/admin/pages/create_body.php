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
            <section class="vbox">
                <section class="wrapper w-f"> 
					<?php echo $this->core->notice->parse_notice();?>
                    <?php echo $success;?>
                    <div class="row">
                    	<div class="col-lg-6">
                        	<header class="panel-heading text-center">
                                Cr&eacute;er un contr&ocirc;leur
                            </header>
                        	<section class="panel">
                                <form method="post" class="panel-body">
                                    <div class="form-group"> 
                                        <label class="control-label">Nom du contr&ocirc;leur</label> 
                                        <input type="text" placeholder="Nom de la page" name="page_name" class="form-control"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Code du contr&ocirc;leur</label> 
                                        <input type="text" placeholder="Code du contr&ocirc;leur" name="page_cname" class="form-control"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Titre du contr&ocirc;leur</label> 
                                        <input type="text" placeholder="D&eacute;signation du contr&ocirc;leur" name="page_title" class="form-control"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Description du contr&ocirc;leur</label> 
                                        <textarea name="page_description" class="form-control" placeholder="Description de la page"></textarea>
                                    </div>
                                    <div class="form-group"> 
                                    	<label class="control-label">Emplacement du contr&ocirc;leur</label> 
                                        <select class="input-sm form-control inline" name="page_parent">
                                            <option value="">Empiler dans </option>
                                            <option value="none">A la racine</option>
                                            <?php
                                            foreach($createC as $g) 
                                            {
                                                ?>
                                                <option value="<?php echo $g['ID'];?>"><?php echo $g['PAGE_NAMES'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Lien vers une page</label> 
                                        <input name="page_link" class="form-control" placeholder="Lien vers une page" />
                                    </div>
                                    <div class="form-group"> 
                                        <select class="input-sm form-control inline" name="page_visible">
                                            <option value="">Visibilit&eacute; de la page</option>
                                            <option value="TRUE">Visible</option>
                                            <option value="FALSE">Cachée</option>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <select class="input-sm form-control inline" name="page_module">
                                            <option value="">Affecter un module</option>
                                            <option value="#LINK#">Attacher un lien</option>
                                            <?php
                                            foreach($get_mod as $g) 
                                            {
                                                ?>
                                                <option value="<?php echo $g['NAMESPACE'];?>"><?php echo $g['HUMAN_NAME'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <select name="page_priority" class="input-sm form-control inline">
                                            <option value="">D&eacute;finir comme principale</option>
                                            <option value="TRUE">Oui</option>
                                            <option value="FALSE">Non</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-sm btn-primary">Cr&eacute;er le contr&ocirc;leur</button>
                                    <input class="btn btn-sm btn-red" value="Annuler" type="reset" />
                                </form>
                            </section>
                        </div>
                        <div class="col-lg-6">
                        	<header class="panel-heading text-center">
                                Plus d'information
                            </header>
                        	<?php
    $field_1	=	(form_error('page_name')) ? form_error('page_name') : Tendoo_info('Ce nom sera affich&eacute; comme indice dans les liens.');
    $field_2	=	(form_error('page_cname')) ? form_error('page_cname') : Tendoo_info('D&eacute;signation disponible dans l\'adresse URL. En un mot. <br>Exemple : '.$this->core->url->main_url().'index.php/<strong>nouvelle-page</strong>');
    $field_3	=	(form_error('page_title')) ? form_error('page_title') : Tendoo_info('D&eacute;signe le titre du contr&ocirc;leur.');
    $field_4	=	(form_error('page_module')) ? form_error('page_module') : Tendoo_info('D&eacute;finir le module ex&eacute;cut&eacute; par ce contr&ocirc;leur.');
    $field_5	=	(form_error('page_priority')) ? form_error('page_priority') : Tendoo_info('Cette op&eacute;ration changera le statut des autres contr&ocirc;leurs.');
    $field_6	=	(form_error('page_description')) ? form_error('page_description') : Tendoo_info('Pourra &ecirc;tre utilis&eacute;e par les moteurs de recherche.');
	$field_7	=	(form_error('page_visible')) ? form_error('page_visible') : Tendoo_info('D&eacute;finit si oui ou non le contr&ocirc;leur sera visible sur le menu.');
	$field_8	=	(form_error('page_parent')) ? form_error('page_visible') : Tendoo_info('Modifier l\'emplacement d\'un menu vous permet de modifier sa position dans le menu. Vous pouvez choisir de l\'empiler sous un autre menu, ou alors le laisser à la racine du menu');

    ?>
    						<section class="panel">
                            	<div class="wrapper">
                            <p><?php echo $field_1; ?></p>
                            <p><?php echo $field_2; ?></p>
                            <p><?php echo $field_3; ?></p>
                            <p><?php echo $field_6; ?></p>
                            <p><?php echo $field_8; ?></p>
                            <p><?php echo $field_7; ?></p>
                            <p><?php echo $field_4; ?></p>
                            <p><?php echo $field_5; ?></p>
                            	</div>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>