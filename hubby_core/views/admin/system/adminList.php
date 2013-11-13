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
                    <div class="hub_table">
                    	<h2>Liste des administrateurs</h2>
                        <div>
							<?php echo validation_errors('<p class="error">', '</p>');?>
                            <?php $this->core->notice->parse_notice();?>
                            <?php echo notice_from_url();?>
                        </div>
                        <br />
                        <table class="bordered">
                        	<thead>
                            	<tr>
                                	<td width="100">Identifiant</td>
                                	<td width="300">pseudo</td>
                                    <td>Status</td>
                                    <td>Privil&egrave;ge</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							if(is_array($subadmin))
							{
								if(count($subadmin) > 0)
								{
									foreach($subadmin as $s)
									{
										$priv	=	$this->core->hubby_admin->getPrivileges($s['PRIVILEGE'])
								?>
									<tr>
										<td><?php echo $s['ID'];?></td>
										<td><a href="<?php echo $this->core->url->site_url(array('admin','system','editAdmin',$s['PSEUDO']));?>"><?php echo $s['PSEUDO'];?></a></td>
                                        <td><?php echo $priv[0]['HUMAN_NAME'];?></td>
										<td><?php echo $s['PRIVILEGE'];?></td>
									</tr>
								<?php
									}
								}
								else
								{
								?>
                                <tr>
                                	<td colspan="3">Aucun administrateur cr&eacute;e.</td>
                                </tr>
                                <?php
								}
							}
							else
							{
								?>
                                <tr>
                                	<td colspan="3">Aucun administrateur cr&eacute;e.</td>
                                </tr>
                                <?php
							}
							?>
                            </tbody>
                        </table>
                        Page : 
                        <?php
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