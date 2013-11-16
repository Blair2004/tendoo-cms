<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
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
                    <div class="row">
                    	<div class="col-lg-6">
                        	<header class="panel-heading text-center">
                                Cr&eacute;er un contr&ocirc;leur
                            </header>
                        	<section class="panel">
                                <form method="post" class="panel-body">
                                    <div class="form-group"> 
                                        <label class="control-label">Nom du contr&ocirc;leur</label> 
                                        <input type="text" placeholder="Nom de la page" name="page_name" value="<?php echo $get_pages[0]['PAGE_NAMES'];?>" class="form-control"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Code du contr&ocirc;leur</label> 
                                        <input type="text" placeholder="Code du contr&ocirc;leur" value="<?php echo $get_pages[0]['PAGE_CNAME'];?>" name="page_cname" class="form-control"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Titre du contr&ocirc;leur</label> 
                                        <input type="text" value="<?php echo $get_pages[0]['PAGE_TITLE'];?>" placeholder="D&eacute;signation du contr&ocirc;leur" name="page_title" class="form-control"> 
                                    </div>
                                    <div class="form-group"> 
                                        <label class="control-label">Description du contr&ocirc;leur</label> 
                                        <textarea name="page_description" class="form-control" placeholder="Description de la page"><?php echo $get_pages[0]['PAGE_DESCRIPTION'];?></textarea>
                                    </div>
                                    <div class="form-group"> 
                                        <select class="input-sm form-control inline" name="page_visible">
                                            <option value="">Visibilit&eacute; de la page</option>
                                        <?php
										if($get_pages[0]['PAGE_VISIBLE'] == 'TRUE')
										{
											?>
                                            <option selected="selected" value="TRUE">Visible</option>
                                            <option value="FALSE">Cachée</option>
                                            <?php
										}
										else
										{
											?>
                                            <option value="TRUE">Visible</option>
                                            <option selected="selected" value="FALSE">Cachée</option>
                                            <?php
										}
										?>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <select class="input-sm form-control inline" name="page_module">
                                            <option value="">Affecter un module</option>
                                            <?php
                                            foreach($get_mod as $g) 
                                            {
												if($g['NAMESPACE']	==	$get_pages[0]['PAGE_MODULES'][0]['NAMESPACE'])
                                                {
                                                ?>
                                                <option selected="selected" value="<?php echo $g['NAMESPACE'];?>"><?php echo $g['HUMAN_NAME'];?></option>
                                                <?php
												}
												else 
												{
                                                ?>
                                                <option value="<?php echo $g['NAMESPACE'];?>"><?php echo $g['HUMAN_NAME'];?></option>
                                                <?php
												}
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <select name="page_priority" class="input-sm form-control inline">
                                            <option value="">D&eacute;finir comme principale</option>
                                            <?php
                                            if($get_pages[0]['PAGE_MAIN'] == 'TRUE')
                                            {
                                                ?>
                                            <option selected="selected" value="TRUE">Oui</option>
                                            <option value="FALSE">Non</option>
                                            <?php
											}
											else
											{
												?>
											<option value="TRUE">Oui</option>
											<option selected="selected" value="FALSE">Non</option>
                                                <?php
											}
											?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="page_id" value="<?php echo $get_pages[0]['ID'];?>" />
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
    $field_1	=	(form_error('page_name')) ? form_error('page_name') : 'Ce nom sera affich&eacute; comme indice dans les liens.';
    $field_2	=	(form_error('page_cname')) ? form_error('page_cname') : 'D&eacute;signation disponible dans l\'adresse URL. En un mot. <br>Exemple : '.$this->core->url->main_url().'<strong>nouvelle-page</strong>';
    $field_3	=	(form_error('page_title')) ? form_error('page_title') : 'D&eacute;signe le titre du contr&ocirc;leur.';
    $field_4	=	(form_error('page_module')) ? form_error('page_module') : 'D&eacute;finir le module ex&eacute;cut&eacute; par cette page.';
    $field_5	=	(form_error('page_priority')) ? form_error('page_priority') : 'Cette op&eacute;ration changera le statut des autres pages.';
    $field_6	=	(form_error('page_description')) ? form_error('page_description') : 'Pourra &ecirc;tre utilis&eacute;e par les moteurs de recherche.';
	$field_7	=	(form_error('page_visible')) ? form_error('page_visible') : 'D&eacute;finit si oui ou non le contr&ocirc;leur sera visible sur le menu';
    ?>
    						<section class="panel">
                            	<div class="wrapper">
                            <p style="padding:30px 0;"><?php echo $field_1; ?></p>
                            <p style="padding:20px 0;"><?php echo $field_2; ?></p>
                            <p style="padding:10px 0;"><?php echo $field_3; ?></p>
                            <p style="padding:30px 0;"><?php echo $field_6; ?></p>
                            <p style="padding:7px 0;margin-top:20px;"><?php echo $field_7; ?></p>
                            <p style="padding:7px 0;"><?php echo $field_4; ?></p>
                            <p style="padding:7px 0;"><?php echo $field_5; ?></p>
                            	</div>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>