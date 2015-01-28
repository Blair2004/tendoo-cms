<?php
if( !function_exists( 'loop_items' ) ){
	function loop_items( $field , $namespace , $status , &$item_setting = array() ){
		// var_dump( $item_setting );
		$title			=	return_if_array_key_exists( 'input_title' , $field );
		$value			=	return_if_array_key_exists( 'input_value' , $field );
		$name			=	return_if_array_key_exists( 'input_name' , $field );
		$placeholder	=	return_if_array_key_exists( 'input_placeholder' , $field );
		$closing_bracket = ( $status == 'is_loopable' ) ? '[]' : '';
		$level_name		=	( $status == 'is_loopable' ) ? '[level]' : '';
			
		if( in_array( ( $type = return_if_array_key_exists( 'input_type' , $field ) ) , array( 'text', 'password', 'email', 'hidden' ) ) ){
			// This Fields does not support array
			$value	=	is_array( $value ) ? '' : $value;
			if( !($value	=	return_if_array_key_exists( $name , $item_setting ) ) ){
				$value	=	'';
			}
			/** Si la valeur enregistré est un tableau, l'on considère qu'il s'agit d'un élément loopable
			*	$value =  [ 'level' ][1][2][3][4]
			*	Le moyen de parcourir ces éléments sans accéder à la boucle est de supprimer la première valeur du tableau.
			**/
			if( is_array( $value ) ){
				array_shift( $item_setting[ $name ][ 'level' ] );
				$value	=	$value[ 'level' ][0];
			}
			?>

<div class="form-group">
    <div class="input-group input-group-sm">
        <span class="input-group-addon"><?php echo $title;?></span>
        <input type="<?php echo $type;?>" class="form-control" placeholder="<?php echo $placeholder;?>" value="<?php echo $value;?>" name="static[<?php echo $namespace;?>][<?php echo $name;?>]<?php echo $level_name ;?><?php echo $closing_bracket;?>">
    </div>
</div>
<?php	
		} 
		else if( $type == 'textarea' ) {
			// This Fields does not support array
			$value	=	is_array( $value ) ? '' : $value;
			if( !($value	=	return_if_array_key_exists( $name , $item_setting ) ) ){
				$value	=	'';
			}
			/** Si la valeur enregistré est un tableau, l'on considère qu'il s'agit d'un élément loopable
			*	$value =  [ 'level' ][1][2][3][4]
			*	Le moyen de parcourir ces éléments sans accéder à la boucle est de supprimer la première valeur du tableau.
			**/
			if( is_array( $value ) ){
				array_shift( $item_setting[ $name ][ 'level' ] );
				$value	=	$value[ 'level' ][0];
			}
			?>
<div class="form-group">
    <label for="global-fields-textarea-<?php echo $title;?>"><?php echo $title;?></label>
    <textarea name="static[<?php echo $namespace;?>][<?php echo $name;?>]<?php echo $level_name ;?><?php echo $closing_bracket;?>" class="form-control" id="global-fields-textarea-<?php echo $title;?>" placeholder="<?php echo $placeholder;?>"><?php echo $value;?></textarea>
</div>
<?php
		} 
		else if( $type == 'media_lib' ) {
			// This Fields does not support array
			$value	=	is_array( $value ) ? '' : $value;
			if( !($value	=	return_if_array_key_exists( $name , $item_setting ) ) ){
				$value	=	'';
			}
			/** Si la valeur enregistré est un tableau, l'on considère qu'il s'agit d'un élément loopable
			*	$value =  [ 'level' ][1][2][3][4]
			*	Le moyen de parcourir ces éléments sans accéder à la boucle est de supprimer la première valeur du tableau.
			**/
			if( is_array( $value ) ){
				array_shift( $item_setting[ $name ][ 'level' ] );
				$value	=	$value[ 'level' ][0];
			}
			?>
<div class="form-group">
    <label for="global-fields-textarea-<?php echo $title;?>"><?php echo $title;?></label>
    <?php
	get_core_vars( 'fmlib' )->mediaLib_button(array(
		'PLACEHOLDER'		=>		$placeholder,
		'NAME'				=>		'static[' . $namespace . '][' . $name . ']' . $level_name . $closing_bracket,
		'TEXT'				=>		$title,
		'VALUE'				=>		$value
	));	
	?>
</div>
<?php
		} 
		else if( $type == 'select' ) {
			// This Fields Support array
			$selected	=	'';
			if( is_array( $value ) ){
				if( $field_setting	=	return_if_array_key_exists( $name , $item_setting ) ){
					if( is_array( riake( 'level' , $item_setting[ $name ] ) ) ){
						$selected	=	$item_setting[ $name ][ 'level' ][0];
						array_shift( $item_setting[ $name ][ 'level' ] );
					} else if( riake( $name , $item_setting ) ) {
						$selected	=	$item_setting[ $name ];
					}
				}
			}
			$value	=	! is_array( $value ) ? array() : $value;
			
			?>
<div class="form-group">
    <div class="input-group input-group-sm">
        <span class="input-group-addon"><?php echo $title;?></span>
        <select class="form-control" placeholder="<?php echo $placeholder;?>" name="static[<?php echo $namespace;?>][<?php echo $name;?>]<?php echo $level_name ;?><?php echo $closing_bracket;?>">
            <option value=""><?php echo $placeholder !== false ? $placeholder : "Veuillez choisir une option";?></option>
            <?php
					foreach( $value as $option ){
						if( return_if_array_key_exists( 'value' , $option ) == $selected ){
						?>
            <option selected value="<?php echo return_if_array_key_exists( 'value' , $option );?>"><?php echo return_if_array_key_exists( 'text' , $option );?></option>
            <?php
						} else {
						?>
            <option value="<?php echo return_if_array_key_exists( 'value' , $option );?>"><?php echo return_if_array_key_exists( 'text' , $option );?></option>
            <?php
						}
					}
					?>
        </select>
    </div>
</div>
<?php
		}
	}
};
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
                            <p class="block text-muted">
                                <?php echo get_page('description');?>
                            </p>
                        </div>
                    </div>
                </header>
                <section class="vbox stretch">
                    <section class="wrapper">
                        <?php echo output('notice');?> <?php echo fetch_notice_from_url();?> <?php echo validation_errors();?>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#general" data-toggle="tab">Généraux</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="general">
                                <div class="panel">
                                    <div class="panel-body">
                                        <h4>Composantes : </h4>
                                        <div class="panel-group" id="accordion">
                                            <?php 
