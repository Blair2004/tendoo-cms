<section id="content" class="m-t-lg wrapper-md animated fadeInDown scrollable wrapper">
    <div class="row">
        <div class="col-lg-4 col-sm-offset-4">
            <div class="list-group m-b-sm bg-white m-b-lg">
                <header class="panel-heading bg bg-color-green text-center">Connexion</header>
                <div class="panel-body">
                    <form method="post" class="panel-body" action="<?php echo $this->instance->url->site_url(array('login?ref='.$redirect));?>">
                        <div class="form-group">
                            <label class="control-label">Pseudo</label>
                            <input type="text" name="admin_pseudo" placeholder="Pseudo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mot de passe</label>
                            <input type="password" name="admin_password" placeholder="Mot de passe" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-info">Connexion</button>
                        <input type="reset" class="btn btn-danger" value="Annuler" />
                        <?php
						if($options[0]['ALLOW_REGISTRATION'] == '1')
						{
							?>
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('registration'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="fa fa-group text"></i> <span class="text">Cr&eacute;er un nouveau compte</span> <i class="fa fa-ok text-active"></i></a>
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login','recovery'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="fa fa-share text"></i> <span class="text">R&eacute;cup&eacute;rer un compte</span> <i class="fa fa-ok text-active"></i></a>
                        <?php
						}
						?>
                    </form>
                    <?php echo fetch_notice_from_url();?>
                    <?php echo form_error('admin_pseudo');?><br />
                    <?php echo form_error('admin_password');?><br />
                    <?php echo output('notice');?> </div>
            </div>
        </div>
    </div>
</section>
