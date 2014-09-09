<?php
$page	=	get_core_vars( 'page' );
?>
<h1 class="page-header" style="margin-bottom:10px;">
    <?php echo get_page( 'title' );?><br />
    <small><?php echo $page[0]['PAGE_DESCRIPTION'];?></small>
</h1>
<div class="row">
<?php get_breads();?>
</div>
<div class="blog">
	<?php
    if(have_blog_posts() !== false)
    {
        while($post	=	get_blog_posts())
        {
            $global		=	$this->instance->date->time($post->timestamp,TRUE); 
            $base		=	$this->instance->date->time($post->timestamp);
        ?>
        <div class="blog-item" style="margin-bottom:10px;"> 
        	<img class="img-responsive img-blog" src="<?php echo $post->thumb;?>" width="100%" alt="">
            <div class="blog-content"> <a href="<?php echo $post->link;?>" >
                <h3><?php echo $post->title;?></h3>
                </a>
                <div class="entry-meta"> 
                	<span> <i class="icon-user"></i> <a href="<?php echo $post->author_link;?>"><?php echo $post->author['PSEUDO'];?></a></span>
                    <span> <i class="icon-folder-close"></i> 
	                	<?php loop_categories($post->categories);?>
                	</span> 
                    <span> <i class="icon-calendar"></i> <?php echo $base;?></span> 
                    <span> <i class="icon-comment"></i> <a href="<?php echo $post->link;?>#comments"><?php echo $post->comments;?> Commentaire(s)</a></span> 
				</div>
                <hr class="line" style="margin:5px 0;" />
                <p><?php echo word_limiter(strip_tags($post->content),100);?></p>
                <a class="btn btn-info btn-small" href="<?php echo $post->link;?>">Lire la suite</a> 
                <hr class="line" style="margin:10px 0;" />
			</div>
        </div>
        <?php
        }
    ?>
    <div class="pagination">
    <?php if( pagination_exists() ) : ?>
        <?php parse_pagination( array( 
            'parent_class'		=>	'',
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
        <p>Aucun article disponible désolé</p>
        <?php
    }
    ?>
</div>