<?php
$page	=	get_core_vars( 'page' );
?>
<?php
$page	=	get_core_vars( 'page' );
?>
<!--start wrapper-->
	<section class="wrapper">
		<section class="page_head">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<h2><?php echo get_page( 'title' );?></h2>
                        <?php get_breads();?>
					</div>
				</div>
			</div>
		</section>

		<section class="content blog">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    	<?php
						if(have_blog_single())
						{
							$post		=	get_blog_single();
							$global		=	$this->instance->date->time($post->timestamp,TRUE); 
							$base		=	$this->instance->date->time($post->timestamp);
						?>
						<div class="blog_single">
                            <article class="post">
                                <figure class="post_img">
                                    <a href="#">
                                        <img src="<?php echo $post->full;?>" alt="blog post">
                                    </a>
                                </figure>
                                <div class="post_date">
                                    <span class="day">28</span>
                                    <span class="month">Nov</span>
                                </div>
                                <div class="post_content">
                                    <div class="post_meta">
                                        <h2>
                                            <a href="#"><?php echo $post->title;?></a>
                                        </h2>
                                        <div class="metaInfo">
                                            <span><i class="fa fa-calendar"></i> <a href="#"><?php echo $base;?></a> </span>
                                            <span><i class="fa fa-user"></i> By <a href="<?php echo $post->author_link;?>"><?php echo $post->author[ 'PSEUDO' ];?></a> </span>
                                            <span><i class="fa fa-tag"></i> <?php loop_tags( $post->keywords );?> </span>
                                            <span><i class="fa fa-comments"></i> <a href="#"><?php echo $post->comments;?> Comments</a></span>
                                        </div>
                                    </div>
                                    <p><?php echo $post->content;?></p>
                                </div>
                                <!-- <ul class="shares">
                                    <li class="shareslabel"><h3>Share This Story</h3></li>
                                    <li><a class="twitter" href="#" data-placement="bottom" data-toggle="tooltip" title="Twitter"></a></li>
                                    <li><a class="facebook" href="#" data-placement="bottom" data-toggle="tooltip" title="Facebook"></a></li>
                                    <li><a class="gplus" href="#" data-placement="bottom" data-toggle="tooltip" title="Google Plus"></a></li>
                                    <li><a class="pinterest" href="#" data-placement="bottom" data-toggle="tooltip" title="Pinterest"></a></li>
                                    <li><a class="yahoo" href="#" data-placement="bottom" data-toggle="tooltip" title="Yahoo"></a></li>
                                    <li><a class="linkedin" href="#" data-placement="bottom" data-toggle="tooltip" title="LinkedIn"></a></li>
                                </ul> -->
                            </article>
                            <div class="about_author">
                                <div class="author_desc">
                                    <img src="<?php echo $post->author[ 'avatar_link' ];?>" alt="about author">
                                    <!--<ul class="author_social">
                                        <li><a class="fb" href="#." data-placement="top" data-toggle="tooltip" title="Facbook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a class="twtr" href="#." data-placement="top" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a class="skype" href="#." data-placement="top" data-toggle="tooltip" title="Skype"><i class="fa fa-skype"></i></a></li>
                                    </ul>-->
                                </div>
                                <div class="author_bio">
                                    <h3 class="author_name"><a href="#"><?php echo $post->author[ 'PSEUDO' ];?></a></h3>
                                    <!-- <h5>CEO at <a href="#">jQuery Rain</a></h5>-->
                                    <p class="author_det" style="min-height:100px;">
                                        <?php echo ( $bio = riake( 'bio' , $post->author ) ) != false ? $bio : "Aucune bio disponible pour cet auteur";?>
                                    </p>
                                </div>
                            </div>
                        </div>	
                        <div class="news_comments">
                            <div class="dividerHeading">
                                <h4><span>Comments (<?php echo $post->comments;?>)</span></h4>
                            </div>
                            <div id="comment">
                                <ul id="comment-list">
                                <?php
								if( have_blog_comments() )
								{
									while($comment  = get_blog_comments())
									{
										$base		=	$this->instance->date->time($comment->timestamp);
								?>
                                    <li class="comment">
                                        <div class="avatar"><img alt="" src="<?php 
										if(is_array($comment->author))
										{
											echo $comment->author['avatar_link'];
										}
										else
										{
											echo img_url('avatar_default.png');
										}
										;?>" class="avatar"></div>
                                        <div class="comment-container">
                                            <h4 class="comment-author"><a href="#"><?php 
										if(is_array($comment->author))
										{
											echo $comment->author['PSEUDO'];
										}
										else
										{
											echo $comment->author;
										}
										;?></a></h4>
                                            <div class="comment-meta"><a href="#" class="comment-date link-style1"><?php echo $base;?></a><a class="comment-reply-link link-style3" href="#comments">Reply »</a></div>
                                            <div class="comment-body">
                                                <p><?php echo $comment->content;?></p>
                                            </div>
                                        </div>
                                    </li>
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
                                </ul>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
								<?php if( pagination_exists() ) : ?>
                                    <?php parse_pagination( array( 
                                        'parent_class'		=>	'pagination pull-left mrgt-0',
                                        'parent'			=>	'ul',
                                        'li_active_class'	=>	'active'
                                    ));?>
                                <?php endif; ?>
                            </div>
                            <!-- /#comments -->
                            <?php parse_notices( $array );?>
                            <div class="dividerHeading">
                                <h4><span>Laisser un commentaire</span></h4>
                            </div>
                            <form class="form" method="post">
                                <?php parse_form( 'blog_single_reply_form' );?>
                            </form>
                        </div>
                        <?php
						}
						?>					
					</div>
					
					<!--Sidebar Widget-->
					<?php $this->sidebar_right();?>
				</div><!--/.row-->
			</div> <!--/.container-->
		</section>
	</section>
	<!--end wrapper-->