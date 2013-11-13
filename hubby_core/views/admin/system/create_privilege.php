<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $pageTitle;?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','system','adminMain'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div class="hub_table">
                        <div class="grid">
                        	<div class="row">
                            	<div>
                                    <h2>C'est quoi un privil&egrave;ge ?</h2>
                                    <p>Est un grade qui regroupe un certain nombre d'action. Les actions sont syst&egrave;me et commune. Syst&egrave;me en ce sens o&ugrave; certaines actions natives sont d&eacute;j&agrave; pr&eacute;d&eacute;finies, commune en ce sens o&ugrave; certains modules peuvent ajouter des actions au syst&egrave;me. Vous pouvez attribuer &agrave; un privil&egrave;ge des actions syst&egrave;mes et des actions communes. Le syst&egrave;me de privil&egrave;ge permet de r&eacute;guler les activit&eacute;s des administrateurs.<br /><br /><a href="<?php echo $this->core->url->site_url(array('admin','system','privilege_list'));?>">Administrer les privil&egrave;ges d&eacute;j&agrave; cr&eacute;e ici.</a></p>
                                </div>
                                <div class="span4 padding10">
                                    <div>
                                        <form method="post">
                                        	<div class="input-control text">
                                            	<input type="text" name="priv_name" placeholder="Nom du privil&egrave;ge" title="Nom du privil&egrave;ge"/>
                                            </div>
                                            <div class="input-control text">
                                            	<input type="text" name="priv_encoding" placeholder="Identifiant du privil&egrave;ge" title="Identifiant du privil&egrave;ge" disabled="disabled" value="<?php echo $privId;?>"/>
                                            </div>
                                            <div class="input-control textarea">
                                            	<textarea name="priv_description" placeholder="Description du privil&egrave;ge" title="Description du privil&egrave;ge"></textarea>
                                            </div>
                                            <input type="submit" value="Cr&eacute;er le privil&egrave;ge" />
                                            <input type="reset" value="Annuler" />
                                        </form>
                                    </div>

                                </div>
                                <div class="span8 padding10">
<?php
$field_1	=	(form_error('priv_name')) ? form_error('priv_name') : 'Nom du privil&egrave;ge.';
$field_2	=	(form_error('priv_encoding')) ? form_error('priv_encoding') : 'Idenfitiant du privil&egrave;ge.';
$field_3	=	(form_error('priv_description')) ? form_error('priv_description') : 'Description du privil&egrave;ge.';
?>
                                    <p style="padding:7px 0;"><?php echo $field_1; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_2; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_3; ?></p>
                                </div>
							</div>
						</div>
						<?php $this->core->notice->parse_notice();?>
                        <?php echo notice_from_url();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>