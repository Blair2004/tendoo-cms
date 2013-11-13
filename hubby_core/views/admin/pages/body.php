<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Gestionnaire des pages<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
            	<h2>Liste des pages cr&eacute;&eacute;es</h2>
                <div>
				<?php echo $this->core->notice->parse_notice();?>
                <?php echo $success;?>
                </div>
                <br />
            <table class="bordered hub_table">
                    <tr class="info">
                        <td>Nom de la page</td>
                        <td>Titre de la page</td>
                        <td>Description</td>
                        <td>Module affect&eacute;</td>
                        <td>Principale</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach($get_pages as $g)
                    {
                        ?>
                        <tr>
                            <td class="action"><a class="view" href="<?php echo $this->core->url->site_url('admin/pages/edit/'.$g['PAGE_CNAME']);?>"><?php echo $g['PAGE_NAMES'];?></a></td>
                            <td><?php echo $g['PAGE_TITLE'];?></td>
                            <td><?php echo $g['PAGE_DESCRIPTION'];?></td>
                            <td><?php 
                            if(count($g['PAGE_MODULES']) > 0)
                            {
                                echo $g['PAGE_MODULES'][0]['HUMAN_NAME'];
                            }
                            else
                            {
                                echo 'Module introuvable ou incorrect';
                            };?></td>
                            <td><?php echo ($g['PAGE_MAIN'] == 'TRUE') ? 'Oui' : 'Non';?></td>
                            <td class="action"><a class="delete" href="<?php echo $this->core->url->site_url('admin/pages/delete/'.$g['PAGE_CNAME']);?>" onclick="if(confirm('Voulez vous supprimer ce controlleur ?')){return true;}else{return false}">Supprimer</a></td>
                        </tr>
                        <?php
                    }
                        ?>
                </table>
            </div>
        </div>
    </div>
</div>