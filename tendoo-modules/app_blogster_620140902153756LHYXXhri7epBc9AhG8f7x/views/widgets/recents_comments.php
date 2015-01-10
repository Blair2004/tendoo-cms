<?php
$MODULE = get_modules( 'filter_namespace' , 'blogster' );
if( is_file( $file = $MODULE[ 'uri_path' ] . '/library.php' ) ){
	include_once( $file );
};
if( class_exists( 'blogster_library' ) ){
	$BLIB		=	new blogster_library;
	$COMMENTS	=	$BLIB->getComments(0,5);
	?>
	<div class="panel">
		<div class="panel-heading <?php echo theme_class();?>"><?php _e( 'Recents Comments' );?></div>
		<?php 
			if($COMMENTS)
			{
				foreach($COMMENTS as $C)
				{
					$ARTICLE	=	$BLIB->getSpeNews($C['REF_ART']);
					$timespan	=	get_instance()->date->timespan( $C[ 'DATE' ] );
					if($C['OFFLINE_AUTEUR'] != '')
					{
					?>
		<div class="panel-body">
			<div class="clearfix m-b"> <small class="text-muted pull-right"><?php echo $timespan;?></small> <a href="#" class="thumb-sm pull-left m-r"> <img src="<?php echo img_url( 'avatar_default.jpg' );?>" class="img-circle"> </a>
				<div class="clear"> <a href="#"><strong><?php echo $C['OFFLINE_AUTEUR'];?></strong></a> <small class="block text-muted"><?php _e( 'Unknow Location' );?></small> </div>
			</div>
			<p><a href="<?php echo get_instance()->url->site_url( array( 'admin' , 'open' ,'modules' , $MODULE[ 'namespace' ], 'comments_manage' , $C[ 'ID' ] ) );?>"><?php echo word_limiter($C['CONTENT'],20);?></a></p>
			<small class=""> <span class="text-muted"><a href="<?php echo get_instance()->url->site_url(array('admin','open','modules',$MODULE[ 'namespace' ],'edit',$ARTICLE[0]['ID']));?>"><i class="fa fa-share"></i> <?php echo $ARTICLE[0]['TITLE'];?></a></span></small> 
		</div>
		<?php
					}
					else
					{
						$AUTEUR			=	get_user( $C['AUTEUR'] ,'as_id');
						$AUTEUR_METAS	=	get_user_meta( 'all' , $C['AUTEUR'] , 'as_id' );
						$avatar			=	return_if_array_key_exists( 'avatar_link' , $AUTEUR_METAS ) ? return_if_array_key_exists( 'avatar_link' , $AUTEUR_METAS ) : img_url( 'avatar_default.jpg' );
						?>
		<div class="panel-body">
			<div class="clearfix m-b"> <small class="text-muted pull-right"><?php echo $timespan;?></small> <a href="#" class="thumb-sm pull-left m-r"> <img src="<?php echo $avatar; ?>" class="img-circle"> </a>
				<div class="clear"> <a href="#"><strong><?php echo $AUTEUR['PSEUDO'];?></strong></a> <small class="block text-muted"><?php echo (return_if_array_key_exists( 'town' , $AUTEUR_METAS ) != '' && return_if_array_key_exists( 'state' , $AUTEUR_METAS ) != '' ) ? return_if_array_key_exists( 'town' , $AUTEUR_METAS ). ', ' . return_if_array_key_exists( 'state' , $AUTEUR_METAS ) : __( 'Unknow' );?></small> </div>
			</div>
			<p><a href="<?php echo get_instance()->url->site_url( array( 'admin' , 'open' ,'modules' , $MODULE[ 'namespace' ], 'comments_manage' , $C[ 'ID' ] ) );?>"><?php echo word_limiter($C['CONTENT'],20);?></a></p>
			<small class=""> <span class="text-muted"><a href="<?php echo get_instance()->url->site_url(array('admin','open','modules',$MODULE[ 'namespace' ],'edit',$ARTICLE[0]['ID']));?>"><i class="fa fa-share"></i> <?php echo $ARTICLE[0]['TITLE'];?></a></span></small> 
		</div>
		<?php
					}
				}
			} 
			else
			{
				?>
                <div class="panel-body">
                	<p><?php _e( 'No one has commented right now' );?></p>
                </div>
                <?php
			}
			?>
	</div>
	<?php
}
