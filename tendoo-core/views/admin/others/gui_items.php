<?php
	$panel		=	get_core_vars( 'panel' );
	$form_wrap	=	riake( 'form_wrap' , $panel , '');
	$action		=	riake( 'action' , $form_wrap , '' );
	$enctype	=	riake( 'enctype' , $form_wrap , '');
	$method		=	riake( 'method' , $form_wrap , "POST" );
	$content	=	riake( 'meta_items' , $panel );
	$form_expire=	get_instance()->date->timestamp() + GUI_EXPIRE;
	$ref		=	urlencode( get_instance()->url->site_url() );
	
	if( riake( 'gui_saver' , $form_wrap ) ) // Overwriting setted action
	{
		$action	=	get_instance()->url->site_url( array( 'admin' , 'options' , 'save' ) );
	}
	if( $form_wrap )
	{
		/**
		 *	@new	:	class, id
		 *	@since	:	1.4
		**/
	?>
	<form class="form <?php echo riake( 'class' , $form_wrap );?>" id="<?php echo riake( 'id' , $form_wrap );?>" action="<?php echo $action;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
    	<input type="hidden" name="gui_saver_ref" value="<?php echo $ref;?>" />
        <input type="hidden" name="gui_saver_option_namespace" value="<?php echo riake( 'namespace' , $panel );?>" />
        <input type="hidden" name="gui_saver_expiration_time" value="<?php echo $form_expire;?>" />
        <input type="hidden" name="gui_saver_use_namespace" value="<?php echo riake( 'use_namespace' , $form_wrap , false ) ? 'true' : 'false';?>" />
	<?php
	}
	if( is_array( $content ) )
	{
		foreach( $content as $item )
		{
			// Since it's used by inputs and textarea
			$attrs				= riake( 'attrs' , $item );
			$attrs_string		= riake( 'attrs_string' , $item , '' );
			foreach( force_array( $attrs ) as $key => $value )
			{
				if( is_array( $value ) ) // for multiple attrs in buttons types item
				{
					$unique_string	=	'';
					foreach( $value as $__key	=>	$__value )
					{
						$unique_string	.=	$__key . '="' . $__value . '" ';
					}
					$attrs_string[]	= 	$unique_string;
				}
				else
				{
					$attrs_string .= $key . '="' . $value . '" ';
				}
			}
			$description		= '<em style="margin-left:5px;margin-top:0px;font-style:normal;display:block">' . strip_tags( riake( 'description' , $item , '' ) ) . '</em>';
			
			// Providing "Type" is now required
			if( in_array( riake( 'type' , $item  ) , array( "text" , 'password' , 'file' ) ) )
			{
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				$value			= return_if_array_key_exists( 'value' , $item );			
				?>
<div class="form-group">
	<?php
		/**
		 * 	Hide Label if not set
		**/
		if( $label )
		{
			?>
	<div class="input-group">
	  <span class="input-group-addon"><?php echo $label ;?></span>
	  <input name="<?php echo $name;?>" <?php echo $attrs_string;?> type="<?php echo $item[ 'type' ];?>" class="form-control" placeholder="<?php echo $placeholder;?>" value="<?php echo $value;?>">
	</div>
          <?php
		}
		else
		{
			?>
            <input name="<?php echo $name;?>" <?php echo $attrs_string;?> type="<?php echo $item[ 'type' ];?>" class="form-control" placeholder="<?php echo $placeholder;?>" value="<?php echo $value;?>">
            <?php
		}
		?>
    <?php echo $description;?>
</div>
				<?php
			}
			if( riake( 'type' , $item  ) == "buttons" )
			{
				$value		 	= convert_to_array( riake( 'value' , $item ) );
				$buttons_types	= convert_to_array( riake( 'buttons_types' , $item , 'submit' ) );
				$name			= convert_to_array( riake( 'name' , $item ) );
				$classes		= convert_to_array( riake( 'classes' , $item , 'btn-primary' ) );
				$attrs_string	= convert_to_array( riake( 'attrs_string' , $item , '' ) );
				?>
<div class="form-group">
	<div class="input-group">
    	<?php foreach( $value as $_key => $_button )
		{
			?>
	  <input class="btn btn-sm <?php echo riake( $_key , $classes , 'btn-primary' );?>" <?php echo riake( $_key , $attrs_string );?> type="<?php echo riake( $_key , $buttons_types , 'submit' );?>" name="<?php echo riake( $_key , $name );?>" value="<?php echo $_button ;?>" style="margin-right:10px;">
      <?php
		}
	  ?>
	</div>
    <?php echo $description;?>
</div>
				<?php
			}
			if( riake( 'type' , $item  ) == "hidden" )
			{
				$field_value	= riake( 'value' , $item , '');
				$name			= return_if_array_key_exists( 'name' , $item );
				?>
	  <input <?php echo $attrs_string;?> name="<?php echo $name;?>" type="hidden" class="form-control" value="<?php echo $field_value;?>">
				<?php
			}
			if( riake( 'type' , $item  ) == "textarea" )
			{
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				?>
<div class="form-group">
	<div class="input-group">
	  <span class="input-group-addon"><?php echo $label ;?></span>
	  <textarea <?php echo $attrs_string;?> name="<?php echo $name;?>" type="text" class="form-control" placeholder="<?php echo $placeholder;?>"><?php echo riake( 'value' , $item );?></textarea>
	</div>
    <?php echo $description;?>
</div>
				<?php
			}
			if( riake( 'type' , $item  ) == "title" )
			{
				$title		 	= return_if_array_key_exists( 'title' , $item );
				?>
				<h4><?php echo $title;?></h4>
				<?php
			}
			else if( riake( 'type' , $item  ) == 'visual_editor' )
			{
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$value		 	= return_if_array_key_exists( 'value' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				$id				= return_if_array_key_exists( 'name' , $item );
				?>
			<div class="form-group">
				<?php
				echo $this->visual_editor->getEditor( array (
					'name'				=>	$name,
					'defaultValue'		=>	$value,
					'id'				=>	$id
				) );
				?>
                <?php echo $description;?>
			</div>
				<?php
			}
			/**
			*	a Radio field must have at least 2 name in array;
			**/
			else if( riake( 'type' , $item  ) == 'radio' ){
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$value		 	= return_if_array_key_exists( 'value' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				if( count( $value ) >= 2 && count( $value ) == count( $label ) && count( $value ) == count( $name ) )
				{
				?>
<div class="form-group">
<div class="btn-group" data-toggle="buttons">
<?php for( $i = 0 ; $i < count( $name ) ; $i++ ): ?>
<label class="btn btn-primary">
<input <?php echo $attrs_string;?> type="radio" name="<?php echo $name[ $i ];?>" id="option1" value="<?php echo $value[ $i ];?>"> <?php echo $label[ $i ];?>
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
			else if( riake( 'type' , $item  ) == 'checkbox' )
			{
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$value		 	= return_if_array_key_exists( 'value' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				$checked		= return_if_array_key_exists( 'checked' , $item );

				if( count( $value ) == count( $label ) && count( $value ) == count( $name ) )
				{
				?>
<div class="form-group">
<div class="btn-group" data-toggle="buttons">
<?php for( $i = 0 ; $i < count( $name ) ; $i++ ): ?>
<label class="btn btn-primary <?php echo riake( $i , $checked ) == true ? 'active' : '';?>">
<input type="checkbox" <?php echo riake( $i , $checked ) == true ? 'checked="checked"' : '';?> <?php echo $attrs_string;?> name="<?php echo $name[ $i ];?>" id="option1" value="<?php echo $value[ $i ];?>"> <?php echo $label[ $i ];?>
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
			else if( riake( 'type' , $item  ) == 'select' )
			{
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$value		 	= return_if_array_key_exists( 'value' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				$text			= return_if_array_key_exists( 'text' , $item );
				// Set active option while one option value matches "active" value.
				$active			= return_if_array_key_exists( 'active' , $item );
				if( count( $value ) == count( $text ) )
				{
					?>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><?php echo $label ;?></span>
<select <?php echo $attrs_string;?> name="<?php echo $name;?>" type="text" class="form-control">

<?php if( $placeholder ):?>
<option value=""><?php echo $placeholder;?></option>
<?php endif;?>

<?php for( $i = 0 ; $i < count( $text ) ; $i++ ): ?>
	<?php $selected	=	( $value[ $i ] == $active ) ? 'selected="selected"' : '';?>
<option value="<?php echo $value[ $i ];?>" <?php echo $selected;?>><?php echo $text[ $i ];?></option>
<?php endfor;?>
</select>
</div>
<?php echo $description;?>
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
			else if( riake( 'type' , $item  ) == 'multiple' )
			{
				$placeholder 	= return_if_array_key_exists( 'placeholder' , $item );
				$value		 	= return_if_array_key_exists( 'value' , $item );
				$label			= return_if_array_key_exists( 'label' , $item );
				$name			= return_if_array_key_exists( 'name' , $item );
				$text			= return_if_array_key_exists( 'text' , $item );
				// Set active option while one option value matches "active" value.
				$active			= return_if_array_key_exists( 'active' , $item );
				if( count( $value ) == count( $text ) )
				{
					?>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon"><?php echo $label ;?></span>
<select multiple="multiple" <?php echo $attrs_string;?> name="<?php echo $name;?>" type="text" class="form-control">

<?php if( $placeholder ):?>
<option value=""><?php echo $placeholder;?></option>
<?php endif;?>

<?php for( $i = 0 ; $i < count( $text ) ; $i++ ): ?>
	<?php $selected	=	( $value[ $i ] == $active ) ? 'selected="selected"' : '';?>
<option value="<?php echo $value[ $i ];?>" <?php echo $selected;?>><?php echo $text[ $i ];?></option>
<?php endfor;?>
</select>
</div>
<?php echo $description;?>
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
			else if( in_array( riake( 'type' , $item  ) , array( 'table' , 'table-panel' ) ) )
			{
				$namespace			=	riake( 'name' , $item , 'default' );
				$empty_message		=	riake( 'empty_message' , $item , __( 'No result available' ) );
				
				$class				=	riake( 'type' , $item  ) == 'table' ? 'table table-striped m-b-none' : '';
				$class				=	riake( 'type' , $item  ) == 'table-panel' ? 'table table-striped m-b-none panel-body' : $class;
				$class				.=  ' ' . get_user_meta( 'gui_'. riake( 'namespace' , $panel ) );
				
				get_instance()->gui->set_table( $namespace );
				get_instance()->gui->empty_message( $empty_message );
				// Creating Cols
				foreach( force_array( riake( 'cols' , $item ) ) as $key	=>	$title )
				{
					get_instance()->gui->add_col( $key	, $title );
				}
				// Adding Row
				foreach( force_array( riake( 'rows' , $item ) ) as $key 	=>	$row )
				{
					get_instance()->gui->add_row( $row );
				}
				// Introducing col width
				get_instance()->gui->add_cols_width( riake( 'cols_width' , $item ) );
				// Get table
				get_instance()->gui->get_table( $namespace, $class , $attrs_string );
			}
			else if( in_array( riake( 'type' , $item  ) , array( 'dynamic-table' ) ) )
			{
				$namespace			=	riake( 'name' , $item , 'default' );
				$empty_message		=	riake( 'empty_message' , $item , __( 'No result available' ) );
				
				$class				=	riake( 'type' , $item  ) == 'table' ? 'table table-striped m-b-none' : '';
				$class				=	riake( 'type' , $item  ) == 'table-panel' ? 'table table-striped m-b-none panel-body' : $class;
				$class				.=  ' ' . get_user_meta( 'gui_'. riake( 'namespace' , $panel ) );
				
				get_instance()->gui->set_table( $namespace );
				get_instance()->gui->empty_message( $empty_message );
				// Creating Cols
				foreach( force_array( riake( 'cols' , $item ) ) as $key	=>	$title )
				{
					get_instance()->gui->add_col( $key	, $title );
				}
				// Adding Row
				foreach( force_array( riake( 'rows' , $item ) ) as $key 	=>	$row )
				{
					get_instance()->gui->add_row( $row );
				}
				// Get table
				get_instance()->gui->get_dynamic_table( $namespace, $class , $attrs_string );
			}
			else if( riake( 'type' , $item  ) == 'dom' )
			{
				echo riake( 'value' , $item );
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