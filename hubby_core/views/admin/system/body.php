<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <div class="wrapper">
                <h3>Administrateurs et super administrateur</h3>
                <p>En cr&eacute;ant plusieurs administrateur vous pouvez choisir une personne qui pourra g&eacute;rer avec vous le contenu de votre site web. Vous avez la possiblit&eacute; de d&eacute;finir les privil&egrave;ges de chaque administrateurs. Les administrateurs ont diff&eacute;rent privil&egrave;ge, cependant il n'est pas permis qu'un administrateur ait autant de privil&egrave;ge qu'un super administrateur.<br />Le super administrateur &agrave; un contr&ocirc;le total sur tous les privil&egrave;ges et peut &agrave; lui seul <a href="#">cr&eacute;er</a> d'autres administrateurs et les <a href="#">g&eacute;rer</a>.</p>
                <h3>Restauration du CMS</h3>	
                <h4>Pourquoi faire une restauration ?</h4>
                <p>Lorsque votre site web se comporte de façon inhabituelle. Lorsque vous pensez que l'un des modules que vous avez r&eacute;cemment install&eacute; peut &ecirc;tre &agrave; l'origine du disfonctionnement de votre site web, et que malgr&eacute; tout la d&eacute;sinstallation de ce module est impossible. Lorsque vous souhaitez reinitialiser votre site web, opter pour l'une des méthodes de restauration <a href="#">souple</a> ou <a href="#">brutale</a> selon vos envies et le possibilités offertes par les restaurations.</p>
                <h4>Restauration souple</h4>
                <p>La restauration désintallera les modules, th&egrave;mes et demandera &agrave; chaque modules et th&egrave;mes de supprimer par la m&ecirc;me occassion les tables et fichiers qui ont &eacute;t&eacute; install&eacute; ult&eacute;rieurement &agrave; leur installation.</p>
            </div>
        </section>
    </section>
</section>