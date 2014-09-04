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
		<div class="panel-heading <?php echo theme_class();?>">Statistiques Blogster</div>
		<?php 
		if( $brouillons == 0 && $article_publies == 0 && $commentaires == 0 ){
			?>
			<div class="panel-body">Aucune statistiques disponible pour l'instant</div>
			<?php
		} else {
		?>
		<ul class="list-group no-radius">
			<li class="list-group-item"> <span class="badge <?php echo theme_class();?>"><?php echo $article_publies ;?></span>Articles publiés</li>
			<li class="list-group-item"> <span class="badge <?php echo theme_class();?>"><?php echo $brouillons;?></span>Brouillons </li>
			<li class="list-group-item"> <span class="badge <?php echo theme_class();?>"><?php echo $commentaires;?></span>Commentaires postés</li>
		</ul>
		<?php
		}
		?>
	</div>
<?php
}