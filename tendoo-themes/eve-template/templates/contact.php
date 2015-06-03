<?php
$contact_datas	=	get_items( 'contact_datas' );
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
    <section class="content contact">
        <div class="container">
            <div class="row sub_content">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="maps" id="page_maps"> </div>
                </div>
            </div>
            <div class="row sub_content">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="dividerHeading">
                        <h4><span><?php echo ( $title = riake( 'contact_description_title' , $contact_datas ) ) == true ? $title : "Custom title" ;?></span></h4>
                    </div>
                    <p>
                        <?php echo ( $content = riake( 'contact_description_content' , $contact_datas ) ) == true ? $content : "Custom content. Please log to your theme customizer to edit this area." ;?>
                    </p>
                    <?php parse_notices( $array );?>
                    <form id="contactForm" action="" method="post" novalidate="novalidate">
                        <?php parse_form( 'contact_form' );?>
                    </form>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="sidebar">
                        <div class="widget_info">
                            <div class="dividerHeading">
                                <h4><span><?php echo ( $title  = riake( 'contact_details_title' ,  $contact_datas ) ) == true ? $title : "Custom Title" ;?></span></h4>
                            </div>
                            <p><?php echo ( $content = riake( 'contact_details_content' , $contact_datas ) ) == true ? $content : "Custom content" ;?></p>
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
                                    <?php 
									if( count( riake( 'level' , riake( 'social_feeds_icon' , $contact_datas ) ) ) > 0 )
									{
										for( $i = 0; $i < count( riake( 'level' , riake( 'social_feeds_icon' , $contact_datas ) ) ) ; $i++ )
										{
											?>
										
									<li><i class="fa fa-<?php echo $contact_datas[ 'social_feeds_icon' ][ 'level' ][ $i ];?>"></i>
										<p><strong><?php echo $contact_datas[ 'social_feeds_title' ][ 'level' ][ $i ];?></strong>: <?php echo $contact_datas[ 'social_feeds_value' ][ 'level' ][ $i ];?></p>
									</li>
									<?php
										}
									}
									?>
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
