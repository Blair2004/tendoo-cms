<li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-puzzle-piece"></i> <span>Gestion des widgets</span> </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID']);?>">Accueil</a></li>
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID'].'/create_widget');?>">Créer un widget</a></li>
    </ul>
</li>