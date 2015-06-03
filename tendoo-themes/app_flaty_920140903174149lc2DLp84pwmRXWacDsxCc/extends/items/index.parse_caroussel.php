<section class="flexslider home">
    <ul class="slides">
        <?php
	if(count($this->carousselElement) > 0)
	{
		foreach($this->carousselElement as $caroussel)
		{
	?>
        <li><img src="<?php echo $caroussel['IMAGE'];?>" style="max-height:400px;" alt="<?php echo $caroussel['TITLE'];?>">
            <article class="slide-caption">
                <h3><a href="<?php echo $caroussel['LINK'];?>" style="color:white;"><?php echo $caroussel['TITLE'];?></a></h3>
                <p><?php echo word_limiter(strip_tags($caroussel['CONTENT']),50);?></p>
            </article>
        </li>
        <?php
		}
	}
	else
	{
		?>
        <li><img src="<?php echo img_url('Hub_back.png');?>" alt="">
            <article class="slide-caption">
                <h3>Aucun article disponible</h3>
                <p>Aucun article disponible, veuillez publier un nouvel article depuis l'interface d'administration.</p>
            </article>
        </li>
        <?php
	}
	?>
    </ul>
</section>
