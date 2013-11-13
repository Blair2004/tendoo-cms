<div class="page-sidebar"> <?php echo $this->core->hubby_admin->parseMenuBefore();?>
    <ul>
        <li class="sticker sticker-color-red" data-role="dropdown">
            <a><i class="icon-book"></i>Gestionnaire de pages</a>
            <ul class="sub-menu light sidebar-dropdown-menu">
                <li> <a href="<?php echo $this->core->url->site_url('admin/pages');?>">Liste des pages</a> </li>
                <li> <a href="<?php echo $this->core->url->site_url('admin/pages/create');?>">Cr&eacute;er une page</a> </li>
            </ul>
        </li>
        <li class="sticker sticker-color-green" data-role="dropdown">
        	<a href="<?php echo $this->core->url->site_url('admin/installer');?>"><i class="icon-puzzle"></i>Installer une application</a>
        </li>
        <li class="sticker sticker-color-blue"> 
        	<a href="<?php echo $this->core->url->site_url('admin/modules');?>"><i class="icon-cube"></i>Liste des modules</a> 
		</li>
        <li class="sticker sticker-color-yellow"> <a href="<?php echo $this->core->url->site_url('admin/themes');?>"><i class="icon-html5-2"></i>Liste des th&egrave;mes</a> </li>
        <li class="sticker sticker-color-pinkDark"> <a href="<?php echo $this->core->url->site_url('admin/setting');?>"><i class="icon-wrench"></i>Param. et configurations</a> </li>
        <li class="sticker sticker-color-darken"> <a href="<?php echo $this->core->url->site_url('admin/system');?>"><i class="icon-equalizer"></i>Syst&egrave;me</a> </li>
        <li class="sticker sticker-color-greenDark"> <a href="<?php echo $this->core->url->site_url('index');?>"><i class="icon-exit"></i>Retourner au site</a> </li>
    </ul>
    <?php echo $this->core->hubby_admin->parseMenuAfter();?> </div>
