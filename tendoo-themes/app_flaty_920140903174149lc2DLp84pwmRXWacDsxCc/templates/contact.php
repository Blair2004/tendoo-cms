<section id="title" class="emerald" style="padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1><?php echo get_page( 'title' );?></h1>
                <p><?php echo get_page( 'description' );?></p>
            </div>
            <?php get_breads();?>
        </div>
    </div>
</section>
<section id="blog" class="container" style="padding-top:50px;">
    <div class="row">
        <?php $this->sidebar_right();?>
        <div class="col-sm-8 col-sm-pull-4">
            <div class="blog">
            	<div class="row">
                	<div class="col-sm-6">
                    	<h3><?php echo get_contact_page( 'about_us_title' );?></h3>
                        <p>
							<?php 
								$contact	=	get_contact_page( 'about_us' );
								echo return_if_array_key_exists( 'FIELD_CONTENT' , riake( 0 , $contact ) );
							?>
						</p>
                    </div>
                    <div class="col-sm-6">
                    	<h3><?php echo get_contact_page( 'adress_title' );?></h3>
						<?php 
						if( is_array( get_contact_page( 'addresses' ) ) ){
							foreach( get_contact_page( 'addresses' ) as $_adress ){
								?>
                                <div><span><?php echo $_adress[ 'CONTACT_TYPE' ];?></span> <?php echo $_adress[ 'CONTACT_TEXT' ];?></div>
                                <?php
							}
						}
						;?>
                    </div>
                </div>
                <form class="form-horizontal" role="form" method="post">
                    <?php parse_form( 'contact_form' );?>
                </form>
            </div>
        </div>
        <!--/.col-md-8--> 
    </div>
    <!--/.row--> 
</section>
<?php $this->sidebar_bottom();?>
