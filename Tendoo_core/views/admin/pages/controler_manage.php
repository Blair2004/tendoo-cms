<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable hbox stretch" id="pjax-container">
            <aside class="aside-lg bg-light lter b-r">
                <section class="vbox">
                    <section class="scrollable">
                        <div class="wrapper">
                            <div class="clearfix m-b"> <a href="#" class="pull-left thumb m-r"> <img src="images/avatar.jpg" class="img-circle"> </a>
                                <div class="clear">
                                    <div class="h3 m-t-xs m-b-xs">John.Smith</div>
                                    <small class="text-muted"><i class="icon-map-marker"></i> London, UK</small> </div>
                            </div>
                            <div class="panel wrapper">
                                <div class="row">
                                    <div class="col-xs-4"> <a href="#"> <span class="m-b-xs h4 block">245</span> <small class="text-muted">Followers</small> </a> </div>
                                    <div class="col-xs-4"> <a href="#"> <span class="m-b-xs h4 block">55</span> <small class="text-muted">Following</small> </a> </div>
                                    <div class="col-xs-4"> <a href="#"> <span class="m-b-xs h4 block">2,035</span> <small class="text-muted">Tweets</small> </a> </div>
                                </div>
                            </div>
                            <div class="btn-group btn-group-justified m-b"> <a class="btn btn-success btn-rounded" data-toggle="button"> <span class="text"> <i class="icon-eye-open"></i> Follow </span> <span class="text-active"> <i class="icon-eye-open"></i> Following </span> </a> <a class="btn btn-info btn-rounded"> <i class="icon-comment-alt"></i> Chat </a> </div>
                            <div> <small class="text-uc text-xs text-muted">about me</small>
                                <p>Artist</p>
                                <small class="text-uc text-xs text-muted">info</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id neque quam. Aliquam sollicitudin venenatis ipsum ac feugiat.</p>
                                <div class="line"></div>
                                <small class="text-uc text-xs text-muted">connection</small>
                                <p class="m-t-sm"> <a href="#" class="btn btn-rounded btn-twitter btn-icon"><i class="icon-twitter"></i></a> <a href="#" class="btn btn-rounded btn-facebook btn-icon"><i class="icon-facebook"></i></a> <a href="#" class="btn btn-rounded btn-gplus btn-icon"><i class="icon-google-plus"></i></a> </p>
                            </div>
                        </div>
                    </section>
                </section>
            </aside>
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
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
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small> </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <?php 
					 if(isset($paginate))
					 {
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                        <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
                        <?php
						}
					}
					 }
				?>
                    </ul>
                </div>
            </div>
        </footer>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
