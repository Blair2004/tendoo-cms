<body style="" cz-shortcut-listen="true">
<section id="content">
    <div class="row m-n">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="text-center m-b-lg">
                <h1 class="h text-white animated bounceInDown" style="font-size:120px">Erreur</h1>
            </div>
            <?php echo $body;?>
            <div class="list-group m-b-sm bg-white m-b-lg"> 
            	<a href="<?php echo $this->core->url->main_url();?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-home"></i> Accueil </a> 
                <?php
				if($this->core->users_global)
				{
					if($this->core->users_global->isConnected())
					{
						?>
					<a href="<?php echo $this->core->url->site_url(array('account'));?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-user"></i> Mon profil </a> 
						<?php
						if($this->core->users_global->isAdmin())
						{
							?>
						<a href="<?php echo $this->core->url->site_url(array('admin'));?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-dashboard"></i> Espace administration </a> 
							<?php					
						}
					}
					else
					{
						?>
            	<a href="<?php echo $this->core->url->site_url(array('login'));?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-signin"></i> Connexion </a> 
                        <?php
						if($options[0]['ALLOW_REGISTRATION'] == '1')
						{
						?>
                <a href="<?php echo $this->core->url->site_url(array('registration'));?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-group"></i> Inscription </a> 

                        <?php
						}
					}
				}
				else if($this->core->users_global === FALSE)
				{
					?>
            	<a href="<?php echo $this->core->url->site_url(array('install'));?>" class="list-group-item"> <i class="icon-chevron-right"></i> <i class="icon-signin"></i> Installer Hubby </a> 

                    <?php
				}
				?>
			</div>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
</footer>
<?php echo $file->js_load();?>
</body>
</html>