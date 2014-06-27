<?php
if(strlen($this->indexAboutUs) > 1)
{
?>	
<div class="container floated">
	<div class="blank floated">
            <h3 class="margin-1"><?php echo $this->indexAboutUsTitle;?></h3>
    
            <!-- Testimonial Rotator -->
            <div class="testimonials margin-1"><?php echo $this->indexAboutUs;?></div>
            <!-- Testomonial Rotator / End -->
	</div>
</div>
<?php
}