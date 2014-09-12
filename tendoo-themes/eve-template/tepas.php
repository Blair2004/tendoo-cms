<?php
class eva_theme_tepas_class
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
			'before_each_textarea_field'=>	'<div class="comment-box row"><div class="col-sm-12"><p>',
			'after_each_textarea_field'	=>	'</p></div></div>',
			'each_input_field_class'	=>	'col-lg-4 col-md-4 form-control" name="name" type="text" id="name" size="30" onfocus="if(this.value == \'Name\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value = \'Name\'; }',
			'each_textarea_field_class'	=>	'form-control" rows="6" cols="40" id="comments" onfocus="if(this.value == \'Message\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value = \'Message\'; }',
			'each_button_field_class'	=>	'btn btn-lg btn-default',
			'do_user_text'				=>	false
		);
		declare_form( 'blog_single_reply_form' , $config );
		$contact_form		=	array(
			'before_each_input_field'	=>	'<div class="col-sm-4">',
			'after_each_input_field'	=>	'</div>',
			'before_each_textarea_field'=>	'<div class="form-group"><div class="col-sm-12">',
			'after_each_textarea_field'	=>	'</div></div>',
			'each_input_field_class'	=>	'form-control',
			'each_textarea_field_class'	=>	'form-control',
			'each_button_field_class'	=>	'btn btn-danger btn-lg',
			'do_user_text'				=>	false
		);
		declare_form( 'contact_form' , $config );
	}
	public function set_compatibility()
	{
		active_theme_compatibility( array( 'INDEX' , 'BLOG' , 'CONTACT' , 'STATIC' , 'WIDGETS' ) );
	}
	private function widget_definition()
	{
		declare_widget( 'right' , 'categories' , array(
			'open_wrapper'	=>	'<div class="widget widget_categories">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<div class="widget_title"><h4><span>',
			'after_title'	=>	'</span></h4></div>',
			'open_content'	=>	'<ul class="arrows_list">',
			'close_content'	=>	'</ul>',
			'open_parent'	=>	false,
			'close_parent'	=>	false,
			'before_item'	=>	'<li><i class="icon-angle-right"></i>',
			'after_item'	=>	'</li>'			
		) );
		declare_widget( 'bottom' , 'categories' , array(
			'open_wrapper'	=>	'<div class="col-sm-6 col-md-3 col-lg-3"><div class="widget widget_categories">',
			'close_wrapper'	=>	'</div></div>',
			'before_title'	=>	'<div class="widget_title"><h4><span>',
			'after_title'	=>	'</span></h4></div>',
			'open_content'	=>	'<ul class="arrows_list">',
			'close_content'	=>	'</ul>',
			'open_parent'	=>	false,
			'close_parent'	=>	false,
			'before_item'	=>	'<li><i class="icon-angle-right"></i>',
			'after_item'	=>	'</li>'			
		) );
		declare_widget( 'right' , 'tags' , array(
			'open_wrapper'	=>	'<div class="widget widget_tags">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<div class="widget_title"><h4><span>',
			'after_title'	=>	'</span></h4></div>',
			'open_content'	=>	'<ul class="tags">',
			'close_content'	=>	'</ul>',
			'open_parent'	=>	false,
			'close_parent'	=>	false,
			'before_item'	=>	'<li>',
			'after_item'	=>	'</li>',
			'item_class'	=>	''
		) );
		declare_widget( 'bottom' , 'tags' , array(
			'open_wrapper'	=>	'<div class="col-sm-6 col-md-3 col-lg-3"><div class="widget widget_tags">',
			'close_wrapper'	=>	'</div></div>',
			'before_title'	=>	'<div class="widget_title"><h4><span>',
			'after_title'	=>	'</span></h4></div>',
			'open_parent'	=>	'<ul class="tags">',
			'close_parent'	=>	'</ul>',
			'before_item'	=>	'<li>',
			'after_item'	=>	'</li>',
			'item_class'	=>	''
		) );
		declare_widget( 'bottom' , 'text' , array(
			'open_wrapper'	=>	'<div class="col-sm-6 col-md-3 col-lg-3"><div class="widget widget_tags">',
			'close_wrapper'	=>	'</div></div>',
			'before_title'	=>	'<div class="widget_title"><h4><span>',
			'after_title'	=>	'</span></h4></div>',
			'before_item'	=>	'<p>',
			'after_item'	=>	'</p>',
			'item_class'	=>	false
		) );
		declare_widget( 'right' , 'text' , array(
			'open_wrapper'	=>	'<div class="widget widget_about">',
			'close_wrapper'	=>	'</div>',
			'before_title'	=>	'<div class="widget_title"><h4><span>',
			'after_title'	=>	'</span></h4></div>',
			'before_item'	=>	'<p>',
			'after_item'	=>	'</p>',
			'item_class'	=>	false
		) );
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
		// 
		$config		=	array(
			'draggable'					=>	false,
			'human_name'				=>	'[En-tête] Liens vers les réseaux sociaux',
			'is_static'					=>	true,
			'namespace'					=>	'social_feeds',
			'item_loopable_fields'		=>	array(
				array(
					'input_type'			=>	'text',
					'input_name'			=>	'social_links',
					'input_title'			=>	'Liens',
					'input_placeholder'		=>	'Entrez votre lien'
				),
				array(
					'input_type'			=>	'select',
					'input_value'			=>	array(
						array( 'text' =>	'icone facebook' , 'value'	=>	'facebook' ),
						array( 'text' =>	'icone Twitter' , 'value'	=>	'twitter' ),
						array( 'text' =>	'icone Skype' , 'value'	=>	'skype' ),
						array( 'text' =>	'icone Pinterest' , 'value'	=>	'pinterest' ),
						array( 'text' =>	'icone Google Plus' , 'value'	=>	'google-plus' ),
					),
					'input_name'			=>	'social_icons',
					'input_title'			=>	'Icône'
				)
			),
			'description'				=>	"Vous permet d'afficher les liens vers des réseaux sociaux sur l'en-tête de la page"
		);
		declare_item( 'social_feeds'  , $config );
		// 
		$config		=	array(
			'draggable'					=>	false,
			'human_name'				=>	'[En-tête] Informations de contact',
			'is_static'					=>	true,
			'namespace'					=>	'header_datas',
			'item_loopable_fields'		=>	array(
				array(
					'input_type'			=>	'text',
					'input_name'			=>	'header_text',
					'input_title'			=>	'Entrez un texte',
					'input_placeholder'		=>	'Entrez un texte'
				),
				array(
					'input_type'			=>	'select',
					'input_value'			=>	array(
						array( 'text' =>	'icone Téléphone' , 'value'	=>	'phone' ),
						array( 'text' =>	'icone Mail' , 'value'	=>	'envelope' ),
					),
					'input_name'			=>	'header_icon',
					'input_title'			=>	'Choisir une icône'
				)
			),
			'description'				=>	"Définissez des informations de contact affiché en haut à gauche."
		);
		declare_item( 'header_datas'  , $config );
		// 
		$config		=	array(
			'draggable'					=>	false,
			'human_name'				=>	'[Pied de page] Liens vers les réseaux sociaux',
			'is_static'					=>	true,
			'namespace'					=>	'footer_social_feeds',
			'item_loopable_fields'		=>	array(
				array(
					'input_type'			=>	'text',
					'input_name'			=>	'social_links',
					'input_title'			=>	'Liens',
					'input_placeholder'		=>	'Entrez votre lien'
				),
				array(
					'input_type'			=>	'select',
					'input_value'			=>	array(
						array( 'text' =>	'icone facebook' , 'value'		=>	'facebook' ),
						array( 'text' =>	'icone Twitter' , 'value'		=>	'twitter' ),
						array( 'text' =>	'icone Skype' , 'value'			=>	'skype' ),
						array( 'text' =>	'icone Pinterest' , 'value'		=>	'pinterest' ),
						array( 'text' =>	'icone Google Plus' , 'value'	=>	'google-plus' ),
						array( 'text' =>	'icone RSS' , 'value'			=>	'rss' ),
						array( 'text' =>	'icone Dribbble' , 'value'		=>	'dribbble' ),
					),
					'input_name'			=>	'social_icons',
					'input_title'			=>	'Icône'
				)
			),
			'description'				=>	"Vous permet d'afficher les liens vers des réseaux sociaux sur le pied de page"
		);
		declare_item( 'footer_social_feeds'  , $config );
		declare_item( 'contact_get_social' , array(
			'draggable'					=>	false,
			'human_name'				=>	'[Contact] Liens vers les réseaux sociaux',
			'is_static'					=>	true,
			'namespace'					=>	'contact_get_social',
			'item_loopable_fields'		=>	array(
				array(
					'input_type'			=>	'text',
					'input_name'			=>	'social_links',
					'input_title'			=>	'Liens',
					'input_placeholder'		=>	'Entrez votre lien'
				),
				array(
					'input_type'			=>	'select',
					'input_value'			=>	array(
						array( 'text' =>	'icone facebook' , 'value'		=>	'facebook' ),
						array( 'text' =>	'icone Twitter' , 'value'		=>	'twitter' ),
						array( 'text' =>	'icone Skype' , 'value'			=>	'skype' ),
						array( 'text' =>	'icone Pinterest' , 'value'		=>	'pinterest' ),
						array( 'text' =>	'icone Google Plus' , 'value'	=>	'google-plus' ),
						array( 'text' =>	'icone RSS' , 'value'			=>	'rss' ),
						array( 'text' =>	'icone Dribbble' , 'value'		=>	'dribbble' ),
						array( 'text' =>	'icone Youtube' , 'value'		=>	'youtube' ),
					),
					'input_name'			=>	'social_icons',
					'input_title'			=>	'Icône'
				)
			),
			'item_global_fields'	=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'get_social_title',
					'input_title'		=>	'Titre des liens sociaux',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
			),
			'description'				=>	"Personnalisez les informations disponibles sur la page des contact"
		) );
		declare_item( 'contact_datas' , array( 
			'draggable'					=>	false,
			'human_name'				=>	'[Contact] Informations de la page de contact',
			'is_static'					=>	true,
			'namespace'					=>	'contact_datas',
			'item_global_fields'	=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'contact_description_title',
					'input_title'		=>	'Titre de la zone de contact',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
				array(
					'input_type'		=>	'textarea',
					'input_name'		=>	'contact_description_content',
					'input_title'		=>	'Contenu de la zone de contact',
					'input_placeholder'	=>	'Entrez la description ici'
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'contact_details_title',
					'input_title'		=>	'Titre des zones des détails sur les contacts',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
				array(
					'input_type'		=>	'textarea',
					'input_name'		=>	'contact_details_content',
					'input_title'		=>	'Contenu de la zone des détails sur les contacts',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
			),
			'description'				=>	"Personnalisez les informations disponibles sur la page des contact. Cette section est considéré comme la section \"A propos de nous\"."
		) );
		// Bind Events
		bind_event( 'handle_contact_get_social' , array( $this , 'contact_get_social' ) ) ;
		bind_event( 'handle_footer_social_feeds' , array( $this , 'footer_social_feeds' ) );
		bind_event( 'handle_header_datas' , array( $this , 'header_datas' ) );
		bind_event( 'handle_list_services' , array( $this , 'list_services' ) );
		bind_event( 'handle_social_feeds' , array( $this , 'social_feeds' ) );
		bind_event( 'set_slider_items_vars' , array( $this , 'filter' ) );
		bind_event( 'loop_slider_lines' , array( $this , 'loop_slider' ) );
		bind_event( 'handle_testimony' , array( $this , 'testimony' ) );
	}
	function contact_get_social( $array )
	{
		?>
        <div class="dividerHeading">
            <h4><span><?php echo riake( 'get_social_title' , $array	 );?></span></h4>
        </div>
        <?php
		$index	=	count( $array[ 'social_links' ][ 'level' ] );
			?>
            <ul class="widget_social">
            <?php
			for( $i = 0 ; $i < $index ; $i++ )
			{
				$background	=	$array[ 'social_icons' ][ 'level' ][ $i ];
				if( $array[ 'social_icons' ][ 'level' ][ $i ] == 'facebook' )
				{
					$background	=	'fb';
				} 
				else if( $array[ 'social_icons' ][ 'level' ][ $i ] == 'google-plus' )
				{
					$background	=	'gmail';
				}
				else if( $array[ 'social_icons' ][ 'level' ][ $i ] == 'twitter' )
				{
					$background	=	'twtr';
				}
				?>
                <li><a class="<?php echo $background;?>" href="<?php echo $array[ 'social_links' ][ 'level' ][ $i ];?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $array[ 'social_icons' ][ 'level' ][ $i ];?>"><i class="fa fa-<?php echo $array[ 'social_icons' ][ 'level' ][ $i ];?>"></i></a></li>
                <?php
			}
			?>
            </ul>
            <?php
	}
	function footer_social_feeds( $array )
	{
		if( is_array( $array ) && count( $array ) > 0 )
		{
			$index	=	count( $array[ 'social_links' ][ 'level' ] );
			?>
            <ul class="footbot_social">
            <?php
			for( $i = 0 ; $i < $index ; $i++ )
			{
				$background	=	$array[ 'social_icons' ][ 'level' ][ $i ];
				if( $array[ 'social_icons' ][ 'level' ][ $i ] == 'facebook' )
				{
					$background	=	'fb';
				} 
				else if( $array[ 'social_icons' ][ 'level' ][ $i ] == 'google-plus' )
				{
					$background	=	'gmail';
				}
				else if( $array[ 'social_icons' ][ 'level' ][ $i ] == 'twitter' )
				{
					$background	=	'twtr';
				}
				?>
                <li><a class="<?php echo $background;?>" href="<?php echo $array[ 'social_links' ][ 'level' ][ $i ];?>" data-placement="top" data-toggle="tooltip" title="<?php echo $array[ 'social_icons' ][ 'level' ][ $i ];?>"><i class="fa fa-<?php echo $array[ 'social_icons' ][ 'level' ][ $i ];?>"></i></a></li>
                <?php
			}
			?>
            </ul>
            <?php
		}
	}
	function header_datas( $array )
	{
		if( is_array( $array ) && count( $array ) > 0 )
		{
			$index	=	count( $array[ 'header_text' ][ 'level' ] );
			for( $i = 0 ; $i < $index ; $i++ )
			{
				?>
                <span><i class="fa fa-<?php echo $array[ 'header_icon' ][ 'level' ][ $i ];?>"></i><?php echo $array[ 'header_text' ][ 'level' ][ $i ];?></span>
                <?php
			}
		}
	}
	function social_feeds( $array )
	{
		if( is_array( $array ) && count( $array ) > 0 )
		{
			$index	=	count( $array[ 'social_links' ][ 'level' ] );
			?>
            <ul>
            <?php
			for( $i = 0 ; $i < $index ; $i++ )
			{
				?>
                <li><a href="<?php echo $array[ 'social_links' ][ 'level' ][ $i ];?>" class="my-tweet"><i class="fa fa-<?php echo $array[ 'social_icons' ][ 'level' ][ $i ];?>"></i></a></li>
                <?php
			}
			?>
            </ul>
            <?php
		}
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
			'wrapper'					=>	'ul',
			'wrapper_class'				=>	false,
			'wrapper_id'				=>	false,
			'container'					=>	'nav',
			'container_class'			=>	false,
			'container_id'				=>	'breadcrumbs',
			'word_limiter'				=>	5,
			'text_before_bread_loop'	=>	'<li>Vous êtes ici : </li>',
			'divider'					=>	false
		) );
	}
}