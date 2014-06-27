<?php		if(count($this->blogPost) > 0)		{	?>
  		<?php foreach($this->blogPost as $p){	
			$global	=	$this->instance->date->time($p['TIMESTAMP'],TRUE); 
			$base		=	$this->instance->date->time($p['TIMESTAMP']);
		?>
<article class="post">

    <figure class="post-img">
        <a href="<?php echo $p['LINK'];?>"><img style="width:100%;" src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>"></a>
    </figure>

    <section class="date">
        <span class="day"><?php echo $global['d'];?></span>
        <span class="month"><?php echo $global['month'];?></span>
    </section>

    <section class="post-content">

        <header class="meta">
            <h2><a href="<?php echo $p['LINK'];?>"><?php echo $p['TITLE'];?></a></h2>
            <span>Dans 
            <?php
			for($i = 0;$i < count($p['CATEGORIES']); $i++)
			{ 
				if($i < 1)
				{
					if(isset($p['CATEGORIES'][$i+1]))
					{
				?>            
					<a href="<?php echo $p['CATEGORIES'][$i]['LINK'];?>"><?php echo $p['CATEGORIES'][$i]['TITLE'];?></a>,
				<?php
					}
					else
					{
				?>            
					<a href="<?php echo $p['CATEGORIES'][$i]['LINK'];?>"><?php echo $p['CATEGORIES'][$i]['TITLE'];?></a>
				<?php
					}
				}
				else if($i+ 1 == count($p['CATEGORIES']))
				{
					?>
                    <a href="javascript:void(0);">...</a>
                    <?php
				}
			}
			?>
            </span>
            <span><i class="halflings user icon-user"></i>Par <a href="<?php echo $this->url->site_url(array('account','profile',$p['AUTHOR']['PSEUDO']));?>"><?php echo $p['AUTHOR']['PSEUDO'];?></a></span>
            <?php 
			if(is_array($p['KEYWORDS']) && count($p['KEYWORDS']) > 0)
			{ 
			?>
            <span><i class="halflings tag icon-tags"></i>
				<?php 
                for($i = 0; $i < count($p['KEYWORDS']); $i++)
                {
					if($i < 1)
					{
						if(isset($p['KEYWORDS'][$i+1]))
						{
					?>
					<a href="<?php echo $p['KEYWORDS'][$i]['LINK']; ?>"><?php echo $p['KEYWORDS'][$i]['TITLE'];?></a>,
					<?php 
						}
						else
						{
					?>
					<a href="<?php echo $p['KEYWORDS'][$i]['LINK']; ?>"><?php echo $p['KEYWORDS'][$i]['TITLE'];?></a>
					<?php 
						}
					}
					else if($i+1 == count($p['KEYWORDS']))
					{
						?>
                        <a href="javascrip:void(0);">...</a>
                        <?php
					}
                } 
                ?>   
			</span>   
            <?php 
			} 
			?>
            <span><i class="halflings comments icon-comment"></i><a href="<?php echo $p['LINK'];?>#comments"><?php echo $p['COMMENTS'];?> Commentaire(s)</a></span>
        </header>

        <p><?php echo word_limiter(strip_tags($p['CONTENT']),80);?></p>

        <a href="<?php echo $p['LINK'];?>" class="button color">Lire la suite</a>

    </section>

</article>
<div class="line"></div>

<?php
		}
?>
<?php $this->pagination();?>
<?php	}		
		else if($this->blogPost === FALSE)		{			?>
<article class="post">

    <figure class="post-img">
        <a href=""><img src="<?php echo img_url('Hub_back.png');?>" alt="Aucun article"></a>
    </figure>

    <section class="date">
        <span class="day">00</span>
        <span class="month">00</span>
    </section>

    <section class="post-content">

        <header class="meta">
            <h2><a href="#">Aucun article disponible</a></h2>
            <span>Dans 
            </span>
            <span><i class="halflings user icon-user"></i>Par ???
            <span><i class="halflings comments icon-comment"></i><a href="#">0 Commentaire(s)</a></span>
        </header>

        <p>Aucun article disponible, veuillez vous connecter et publiez un nouvel article</p>

        <a href="<?php echo $this->url->site_url(array('admin'));?>" class="button color">Connectez-vous</a>

    </section>

</article>
<div class="line"></div>
<?php 	}	?>
