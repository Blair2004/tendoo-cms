<?php
$ttTheme		=	count( get_themes() );
$ttModule		=	count( get_modules( 'all' ) );
$ttPages		=	$this->tendoo_admin->countPages();
$ttPrivileges	=	$this->roles->count();
$countUsers		=	count($this->users_global->getAdmin());
?>
<section class="panel">
    <header class="panel-heading <?php echo theme_class();?>"><?php _e( 'Stats' );?></header>
    <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
        <li class="list-group-item"><?php _e( 'Modules' );?> <span class="badge <?php echo theme_class();?>"><?php echo $ttModule;?></span></li>
        <li class="list-group-item"><?php _e( 'Themes' );?> <span class="badge <?php echo theme_class();?>"><?php echo $ttTheme;?></span></li>
        <li class="list-group-item"><?php _e( 'Controllers' );?> <span class="badge <?php echo theme_class();?>"><?php echo $ttPages;?></span></li>
        <li class="list-group-item"><?php _e( 'Privileges' );?><span class="badge <?php echo theme_class();?>"><?php echo $ttPrivileges;?></span></li>
        <li class="list-group-item"><?php _e( 'Users' );?> <span class="badge <?php echo theme_class();?>"><?php echo $countUsers;?></span></li>
    </ul>
</section>
