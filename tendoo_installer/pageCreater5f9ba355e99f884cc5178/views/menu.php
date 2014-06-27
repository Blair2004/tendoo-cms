<li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-puzzle-piece"></i> <span>Page Editor</span> </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID']);?>">Accueil</a></li>
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID'].'/create');?>">Créer une page</a></li>    
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID'].'/page_linker');?>">Li&eacute;er &agrave; un contr&ocirc;leur</a></li>
    </ul>
</li>