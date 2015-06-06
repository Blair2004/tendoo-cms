<?php

// items set buy GUI::get_items
$form_option		=	get_core_vars( riake( 'namespace' , $meta ) );
foreach( force_array( riake( 'items' , $meta ) ) as $_item )
{
	$name	=	riake( 'name' , $_item );
	$type   = 	riake( 'type' , $_item );
	$placeholder	=	riake( 'placeholder' , $_item );
	$value			=	riake( 'value' , $_item );
	$icon			=	riake( 'icon' , $_item );
	$label			=	riake( 'label' , $_item );
	$rows			=	riake( 'rows' , $_item );
	$description	=	riake( 'description' , $_item );
	if( in_array( $type , array( 'text' , 'password' , 'email' , 'tel' ) ) )
	{
		$value		=	
			// if namespace is used and option exists
			is_array( $form_option ) ? riake( $name , $form_option ) : 			
			// if namespace is not used
			$_option	=	( $_option = $this->options->get( $name ) ) ? $_option : $value;
		?>
        <div class="input-group" style="margin-bottom:5px;">
            <span class="input-group-addon"><?php echo riake( 'label' , $_item );?></span>
            <input type="<?php echo $type;?>" name="<?php echo riake( 'name' , $_item );?>" class="form-control" placeholder="<?php echo riake( 'placeholder' , $_item );?>" value="<?php echo $value;?>">
        </div>
        <?php
	}
	else if( $type == 'textarea' )
	{
		$value			=	
			// if namespace is used and option exists
			is_array( $form_option ) ? riake( $name , $form_option ) : 			
			// if namespace is not used
			$_option	=	( $_option = $this->options->get( $name ) ) ? $_option : $value;
		?>
        <div class="form-group">
          <label><?php echo $label;?></label>
          <textarea class="form-control" rows="3" placeholder="<?php echo $placeholder;?>" name="<?php echo $name;?>"><?php echo $value;?></textarea>
        </div>
        <?php
	}
	else if( $type == 'file-input' )
	{
		?>
        <div class="form-group">
          <label for="exampleInputFile"><?php echo $label;?></label>
          <input type="file" id="exampleInputFile" name="<?php echo $name;?>">
          <p class="help-block"><?php echo $description;?></p>
        </div>
        <?php
	}
	else if( $type == 'checkbox' )
	{
		$db_value		=	
			// if namespace is used and option exists
			is_array( $form_option ) ? riake( $name , $form_option ) : 			
			// if namespace is not used
			$_option	=	( $_option = $this->options->get( $name ) ) ? $_option : false;
		// control check
		$checked	=	$db_value == $value ? 'checked="checked"' : '';
		?>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="<?php echo $value;?>" name="<?php echo $name;?>" <?php echo $checked;?>> <?php echo $label;?>
          </label>
        </div>
        <?php
	}
	else if( $type == 'radio' )
	{
		?>
        <div class="form-group">
		<?php
		foreach( force_array( riake( 'options' , $_item ) ) as $radio_item )
		{
			$db_value		=	
				// if namespace is used and option exists
				is_array( $form_option ) ? riake( riake( 'name' , $radio_item ) , $form_option ) : 			
				// if namespace is not used
				$_option	=	( $_option = $this->options->get( riake( 'name' , $radio_item ) ) ) ? $_option : false;
			// control check
			$checked	=	$db_value == riake( 'value' , $radio_item ) ? 'checked="checked"' : '';
		?>
          <div class="radio">
            <label>
              <input type="radio" name="<?php echo riake( 'name' , $radio_item );?>" id="optionsRadios1" value="<?php echo riake( 'value' , $radio_item );?>" <?php echo $checked;?>>
              <?php echo riake( 'description' , $radio_item );?>
            </label>
          </div>
		<?php
		}
		?>
        </div>
        <?php
	}
	/**
	 * Form
	 *
	 * add_meta( array(
	 *		'type'	=>	'multiple',
	 *		'options'	=>	array(
	 *			array(
	 *				'name'	=>	'foo',
	 *				'value'	=>	'bar'
	 *			)
	 *		)
	 *	) )
	**/
	else if( in_array( $type , array( 'select' , 'multiple' ) ) )
	{
		$multiple = $type == 'multiple' ? $type : '';
		?>
        <div class="form-group">
          <label><?php echo $label;?></label>
          <select <?php echo $multiple;?> class="form-control" name="<?php echo $name;?>">
          	<?php 
			foreach( force_array( riake( 'options' , $_item ) ) as $value	=>	$text )
			{
				$db_value		=	
					// if namespace is used and option exists
					is_array( $form_option ) ? riake( $name , $form_option ) : 			
					// if namespace is not used
					$_option	=	( $_option = $this->options->get( $name ) ) ? $_option : false;
				// control check
				$selected	=	$db_value == $value ? 'selected="selected"' : '';
				?>
            <option <?php echo $selected;?> value="<?php echo $value;?>"><?php echo $text;?>
				<?php
			}
			?>
          </select>
        </div>
        <?php
	}
	/**
	 *  ..add_meta( array(
	 		'type'		=>		'html-list',
			'options'	=>		array(
				array( 
					'type'	=>	'foo',
					'text'	=>	'bar'
				)
			)
	 	) );
	**/
	else if( $type == 'html-list' )
	{
		?>
        <ul class="list-group">
        <?php
		foreach( force_array( riake( 'options' , $_item ) ) as $list_option )
		{
			$type =	riake( 'type' , $list_option );
			$text =	riake( 'text' , $list_option );		
		?>
          <li class="list-group-item list-group-item-<?php echo $type;?>"><?php echo $text;?></li>
          <?php
		}
		?>
        </ul>
        <?php
	}
	/**
	 * 
	**/
	else if( $type == 'dom' )
	{
		echo riake( 'content' , $_item );     
	}
	/**
	 * Error Section
	 *
	**/
	
	else if( $type == 'html-error' )
	{
		?>
        <div class="error-page">
            <h2 class="headline text-yellow"><?php echo riake( 'error-type' , $_item );?></h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> <?php echo riake( 'title' , $_item );?></h3>
              <p>
               <?php echo riake( 'content' , $_item );?>
              </p>
              <!--
              <form class="search-form">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
              -->
            </div><!-- /.error-content -->
          </div>
        <?php
	}
	
	/**
	 * ->add_item( array(
	 *		'type'		=>	'table',
	 *		'cols'		=>	array( __( 'Id' ) , __( 'Title' ) , __( 'Name' ), __( 'Description' ) ),
	 *		'rows'		=>	array(
	 *			array( 1 , __( 'Custom 1' ) , __( 'Name 1' ) , __( 'Description' ) ),
	 *			array( 1 , __( 'Custom 1' ) , __( 'Name 1' ) , __( 'Description' ) ),
	 * 			array( 1 , __( 'Custom 1' ) , __( 'Name 1' ) , __( 'Description' ) ),
	 *			array( 1 , __( 'Custom 1' ) , __( 'Name 1' ) , __( 'Description' ) )	
	 * 		)
	 *	) , 'settings' , 2 );
	**/
	
	else if( $type == 'table' )
	{
		// Optional riake( 'width' , $_item )
		?>
      <table class="table table-bordered">
        <tbody><tr>
        	<?php 
			foreach( force_array( riake( 'cols' , $_item ) ) as $index	=>	$_col )
			{
				?>
          		<th style="<?php echo $width =	riake( $index , riake( 'width' , $_item ) ) ? 'width:' . $width . ';' : '';?>"><?php echo $_col;?></th>
                <?php
			}
			?>
        </tr>
        <?php
		if( count( force_array( riake( 'rows' , $_item ) ) ) > 0 )
		{
			foreach( force_array( riake( 'rows' , $_item ) ) as $index => $_row )
			{
				?>
				<tr>
                	<?php
					foreach( force_array( $_row ) as $_unique_col )
					{
					?>
				  <td><?php echo $_unique_col;?></td>
                  <?php
					}
				  ?>
				</tr>
				<?php 
			}
		}
		else
		{
			?>
            <tr>
            	<td colspan="<?php count( force_array( riake( 'cols' , $_item ) ) );?>"><?php echo __( 'Empty table' );?></td>
            </tr>
            <?php
		}
		?>
        
      </tbody></table>
        <?php
	}
}