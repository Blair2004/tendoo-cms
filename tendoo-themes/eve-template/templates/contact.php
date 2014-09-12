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
    <section class="content contact">
        <div class="container">
            <div class="row sub_content">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="maps"> </div>
                </div>
            </div>
            <div class="row sub_content">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="dividerHeading">
                        <h4><span>Get in Touch</span></h4>
                    </div>
                    <p>
                        <?php 
							$contact	=	get_contact_page( 'about_us' );
							echo return_if_array_key_exists( 'FIELD_CONTENT' , riake( 0 , $contact ) );
						?>
                    </p>
                    <div class="alert alert-success hidden alert-dismissable" id="contactSuccess">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Success!</strong> Your message has been sent to us. </div>
                    <div class="alert alert-error hidden" id="contactError">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Error!</strong> There was an error sending your message. </div>
                    <form id="contactForm" action="" novalidate="novalidate">
                        <?php parse_form( 'contact_form' );?>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="sidebar">
                        <div class="widget_info">
                            <div class="dividerHeading">
                                <h4><span><?php echo get_contact_page( 'adress_title' );?></span></h4>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adip, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <ul class="widget_info_contact">
                                <?php 
									if( is_array( get_contact_page( 'addresses' ) ) ){
										foreach( get_contact_page( 'addresses' ) as $_adress ){
											?>
                                <div><span><?php echo $_adress[ 'CONTACT_TYPE' ];?></span> <?php echo $_adress[ 'CONTACT_TEXT' ];?></div>
                                <?php
										}
									}
									;?>
                                <li><i class="fa fa-map-marker"></i>
                                    <p><strong>Address</strong>: #2021 Lorem Ipsum</p>
                                </li>
                                <li><i class="fa fa-user"></i>
                                    <p><strong>Phone</strong>:(+91) 9000-12345</p>
                                </li>
                                <li><i class="fa fa-envelope"></i>
                                    <p><strong>Email</strong>: <a href="#">mail@example.com</a></p>
                                </li>
                                <li><i class="fa fa-globe"></i>
                                    <p><strong>Web</strong>: <a href="#" data-placement="bottom" data-toggle="tooltip" title="www.example.com">www.example.com</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="widget_social">
                        	<?php get_items( 'contact_get_social' );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
