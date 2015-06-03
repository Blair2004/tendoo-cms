<li class="dropdown-submenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-puzzle-piece"></i> <span><?php echo $module[0]['NAME'];?></span> </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID']);?>">Accueil</a></li>
        <li><a href="<?php echo $this->instance->url->site_url('admin/open/modules/'.$module[0]['ID'].'/setting');?>">Param&ecirc;tres</a></li>
    </ul>
</li>