<?php
$page	=	get_core_vars( 'page' );
?>
    <section class="wrapper">
		<section class="page_head">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<h2><?php echo get_page( 'title' );?></h2>
                        <?php get_breads();?>
					</div>
				</div>
			</div>
		</section>
		
		
		<section class="content not_found">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12">
						<div class="page_404">
							<h1>404</h1>
							<p>Sorry, Page you're looking for is not found</p>
							<a href="<?php echo $this->url->main_url();?>" class="btn btn-default btn-lg back_home">
								<i class="fa fa-arrow-circle-o-left"></i>
								<?php echo translate( 'home' );?>
							</a>
						</div>
					</div>
				</div>
				
			</div>
		</section>		
		
	</section>