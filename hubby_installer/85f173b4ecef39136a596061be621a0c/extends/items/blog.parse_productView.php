<?php

		if(count($this->productView) > 0)
		{
		?>
        <div id="posts-list">
        	<?php
			foreach($this->productView as $p)
			{
				$global	=	$this->core->hubby->time($p['TIMESTAMP'],TRUE);
			?>
            <article class="format-standard">
                
                <div class="feature-image">
                    <a href="<?php echo $p['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>" /></a>
                </div>
                
                <h1><a href="<?php echo $p['LINK'];?>" class="post-heading"><?php echo $p['TITLE'];?></a></h1>
                <div class="meta">
                	<?php
					if(is_numeric($p['PRICE']))
					{
					?>
                	<span>Prix : <?php echo $this->productListingDevise;?> <?php echo $p['PRICE'];?></span> - 
                    <?php
					}
					else
					{
						?>
                	<span><?php echo $p['PRICE'];?></span>
                        <?php
					}
					?>
                    <span class="entry-date"><?php echo $this->core->hubby->time($p['TIMESTAMP']);?></span>
                    dans <span class="categories"><a href="<?php echo $p['CATEGORY_LINK'];?>"><?php echo $p['CATEGORY'];?></a></span>
                </div>
                <div class="excerpt"><?php echo word_limiter(strip_tags($p['CONTENT']),50);?>
                </div>
                <a href="<?php echo $p['LINK'];?>" class="read-more"><?php echo $p['LINK_TEXT'];?></a>
                <?php
				if($p['ADD_LINK'] != '#')
				{
				?>
                <a href="<?php echo $p['ADD_LINK'];?>" class="read-more"><?php echo $p['ADD_TEXT'];?></a>
                <?php
				}
				if($p['REMOVE_LINK'] != '#')
				{
				?>
                <a href="<?php echo $p['REMOVE_LINK'];?>" class="read-more"><?php echo $p['REMOVE_TEXT'];?></a>
                <?php
				}
				if($p['LOGIN_LINK'] != '#')
				{
				?>
                <a href="<?php echo $p['LOGIN_LINK'];?>" class="read-more"><?php echo $p['LOGIN_TEXT'];?></a>
                <?php
				}
				?>
            </article>
                <?php
			}
				?>
        </div>
        <?php
		}
		else if($this->blogPost === FALSE)
		{
			var_dump($this->blogPost);
			?>
		<div id="posts-list">
        	<pre>Aucun article disponible</pre>
        </div>
            <?php
		}
	
	