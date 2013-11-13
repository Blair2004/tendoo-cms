<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Gestionnaire des pages<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <h2>Modifier une page</h2>
                <div class="hub_table">
                	<div>    
                    <?php echo $this->core->notice->parse_notice();?>
                    <?php echo $success;?>
                    </div>
                    <br />
                    <div class="grid">
                        <div class="row">
                            <div class="span4">
                                <form method="post">
                                    <div class="input-control text">
                                        <input type="text" name="page_name" placeholder="Nom de la page" value="<?php echo $get_pages[0]['PAGE_NAMES'];?>" />
                                        <button class="btn-clear"></button>
                                    </div>
                                    <div class="input-control text">
                                        <input type="text" name="page_cname" placeholder="Nom du contr&ocirc;leur" value="<?php echo $get_pages[0]['PAGE_CNAME'];?>" />
                                        <button class="btn-clear"></button>
                                    </div>
                                    <div class="input-control text">
                                        <input type="text" name="page_title" placeholder="Titre de la page" value="<?php echo $get_pages[0]['PAGE_TITLE'];?>" />
                                        <button class="btn-clear"></button>
                                    </div>
                                    <div class="input-control select">
                                        <select name="page_module">
                                            <option value="">Affecter un module</option>
                                            <?php
                                            foreach($get_mod as $g) 
                                            {
                                                if($g['NAMESPACE']	==	$get_pages[0]['PAGE_MODULES'][0]['NAMESPACE'])
                                                {
                                                ?>
                                                <option value="<?php echo $g['NAMESPACE'];?>" selected="selected"><?php echo $g['HUMAN_NAME'];?></option>
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
                                    <div class="input-control select">
                                        <select name="page_priority">
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
                                    <div class="input-control textarea">
                                        <textarea name="page_description" placeholder="Description de la page"><?php echo $get_pages[0]['PAGE_DESCRIPTION'];?></textarea>
                                    </div>
                                    <div class="input-control select">
                                        <select name="page_visible">
                                            <option value="">Visibilit&eacute; de la page</option>
                                            <?php
											if($get_pages[0]['PAGE_VISIBLE']== 'TRUE')
											{
												?>
                                            <option value="TRUE" selected="selected">Visible</option>
                                            <option value="FALSE">Cachée</option>
                                                <?php
											}
											else
											{
												?>
                                            <option value="TRUE">Visible</option>
                                            <option value="FALSE" selected="selected">Cachée</option>
                                                <?php	
											}
											?>
                                        </select>
                                    </div>
                                    <input type="submit" value="Cr&eacute;er la page"/>
                                    <input type="reset"  value="Annuler"/>
                                    <input type="hidden" name="page_id" value="<?php echo $get_pages[0]['ID'];?>" />
                                </form>
                            </div>
                            <div class="span8">
    <?php
    $field_1	=	(form_error('page_name')) ? form_error('page_name') : 'Ce nom sera affich&eacute; comme indice dans les liens.';
    $field_2	=	(form_error('page_cname')) ? form_error('page_cname') : 'D&eacute;signation disponible dans l\'adresse URL. En un mot.';
    $field_3	=	(form_error('page_title')) ? form_error('page_title') : 'D&eacute;signe le titre de la page.';
    $field_4	=	(form_error('page_module')) ? form_error('page_module') : 'D&eacute;finir le module ex&eacute;cut&eacute; par cette page.';
    $field_5	=	(form_error('page_priority')) ? form_error('page_priority') : 'Cette op&eacute;ration changera le statut des autres pages.';
    $field_6	=	(form_error('page_description')) ? form_error('page_description') : 'Pourra &ecirc;tre utilis&eacute;e par les moteurs de recherche.';
	$field_7	=	(form_error('page_visible')) ? form_error('page_visible') : 'D&eacute;finit si oui ou non la page sera visible sur le menu';
    ?>
                                <p style="padding:7px 0;"><?php echo $field_1; ?></p>
                                <p style="padding:7px 0;"><?php echo $field_2; ?></p>
                                <p style="padding:7px 0;"><?php echo $field_3; ?></p>
                                <p style="padding:7px 0;"><?php echo $field_4; ?></p>
                                <p style="padding:7px 0;"><?php echo $field_5; ?></p>
                                <p style="padding:7px 0;"><?php echo $field_6; ?></p>
                                <p style="padding:7px 0;margin-top:75px"><?php echo $field_7; ?></p>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
    </div>
</div>