<li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-puzzle-piece"></i> <span>Blogster</span> </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID']);?>">Accueil</a></li>
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/publish');?>">Créer un article</a></li>
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/category');?>">Gestion des catégories</a></li>
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/category/create');?>">Cr&eacute;er une catégorie</a></li>
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/comments');?>">Gestion des commentaires</a></li>
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/setting');?>">Param&ecirc;tres avanc&eacute;s</a></li>
    </ul>
</li>