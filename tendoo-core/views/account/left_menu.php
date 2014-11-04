<aside class="aside <?php echo theme_class();?> <?php echo get_user_meta( 'admin-left-menu-status' );?> b-r" id="nav">
    <section class="hbox stretch">
        <header class="dker nav-bar"> 
        	<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> 
            	<i class="fa fa-reorder"></i> 
			</a> 
            <span href="#" class="nav-brand <?php echo theme_class();?>">
            	<img style="max-height:30px;" src="<?php echo $this->instance->url->img_url('logo_minim.png');?>" alt="logo">
            </span> 
            <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> 
            	<i class="fa fa-comment-alt"></i>
			</a> 
		</header>
        <?php
		$redirective	=	urlencode($this->instance->url->request_uri());
		?>
        <footer class="footer bg-gradient hidden-xs"> 
			<a href="javascript:void(0)" class="showAppTab btn btn-sm pull-right"> 
				<i class="fa fa-th-large"></i> 
			</a> 
			<a href="#nav" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm"> 
				<i class="fa fa-arrows-h"></i> 
			</a> 
		</footer>
        <section>
            <nav class="nav-primary">
                <ul class="nav">
                    <li> <a href="<?php echo $this->instance->url->site_url('account');?>"> <i class="fa fa-home"></i> <span><?php _e( 'Profile' );?></span> </a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url('account/messaging');?>"> 
                    <?php
					$unread	=	$this->instance->users_global->getUnreadMsg();
					if($unread > 0)
					{
                    ?><b class="badge bg-danger pull-right"><?php echo $unread;;?></b> 
                    <?php
					}
                    ?>
                    <i class="fa fa-envelope"></i><span><?php _e( 'Inbox' );?></span> </a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url('account/update');?>"> <i class="fa fa-edit"></i> <span><?php _e( 'Edit' );?></span> </a> </li>
                    <?php
					if($this->instance->users_global->isAdmin())
					{
					?>
                    <li> <a href="<?php echo $this->instance->url->site_url('admin');?>"> <i class="fa fa-dashboard"></i> <span><?php _e( 'Dashboard' );?></span> </a> </li>
                    <?php
					}
					?>
                    <li> <a href="<?php echo $this->instance->url->site_url('index');?>"> <i class="fa fa-eye"></i> <span><?php _e( 'Get to live' );?></span> </a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('logoff'));?>"> <i class="fa fa-sign-out"></i> <span><?php echo translate( 'Log off' );?></span> </a> </li>
                </ul>
            </nav>
        </section>
    </section>
</aside>