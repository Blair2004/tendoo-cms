<?php if(count($this->singleBlogPost) > 0)		{	
	$global	=	$this->instance->date->time($this->singleBlogPost['TIMESTAMP'],TRUE); 
	$base		=	$this->instance->date->time($this->singleBlogPost['TIMESTAMP']);
?>
<article class="post">
    <figure class="post-img picture">
        <a href="<?php echo $this->singleBlogPost['FULL'];?>" rel="fancybox" title="First Light on the Lake"><img src="<?php echo $this->singleBlogPost['THUMB'];?>" alt="<?php echo $this->singleBlogPost['TITLE'];?>"></a>
    </figure>

    <section class="date">
        <span class="day">28</span>
        <span class="month">Dec</span>
    </section>

    <section class="post-content">

        <header class="meta">
            <h2><a href="javascript:void(0);"><?php echo $this->singleBlogPost['TITLE'];?></a></h2>
            <span><i class="halflings user icon-user"></i>Par : <a href="<?php echo $this->url->site_url(array('account','profile',$this->singleBlogPost['AUTHOR']['PSEUDO']));?>"><?php echo $this->singleBlogPost['AUTHOR']['PSEUDO'];?></a></span>
            <br>
            <span><i class="halflings icon-quote-right"></i>Dans :
                <?php 
				for($i = 0; $i < count($this->singleBlogPost['CATEGORIES']); $i++)
				{
					if($i+1 == count($this->singleBlogPost['CATEGORIES']))
					{ 
				?> 
                    <a href="<?php echo $this->singleBlogPost['CATEGORIES'][$i]['LINK'];?>"><?php echo $this->singleBlogPost['CATEGORIES'][$i]['TITLE'];?></a>
                <?php
					}
					else
					{
				?> 
                    <a href="<?php echo $this->singleBlogPost['CATEGORIES'][$i]['LINK'];?>"><?php echo $this->singleBlogPost['CATEGORIES'][$i]['TITLE'];?></a>, 
                <?php
					}
				} 
				?> 
            </span>
            <?php if(is_array($this->singleBlogPost['KEYWORDS']) && count($this->singleBlogPost['KEYWORDS']) > 0){ ?>
            <br>
            <span><i class="halflings tag icon-tag"></i>Mots-clés :
            	<?php 
				for($i = 0; $i < count($this->singleBlogPost['KEYWORDS']); $i++)
				{ 
					if($i+1 == count($this->singleBlogPost['KEYWORDS']))
					{
				?>
                	<a href="<?php echo $this->singleBlogPost['KEYWORDS'][$i]['LINK']; ?>"><?php echo $this->singleBlogPost['KEYWORDS'][$i]['TITLE']; ?></a>
				<?php
					}
					else
					{
				?>
                	<a href="<?php echo $this->singleBlogPost['KEYWORDS'][$i]['LINK']; ?>"><?php echo $this->singleBlogPost['KEYWORDS'][$i]['TITLE']; ?></a>,
				<?php
					}
				} 
				?>
			<?php
			}
			?>		
            </span>
            <br>
            <span><i class="halflings comments icon-comments"></i>Avec : <a href="#"><?php echo $this->TT_SBP_comments;?> commentaire(s)</a></span>
            <!-- SOCIAL INTEGRATION -->
            <span style="margin:5px 0px;"><div class="g-plus" data-action="share"></div>

<!-- Placez cette ballise après la dernière balise Partager. -->
<script type="text/javascript">
  window.___gcfg = {lang: 'fr'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script></span>
			<div class="clearfix"></div>
			<span>
            	<div id="fb-root"></div>
<script id="facebook">(function(d, s, id) {
  var js, fjs = d.getElementsById(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=357168941033596&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'facebook', 'facebook-jssdk'));</script>
			<div class="fb-share-button" data-href="" data-type="button_count"></div>
            </span>
			<!-- ENDS SOCIAL INTEGRATION -->
        </header>

        <p><?php echo $this->singleBlogPost['CONTENT'];?></p>

    </section>

</article>
<div class="line"></div>
<section class="comments-sec">
<h3><?php echo $this->TT_SBP_comments;?> commentaire(s)</h3>
<br>
<br>
<br>
<?php	if($this->TT_SBP_comments > 0)			{ ?>
    <ol class="commentlist" id="comments">
    	<?php $commentID	=	1;	foreach($this->SBP_comments as $s)	{ ?>
        <li style="width:100%;margin:5px 0 50px 0;float:left;padding:10px 0;">
            <div class="comment">
                <div class="avatar"><img src="http://www.gravatar.com/avatar/88930f2341cc3ce9c2688b2b3b5d69e3?s=60&amp;d=identicon" alt=""> </div>
                <div class="comment-des"><div class="arrow-comment"></div>
                    <div class="comment-by"><strong><?php echo $s['AUTHOR']['PSEUDO'] ;?></strong><span class="reply"><span style="color:#ccc">/ </span><a href="#commentform">Répondre</a></span><span class="date"><?php echo $s['TIMESTAMP'];?></span></div>
                    <p><?php echo $s['CONTENT'];?></p>
                </div>
                <div class="clearfix"></div>
             </div>
        </li>
        <?php };?>
	<?php	};?>
     </ol>
</section>
<section class="comments-sec">
     <section id="contact">
	<?php $this->parseNotice();?>
    <?php $this->parseForm();?>
    </section>
</section>

<?php
}
else
{
}
?>

