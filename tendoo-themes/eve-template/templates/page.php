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
<?php echo get_active_theme_vars( 'page_content' );?>