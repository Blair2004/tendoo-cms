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
                                <?php echo $this->core->notice->parse_notice();?>
                                <br />
                                <br />
                                <div class="span6">
                                    <form method="post">
                                        <div class="input-control text">
                                            <input type="text" name="receiver" placeholder="Pseudo du correspondant" />
                                        </div>
                                        <div class="input-control textarea">
                                            <textarea name="content" placeholder="Contenu du message"></textarea>
                                        </div>
                                        <input type="submit" value="Envoyer" /> <input type="reset" value="Tout effacer" />
                                    </form>
                                </div>
                                <div class="span6">
        <?php
        $field_1	=	(form_error('receiver')) ? form_error('receiver') : 'Ce pseudo doit correspondre à l\'un des pseudo valide.';
        $field_2	=	(form_error('content')) ? form_error('content') : 'Le contenu du message.';
        ?>
                                    <p style="padding:7px 0;"><?php echo $field_1; ?></p>
                                    <p style="padding:7px 0;"><?php echo $field_2; ?></p>
                                </div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>