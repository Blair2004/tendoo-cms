<ul class="sideNav">
    <li class="sticker sticker-color-blue" data-role="dropdown"><a href="#"><i class="icon-pencil"></i>Gestionnaire d'article</a>
        <ul class="sub-menu sidebar-dropdown-menu keep-opened light">
            <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID']);?>">Accueil</a></li>
            <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/publish');?>">Créer un article</a></li>
            <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/category');?>">Gestion des catégories</a></li>
            <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/category/create');?>">Cr&eacute;er une catégorie</a></li>
            <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/comments');?>">Gestion des commentaires</a></li>
            <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/setting');?>">Param&ecirc;tres avanc&eacute;s</a></li>
        </ul>
    </li>
</ul>