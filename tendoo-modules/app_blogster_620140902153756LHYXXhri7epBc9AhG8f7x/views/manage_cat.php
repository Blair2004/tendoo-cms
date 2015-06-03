<?php 
ob_start();
?>
<form action="" class="panel-body" method="post">
    <div class="form-group">
        <span class="notice">Une cat&eacute;gorie ne peut &ecirc;tre supprim&eacute;e si certaines publications y sont encore attach&eacute;es. Rassurez-vous qu'aucun article n'est rattach&eacute; &agrave; cette cat&eacute;gorie avant de la supprimer</span>
    </div>
    <input type="hidden" value="<?php echo $cat['id'];?>" name="cat_id_for_deletion">
    <input type="hidden" value="ALLOWCATDELETION" name="allower">
    <input class="btn btn-sm btn-danger" type="submit" value="supprimer la cat&eacute;gorie">
</form>
<?php
$content	=	ob_get_clean();
 
$this->gui->cols_width( 1 , 3 );

$this->gui->set_meta( array( 
	'namespace'		=>		'manage-categorie',
	'title'			=>		__( 'Edit a category' ),
	'type'			=>		'panel'
) )->push_to( 1 );

$this->gui->set_item( array(
	'type'			=>	'dom',
	'value'			=>	$content
) )->push_to( 'manage-categorie' );


$this->gui->get();

return;
?>
<?php echo $inner_head;?>
<section id="w-f">
    <section class="hbox stretch">
		<?php echo $lmenu;?>
        <section class="vbox">
        	<section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> 
					<?php echo output('notice');?> 
					 
					<?php echo fetch_notice_from_url();?>
					<?php echo validation_errors(); ?> 
                    
                    <section class="panel">
                        <div class="panel-heading">Supprimer la cat&eacute;gorie</div>
                        
                    </section>
                </section>
            </section>
        </section>
        	
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>