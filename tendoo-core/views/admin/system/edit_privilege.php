<?php echo get_core_vars( 'lmenu' );?>
<section id="content">
    <section class="bigwrapper">
        <?php echo get_core_vars( 'inner_head' );?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/apprendre/le-panneau-de-configuration/comment-modifier-un-privilege" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </header>
            <section class="bigwrapper">
                <section class="wrapper w-f"> 
					<?php echo output('notice');?>
                    
                    <div class="row">
                    	<div class="col-lg-8">
                        	<section class="panel">
                                <header class="panel-heading text-center">
                                    Cr&eacute;er un contr&ocirc;leur
                                </header>
                                <form method="post" class="panel-body">
                                    <div class="form-group">
                                    	<label class="label-control">Nom du privil&egrave;ge</label>
                                        <input value="<?php echo $getPriv[0]['HUMAN_NAME'];?>" class="form-control" type="text" name="priv_name" placeholder="Nom du privil&egrave;ge" title="Nom du privil&egrave;ge"/>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Acc&eacute;ssible au public</label>
                                        <select class="form-control" type="checkbox" name="is_selectable" title="Nom du privil&egrave;ge">
                                        	<option value="">Choisir...</option>
                                        	<option value="0" <?php echo $getPriv[0]['IS_SELECTABLE'] == "0" ? 'selected="selected"' : '' ;?>>Indisponible pour le public</option>
                                            <option value="1" <?php echo $getPriv[0]['IS_SELECTABLE'] == "1" ? 'selected="selected"' : '' ;?>>Disponible pour le public</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Identifiant du privil&egrave;ge</label>
                                        <input class="form-control" type="text" name="priv_encoding" placeholder="Identifiant du privil&egrave;ge" title="Identifiant du privil&egrave;ge" disabled="disabled" value="<?php echo $getPriv[0]['PRIV_ID'];?>"/>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Description du privil&egrave;ge</label>
                                        <textarea class="form-control" name="priv_description" placeholder="Description du privil&egrave;ge" title="Description du privil&egrave;ge"><?php echo $getPriv[0]['DESCRIPTION'];?></textarea>
                                    </div>
                                    <input class="btn <?php echo theme_button_class();?>" type="submit" value="Modifier le privil&egrave;ge" />
                                    <input class="btn btn-danger" type="reset" value="Annuler" />
                                </form>
                            </section>
                        </div>
                        <div class="col-lg-4">
<?php
$field_1	=	(form_error('priv_name')) ? form_error('priv_name') : '';
$field_2	=	(form_error('priv_encoding')) ? form_error('priv_encoding') : '';
$field_3	=	(form_error('priv_description')) ? form_error('priv_description') : '';
?>
    						<section class="panel">
                            	<header class="panel-heading text-center">
                                    Plus d'information
                                </header>
                            	<div class="panel-body">
                                	<p>Un privil&egrave;ge est un grade qui regroupe un certain nombre d'action. Les actions sont syst&egrave;me et commune. Syst&egrave;me en ce sens o&ugrave; certaines actions natives sont d&eacute;j&agrave; pr&eacute;d&eacute;finies, commune en ce sens o&ugrave; certains modules peuvent ajouter des actions au syst&egrave;me. Vous pouvez attribuer &agrave; un privil&egrave;ge des actions syst&egrave;mes et des actions communes. Le syst&egrave;me de privil&egrave;ge permet de r&eacute;guler les activit&eacute;s des administrateurs.<br /><a href="<?php echo $this->instance->url->site_url(array('admin','system','privilege_list'));?>">Administrer les privil&egrave;ges d&eacute;j&agrave; cr&eacute;e ici.</a></p>
                                	<ul>
                                    	<?php if(strlen($field_1) > 0):;?><li><?php echo $field_1; ?></li><?php endif;?>
                                        <?php if(strlen($field_2) > 0):;?><li><?php echo $field_2; ?></li><?php endif;?>
                                        <?php if(strlen($field_3) > 0):;?><li><?php echo $field_3; ?></li><?php endif;?>
                                    </ul>
                            	</div>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>