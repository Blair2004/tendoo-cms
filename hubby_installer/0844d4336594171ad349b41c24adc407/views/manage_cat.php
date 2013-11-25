<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Gestionnaire de cat&eacute;gorie<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Modifier une cat&eacute;gorie</h2>
                    <form action="" class="jNice" method="post">
                    	<div class="input-control text">
                            <input type="text" name="cat_name" value="<?php echo $cat['name'];?>" placeholder="Nom de la cat&eacute;gorie">
                            <button class="btn-clear"></button>
                        </div>
                        <div class="input-control text">
                        	<textarea name="cat_description" placeholder="Description de la cat&eacute;gorie"><?php echo $cat['desc'];?></textarea>
                        </div>
                        <input type="hidden" name="cat_id" value="<?php echo $cat['id'];?>">
                      <input type="submit" value="Modifier la cat&eacute;gorie">
                      <input type="hidden" value="ALLOWEDITCAT" name="allower">
                    </form>
                    <h2>Supprimer la cat&eacute;gorie</h2>
                    <form action="" class="jNice" method="post">
                    	<div class="input-control text">
                        	<span class="notice">Une cat&eacute;gorie ne peut &ecirc;tre supprim&eacute;e si certaines publications y sont encore attach&eacute;s. Rassurez-vous qu'aucun article n'est rattach&eacute; &agrave; cette cat&eacute;gorie avant de la supprimer</span>
                        </div>
                    	<input type="hidden" value="<?php echo $cat['id'];?>" name="cat_id_for_deletion">
                        <input type="hidden" value="ALLOWCATDELETION" name="allower">
                        <input type="submit" value="supprimer la cat&eacute;gorie">
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