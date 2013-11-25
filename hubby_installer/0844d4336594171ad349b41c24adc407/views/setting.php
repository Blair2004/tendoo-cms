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
                	<div class="span8">
						<?php echo validation_errors(); ?>
                        <?php echo $this->core->notice->parse_notice();?>
                        <h2>Param&ecirc;tres avanc&eacute;s</h2>
                        <form method="post">
                            <label  class="input-control switch">
                                <input type="checkbox" name="validateall" value="true" 
                                <?php
								if(array_key_exists('APPROVEBEFOREPOST',$setting))
								{
									if($setting['APPROVEBEFOREPOST'] == "1")
									{
                                    ?>
                                    checked="checked"
                                    <?php
                                	}
								}
                                ?> />
                                <span class="helper">Valider chaque commentaire avant de l'afficher </span>
                            </label >
                            <label  class="input-control switch">
                            	<input type="checkbox" name="allowPublicComment" value="true" <?php
								if(array_key_exists('EVERYONEPOST',$setting))
								{
									if($setting['EVERYONEPOST'] == "1")
									{
									?>
                                    checked="checked"
                                    <?php
									}
								}
								?> />
                                <span class="helper">Autoriser les membres non inscrit &agrave; commenter</span>
                            </label >
                            <p><input type="submit" value="Enregistrer les modifications" name="update"></p>
                        </form>
                        <h2>Param&ecirc;tres des widgets</h2>
                        <h3>Widget - Categories</h3>
                        <form method="post">
                        	<div class="input-control select">
                                <select name="limitcat">
                                    <option value="">Nombre total d'affichage</option>
                                    <?php
                                    for($i=1;$i<=50;$i++)
                                    {
										if(array_key_exists('WIDGET_CATEGORY_LIMIT',$setting))
										{
											if($setting['WIDGET_CATEGORY_LIMIT']	==	$i)
											{
												?>
                                    <option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
											}
											else
											{
												?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
											}
										}
										else
										{
                                        ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
										}
                                    }
                                    ?>
                                </select>
                            </div>
                            <p><input name="limit_submiter" type="submit" value="Enregistrer" /></p>
                        </form>
                        <h3>Widget - Les articles les plus lues</h3>
                        <form method="post">
                        	<div class="input-control select">
                                <select name="mostreaded">
                                    <option value="">Nombre total d'affichage</option>
                                    <?php
                                    for($i=1;$i<=50;$i++)
                                    {
										if(array_key_exists('WIDGET_MOSTREADED_LIMIT',$setting))
										{
											if($setting['WIDGET_MOSTREADED_LIMIT']	==	$i)
											{
												?>
                                    <option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
											}
											else
											{
												?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
											}
										}
										else
										{
                                        ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php
										}
                                    }
                                    ?>
                                </select>
                            </div>
                            <p><input name="mostreaded_submiter" type="submit" value="Enregistrer" /></p>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>