<?php
$page	=	get_core_vars( 'page' );
?>
<h1 class="page-header" style="margin-bottom:10px;"> <?php echo get_page( 'title' );?> <br /><small><?php echo $page[0]['PAGE_DESCRIPTION'];?></small> </h1>
<div class="row">
<?php get_breads();?>
</div>
<div class="blog">
    <?php
	if(have_blog_single())
	{
		$post		=	get_blog_single();
		$global		=	$this->instance->date->time($post->timestamp,TRUE); 
		$base		=	$this->instance->date->time($post->timestamp);
	?>
    <div class="blog-item"> <img class="img-responsive img-blog" src="<?php echo $post->full;?>" width="100%" alt="">
        <div class="blog-content">
            <h3><?php echo $post->title;?></h3>
            <div class="entry-meta"> <span><i class="icon-user"></i> <a href="<?php echo $post->author_link;?>"><?php echo $post->author['PSEUDO'];?></a></span> <span><i class="icon-folder-close"></i>
                <?php loop_categories($post->categories);?>
                </span> <span><i class="icon-calendar"></i> <?php echo $base;?> </span> <span><i class="icon-comment"></i> <a href="#comments"><?php echo $post->comments;?> Commentaire(s)</a></span> </div>
                <hr class="line" />
            <p class="lead"><?php echo $post->content;?></p>
            <hr>
            <div class="tags"> <i class="icon-tags"></i> Mots-clés
                <?php loop_tags($post->keywords , array(
						'item_class'	=>	'btn btn-xs btn-primary btn-mini',
						'divider'		=>	' '
					));?>
                <p>&nbsp;</p>
                <div class="author well">
                    <div class="media">
                        <div class="pull-left"> <img class="avatar img-thumbnail" src="<?php echo riake( 'avatar_link' , $post->author );?>" alt=""> </div>
                        <div class="media-body">
                            <div class="media-heading"> <strong><?php echo $post->author['PSEUDO'];?></strong> </div>
                            <p><?php echo riake( 'bio' , $post->author );?></p>
                        </div>
                    </div>
                </div>
                <!--/.author-->
                
                <div id="comments">
                    <div id="comments-list">
                        <h3><?php echo $post->comments;?> Commentaire(s)</h3>
                        <?php
							if( have_blog_comments() )
							{
								while($comment  = get_blog_comments())
								{
									$base		=	$this->instance->date->time($comment->timestamp);
							?>
                        <div class="media">
                            <div class="pull-left"> <img style="height:60px;" class="avatar img-circle" src="<?php 
										if(is_array($comment->author))
										{
											echo $comment->author['avatar_link'];
										}
										else
										{
											echo img_url('avatar_default.png');
										}
										;?>" alt=""> </div>
                            <div class="media-body">
                                <div class="well">
                                    <div class="media-heading"> <strong>
                                        <?php 
										if(is_array($comment->author))
										{
											echo $comment->author['PSEUDO'];
										}
										else
										{
											echo $comment->author;
										}
										;?>
                                        </strong>&nbsp; <small><?php echo $base;?></small> <a class="pull-right" href="#"><i class="icon-repeat"></i> Reply</a> </div>
                                    <p><?php echo $comment->content;?></p>
                                </div>
                                <!--/.media--> 
                            </div>
                        </div>
                        <?php
								}
							}
							else
							{
								?>
                        <p>Aucun commentaire disponible</p>
                        <?php
							}
							?>
                    </div>
                    <div class="pagination pagination-lg">
                        <?php if( pagination_exists() ) : ?>
                        <?php parse_pagination( array( 
								'parent_class'		=>	'',
								'parent'			=>	'ul',
								'li_active_class'	=>	'active',
								'wrapper'			=>	'div',
								'wrapper_class'		=>	'col-lg-12'
							));?>
                        <?php endif; ?>
                    </div>
                    <!--/#comments-list-->
                    <?php parse_notices( $array );?>
                    <div id="comment-form">
                        <h3>Laisser un commentaire</h3>
                        <form class="form" method="post">
                            <?php parse_form( 'blog_single_reply_form' );?>
                        </form>
                    </div>
                    <!--/#comment-form--> 
                </div>
                <!--/#comments--> 
            </div>
        </div>
        <?php
				}
				else
				{
					?>
        <p>Article introuvable ou indisponible.</p>
        <?php
				}
				?>
    </div>
</div>
