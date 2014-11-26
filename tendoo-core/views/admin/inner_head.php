<?php
$options	=	get_core_vars( 'options' ); ?>

<header id="headish" class="header bg-black navbar navbar-inverse pull-in <?php // echo theme_class();?>">
    <div class="navbar-header nav-bar aside dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> <i class="fa fa-reorder"></i> </a> <span href="#" class="nav-brand <?php // echo theme_class();?>"> <img style="max-height:30px;" src="<?php echo $this->instance->url->img_url('logo_minim.png');?>" alt="logo"> </span> <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> <i class="fa fa-comment-alt"></i> </a>
    </div>
    <?php if( current_user()->isAdmin() ):?>
    <div class="collapse navbar-collapse pull-in">
    	<ul class="nav navbar-nav">
        	<?php
            $sysNot			=	$this->instance->tendoo_admin->get_sys_not();
            $ttSystNot		=	count($sysNot);
            ?>
            <li class="hidden-xs"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell text-white"></i>
                <?php 
                if($ttSystNot > 0)
                {
                    ?>
                <span class="badge up bg-info m-l-n-sm"><?php echo $ttSystNot;?></span>
                <?php
                }
                ?>
                </a>
                <section class="dropdown-menu animated fadeInUp input-s-lg">
                    <section class="panel bg-white">
                        <header class="panel-heading"> <strong><?php echo translate( 'You got' );?> : <span class="count-n"><?php echo $ttSystNot;?></span> <?php _e( 'Notice(s)' );?></strong> </header>
                        <?php
                        if($ttSystNot > 0)
                        {
                            foreach($sysNot as $s)
                            {
                        ?>
                        <div class="list-group">
                            <a href="<?php echo $s['LINK'];?>" class="media list-group-item">
                            <?php
                                if($s['THUMB'] != null)
                                {
                                ?>
                            <span class="pull-left thumb-sm"> <img src="<?php echo $s['THUMB'];?>" class="img-circle"> </span>
                            <?php
                                }
                                ?>
                            <span class="media-body block m-b-none"><?php echo $s['TITLE'];?><br>
                            <small class="text-muted"><?php echo $s['CONTENT'];?></small> </span> </a>
                        </div>
                        <?php
                            }
                        ?>
                        <!-- <footer class="panel-footer text-sm"><a href="#" class="pull-right"><i class="fa fa-cog"></i></a> <a href="#">See all the notifications</a> </footer> -->
                        <?php
                        }
                        else
                        {
                            ?>
                        <div class="list-group">
                            <a href="#" class="media list-group-item"> <span class="media-body block m-b-none"><?php _e( 'There is nothing to display now...' );?></span> </a>
                        </div>
                        <?php
                        }
                        ?>
                    </section>
                </section>
            </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-sign-alt"></i> <?php _e( 'Tools' );?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/stats');?>"><?php echo translate( 'Stats' );?></a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/calendar');?>"><?php echo translate( 'Calendar' );?></a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url('admin/tools/seo');?>"><?php echo translate( 'Seo' );?></a> </li>
                    <!--<li> <a href="<?php echo $this->instance->url->site_url('admin/tools/filExplorer');?>">Explorateur de fichiers</a> </li>-->
                </ul>
            </li>
        </ul>
        <form class="navbar-form navbar-left m-t-sm" role="search">
            <a onclick="document.location	=	'<?php echo $this->instance->url->site_url(array('admin'));?>'" type="submit" class="btn btn-sm btn-white"><i class="fa fa-dashboard"></i> <?php echo translate( 'Dashboard' );?></a>
        </form>
        <?php
        if(true == false) // NOT YET ACTIVE $options[0]['CONNECT_TO_STORE'] == "1"
        {
        ?>
        <form class="navbar-form navbar-left m-t-sm" role="search">
            <a href="javascript:void(0)" id="tendooAppStore" class="btn btn-sm btn-white"><i class="fa fa-shopping-cart"></i> <?php echo translate( 'app_store' );?></a>
        </form>
        <?php
        }
        ?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left m-t-n-xs m-r-xs"> <img src="<?php echo current_user('avatar_link');?>" alt="<?php echo ucwords(current_user('PSEUDO'));?>"> </span> <?php echo ucwords($this->instance->users_global->current('PSEUDO'));?>, <?php echo $this->instance->users_global->current('REF_ROLE_ID') == 'SUPERADMIN' ? 'Super administrateur' : 'Administrateur';?> <b class="caret"></b> </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li> <a href="<?php echo $this->instance->url->site_url(array('account','update'));?>"><?php _e( 'Settings' );?></a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('account'));?>">Profil</a> </li>
                    <?php
                    $ttMessage	=	$this->instance->users_global->getUnreadMsg();
                    if($ttMessage == 0)
                    {
                    ?>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('account','messaging','home'));?>"> <?php _e( 'Inbox' );?> </a> </li>
                    <?php
                    }
                    else
                    {
                        ?>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('account','messaging','home'));?>"> <span class="badge bg-danger pull-right"><?php echo $ttMessage;?></span> <?php _e( 'Inbox' );?> </a> </li>
                    <?php
                    }
                    ?>
                    <li> <a href="http://tendoo.org/index.php/apprendre"><?php _e( 'Help' );?></a> </li>
                    <li> <a href="<?php echo $this->instance->url->site_url(array('logoff'));?>"><?php _e( 'Logoff' );?></a> </li>
                </ul>
            </li>
        </ul>
        <form class="navbar-form navbar-right m-t-sm" role="search">
            <div class="form-group">
                <div class="input-group input-s">
                    <input type="text" class="form-control input-sm no-border bg-white" placeholder="<?php echo translate( 'Search' );?>">
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-sm btn-info btn-icon" id="toolbarSearch"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </form>
        <script>
        $('#toolbarSearch').bind('click',function(){
            tendoo.notice.alert('<?php echo translate( 'unavaiable_for_this_tendoo' );?>','info');
        });
        </script>
    </div>
    <?php endif;?>
</header>
