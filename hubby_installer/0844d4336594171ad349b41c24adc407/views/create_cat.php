<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1><?php echo $module[0]['HUMAN_NAME'];?><small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Cr&eacute;er une cat&eacute;gorie</h2>
                    <form action="" class="jNice" method="post">
                    	<div class="input-control text">
                            <input name="cat_name" type="text" placeholder="Nom de la cat&eacute;gorie" />
                            <button class="btn-clear"></button>
                        </div>
                        <div class="input-control text">
                            <textarea name="cat_description" type="text" placeholder="Description de la cat&eacute;gorie"></textarea>
                        </div>
						<input type="submit" value="Créer une cat&eacute;gorie">
                    </form>
                    <div>
						<?php echo notice_from_url();?>
					</div>
                    <br />
					<div>
                        <?php echo $this->core->notice->parse_notice();?>
                    </div>
                    <br />
                </div>
			</div>
		</div>
	</div>
</div>