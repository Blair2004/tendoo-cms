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
                    	<h2>Cr&eacute;er un administrateur</h2>
                        <div class="grid">
                        	<div class="row">
                                <div class="span4 padding10">
                                    <form method="post">
                                        <div class="input-control text">
                                            <input type="text" name="admin_pseudo" placeholder="Pseudo" />
                                            <button class="btn-clear"></button>
                                        </div>
                                        <div class="input-control text">
                                            <input type="password" name="admin_password" placeholder="Mot de passe"/>
                                            <button class="btn-clear"></button>
                                        </div>
                                        <div class="input-control text">
                                            <input type="password" name="admin_password_confirm" placeholder="Confirmer le mot de passe"/>
                                            <button class="btn-clear"></button>
                                        </div>
                                        <div class="input-control text">
                                            <input type="text" name="admin_password_email" placeholder="Email"/>
                                            <button class="btn-clear"></button>
                                        </div>
                                        <div class="input-control text">
                                            <select name="admin_sex">
                                                <option value="">Selection du sexe</option>
                                                <option value="MASC">Masculin</option>
                                                <option value="FEM">Feminin</option>
                                            </select>
                                        </div>
                                        <div class="input-control text">
                                            <select name="admin_privilege">
                                                <option value="">Choisir priv&egrave;ge</option>
                                                <?php
												foreach($getPrivs as $p)
												{
													?>
                                                    <option value="<?php echo $p['PRIV_ID'];?>"><?php echo $p['HUMAN_NAME'];?></option>
                                                    <?php
												}
												?>
                                            </select>
                                        </div>
                                        <input type="submit" value="Cr&eacute;er" />
                                        <input type="reset" value="Annuler" />
                                    </form>
                                </div>
                                <div class="span8 padding10">
<?php
$field_1	=	(form_error('admin_pseudo')) ? form_error('admin_pseudo') : 'Pseudo de l\'administrateur.';
$field_2	=	(form_error('admin_password')) ? form_error('admin_password') : 'Mot de passe de l\'administrateur.';
$field_3	=	(form_error('admin_password_confirm')) ? form_error('admin_password_confirm') : 'Confirmation du mot de passe.';
$field_6	=	(form_error('admin_password_email')) ? form_error('admin_password_email') : 'Email.';
$field_4	=	(form_error('admin_sex')) ? form_error('admin_sex') : '';
$field_5	=	(form_error('admin_privilege')) ? form_error('admin_privilege') : '';
?>
                                    <p style="padding:7px 0;"><?php echo $field_1; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_2; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_3; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_6; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_4; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_5; ?></p>
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