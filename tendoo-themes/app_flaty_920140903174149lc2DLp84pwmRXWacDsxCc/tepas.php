<?php
class flaty_theme_tepas_class
{
	public function __construct()
	{
		$this->set_compatibility();
		$this->widget_definition();
		$this->items_definition();
		$this->set_breadcrumbs();
		$config		=	array(
			'before_each_input_field'	=>	'<div class="form-group"><div class="col-sm-6">',
			'after_each_input_field'	=>	'</div></div>',
			'before_each_textarea_field'=>	'<div class="form-group"><div class="col-sm-12">',
			'after_each_textarea_field'	=>	'</div></div>',
			'each_input_field_class'	=>	'form-control',
			'each_textarea_field_class'	=>	'form-control',
			'each_button_field_class'	=>	'btn btn-danger btn-lg',
			'do_user_text'				=>	false
		);
		declare_form( 'blog_single_reply_form' , $config );
		$contact_form		=	array(
			'before_each_input_field'	=>	'<div class="form-group"><div class="col-sm-6">',
			'after_each_input_field'	=>	'</div></div>',
			'before_each_textarea_field'=>	'<div class="form-group"><div class="col-sm-12">',
			'after_each_textarea_field'	=>	'</div></div>',
			'each_input_field_class'	=>	'form-control',
			'each_textarea_field_class'	=>	'form-control',
			'each_button_field_class'	=>	'btn btn-danger btn-lg',
			'do_user_text'				=>	false
		);
		declare_form( 'contact_form' , $contact_form );
	}
	public function set_compatibility()
	{
		active_theme_compatibility( array( 'BLOG' , 'INDEX' , 'CONTACT' , 'STATIC' , 'WIDGETS' ) );
	}
	private function widget_definition()
	{
		$categories	=	array(
			'open_wrapper'	=>	'<div class="widget categories">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<h3>',
			'after_title'	=>	'</h3>',
			'open_content'	=>	'<div class="row">',
			'close_content'	=>	'</div>',
			'open_parent'	=>	'<div class="col-sm-6"><ul class="arrow">',
			'close_parent'	=>	'</ul></div>',
			'before_item'	=>	'<li>',
			'after_item'	=>	'</li>'			
		);
		declare_widget( 'right' , 'categories' , $categories );
		$tags		=	array(
			'open_wrapper'	=>	'<div class="widget tags">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<h3>',
			'after_title'	=>	'</h3>',
			'open_parent'	=>	'<ul class="tag-cloud">',
			'close_parent'	=>	'</ul>',
			'before_item'	=>	'<li style="margin:5px 5px 0 0;">',
			'after_item'	=>	'</li>',
			'item_class'	=>	'btn btn-xs btn-primary'
		);
		declare_widget( 'right' , 'tags' , $tags );
		$categories	=	array(
			'open_wrapper'	=>	'<div class="col-md-3 col-sm-6">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<h3>',
			'after_title'	=>	'</h3>',
			'open_content'	=>	'<div class="row">',
			'close_content'	=>	'</div>',
			'open_parent'	=>	'<ul class="arrow">',
			'close_parent'	=>	'</ul>',
			'before_item'	=>	'<li>',
			'after_item'	=>	'</li>'			
		);
		declare_widget( 'bottom' , 'categories' , $categories );
		$tags		=	array(
			'open_wrapper'	=>	'<div class="col-md-3 col-sm-6 widget tags">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<h3>',
			'after_title'	=>	'</h3>',
			'open_parent'	=>	'<ul class="tag-cloud">',
			'close_parent'	=>	'</ul>',
			'before_item'	=>	'<li style="margin:5px 5px 0 0;">',
			'after_item'	=>	'</li>',
			'item_class'	=>	'btn btn-xs btn-primary'
		);
		declare_widget( 'bottom' , 'tags' , $tags );
		$text		=	array(
			'open_wrapper'	=>	'<div class="col-md-3 col-sm-6 widget tags">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<h3>',
			'after_title'	=>	'</h3>',
			'before_item'	=>	'<p>',
			'after_item'	=>	'</p>',
			'item_class'	=>	'btn btn-xs btn-primary'
		);
		declare_widget( 'bottom' , 'text' , $text );
	}
	private function items_definition()
	{
		// <li data-target="#main-slider" data-slide-to="0" class="active"></li>
		$config		=	array(
			'has_loop'		=>		true,
			'before_loop'	=>		
			'<section id="main-slider" class="no-margin">
				<div class="carousel slide wet-asphalt">
					<ol class="carousel-indicators">
					</ol>
					<div class="carousel-inner">',
			'the_loop_item'	=>	
				array(
					'<div class="item" style="background-image: url(',
						'[thumb]',
						')">',
						'<div class="container">',
							'<div class="row">',
								'<div class="col-sm-12">',
									'<div class="carousel-content center centered" style="margin-top: 219.5px;">',
										'<h2 class="boxed animation animated-item-1">',
										'[title]',
										'</h2>',
										'<br>',
										'<p class="boxed animation animated-item-2">',
										'[content]',
										'</p>',
										'<br>',
										'<a class="btn btn-md animation animated-item-3" href="',
										'[link]',
										'">Lire la suite</a>',
									'</div>',
								'</div>',
							'</div>',
						'</div>',
					'</div>'
				),			
			'after_loop'	=>		
					'</div>
				</div>
				<a class="prev hidden-xs" href="#main-slider" data-slide="prev">
					<i class="icon-angle-left"></i>
				</a>
				<a class="next hidden-xs" href="#main-slider" data-slide="next">
					<i class="icon-angle-right"></i>
				</a>
			</section>',
			'human_name'		=>	'Slider',
			'draggable'			=>	false,
			'description'		=>	'Ajouter un slider à votre page d\'accueil'
		);
		declare_item( 'slider' , $config  );
		$config		=	array(
			'has_loop'			=>	true, 
			'before_loop'		=>	'<section id="services" class="emerald"><div class="container"><div class="row">',
			'after_loop'		=>	'</div></div></section>',
			'the_loop_item'		=>	array(
				'<div class="col-md-4 col-sm-6">',
                    '<div class="media">',
                        '<div class="pull-left">',
                            '<i class="icon-google-plus icon-md"></i>',
                        '</div>',
                        '<div class="media-body">',
                            '<h3 class="media-heading">',
							'[title]',
							'</h3>',
                            '<p>',
							'[content]',
							'</p>',
                        '</div>',
                    '</div>',
                '</div>'),
			'human_name'		=>	'Liste des services',
			'draggable'		=>	false,
			'item_loopable_fields'		=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'title',
					'input_title'		=>	'Titre'
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'link',
					'input_title'		=>	'Lien vers'
				),
				array(
					'input_type'		=>	'textarea',
					'input_name'		=>	'description',
					'input_title'		=>	'Contenu'
				),
				array(
					'input_type'		=>	'select',
					'input_value'		=>	array(
						array( 'text' =>	'icone facebook' , 'value'	=>	'facebook' ),
						array( 'text' =>	'icone twitter' , 'value'	=>	'twitter' ),
						array( 'text' =>	'icone google+' , 'value'	=>	'google-plus' ),
					),
					'input_name'		=>	'icons',
					'input_title'		=>	'Attribuer une icone'
				)
			),
			'item_global_fields'	=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'section_text',
					'input_title'		=>	'Titre de la section',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
				array(
					'input_type'		=>	'textarea',
					'input_name'		=>	'section_textarea',
					'input_title'		=>	'Description de la section'
				)
			),
			'is_static'			=>	true,
			'description'		=>	'Afficher les différents services que vous proposez'
		);
		declare_item( 'list_services' , $config );
		$config		=	array(
			'draggable'					=>	false,
			'human_name'				=>	'Ajouter des témoignages',
			'is_static'					=>	true,
			'namespace'					=>	'testimony',
			'item_loopable_fields'		=>	array(
				array(
					'input_type'			=>	'textarea',
					'input_name'			=>	'testimony_content',
					'input_title'			=>	'Témoignage',
					'input_placeholder'		=>	'Entrez votre témoignage'
				),
				array(
					'input_type'			=>	'text',
					'input_name'			=>	'testimony_authors',
					'input_title'			=>	'Auteur',
					'input_placeholder'		=>	'Auteur du témoiugnage'
				)
			),
			'item_global_fields'	=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'testimony_big_title',
					'input_title'		=>	'Titre des témoignages',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
				array(
					'input_type'		=>	'textarea',
					'input_name'		=>	'testimony_big_description',
					'input_title'		=>	'Description des témoignages'
				)
			),
			'description'				=>	'Vous permet d\'ajouter des témoignages sur votre page d\'accueil'
		);
		declare_item( 'testimony'  , $config );
		bind_event( 'handle_list_services' , array( $this , 'list_services' ) );
		bind_event( 'set_slider_items_vars' , array( $this , 'filter' ) );
		bind_event( 'loop_slider_lines' , array( $this , 'loop_slider' ) );
		bind_event( 'handle_testimony' , array( $this , 'testimony' ) );
	}
	public function testimony( $array )
	{
		$big_title	=	return_if_array_key_exists( 'testimony_big_title' , $array );
		$big_desc	=	return_if_array_key_exists( 'testimony_big_description' , $array );
		$test_c		=	return_if_array_key_exists( 'testimony_content' , $array );
		$test_a		=	return_if_array_key_exists( 'testimony_authors' , $array );
		$testimonies	=	return_if_array_key_exists( 'level' , $test_c );
		$authors		=	return_if_array_key_exists( 'level' , $test_a );
		if( $testimonies && $authors ){
		?>
        <section id="testimonial" class="alizarin">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="center">
                        <h2><?php echo $big_title;?></h2>
                        <p><?php echo $big_desc;?></p>
                    </div>
                    <div class="gap"></div>
                    <div class="row">
                    	<?php
						if( is_array( $testimonies ) && is_array( $authors ) )
						{
							if( count( $testimonies ) == count( $authors ) )
							{
						?>
                        <div class="col-md-6">
                        	<?php
							$_i = 0;
								for( $i = 0 ; $i < count( $testimonies ) ; $i++ )
								{
									?>
								<blockquote>
									<p><?php echo return_if_array_key_exists( $i , $testimonies );?></p>
									<small><?php echo return_if_array_key_exists( $i , $authors );?></small>
								</blockquote>
									<?php
									if( $_i == 1 ){
										$_i = -1;
										?>
                            </div>
                            <div class="col-md-6">
										<?php	
									}
									$_i++;
								}
							}
						}
						?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <?php
		}
	}
	public function list_services( $array )
	{
		/**
		* 	OK
		**/
		$title_lev		=	return_if_array_key_exists( 'title' , $array );
		$titles			=	return_if_array_key_exists( 'level' , $title_lev );
		$desc_lev		=	return_if_array_key_exists( 'description' , $array );
		$description	=	return_if_array_key_exists( 'level' , $desc_lev );
		$icon_lev		=	return_if_array_key_exists( 'icons' , $array );
		$icons			=	return_if_array_key_exists( 'level' , $icon_lev );
		$link_lev		=	return_if_array_key_exists( 'link' , $array );
		$links			=	return_if_array_key_exists( 'level' , $link_lev );
		?>
        <section id="services" class="emerald">
        <div class="container" style="padding:40px 0px">
            <div class="row">
            	<?php
				if( count( $titles ) == count( $description ) && count( $icons ) == count( $titles ) )
				{
					for($i = 0 ; $i < count( $titles ) ; $i ++ ){
				?>
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-<?php echo $icons[ $i ];?> icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading"><a href="<?php echo return_if_array_key_exists( $i , $links );?>"><?php echo $titles[ $i ];?></a></h3>
                            <p><?php echo strip_tags( $description[ $i ] );?></p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <?php
					}
				}
				?>
            </div>
        </div>
    </section>
        <?php
	}
	public function filter( $array )
	{
		if( array_key_exists( 0, $array ) && array_key_exists( 1 , $array) ) 
		{
			$key	=	$array[0];
			$value	=	$array[1];
			if( $key	==	'content' )
			{
				return word_limiter( strip_tags( $value ) , 30 );
			}
		}
	}
	public function loop_slider( $lines )
	{
		if( !isset( $this->loop_has_started ) )
		{
			$this->loop_has_started	= true;
			if($lines[0]	==	'<div class="item" style="background-image: url(')
			{
				return '<div class="item active" style="background-image: url(';		
			}
		}		
	}
	private function set_breadcrumbs()
	{
		declare_bread( array (
				'wrapper'			=>	'ul',
				'wrapper_class'		=>	'breadcrumb pull-right',
				'container'			=>	'div',
				'container_class'	=>	'col-sm-6',
				'word_limiter'		=>	5,
				'divider'			=>	false
		) );
	}
}