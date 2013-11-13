<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $pageTitle;?><small>Liste des privil&egrave;ges</small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','system'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div class="hub_table">
                    	<table class="bordered">
                        	<thead>
                            	<tr>
                                	<td>Identifiant</td>
                                	<td>Nom</td>
                                    <td>Description</td>
                                    <td>Cr&eacute;er</td>
                                    <td>Action attach&eacute;s</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
								if(count($getPriv) > 0)
								{
									foreach($getPriv as $g)
									{
									?>
                                    <tr>
                                    	<td><a href="<?php echo $this->core->url->site_url(array('admin','system','edit_priv',$g['PRIV_ID']));?>"><?php echo $g['PRIV_ID'];?></a></td>
                                    	<td><?php echo $g['HUMAN_NAME'];?></td>
                                        <td><?php echo $g['DESCRIPTION'];?></td>
                                        <td><?php echo timespan(strtotime($g['DATE']),$this->core->hubby->timestamp());?></td>
                                        <td></td>
                                        <td><a href="<?php echo $this->core->url->site_url(array('admin','system','delete_priv',$g['PRIV_ID']));?>">Supprimer</a></td>
                                    </tr>
                                    <?php
									}
								}
								else
								{
									?>
                                    <tr>
                                    	<td colspan="6">Aucun privil&egrave;ge cr&eacute;e</td>
                                    </tr>
                                    <?php
								}
								?>
                            </tbody>
                        </table>
                    	Page : <?php
						if(is_array($paginate[4]))
						{
							foreach($paginate[4] as $p)
							{
								?>
                                <input type="button" data-url="<?php echo $p['link'];?>" value="<?php echo $p['text'];?>" class="<?php echo $p['state'];?>" style="min-width:0;" />
                                <?php
							}
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo notice_from_url_by_modal();?>