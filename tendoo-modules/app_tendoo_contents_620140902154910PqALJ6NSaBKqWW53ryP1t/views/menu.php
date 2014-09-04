<?php
$opened_module	=	$opened_module[0];
?>
<li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-puzzle-piece"></i> <span>Gest. de contenu</span> </a>
    <ul class="dropdown-menu">    
        <li><a href="#"><strong>Gestionnaire de contenu</strong></a></li>
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$opened_module['ID']);?>">Liste des fichiers</a></li>
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$opened_module['ID'].'/upload');?>">Ajouter un fichier</a></li>
    </ul>
</li>