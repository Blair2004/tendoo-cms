<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
            <?php
			$participant['AUTEUR']	=	$this->core->users_global->getUser($getMsgContent['title'][0]['AUTHOR']);
			$participant['RECEVEUR']	=	$this->core->users_global->getUser($getMsgContent['title'][0]['RECEIVER']);
			?>
                <h1>Messagerie<small>Lecture d'une conversation : <?php echo $participant['AUTEUR']['PSEUDO'];?> &raquo; <?php echo $participant['RECEVEUR']['PSEUDO'];?></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('index'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                	<div class="grid">
                    	<div class="row">
                        	<div class="span12">
                                <form method="post" action="<?php echo $this->core->url->site_url(array('account','messaging','home'));?>" class="read_form_id">
                                <?php include_once(VIEWS_DIR.'account/messaging/menu.php');?>
                                    <input type="button" class="answer bg-color-yellow answer_btn" value="Poster un message" />
                                    <input type="hidden" name="conv_id" class="conv_id" value="<?php echo $getMsgContent['title'][0]['ID'];?>" />
                                </form>
                                <br />
                                <?php echo $this->core->notice->parse_notice();?>
                                <?php echo validation_errors();?>
                                <table class="bordered striped answer_table">
                                	<thead>
                                    	<tr>
                                        	<td width="60">Auteur</td>
                                            <td>Message</td>
                                            <td width="200">Post&eacute;</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <form method="post">
                                    <?php
									if(count($getMsgContent['content']) > 0)
									{
										foreach($getMsgContent['content'] as $g)
										{
											$users		=	$this->core->users_global->getUser($g['AUTHOR']);
											$post_time	=	strtotime($g['DATE']);
									?>
                                    	<tr>
                                            <td><?php echo $users['PSEUDO'];?></td>
                                            <td><?php echo htmlentities($g['CONTENT']);?></td>
                                            <td><?php echo $this->core->hubby->timespan($post_time);?></td>
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
								foreach($paginate[4] as $p)
								{
									?>
                                   	<input style="min-width:20px;width:auto;padding:4px;" class="<?php echo $p['state'];?>" type="button" value="<?php echo $p['text'];?>" button_ref="<?php echo $p['link'];?>" />
                                    <?php
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