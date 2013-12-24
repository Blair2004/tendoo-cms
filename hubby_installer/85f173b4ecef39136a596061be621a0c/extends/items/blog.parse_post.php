<?php
		if(count($this->blogPost) > 0)
		{
		?>
        <div id="posts-list">
        	<?php
			foreach($this->blogPost as $p)
			{
				$global	=	$this->core->hubby->time($p['TIMESTAMP'],TRUE);
			?>
            <article class="format-standard" itemscope itemtype="http://schema.org/Article">
                
                <div class="feature-image" >
                    <a href="<?php echo $p['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $p['THUMB'];?>" itemprop="image" alt="<?php echo $p['TITLE'];?>" /></a>
                </div>
                <h1><a href="<?php echo $p['LINK'];?>" class="post-heading" itemprop="name"><?php echo $p['TITLE'];?></a></h1>
                <div class="meta">
                    <span class="entry-date"><?php echo $this->core->hubby->time($p['TIMESTAMP']);?></span>
                    dans <span class="categories"><a href="<?php echo $p['CATEGORY_LINK'];?>" itemprop="category"><?php echo $p['CATEGORY'];?></a></span>
                </div>
                <div class="excerpt" itemprop="description"><?php echo word_limiter(strip_tags($p['CONTENT']),50);?>
                </div>
                <meta itemprop="datePublished" content="<?php echo $p['DATE'];?>"/>
                <a href="<?php echo $p['LINK'];?>" class="read-more">Lire la suite</a>
            </article>
                <?php
			}
				?>
        </div>
        <?php
		}
		else if($this->blogPost === FALSE)
		{
			?>
		<div id="posts-list">
        	<pre>Aucun article disponible</pre>
        </div>
            <?php
		}
