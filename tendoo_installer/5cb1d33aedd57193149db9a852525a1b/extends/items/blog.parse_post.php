<?php
		if(count($this->blogPost) > 0)
		{
		?>
        	<?php
			foreach($this->blogPost as $p)
			{
				$global	=	$this->core->tendoo->time($p['TIMESTAMP'],TRUE);
			?>
			<article itemscope itemtype="http://schema.org/Article" id="post-83" class="post-83 post type-post status-publish format-standard hentry category-featured category-tutorials">
				<header class="entry-header">
					<h1 itemprop="name" class="entry-title"><a href="<?php echo $p['LINK'];?>" rel="bookmark"><?php echo $p['TITLE'];?></a></h1>
				</header><!-- .entry-header -->
				<a href="<?php echo $p['FULL'];?>">
					<img itemprop="image" class="img-responsive" src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>">
				</a>
				<div class="entry-summary">
					<p itemprop="description"><?php echo word_limiter(strip_tags($p['CONTENT']),50);?> <a href="<?php echo $p['LINK'];?>" class="read-more">[Lire la suite]</a></p>
				</div><!-- .entry-summary -->
				<footer class="entry-meta">
					<span class="cat-links">
						dans <span class="categories">
								<a href="<?php echo $p['CATEGORY_LINK'];?>" itemprop="category"><?php echo $p['CATEGORY'];?></a>
							</span>
						<?php
						if($p['AUTHOR'] == TRUE)
						{
						?>
						par
							<span class="comments-link">
								<a href="<?php echo $this->core->url->site_url(array('account','profile',$p['AUTHOR']['PSEUDO']));?>" title="Comment on Etiam mauris tortor, pharetra quis lobortis in, pharetra in diam"><?php echo $p['AUTHOR']['PSEUDO'];?></a>
							</span>
						<?php
						}
						?>
						<div class="facebook" style="width:100px;"><iframe src="http://www.facebook.com/plugins/like.php?locale=en_US&href=<?php echo $p['LINK'];?>&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div>
				</footer>
			</article>
                <?php
			}
				?>
        <?php
		}
		else if($this->blogPost === FALSE)
		{
			?>
		<h3>Aucun article disponible</h3>
            <?php
		}
