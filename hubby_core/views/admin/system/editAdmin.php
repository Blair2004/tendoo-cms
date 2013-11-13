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
                    	<div class="grid">
                        	<div class="row">
                            	<div class="span2 padding10 bg-color-red">
                                	<i class="icon-user-3" style="font-size:118px;"></i>
                                </div>
                                <div class="span4">
                                <form method="post">
                                    <div class="input-control text">
                                        <input type="text" disabled="disabled" value="<?php echo $adminInfo['PSEUDO'];?>" />
                                    </div>
                                    <div class="input-control text">
                                        <select name="edit_priv">
                                        	<option value="">Modifier son privil&egrave;ge</option>
                                            <?php
											foreach($getPrivs as $p)
											{
												if($adminInfo['PRIVILEGE'] == $p['PRIV_ID'])
												{
												?>
												<option value="<?php echo $p['PRIV_ID'];?>" selected="selected"><?php echo $p['HUMAN_NAME'];?></option>
												<?php
												}
												else
												{
												?>
												<option value="<?php echo $p['PRIV_ID'];?>"><?php echo $p['HUMAN_NAME'];?></option>
												<?php
												}
											}
											?>
                                        </select>
                                    </div>
                                    <input type="hidden" value="<?php echo $adminInfo['PSEUDO'];?>" name="current_admin" />
                                    <input type="submit" value="Enregsitrer" name="set_admin" />
                                    <input type="submit" class="bg-color-red" value="Supprimer <?php echo $adminInfo['PSEUDO'];?>" name="delete_admin"/>
								</form>
                                </div>
                            </div>
						</div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>