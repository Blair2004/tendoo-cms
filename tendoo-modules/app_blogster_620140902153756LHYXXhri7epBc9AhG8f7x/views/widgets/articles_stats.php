<?php
$MODULE = get_modules( 'filter_namespace' , 'blogster' );
if( is_file( $file = $MODULE[ 'uri_path' ] . '/library.php' ) ){
	include_once( $file );
};
if( class_exists( 'blogster_library' ) ){
	$BLOGSTER	=	new blogster_library;
	$article_publies 	=	$BLOGSTER->countNews( 'published' );
	$commentaires		=	$BLOGSTER->countComments();
	$brouillons			=	$BLOGSTER->countNews( 'draft' );
	?>
	<div class="panel">
		<div class="panel-heading <?php echo theme_class();?>"><?php _e( 'Blogster Statistics' );?></div>
		<?php 
		if( $brouillons == 0 && $article_publies == 0 && $commentaires == 0 ){
			?>
			<div class="panel-body"><?php _e( 'There is not any registered activity' );?></div>
			<?php
		} else {
		?>
		<ul class="list-group no-radius">
			<li class="list-group-item"> <span class="badge <?php echo theme_class();?>"><?php echo $article_publies ;?></span><?php _e( 'Published Posts' );?></li>
			<li class="list-group-item"> <span class="badge <?php echo theme_class();?>"><?php echo $brouillons;?></span><?php _e( 'Drafts' );?> </li>
			<li class="list-group-item"> <span class="badge <?php echo theme_class();?>"><?php echo $commentaires;?></span><?php _e( 'Comments' );?></li>
		</ul>
		<?php
		}
		?>
	</div>
<?php
}