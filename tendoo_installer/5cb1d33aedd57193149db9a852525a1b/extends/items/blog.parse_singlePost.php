<?php
		if(count($this->singleBlogPost) > 0)
		{
	?>
	<div id="post-content" itemscope itemptype="http://schema.org/articleBody">

	<div class="feature-image">
		<a href="<?php echo $this->singleBlogPost['FULL'];?>" data-rel="prettyPhoto"><img itemprop="image" src="<?php echo $this->singleBlogPost['THUMB'];?>" alt="<?php echo $this->singleBlogPost['TITLE'];?> text" /></a>
	</div>
	<h1 class="post-heading" itemprop="name"><?php echo $this->singleBlogPost['TITLE'];?></h1>
	<div class="meta" itemprop="dateCreated">
		<span class="entry-date"><?php echo $this->core->tendoo->time($this->singleBlogPost['TIMESTAMP']);?></span>
		dans <span class="categories"><a href="<?php echo $this->singleBlogPost['CATEGORY_LINK'];?>"><?php echo $this->singleBlogPost['CATEGORY'];?></a><br />
		<?php
		if($this->singleBlogPost['AUTHOR'] == TRUE)
		{
		?>
		par
			<span class="comments-link">
				<a href="<?php echo $this->core->url->site_url(array('account','profile',$this->singleBlogPost['AUTHOR']['PSEUDO']));?>" title="Comment on Etiam mauris tortor, pharetra quis lobortis in, pharetra in diam"><?php echo $this->singleBlogPost['AUTHOR']['PSEUDO'];?></a>
			</span>
		<?php
		}
		?>
	</div>
	
	<div class="content-area" itemprop="description"><?php echo $this->singleBlogPost['CONTENT'];?></div>
    <meta itemprop="datePublished" content="<?php echo  $this->singleBlogPost['TIMESTAMP'];?>"/>
	<div class="clearfix"></div>
	<!-- comments list -->
	<div id="comments-wrap">
		<h3 class="heading"><?php echo $this->TT_SBP_comments;?> commentaires</h3>
		<ol class="commentlist">
			<?php
			if($this->TT_SBP_comments > 0)
			{
				$commentID	=	1;
				foreach($this->SBP_comments as $s)
				{
			?>	   
			<li itemscope itemtype="http://schema.org/UserComments" class="comment even thread-even depth-1" id="li-comment-<?php echo $commentID;?>">
				
				<div id="comment-1" class="comment-body clearfix">
					<div class="">
						<div class="col-lg-1" style="padding:0;">
							<img alt='' src='http://127.0.0.1/templates/01/pinball-pack/web/images/img3.jpg' class="thumbnail" />      
						</div>
						<div class="col-lg-11" style="padding:0;padding-left:5px;">
							<div itemprop="creator" class="comment-author vcard"><?php echo $s['AUTHOR'];?></div>
							<div class="comment-inner">
								<p itemprop="commentText"><?php echo $s['CONTENT'];?></p>
							</div>
							<div class="comment-meta commentmetadata">
								<span class="comment-date" itemprop="dateCreated"><?php echo $s['TIMESTAMP'];?></span>
								<span class="comment-reply-link-wrap"><a class='comment-reply-link' href='#respond' onclick='return addComment.moveForm("comment-1", "1", "respond", "432")'>R&eacute;pondre</a></span>
							</div>
						</div>
					</div>
				</div>
			</li>
            <?php
					$commentID++;
				}
			}
			?>
		</ol>
	</div>
	<!-- ENDS comments list -->
    <!-- pager -->
	<?php $this->pagination();?>
    <div class="clearfix"></div>	
	<!-- Respond -->
	<div class="col-lg-6">
	<div id="respond">
		<div class="cancel-comment-reply"><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Cancel reply</a></div>
		<?php $this->parseNotice();?>
        <?php $this->parseForm();?>
	</div>
	</div>
	<div class="clearfix"></div>
	<!-- ENDS Respond -->	
</div>
	<?php
		}
		else if($this->singleBlogPost	===	false)
		{
			?>
		<div id="posts-list">
        	<pre>Article introuvable disponible</pre>
        </div>
            <?php
		}
