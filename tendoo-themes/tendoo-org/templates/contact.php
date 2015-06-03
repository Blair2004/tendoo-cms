<h1 class="page-header" style="margin-bottom:10px;">
    <?php echo get_page( 'title' );?><br />
    <small><?php echo get_page( 'description' );?></small>
</h1>
<div class="row">
<?php get_breads();?>
</div>
<div class="blog">
    <div class="row">
        <div class="span6">
            <p>
                <?php 
                    $contact	=	get_contact_page( 'about_us' );
                    echo return_if_array_key_exists( 'FIELD_CONTENT' , riake( 0 , $contact ) );
                ?>
            </p>
        </div>
        <div class="span6">
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