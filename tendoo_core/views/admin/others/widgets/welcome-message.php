<?php
if(in_array($this->users_global->current('SHOW_WELCOME'),array('1','TRUE')))
{
?>
    <div class="panel">
        <div class="panel-body">
            <div class="carousel slide auto" id="c-slide">
                <ol class="carousel-indicators out" style="bottom:10px;">
                    <li data-target="#c-slide" data-slide-to="0" class=""></li>
                    <li data-target="#c-slide" data-slide-to="1" class=""></li>
                    <li data-target="#c-slide" data-slide-to="2" class="active"></li>
                </ol>
                <div class="carousel-inner" style="min-height:180px;" >
                    <div class="item">
                        <p class="text-center"> <em class="h4 text-mute">Premier pas sur Tendoo</em><br>
                            <br/>
                            D&eacute;couvrer comment publier votre premier article en suivant <a href="http://tendoo.org/index.php/guide/write_article"><strong>ces instructions</strong></a>. Vous pouvez aussi apprendre &agrave; configurer votre site web en suivant <a href="http://tendoo.org/index.php/guide/settings"><strong>ces instructions</strong></a>. Apprenez &eacute;galement &agrave; g&eacute;rer le fonctionnement de votre site web dans la section <a href="http://tendoo.org/index.php/guide/manage_system"><strong>Syst&egrave;me</strong></a> et dans la section <a href="http://tendoo.org/index.php/guide/about_security"><strong>S&eacute;curit&eacute;</strong></a> </p>
                    </div>
                    <div class="item">
                        <p class="text-center"> <em class="h4 text-mute">C'est quoi Tendoo ?</em><br>
                            <br/>
                            <small class="text-muted">Tendoo vous permet de rapidement cr&eacute;er votre site web, sans avoir n&eacute;cessairement besoin d'un expert. La cr&eacute;ation et la gestion d'un site web ne pourra pas &ecirc;tre plus facile. Si vous d&eacute;butez, <a href="#">vous devez savoir ceci</a>, cependant si vous &ecirc;tes un habitu&eacute; de CMS, ce petit aper&ccedil;u vous sera utile.</small> </p>
                    </div>
                    <div class="item active">
                        <p class="text-center"> <em class="h4 text-mute">Bienvenue sur <strong><?php echo get('core_version');?></strong></em><br>
                            <br/>
                            <small class="text-muted">L'&eacute;quipe vous remercie d'avoir choisi Tendoo comme application pour la cr&eacute;ation de votre site web / application web. Si vous demarrez sur Tendoo, consultez <a href="http://tendoo.org/index.php/guide/discover">le guide d'utilisation</a> sur les premiers pas, et commercez &agrave; personnaliser tendoo.</small> </p>
                    </div>
                </div>
                <a class="left carousel-control" href="#c-slide" data-slide="prev"> <i class="fa fa-angle-left"></i> </a> <a class="right carousel-control" href="#c-slide" data-slide="next"> <i class="fa fa-angle-right"></i> </a> </div>
        </div>
    </div>
    <?php
}
