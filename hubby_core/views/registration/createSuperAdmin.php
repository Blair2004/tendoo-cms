<div id="body" class="padding20" style="background:inherit">
	<br>
    <br>
    <br>
    <div class="grid">
        <div class="row">
            <div class="span2 padding10"></div>
            <div class="span2 padding10">
            	<div class="tile" style="vertical-align:middle;">
                	<img src="<?php echo $this->core->url->img_url('start_logo.png');?>" style="width:100%;display:compact;margin-top:18px;">
                </div>
            </div>
            <div class="span4 padding10">
            	<form method="post">
                	<div class="input-control text">
                        <input type="text" name="super_admin_pseudo" placeholder="Pseudo" />
                        <button class="btn-clear"></button>
                    </div>
                    <div class="input-control password">
                        <input type="password" name="super_admin_password" placeholder="Mot de passe"/>
                        <button class="btn-reveal"></button>
                    </div>
                    <div class="input-control password">
                        <input type="password" name="super_admin_password_confirm" placeholder="Confirmer le mot de passe"/>
                        <button class="btn-reveal"></button>
                    </div>
                    <div class="input-control text">
                        <input type="text" name="super_admin_mail" placeholder="Email"/>
                    </div>
                    <div class="input-control select">
                        <select name="super_admin_sex" laceholder="Selection du sexe">
                        	<option value="">Selection du sexe</option>
                            <option value="MASC">Masculin</option>
                            <option value="FEM">Feminin</option>
                        </select>
                    </div>
                    <input type="submit" value="Cr&eacute;er" />
                    <input type="reset" value="Annuler" />
                </form>
            </div>
            <div class="span7 fg-color-white padding10">
<?php
$field_1	=	(form_error('super_admin_pseudo')) ? form_error('super_admin_pseudo') : '';
$field_2	=	(form_error('super_admin_password')) ? form_error('super_admin_password') : '';
$field_3	=	(form_error('super_admin_password_confirm')) ? form_error('super_admin_password_confirm') : '';
;
$field_4	=	(form_error('super_admin_mail')) ? form_error('super_admin_mail') : '';
$field_5	=	(form_error('super_admin_sex')) ? form_error('super_admin_sex') : '';
;
?>
                <p style="padding:7px 0;"><?php echo $field_1; ?></p>
                <p style="padding:7px 0;"><?php echo $field_2; ?></p>
                <p style="padding:7px 0;"><?php echo $field_3; ?></p>
                <p style="padding:7px 0;"><?php echo $field_4; ?></p>
                <p style="padding:7px 0;"><?php echo $field_5; ?></p>
                
			</div>
       </div>
    </div>
</div>