<div class="page-sidebar" style="float:left;">
    <ul>
        <li class="sticker sticker-color-red" data-role="dropdown"> <a>Administrateurs</a>
            <ul class="sub-menu light sub-menu">
                <li> </li>
            </ul>
        </li>
        <li class="sticker sticker-color-red" data-role="dropdown"> <a>Privil&egrave;ges et actions</a>
            <ul class="sub-menu light">
                <li> <a href="<?php echo $this->core->url->site_url('admin/system/privilege_list');?>">Listes des privil&egrave;ges</a> </li>
                <li> <a href="<?php echo $this->core->url->site_url('admin/system/create_privilege');?>">Cr&eacute;er un privil&egrave;ge</a> </li>
                <li> <a href="<?php echo $this->core->url->site_url('admin/system/manage_actions');?>">Gestionnaire d'actions</a> </li>
            </ul>
        </li>
        <li class="sticker sticker-color-blue"> <a>Restauration</a>
            <ul class="sub-menu light sub-menu">
            </ul>
        </li>
        <li class="sticker sticker-color-greenDark"> <a href="<?php echo $this->core->url->site_url('index');?>">Retourner au site</a> </li>
    </ul>
</div>
