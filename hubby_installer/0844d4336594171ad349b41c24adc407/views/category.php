<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $module[0]['HUMAN_NAME'];?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID']));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Liste des cat&eacute;gories</h2>
                    <table class="striped bordered">
                        <thead>
                            <tr>
                                <td>Nom</td>
                                <td>Description</td>
                                <td>Date de creation</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(count($getCat) > 0)
                        {
                            foreach($getCat as $g)
                            {
                        ?>
                            <tr>
                                <td class="action"><a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','manage',$g['ID']));?>"><?php echo $g['CATEGORY_NAME'];?></a></td>
                                <td><?php echo $g['DESCRIPTION'];?></td>
                                <td><?php echo timespan(strtotime($g['DATE']));?></td>
                            </tr>
                        <?php
                            }
                        }
                        else
                        {
                            ?>
                            <tr>
                                <td colspan="3">Aucune cat&eacute;gorie disponible</td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
					if(is_array($pagination[4]))
					{
						foreach($pagination[4] as $p)
						{
							?>
                            <a style="padding:2px 5px; display:block; float:left; margin:0px 4px 0px 0px;" href="<?php echo $p['link'];?>" class="<?php echo $p['state'];?>"><?php echo $p['text'];?></a>
                            <?php
						}
					}
					?>
                    <div>
					<?php echo $this->core->notice->parse_notice();?>
                    </div>
                    <br />
                    <div>
                    <?php echo notice_from_url();?>
                    </div>
					<br />
                </div>
			</div>
		</div>
	</div>
</div>