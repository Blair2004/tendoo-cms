<div class="row m-n"> 
    <div class="col-md-4 col-md-offset-4 m-t-lg"> 
        <section class="panel"> 
            <header class="panel-heading text-center"> <?php echo $pageTitle;?> </header> 
            <form method="POST" class="panel-body"> 
                <div class="form-group"> 
                    <label class="control-label">Pseudo</label> 
                    <input type="text" name="admin_pseudo" placeholder="Pseudo" class="form-control"> 
                    <?php echo form_error('admin_pseudo');?>
                </div> 
                <div class="form-group"> 
                    <label class="control-label">Mot de passe</label> 
                    <input type="password" id="inputPassword" name="admin_password" placeholder="Mot de passe" class="form-control"> 
                    <?php echo form_error('admin_password');?>
                </div> 
                <div class="checkbox"> 
                    <label> 
                        <input type="checkbox" name="stayLoggedIn"> Rester connect&eacute; 
                    </label> 
                </div>
                <button type="submit" class="form-control btn btn-info"><i class="icon-signin"></i>Connexion</button>
                <br>
                <?php
						if($options[0]['ALLOW_REGISTRATION'] == '1')
						{
							?>
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->core->url->site_url(array('registration'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="icon-group text"></i> <span class="text">Cr&eacute;er un nouveau compte</span> <i class="icon-ok text-active"></i></a>
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->core->url->site_url(array('login','recovery'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="icon-share text"></i> <span class="text">R&eacute;cup&eacute;rer un compte</span> <i class="icon-ok text-active"></i></a>
                        <?php
						}
						?>
                <br>
                <?php echo notice_from_url();?>
                <?php echo $this->core->notice->parse_notice();?>
                
            </form> 
        </section> 
    </div> 
</div>