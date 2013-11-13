<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Messagerie<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('index'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                	<div class="grid">
                    	<div class="row">
                        	<div class="span12">
                                <?php include_once(VIEWS_DIR.'account/messaging/menu.php');?>
                                <br />
                                <?php echo $this->core->notice->parse_notice();?>
                                <table class="bordered striped hovered small_app">
                                	<thead>
                                    	<tr>
                                        	<td><input type="checkbox" class="this" /></td>
                                        	<td>Auteur</td>
                                            <td>Derniers messages</td>
                                            <td>Post&eacute;e le</td>
                                            <td>Conversation d&eacute;marr&eacute;e</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <form method="post">
                                    <?php
									if($ttMessage > 0)
									{
										foreach($getMessage as $g)
										{
											$preview	=	$this->core->users_global->getMsgPreview($g['ID']);
											$users		=	$this->core->users_global->getUser($preview[0]['AUTHOR']);
											$post_time	=	strtotime($preview[0]['DATE']);
											$cur_time	=	strtotime($g['CREATION_DATE']);
											$str	=	($preview[0]['AUTHOR']	!=	$this->core->users_global->current('ID')) && ($g['STATE']	==	'0') ? 'bg-color-blueLight' : '';
									?>
                                    	<tr class="<?php echo $str;?>">
                                        	<td><input type="checkbox" name="conv_id[]" value="<?php echo $g['ID'];?>" /></td>
                                            <td><?php echo $users['PSEUDO'];?></td>
                                            <td><?php echo word_limiter($preview[0]['CONTENT'],5);?></td>
                                            <td><?php echo $this->core->hubby->timespan($post_time);?></td>
                                            <td><?php echo $this->core->hubby->timespan($cur_time);?></td>
                                        </tr>
									<?php
										}
									}
									else
									{
										?>
                                        <tr>
                                        	<td colspan="6">Aucun message reçu</td>
                                        </tr>
                                        <?php
									}
									?>
                                    </form>
                                    </tbody>
                                </table>
                                Page :
                                <?php 
								if(is_array($paginate[4]))
								{
									foreach($paginate[4] as $p)
									{
										?>
										<input style="min-width:20px;width:auto;padding:4px;" class="<?php echo $p['state'];?>" type="button" value="<?php echo $p['text'];?>" button_ref="<?php echo $p['link'];?>" />
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
    </div>
</div>