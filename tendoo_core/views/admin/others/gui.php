<?php 
	$ui_config	=	get_core_vars( 'ui_config' );
	$enabled	=	return_if_array_key_exists( 'enabled' , $ui_config ) 
		? return_if_array_key_exists( 'enabled' , $ui_config ) : array();
?>
<?php echo $lmenu;?>

<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <?php if( return_if_array_key_exists( 'pagination' , $enabled ) ) : ;?>
                <div class="col-sm-2 pull-left" id="ajaxLoading"> </div>
                <?php endif;?>
                <div class="col-sm-2"> </div>
                <div class="col-sm-4 text-center"> </div>
                <?php if( return_if_array_key_exists( 'pagination' , $enabled ) ) : ;?>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <li><a href="#" >Un lien</a></li>
                        <li><a href="#" >Un lien</a></li>
                        <li><a href="#" >Un lien</a></li>
                        <li><a href="#" >Un lien</a></li>
                    </ul>
                </div>
                <?php endif;?>
            </div>
        </footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                    	<?php if( $icon	=	return_if_array_key_exists( 'ICON_URL' , $opened_module[0] ) )
						{
							?>
                            <img class="pull-left" src="<?php echo $icon;?>" style="height:50px;margin:6px 12px 0px 0px;">
                            <?php
						}
						?>
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo output('notice');?> <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                    <div class="row">
                        <?php $total_width = 12;?>
                        <?php foreach( $this->cols as $key	=>	$c):?>
                        <?php if( ( $total_width - ( $c[ 'width' ] * 3 ) ) >= 0):?>
                        <?php $total_width -= ( $c[ 'width' ] * 3 );?>
                        <div class="col-lg-<?php echo $c[ 'width' ] * 3 ;?>">
                            <?php $config = return_if_array_key_exists( 'configs' , $this->cols[ $key ] );?>
                            <?php 
							if( is_array( $config ) )
							{
								foreach( $config as $key => $_v )
								{
									if( is_array( $_v ) )
									{
										foreach( $_v as $_k => $value )
										{
											if( $value[ 'type' ] == "collapsible_panel" )
											{
									?>
									<section class="panel pos-rlt clearfix" namespace="<?php echo $value[ 'namespace' ];?>">
										<header class="panel-heading">
											<ul class="nav nav-pills pull-right">
												<li> <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
											</ul>
											<?php echo return_if_array_key_exists( 'title' , $value );?> </header>
										<div class="panel-body <?php echo get_user_data( 'gui_'.$value[ 'namespace' ] );?> clearfix">
											<?php 
											$form_wrap	=	return_if_array_key_exists( 'form_wrap' , $value );
												$action	=	return_if_array_key_exists( 'action' , $form_wrap );
												$enctype	=	return_if_array_key_exists( 'enctype' , $form_wrap );
												$method	=	return_if_array_key_exists( 'method' , $form_wrap ) ? return_if_array_key_exists( 'method' , $form_wrap ) : "POST";
											$content	=	 return_if_array_key_exists( 'meta_fields' , $value );
											if( $form_wrap )
											{
											?>
											<form class="form" action="<?php echo $action;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
											<?php
											}
											if( is_array( $content ) )
											{
												foreach( $content as $c )
												{
													if( $c[ 'type' ] == "text" )
													{
														$placeholder 	= return_if_array_key_exists( 'placeholder' , $c );
														$label			= return_if_array_key_exists( 'label' , $c );
														$name			= return_if_array_key_exists( 'name' , $c );
														?>
										<div class="form-group">
											<div class="input-group">
											  <span class="input-group-addon"><?php echo $label ;?></span>
											  <input name="<?php echo $name;?>" type="text" class="form-control" placeholder="<?php echo $placeholder;?>">
											</div>
										</div>
														<?php
													}
													if( $c[ 'type' ] == "password" )
													{
														$placeholder 	= return_if_array_key_exists( 'placeholder' , $c );
														$label			= return_if_array_key_exists( 'label' , $c );
														$name			= return_if_array_key_exists( 'name' , $c );
														?>
										<div class="form-group">
											<div class="input-group">
											  <span class="input-group-addon"><?php echo $label ;?></span>
											  <input name="<?php echo $name;?>" type="password" class="form-control" placeholder="<?php echo $placeholder;?>">
											</div>
										</div>
														<?php
													}
													else if( $c[ 'type' ] == 'visual_editor' )
													{
														$placeholder 	= return_if_array_key_exists( 'placeholder' , $c );
														$value		 	= return_if_array_key_exists( 'value' , $c );
														$label			= return_if_array_key_exists( 'label' , $c );
														$name			= return_if_array_key_exists( 'name' , $c );
														$id				= return_if_array_key_exists( 'name' , $c );
														?>
													<div class="form-group">
														<div class="input-group">
														<?php
														echo $this->visual_editor->getEditor( array (
															'name'		=>	$name,
															'value'		=>	$value,
															'id'		=>	$id
														) );
														?>
														</div>
													</div>
														<?php
													}
													/**
													*	a Radio field must have at least 2 name in array;
													**/
													else if( $c[ 'type' ] == 'radio' ){
														$placeholder 	= return_if_array_key_exists( 'placeholder' , $c );
														$value		 	= return_if_array_key_exists( 'value' , $c );
														$label			= return_if_array_key_exists( 'label' , $c );
														$name			= return_if_array_key_exists( 'name' , $c );
														if( count( $value ) >= 2 && count( $value ) == count( $label ) && count( $value ) == count( $name ) )
														{
														?>
		<div class="form-group">
			<div class="btn-group" data-toggle="buttons">
			<?php for( $i = 0 ; $i < count( $name ) ; $i++ ): ?>
			  <label class="btn btn-primary">
				<input type="radio" name="<?php echo $name[ $i ];?>" id="option1" value="<?php echo $value[ $i ];?>"> <?php echo $label[ $i ];?>
			  </label>
			<?php endfor;?>
			</div>
		</div>
														<?php
														}
														else
														{
															?>
															<p>Champ "Radio" invalide. Incorrespondance entre les champs. GUI Library</p>
															<?php
														}
													}
													else if( $c[ 'type' ] == 'checkbox' )
													{
														$placeholder 	= return_if_array_key_exists( 'placeholder' , $c );
														$value		 	= return_if_array_key_exists( 'value' , $c );
														$label			= return_if_array_key_exists( 'label' , $c );
														$name			= return_if_array_key_exists( 'name' , $c );
														if( count( $value ) == count( $label ) && count( $value ) == count( $name ) )
														{
														?>
		<div class="form-group">
			<div class="btn-group" data-toggle="buttons">
			<?php for( $i = 0 ; $i < count( $name ) ; $i++ ): ?>
			  <label class="btn btn-primary">
				<input type="checkbox" name="<?php echo $name[ $i ];?>" id="option1" value="<?php echo $value[ $i ];?>"> <?php echo $label[ $i ];?>
			  </label>
			<?php endfor;?>
			</div>
		</div>
														<?php
														}
														else
														{
															?>
															<p>Champ "Checkbox" invalide. Incorrespondance entre les champs. GUI Library</p>
															<?php
														}
													}
													else if( $c[ 'type' ] == 'select' )
													{
														$placeholder 	= return_if_array_key_exists( 'placeholder' , $c );
														$value		 	= return_if_array_key_exists( 'value' , $c );
														$label			= return_if_array_key_exists( 'label' , $c );
														$name			= return_if_array_key_exists( 'name' , $c );
														$text			= return_if_array_key_exists( 'text' , $c );
														if( count( $value ) == count( $text ) )
														{
															?>
		<div class="form-group">
			<div class="input-group">
			  <span class="input-group-addon"><?php echo $label ;?></span>
			  <select name="<?php echo $name;?>" type="text" class="form-control">
				<?php if( $placeholder ):?>
					<option value=""><?php echo $placeholder;?></option>
				<?php endif;?>
				<?php for( $i = 0 ; $i < count( $text ) ; $i++ ): ?>
					<option value="<?php echo $value[ $i ];?>"><?php echo $text[ $i ];?></option>
				<?php endfor;?>
			  </select>
			</div>
		</div>                                                    
															<?php
														}
														else
														{
															?>
															<p>Champ "Select" invalide. Incorrespondance entre les champs. GUI Library</p>
															<?php
														}
													}
												}
											}
											else
											{
												echo $content;
											}
											$submit_text	=	return_if_array_key_exists( 'submit_text' , $form_wrap );
											$reset_text		=	return_if_array_key_exists( 'reset_text' , $form_wrap );
											if( $submit_text || $reset_text )
											{
											?>
											<hr class="line line-dashed">
											<div class="btn-group">
												<?php if( $submit_text ):?>
												  <button type="submit" class="btn <?php echo theme_button_class();?>"><?php echo $submit_text;?></button>
												<?php endif;?>
												<?php if( $reset_text ):?>
												  <button type="reset" class="btn <?php echo theme_button_false_class();?>"><?php echo $reset_text;?></button>
												<?php endif;?>
											</div>
											<?php
											}
											if( $form_wrap )
											{
											?>
											</form>
											<?php
											}
											?>
										</div>
									</section>
									<?php
											}
										}
									}
								}
							}
							?>
                        </div>
                        <?php endif;?>
                        <?php endforeach;?>
                        <script>
						$(document).ready(function(e) {
                            $('section[namespace]').each(function(){
								var parent	=	$(this);
								$(this).find('ul.nav li a.panel-toggle').bind('click',function(){
									var status	=	$(parent).find('div.panel-body').hasClass('collapse') ? "uncollapse" : "collapse";
									tendoo.set_user_data( 'gui_'+ $(parent).attr('namespace') , status );
								});
							});
                        });
						</script>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
