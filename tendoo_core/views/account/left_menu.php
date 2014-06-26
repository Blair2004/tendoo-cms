<aside class="aside nav-vertical <?php echo theme_class();?> b-r" id="nav">
    <section class="vbox">
        <header class="nav-bar"> 
        	<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> 
            	<i class="fa fa-reorder"></i> 
			</a> 
            <a href="#" class="nav-brand" data-toggle="fullscreen">
            	<i class="fa fa-group"></i> 
            </a> 
            <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> 
            	<i class="fa fa-comment-alt"></i> 
			</a> 
		</header>
        <?php
		$redirective	=	urlencode($this->instance->url->request_uri());
		?>
        <footer class="footer bg-gradient hidden-xs"> <a href="<?php echo $this->instance->url->site_url(array('logoff','tologin?ref='.$redirective));?>" data-toggle="ajaxModal" class="btn btn-sm btn-link m-r-n-xs pull-right"> <i class="fa fa-off"></i> </a> <a href="#nav" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm"> <i class="fa fa-reorder"></i> </a> </footer>
        <section>
            <nav class="nav-primary">
                <ul class="nav">
                    <li> <a href="<?php echo $this->instance->url->site_url('account');?>"> <i class="fa fa-home"></i> <span>Profil</span> </a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url('account/messaging');?>"> 
                    <?php
					$unread	=	$this->instance->users_global->getUnreadMsg();
					if($unread > 0)
					{
                    ?><b class="badge bg-danger pull-right"><?php echo $unread;;?></b> 
                    <?php
					}
                    ?>
                    <i class="fa fa-envelope"></i><span>Messagerie</span> </a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url('account/update');?>"> <i class="fa fa-edit"></i> <span>Modifier</span> </a> </li>
                    <?php
					if($this->instance->users_global->isAdmin())
					{
					?>
                    <li> <a href="<?php echo $this->instance->url->site_url('admin');?>"> <i class="fa fa-dashboard"></i> <span>Admin.</span> </a> </li>
                    <?php
					}
					?>
                    <li> <a href="<?php echo $this->instance->url->site_url('index');?>"> <i class="fa fa-sign-out"></i> <span>Retour</span> </a> </li>
                </ul>
            </nav>
        </section>
    </section>
</aside>