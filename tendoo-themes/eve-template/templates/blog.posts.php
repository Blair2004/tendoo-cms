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
						<div class="blog_medium">
                        	<?php
							if(have_blog_posts() !== false)
							{
								while($post	=	get_blog_posts())
								{
									$full_date		=	$this->instance->date->time($post->timestamp,TRUE); 
									$date			=	$this->instance->date->time($post->timestamp);
									// loop_categories($post->categories);
								?>
							<article class="post">
								<div class="post_date">
									<span class="day"><?php echo riake( 'd' , $full_date );?></span>
									<span class="month"><?php echo riake( 'm' , $full_date );?></span>
								</div>
								<figure class="post_img">
									<a href="<?php echo $post->link;?>">
										<img src="<?php echo $post->thumb;?>" alt="blog post">
									</a>
								</figure>
								<div class="post_content">
									<div class="post_meta">
										<h2>
											<a href="<?php echo $post->link;?>"><?php echo $post->title;?></a>
										</h2>
										<div class="metaInfo">
											<span><i class="fa fa-user"></i> By <a href="#"><?php echo $post->author['PSEUDO'];?></a> </span>
											<span><i class="fa fa-comments"></i> <a href="#"><?php echo $post->comments;?> <?php _e( 'comments' );?></a></span>
										</div>
									</div>
									<p><?php echo word_limiter(strip_tags($post->content), 50);?></p>
									<a class="btn btn-small btn-default" href="<?php echo $post->link;?>"><?php _e( 'Read More' );?></a>
									
								</div>
							</article>
							<?php
								}
							?>
							<div class="col-lg-12 col-md-12 col-sm-12">
								<?php if( pagination_exists() ) : ?>
                                    <?php parse_pagination( array( 
                                        'parent_class'		=>	'pagination pull-left mrgt-0',
                                        'parent'			=>	'ul',
                                        'li_active_class'	=>	'active'
                                    ));?>
                                <?php endif; ?>
                            </div>
							<?php
							}
							else
							{
								?>
								<p><?php _e( 'No posts available' );?></p>
								<?php
							}
							?>
							
						</div>
						
					</div>

					<!--Sidebar Widget-->
					<?php $this->sidebar_right();?>
				</div><!--/.row-->
			</div> <!--/.container-->
		</section>
	</section>
	<!--end wrapper-->