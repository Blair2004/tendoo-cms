<?php echo $smallHeader;?>
<section class="scrollable bg-light lt">
    <div class="panel-content">
	<div class="container scrollable wrapper">
    <?php echo $this->core->notice->parse_notice();?>
    <div class="panel">
        <div class="tab-responsive">
        	<div class="wrapper btn-group">
			<?php include_once(VIEWS_DIR.'account/messaging/menu.php');?>
            </div>
            <br />
            <table class="table table-striped b-t text-sm small_app">
                <thead>
                    <tr>
                        <th width="20"><input type="checkbox"></th>
                        <th class="th-sortable" data-toggle="class">Pseudo</th>
                        <th>Contenu</th>
                        <th width="200">Dernier Message</th>
                        <th width="200">Date de cr&eacute;ation</th>
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
                            <th><input type="checkbox" name="conv_id[]" value="<?php echo $g['ID'];?>" /></th>
                            <th><?php echo $users['PSEUDO'];?></th>
                            <th><?php echo word_limiter($preview[0]['CONTENT'],5);?></th>
                            <th><?php echo $this->core->tendoo->timespan($post_time);?></th>
                            <th><?php echo $this->core->tendoo->timespan($cur_time);?></th>
                        </tr>
                        <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <th colspan="5">Aucun message reçu</th>
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
        <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">Montre <?php echo $paginate[1];?> &agrave; <?php echo $paginate[2];?> sur <?php echo $ttMessage;?> El&eacute;ments</small> </div>
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
