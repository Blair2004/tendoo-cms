<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $pageTitle;?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div>
                        <?php echo validation_errors('<p class="error">', '</p>');?>
                        <?php $this->core->notice->parse_notice();?>
                        <?php echo notice_from_url();?>
                    </div>
                    <br />
                    <div class="hub_table">
                    	<h2>Administrateurs et super administrateur</h2>
                        <p>En cr&eacute;ant plusieurs administrateur vous pouvez choisir une personne qui pourra g&eacute;rer avec vous le contenu de votre site web. Vous avez la possiblit&eacute; de d&eacute;finir les privil&egrave;ges de chaque administrateurs. Les administrateurs ont diff&eacute;rent privil&egrave;ge, cependant il n'est pas permis qu'un administrateur ait autant de privil&egrave;ge qu'un super administrateur.<br />Le super administrateur &agrave; un contr&ocirc;le total sur tous les privil&egrave;ges et peut &agrave; lui seul <a href="#">cr&eacute;er</a> d'autres administrateurs et les <a href="#">g&eacute;rer</a>.</p>
                        <h2>Restauration du CMS</h2>	
                        <h3>Pourquoi faire une restauration ?</h3>
                        <p>Lorsque votre site web se comporte de façon inhabituelle. Lorsque vous pensez que l'un des modules que vous avez r&eacute;cemment install&eacute; peut &ecirc;tre &agrave; l'origine du disfonctionnement de votre site web, et que malgr&eacute; tout la d&eacute;sinstallation de ce module est impossible. Lorsque vous souhaitez reinitialiser votre site web, opter pour l'une des méthodes de restauration <a href="#">souple</a> ou <a href="#">brutale</a> selon vos envies et le possibilités offertes par les restaurations.</p>
                        <h3>Restauration souple</h3>
                        <p>La restauration désintallera les modules, th&egrave;mes et demandera &agrave; chaque modules et th&egrave;mes de supprimer par la m&ecirc;me occassion les tables et fichiers qui ont &eacute;t&eacute; install&eacute; ult&eacute;rieurement &agrave; leur installation.</p>
                        <h3>Restauration brutale</h3>
                        <p>La restauration supprime tous les fichiers modules, th&egrave;mes, sans passer par le mode normal de d&eacute;sinstallation. Elle supprime &eacute;galement toutes les tables cr&eacute;es par les modules, th&egrave;mes, supprime toutes les tables contenue dans la base de donn&eacute;, o&ugrave; les tables qui portent le pr&eacute;fix que vous avez d&eacute;sign&eacute;, restore la base de donn&eacute;e avec certaines informations sauvegard&eacute;s.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>