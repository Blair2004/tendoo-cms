<aside class="bg-success dker aside-sm nav-vertical" id="nav">
    <section class="vbox bg-primary">
        <header class="bg-black nav-bar"> 
        	<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav"> <i class="icon-reorder"></i> </a> <a href="#" class="nav-brand" data-toggle="fullscreen">Hubby</a> <a class="btn btn-link visible-xs" data-toggle="collapse" data-target=".navbar-collapse"> <i class="icon-comment-alt"></i> </a> </header>
        <section class="w-f"> <!-- nav -->
            <nav class="nav-primary hidden-xs">
            	<?php echo $this->core->hubby_admin->parseMenuBefore();?>
                <ul class="nav">
                    <li> <a href="#"> <i class="icon-eye-open"></i> <span>D&eacute;couvrir</span> </a> </li>
                    <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-bookmark-empty"></i> <span>Contr&ocirc;leur</span> </a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo $this->core->url->site_url('admin/pages/create');?>">Cr&eacute;er un contr&ocirc;leur</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/pages');?>">Tous les contr&ocirc;leurs</a> </li>
                            <!--<li> <a href="http://flatfull.com/themes/todo/icons.html"> <b class="badge pull-right">302</b>Icons </a> </li>-->
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-puzzle-piece"></i> <span>Applications</span> </a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo $this->core->url->site_url('admin/installer');?>">Installer une application</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/modules');?>">Modules install&eacute;es</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url('admin/themes');?>">Th&egrave;mes install&eacute;s</a> </li>
                        </ul>
                    </li>
                    <li> <a href="<?php echo $this->core->url->site_url('admin/setting');?>"> <!--<b class="badge bg-danger pull-right">3</b>--> <i class="icon-cogs"></i> <span>Param&ecirc;tres</span> </a> </li>
                    <?php
					if($this->core->users_global->current('PRIVILEGE') == 'NADIMERPUS')
					{
					?>
                    <li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-tasks"></i> <span>Syst&egrave;me</span> </a> 
                        <ul class="dropdown-menu">
                        	<li> <a href="<?php echo $this->core->url->site_url('admin/system');?>">A propos du syst&egrave;me</a> </li>
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
                    <li> <a href="<?php echo $this->core->url->site_url('index');?>"> <i class="icon-signout"></i> <span>Retour</span> </a> </li>
                </ul>
                <?php $this->core->hubby_admin->parseMenuAfter();?>
            </nav>
            <!-- / nav --> </section>
        <footer class="footer bg-gradient hidden-xs"> <a href="http://localhost" data-toggle="ajaxModal" class="btn btn-sm btn-link m-r-n-xs pull-right"> <i class="icon-off"></i> </a> <a href="https://localhost" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm"> <i class="icon-reorder"></i> </a> </footer>
    </section>
</aside>