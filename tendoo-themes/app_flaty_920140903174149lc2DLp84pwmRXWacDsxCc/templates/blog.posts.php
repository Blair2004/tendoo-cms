<?php
$page	=	get_core_vars( 'page' );
?>
<section id="title" class="emerald" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1><?php echo get_page( 'title' );?></h1>
                <p><?php echo $page[0]['PAGE_DESCRIPTION'];?></p>
            </div>
            <?php get_breads();	?>
        </div>
    </div>
</section>
<section id="blog" class="container" style="padding-top:50px;">
    <div class="row">
        <?php $this->sidebar_right();?>
        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
                <?php
				if(have_blog_posts() !== false)
				{
					while($post	=	get_blog_posts())
					{
						$global		=	$this->instance->date->time($post->timestamp,TRUE); 
						$base		=	$this->instance->date->time($post->timestamp);
					?>
					<div class="blog-item"> <img class="img-responsive img-blog" src="<?php echo $post->thumb;?>" width="100%" alt="">
						<div class="blog-content"> <a href="<?php echo $post->link;?>">
							<h3><?php echo $post->title;?></h3>
							</a>
							<div class="entry-meta"> <span><i class="icon-user"></i> <a href="<?php echo $post->author_link;?>"><?php echo $post->author['PSEUDO'];?></a></span> <span><i class="icon-folder-close"></i> 
							<?php loop_categories($post->categories);?>
							</span> <span><i class="icon-calendar"></i> <?php echo $base;?></span> <span><i class="icon-comment"></i> <a href="<?php echo $post->link;?>#comments"><?php echo $post->comments;?> Commentaire(s)</a></span> </div>
							<p><?php echo word_limiter(strip_tags($post->content),100);?></p>
							<a class="btn btn-default" href="<?php echo $post->link;?>">Lire la suite <i class="icon-angle-right"></i></a> </div>
					</div>
					<?php
					}
				?>
				<?php if( pagination_exists() ) : ?>
					<?php parse_pagination( array( 
						'parent_class'		=>	'pagination pagination-lg',
						'parent'			=>	'ul',
						'li_active_class'	=>	'active'
					));?>
				<?php endif; ?>
				<?php
				}
				else
				{
					?>
                    <p>Aucun article disponible désolé</p>
                    <?php
				}
				?>
            </div>
        </div>
        <!--/.col-md-8--> 
    </div>
    <!--/.row--> 
</section>
<?php $this->sidebar_bottom();?>
