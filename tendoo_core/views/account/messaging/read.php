<?php echo $smallHeader;?>
<?php
$participant['AUTEUR']	=	$this->core->users_global->getUser($getMsgContent['title'][0]['AUTHOR']);
$participant['RECEVEUR']	=	$this->core->users_global->getUser($getMsgContent['title'][0]['RECEIVER']);
?>
<section class="scrollable bg-light lt">
    <div class="panel-content">
        <div class="wrapper scrollable">
			<?php echo $this->core->notice->parse_notice();?>
            <?php echo validation_errors();?>
        	<div class="panel">
                <div class="panel-heading">
                    <?php echo $participant['AUTEUR']['PSEUDO'];?> &raquo; <?php echo $participant['RECEVEUR']['PSEUDO'];?>
                </div>
            	<div class="span12">
                    	<div class="wrapper btn-group">
							<form method="post" action="<?php echo $this->core->url->site_url(array('account','messaging','home'));?>" class="read_form_id">
								<?php include_once(VIEWS_DIR.'account/messaging/menu.php');?>
								<input type="button" class="btn btn-sm btn-white answer_btn" value="Poster un message" />
								<input type="hidden" name="conv_id" class="conv_id" value="<?php echo $getMsgContent['title'][0]['ID'];?>" />
							</form>
                        </div>
                        <table class="table table-striped b-t text-sm answer_table">
                            <thead>
                                <tr>
                                    <th width="60">Auteur</th>
                                    <th>Message</th>
                                    <th width="200">Post&eacute;</th>
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
                                    <th><?php echo $users['PSEUDO'];?></th>
                                    <th><?php echo htmlentities($g['CONTENT']);?></th>
                                    <th><?php echo $this->core->tendoo->timespan($post_time);?></th>
                                </tr>
                            <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr>
                                    <th colspan="6">Aucun message reçu</th>
                                </tr>
                                <?php
                            }
                            ?>
                            </form>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</section>
<footer class="footer bg-white b-t">
    <div class="row m-t-sm text-center-xs">
        <div class="col-sm-4">
            <select class="input-sm form-control input-s-sm inline">
                <option value="0">Bulk action</option>
                <option value="1">Delete selected</option>
                <option value="2">Bulk edit</option>
                <option value="3">Export</option>
            </select>
            <button class="btn btn-sm btn-white">Apply</button>
        </div>
        <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">Montre <?php echo $paginate[1];?> &agrave; <?php echo $paginate[2];?> sur <?php echo $ttMsgContent;?> El&eacute;ments</small> </div>
        <div class="col-sm-4 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
            <?php
            if(is_array($paginate[4]))
            {
                foreach($paginate[4] as $p)
                {
                    ?>
                    <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
            <?php
                }
            }
            ?>
            </ul>
        </div>
    </div>
</footer>