if( $items	=	return_if_array_key_exists( 'theme_items' , $active_theme ) ){
    if( is_array( $items ) ){
        foreach( $items as $key	=> $_item ){
			
            $description 	= return_if_array_key_exists( 'description' , $_item );
            $namespace		= return_if_array_key_exists( 'namespace' , $_item );
            $draggable		= return_if_array_key_exists( 'draggable' , $_item );
            $name		= return_if_array_key_exists( 'name' , $_item );
			$is_static  	= return_if_array_key_exists( 'is_static' , $_item );
			
            if( !$draggable && !$is_static ){
				
                $settings		= return_if_array_key_exists( 'theme_settings' , get_core_vars( 'active_theme' ) );
                $item_namespace	= return_if_array_key_exists( 'namespace' , $_item );
                $api_limit		= return_if_array_key_exists( 'api_limit' , riake( $item_namespace , $settings ) );
                $declared_apis	= return_if_array_key_exists( 'declared_apis' , riake( $item_namespace , $settings ) );
                ?>
                                            <form class="panel panel-default" method="post">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $namespace;?>"> <?php echo $name;?> </a> </h4>
                                                </div>
                                                <!-- collapse -->
                                                <div id="<?php echo $namespace;?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <?php 
															
														if( $description ){
															?>
                                                                <p>
                                                                    <strong>Description : </strong> <?php echo $description;?>
                                                                </p>
                                                                <?php
														} else {
															echo "Aucun description disponible";
														} 
														?>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon"><?php echo translate( 'show' );?></span>
                                                                        <input type="hidden" name="declared_item" value="<?php echo $namespace;?>">
                                                                        <select class="form-control" name="declared_apis">
                                                                            <option value=""><?php echo translate( 'choose_options' );?></option>
                                                                            <?php
																if( is_array( $apis	=	get_core_vars( 'api_declared' ) ) ){
																	foreach( $apis as $key => $api ){
																		if( $key == $declared_apis ){
																		?>
                                                                            <option selected value="<?php echo $api[ 'namespace' ];?>"><?php echo $api[ 'name'] ;?></option>
                                                                            <?php
																		} else {
																			?>
                                                                            <option value="<?php echo $api[ 'namespace' ];?>"><?php echo $api[ 'name'] ;?></option>
                                                                            <?php
																		}
																	}
																}
																?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon"><?php echo translate( 'limit_to' );?></span>
                                                                        <select class="form-control" name="api_limit">
                                                                            <option value="0"><?php echo translate( 'dont_show' );?> : <?php echo $_item[ 'name' ];?></option>
                                                                            <?php
																for( $i = 1 ; $i <= 30 ; $i ++ ){
																	if( $i == $api_limit ){
																	?>
                                                                            <option selected value="<?php echo $i;?>"> <?php echo $i;?> </option>
                                                                            <?php
																	} else {
																		?>
                                                                            <option value="<?php echo $i;?>"> <?php echo $i;?> </option>
                                                                            <?php
																	}
																}
																?>
                                                                        </select>
                                                                        <span class="input-group-addon"><?php echo translate( 'results' );?></span>
                                                                    </div>
                                                                </div>
                                                                <input type="submit" name="static_item" class="btn btn-sm <?php echo theme_button_class();?>" value="<?php echo translate( 'save_settings' );?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
											}
										}
									};
								}								
