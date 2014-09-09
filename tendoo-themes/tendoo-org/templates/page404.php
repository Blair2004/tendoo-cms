<?php
$page	=	get_core_vars( 'page' );
?>
<section id="error" class="container">
    <h1>404, Page not found</h1>
    <p>The Page you are looking for doesn't exist or an other error occurred.</p>
    <a class="btn btn-success" href="<?php echo $this->url->main_url();?>">GO BACK TO THE HOMEPAGE</a>
</section>
<?php $this->sidebar_bottom();?>
