<aside class="<?php echo theme_class();?> aside-sm nav-vertical" id="nav">
    <section class="vbox">
        <header class="dker nav-bar"> 
        	<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> 
            	<i class="fa fa-reorder"></i> 
			</a> 
            <span href="#" class="nav-brand <?php echo theme_class();?>">
            	<img style="max-height:30px;" src="<?php echo $this->core->url->img_url('logo_minim.png');?>" alt="logo">
            </span> 
            <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> 
            	<i class="fa fa-comment-alt"></i>
			</a> 
		</header>
        <?php
		$redirective	=	urlencode($this->core->url->request_uri());
		?>
		<!-- <?php echo $this->core->url->site_url(array('logoff','tologin?ref='.$redirective));?> TO LOGIN REDIR -->
        <footer class="footer bg-gradient hidden-xs"> 
			<a href="javascript:void(0)" class="showAppTab btn btn-sm pull-right"> 
				<i class="fa fa-th-large"></i> 
			</a> 
			<a href="#nav" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm"> 
				<i class="fa fa-arrows-h"></i> 
			</a> 
		</footer>
        <section>
            <nav class="nav-primary hidden-xs">
                <ul class="nav">
					<?php echo $this->core->tendoo_admin->parseMenuBefore();?>
                    <li class="dropdown-submenu"> <a href="<?php echo $this->url->site_url(array('admin','discover'));?>"> <i class="fa fa-eye"></i> <span>D&eacute;couvrir</span> </a>
						<ul class="dropdown-menu">
                            <li> <a href="<?php echo $this->core->url->site_url('admin/discover/firstSteps');?>">Premiers pas</a> </li>
                        </ul>
					</li>
                    <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bookmark"></i> <span>Contr&ocirc;leurs</span> </a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo $this->core->url->site_url('admin/pages/create');?>">Cr&eacute;er un contr&ocirc;leur</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/pages');?>">Tous les contr&ocirc;leurs</a> </li>
                        </ul>
                    </li>
                    
                    <li class="dropdown-submenu"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-puzzle-piece"></i> <span>Applications</span> </a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo $this->core->url->site_url('admin/installer');?>">Installer une application</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/modules');?>">Modules install&eacute;s</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/themes');?>">Th&egrave;mes install&eacute;s</a> </li>
                            <!--<li> <a href="<?php echo $this->core->url->site_url('admin/tools');?>">Utilitaires</a> </li> -->
                        </ul>
                    </li>
					<li> <a href="<?php echo $this->core->url->site_url('admin/setting');?>"> <!--<b class="badge bg-danger pull-right">3</b>--> <i class="fa fa-cogs"></i> <span>Param&egrave;tres</span> </a> </li>
                    <?php
					if($this->core->users_global->current('PRIVILEGE') == 'NADIMERPUS')
					{
					?>
                    <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-wrench"></i> <span>Syst&egrave;me</span> </a> 
                        <ul class="dropdown-menu">
                        	<li> <a href="<?php echo $this->core->url->site_url('admin/system');?>">&Agrave; propos de Tendoo</a> </li>
                            <li><a href="<?php echo $this->core->url->site_url('admin/system/adminMain');?>">Gestion des utilisateurs</a></li>
                            <li><a href="<?php echo $this->core->url->site_url('admin/system/createAdmin');?>">Cr&eacute;er un utilisateur</a></li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/system/privilege_list');?>">Listes des privil&egrave;ges</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/system/create_privilege');?>">Cr&eacute;er un privil&egrave;ge</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/system/manage_actions');?>">Gestionnaire d'actions</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/system/restore/soft');?>">Restauration souple</a> </li>                            
                        </ul>
                    </li>
                    <?php
					}
					?>
                    <li> <a href="<?php echo $this->core->url->site_url('index');?>"> <i class="fa fa-sign-out"></i> <span>Retour</span> </a> </li>
                    
					<?php $this->core->tendoo_admin->parseMenuAfter();?>
                </ul>
            </nav>
        </section>
    </section>
</aside>