if( $static_items = return_if_array_key_exists( 'theme_items' , $active_theme ) ){
	if( is_array( $static_items ) ){
		foreach( $static_items as $namespace => $item ){
			// Seul les éléments statics sont parcouru
			if( $is_static  =	return_if_array_key_exists( 'is_static' , $item ) ){
				$description	=	return_if_array_key_exists( 'description' , $item );
				$title			=	return_if_array_key_exists( 'title' , $item );
				$name		=	return_if_array_key_exists( 'name' , $item );
				$settings		=	get_active_theme_vars( 'theme_settings' );
				$item_setting	=	return_if_array_key_exists( $namespace , $settings ) 
					? return_if_array_key_exists( $namespace , $settings ) : array();
			?>
                                            <form class="panel panel-default" method="post">
                                                <input type="hidden" name="is_static_item" value="true">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $namespace;?>"> <?php echo $name;?> </a> </h4>
                                                </div>
                                                <!-- collapse -->
                                                <div id="<?php echo $namespace;?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <?php
							/**
							*	recupération des champs globaux, qui ne peuvent pas être loopable
							**/
							$global_field	=	return_if_array_key_exists( 'item_global_fields' , $item );
							if( count( $global_field ) > 0 && is_array( $global_field ) ){
								foreach( $global_field as $field ){									
									?>
                                                            <div class="col-lg-12">
                                                                <?php loop_items( $field , $namespace , 'is_not_loopable' , $item_setting );	?>
                                                            </div>
                                                            <?php
								}
							}
							?>
                                                            <div class="col-lg-4">
                                                                <strong>Description : </strong><?php echo strip_tags( $description );?>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <?php
// Combien de données ont été enregistrées ?
$totalFields	=	0; // valeur par défaut;
foreach( $item_setting as $setting ){
	if( $fields_settings = return_if_array_key_exists( 'level' , $setting ) ){
		$totalFields = count( $fields_settings );
	}
}
/** 
*	Si le nombre total d'enregistrement vaut zero, nous attribuons la valeur 1 pour qu'il y ait au moins un parcour
**/
	$totalFields	=	( $totalFields  == 0 ) ? 1 : $totalFields;
	
// S'il y a des données enregistrés pour les items loopables, on considère que le nombre de ces données équivaut le nombre des enregistrement
if( $totalFields > 0 ){
	/**
	*	Si les champs "loopables" sont défini, alors il peut y avoir parcours, sinon une meta box vide sera affichée.
	**/
	if( return_if_array_key_exists( 'item_loopable_fields' , $item ) ) :
	/**
	*	à chaque appel de la fonction loop_items, la valeur attribué aux champs devront varier en fonction des enregistrements.
	**/
		for( $i = 0 ; $i < $totalFields ; $i++ ){
?>
                                                                <section class="panel pos-rlt clearfix duplicator">
                                                                    <header class="panel-heading">
                                                                        <ul class="nav nav-pills pull-right duplicator-panel">
                                                                            <li> <a href="#" class="text-muted"><i class="fa fa-plus text"></i></a> </li>
                                                                            <li> <a href="#" class="text-muted"><i class="fa fa-minus text"></i></a> </li>
                                                                        </ul>
                                                                        Option multiples </header>
                                                                    <div class="panel-body">
                                                                        <?php 
if( $loopable_field =	return_if_array_key_exists( 'item_loopable_fields' , $item ) ){
	
	if( is_array( $loopable_field ) ){
		foreach( $loopable_field as $field ){
			loop_items( $field , $namespace , 'is_loopable' , $item_setting );											
		}
	}
}
?>
                                                                    </div>
                                                                </section>
                                                                <?php
	}
	endif;
}
?>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <br>
                                                                <input type="submit" class="btn <?php echo theme_button_class();?> btn-sm" value="Enregistrer">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php		
			}
		}
	}
};
?>
                                            <script>
	$(document).ready(function(e) {
		var cloner	=	new function(){
			var bind	=	function(){
				$('.duplicator-panel').each(function(){
					if( !tools.isDefined( $(this).attr( 'binded' ) ) ){
						$(this).attr( 'binded' , 'true' );
						// Adding
						$(this).find( 'li' ).eq(0).bind( 'click' , function(){
							var clone	=	$(this).closest( '.duplicator' ).clone();
							$(clone).find( '.duplicator-panel' ).removeAttr( 'binded' );
							// Reset Values
							$(clone).find( 'input' ).each(function(){
								$(this).val('');
							});
							// Reset Values
							$(clone).find( 'textarea' ).each(function(){
								$(this).val('');
							});
							$(clone).insertAfter( $(this).closest( '.duplicator' ) );
							bind();
						});
						// Removing
						$(this).find( 'li' ).eq(1).bind( 'click' , function(){
							if( $(this).closest( '.duplicator' ).parent().children( '.duplicator' ).length > 1 ){
								$(this).closest( '.duplicator' ).fadeOut(500,function(){
									$(this).remove();
								});
							}
s						});
					}
				})
			}
			bind();
		}
	});
</script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                </div>
            </footer>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
<?php
	get_core_vars( 'fmlib' )->mediaLib_load();
	?>
