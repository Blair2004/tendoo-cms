<li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-puzzle-piece"></i> <span><?php echo $module[0]['HUMAN_NAME'];?></span> </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID']);?>">Accueil</a></li>
        <li><a href="<?php echo $this->core->url->site_url('admin/open/modules/'.$module[0]['ID'].'/create_widget');?>">Créer un widget</a></li>
    </ul>
</li>