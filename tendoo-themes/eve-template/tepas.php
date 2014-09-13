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
		/* declare_item( 'slider' , array(
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
		)  ); */
		declare_item( 'list_services' , array(
			'has_loop'			=>	true, 
			'human_name'		=>	'[ Accueil - 1 ] Liste des services',
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
						array( 'text' =>	'icone Malette' , 'value'	=>	'briefcase' ),
						array( 'text' =>	'icone MégaPhone' , 'value'	=>	'bullhorn' ),
						array( 'text' =>	'icone Archive' , 'value'	=>	'archive' ),
						array( 'text' =>	'icone Graphisme statistique' , 'value'	=>	'area-chart' ),
						array( 'text' =>	'icone Maison' , 'value'	=>	'home' ),
						array( 'text' =>	'icone Fusée' , 'value'	=>	'rocket' ),
						array( 'text' =>	'icone Pouce Ok' , 'value'	=>	'thumbs-o-up' ),
						array( 'text' =>	'icone Ordinateur' , 'value'	=>	'laptop' ),
						array( 'text' =>	'icone cadeau' , 'value'	=>	'gift' ),
						array( 'text' =>	'icone Groupe de personnes' , 'value'	=>	'group' ),						
						array( 'text' =>	'icone Note musicale' , 'value'	=>	'music' ),
						array( 'text' =>	'icone Etoile+' , 'value'	=>	'star-o' ),
						array( 'text' =>	'icone Windows' , 'value'	=>	'windows' ),
						array( 'text' =>	'icone WordPress' , 'value'	=>	'Wordpress' ),
						array( 'text' =>	'icone yahoo' , 'value'	=>	'yahoo' ),
						array( 'text' =>	'icone facebook' , 'value'	=>	'facebook' ),
						array( 'text' =>	'icone dribbble' , 'value'	=>	'dribbble' ),
						array( 'text' =>	'icone Github' , 'value'	=>	'github-alt' ),
						array( 'text' =>	'icone Google +' , 'value'	=>	'google-plus' ),
						array( 'text' =>	'icone Linkedin' , 'value'	=>	'linkedin-square' ),
						array( 'text' =>	'icone Pinterest' , 'value'	=>	'pinterest-square' ),
						array( 'text' =>	'icone Twitter' , 'value'	=>	'twitter-square' ),
						array( 'text' =>	'icone Youtube' , 'value'	=>	'youtube' ),
					),
					'input_name'		=>	'icons',
					'input_title'		=>	'Attribuer une icone'
				)
			),
			'is_static'			=>	true,
			'description'		=>	'Afficher les différents services que vous proposez'
		) );
		declare_item( 'recents_works' , array(
			'has_loop'			=>	true, 
			'human_name'		=>	'[ Accueil - 1 ] Travaux récents',
			'draggable'		=>	false,
			'item_global_fields'		=>	array(
				array(
					'input_type'			=>	'text',
					'input_name'			=>	'global_title',
					'input_title'			=>	'Titre de la section',
					'input_placeholder'		=>	'"Nos projets récents" par exemple'
				),
			),
			'item_loopable_fields'		=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'title',
					'input_title'		=>	'Titre'
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'category',
					'input_title'		=>	'Categorie'
				),
				array(
					'input_type'		=>	'media_lib',
					'input_name'		=>	'full_image',
					'input_title'		=>	'Lien Image Dimensions réelles'
				),
				array(
					'input_type'		=>	'media_lib',
					'input_name'		=>	'thumb_image',
					'input_title'		=>	'Lien Image Aperçu'
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'link',
					'input_title'		=>	'Lien Vers le projet'
				),
			),
			'is_static'			=>	true,
			'description'		=>	'Affichez vos derniers travaux sur la page d\'accueil'
		) );
		/* declare_item( 'testimony'  , array(
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
		) ); */
		declare_item( 'theme_color_and_style' , array(
			'draggable'					=>	false,
			'human_name'				=>	'[Style et Mise en page]',
			'is_static'					=>	true,
			'namespace'					=>	'theme_color_and_style',
			'item_global_fields'	=>	array(
				array(
					'input_type'		=>	'select',
					'input_value'		=>	array(
						array( 'text'	=>	'rouge' , 'value'	=>	'red' ),
						array( 'text'	=>	'rose' , 'value'	=>	'pink' ),
						array( 'text'	=>	'bleu' , 'value'	=>	'blue' ),
						array( 'text'	=>	'orange' , 'value'	=>	'orange' ),
						array( 'text'	=>	'violet' , 'value'	=>	'purple' ),
						array( 'text'	=>	'Cyan Sombre' , 'value'	=>	'darkcyan' ),
						array( 'text'	=>	'Cyan' , 'value'	=>	'cyan' ),
					),
					'input_name'		=>	'background',
					'input_title'		=>	'Choisir une style',
					'input_placeholder'	=>	'Entrez la valeur'
				),
				array(
					'input_type'		=>	'select',
					'input_value'		=>	array(
						array( 'text'	=>	'Pleine Largeur' , 'value'	=>	'fullwidth' ),
						array( 'text'	=>	'Dans une boite' , 'value'	=>	'boxed' ),
					),
					'input_name'		=>	'box_style',
					'input_title'		=>	'Style de la boite',
					'input_placeholder'	=>	'Entrez la valeur'
				),
				array(
					'input_type'		=>	'select',
					'input_value'		=>	array(
						array( 'text'	=>	'Crossed' , 'value'	=>	'crossed' ),
						array( 'text'	=>	'Fabric' , 'value'	=>	'fabric' ),
						array( 'text'	=>	'Linen' , 'value'	=>	'linen' ),
						array( 'text'	=>	'Wood' , 'value'	=>	'wood' ),
						array( 'text'	=>	'Daigmonds' , 'value'	=>	'diagmonds' ),
						array( 'text'	=>	'Triangles' , 'value'	=>	'triangles' ),
						array( 'text'	=>	'Black Mamba' , 'value'	=>	'black_mamba' ),
						array( 'text'	=>	'Vichy' , 'value'	=>	'vichy' ),
						array( 'text'	=>	'Black Pattern' , 'value'	=>	'back_pattern' ),
						array( 'text'	=>	'Checkered Pattern' , 'value'	=>	'checkered_pattern' ),
						array( 'text'	=>	'Diamond Upholstery' , 'value'	=>	'diamond_upholstery' ),
						array( 'text'	=>	'Lyonnette' , 'value'	=>	'lyonnette' ),
						array( 'text'	=>	'Graphy' , 'value'	=>	'graphy' ),
						array( 'text'	=>	'Black Thread' , 'value'	=>	'black_thread' ),
						array( 'text'	=>	'Subtlenet 2' , 'value'	=>	'subtlenet2' ),
					),
					'input_name'		=>	'bg_image',
					'input_title'		=>	'Image d\'arrière-plan',
					'input_placeholder'	=>	'Entrez la valeur'
				),
			),
			'description'				=>	"Modifiez le style de votre thème. Attribuer une coleur générale et le type de la mise en page ('boxed' ou 'full-width')."
		) );
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
			'human_name'				=>	'[Contact - 1] Liens vers les réseaux sociaux',
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
			'human_name'				=>	'[Contact - 1] Informations de la page de contact',
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
			'item_loopable_fields'		=>	array(
				array(
					'input_type'		=>	'select',
					'input_name'		=>	'social_feeds_icon',
					'input_title'		=>	'Icône pour le lien vers le réseau social',
					'input_placeholder'	=>	'Entrez le titre ici',
					'input_value'		=>	array(
						array( 'text' =>	'icone Map Marker' , 'value'	=>	'map-marker' ),
						array( 'text' =>	'icone User' , 'value'	=>	'user' ),
						array( 'text' =>	'icone Mail' , 'value'	=>	'envelope' ),
						array( 'text' =>	'icone Terre' , 'value'	=>	'globe' ),
					)
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'social_feeds_title',
					'input_title'		=>	'Titre de l\'icône',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'social_feeds_value',
					'input_title'		=>	'Valeur de l\'icône',
					'input_placeholder'	=>	'Entrez le titre ici'
				),
			),
			'description'				=>	"Personnalisez les informations disponibles sur la page des contact. Cette section est considéré comme la section \"A propos de nous\"."
		) );
		declare_item( 'contact_gmap_data' , array( 
			'draggable'					=>	false,
			'human_name'				=>	'[Contact - 1] Google Map',
			'is_static'					=>	true,
			'namespace'					=>	'contact_gmap_data',
			'item_global_fields'	=>	array(
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'gmap_longitude',
					'input_title'		=>	'Longitude',
					'input_placeholder'	=>	'Entrez la valeur'
				),
				array(
					'input_type'		=>	'text',
					'input_name'		=>	'gmap_latitude',
					'input_title'		=>	'Latitude',
					'input_placeholder'	=>	'Entrez la valeur'
				),
			),
			'description'				=>	"Définissez l'emplacement géographique de votre entreprise, en longitude et latitude."
		) );
		// Bind Events
		bind_event( 'handle_recents_works' , array( $this , 'recents_works' ) );
		bind_event( 'handle_theme_color_and_style' , array( $this , 'return_values' ) ) ;
		bind_event( 'handle_contact_gmap_data' , array( $this , 'return_values' ) ) ;
		bind_event( 'handle_contact_datas' , array( $this , 'return_values' ) ) ;
		bind_event( 'handle_contact_get_social' , array( $this , 'contact_get_social' ) ) ;
		bind_event( 'handle_footer_social_feeds' , array( $this , 'footer_social_feeds' ) );
		bind_event( 'handle_header_datas' , array( $this , 'header_datas' ) );
		bind_event( 'handle_list_services' , array( $this , 'list_services' ) );
		bind_event( 'handle_social_feeds' , array( $this , 'social_feeds' ) );
		bind_event( 'set_slider_items_vars' , array( $this , 'filter' ) );
		bind_event( 'loop_slider_lines' , array( $this , 'loop_slider' ) );
		bind_event( 'handle_testimony' , array( $this , 'testimony' ) );
	}
	function recents_works( $array )
	{
		/**
		* 	OK
		**/
		$var			=	return_if_array_key_exists( 'title' , $array );
		$titles			=	return_if_array_key_exists( 'level' , $var );
		
		$var			=	return_if_array_key_exists( 'category' , $array );
		$categories		=	return_if_array_key_exists( 'level' , $var );
		
		$var			=	return_if_array_key_exists( 'full_image' , $array );
		$full_images	=	return_if_array_key_exists( 'level' , $var );
		
		$var			=	return_if_array_key_exists( 'thumb_image' , $array );
		$thumb_image	=	return_if_array_key_exists( 'level' , $var );
				
		$link_lev		=	return_if_array_key_exists( 'link' , $array );
		$links			=	return_if_array_key_exists( 'level' , $link_lev );
		
		if( count( $titles ) == count( $categories ) && count( $full_images ) == count( $links ) ) // ...
		{
		?>

<section class="latest_work">
    <div class="container">
        <div class="row sub_content">
            <div class="carousel-intro">
                <div class="col-md-12">
                    <div class="dividerHeading">
                        <h4><span><?php echo ( $title = riake( 'global_title' , $array ) ) ? $title : "Custom Title";?></span></h4>
                    </div>
                    <div class="carousel-navi">
                        <div id="work-prev" class="arrow-left jcarousel-prev" data-jcarouselcontrol="true"><i class="fa fa-angle-left"></i></div>
                        <div id="work-next" class="arrow-right jcarousel-next active" data-jcarouselcontrol="true"><i class="fa fa-angle-right"></i></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="jcarousel recent-work-jc" data-jcarousel="true" style="height: 162px;">
                <ul class="jcarousel-list" style="left: 0px;">
                    <!-- Recent Work Item -->
                    <?php
					if( count( $titles ) == count( $categories ) && count( $full_images ) == count( $thumb_image ) ) // :)
					{
						for($i = 0 ; $i < count( $titles ) ; $i ++ ){
					?>
                    <li class="col-sm-3 col-md-3 col-lg-3">
                        <div class="recent-item">
                            <figure>
                                <div class="touching medium"> <img src="<?php echo $thumb_image[ $i ];?>" alt="" width="530"> </div>
                                <div class="option"> <a href="<?php echo $full_images[ $i ];?>" class="hover-zoom mfp-image"><i class="fa fa-search"></i></a> <a href="<?php echo $links[ $i ];?>" class="hover-link"><i class="fa fa-link"></i></a> </div>
                                <figcaption class="item-description">
                                    <h5><?php echo $titles[ $i ];?></h5>
                                    <span><?php echo $categories[ $i ];?></span> </figcaption>
                            </figure>
                        </div>
                    </li>
                    <?php
						}
					}
					?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php
		}
	}
	function return_values( $array )
	{
		return $array;
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
                            <small><?php echo return_if_array_key_exists( $i , $authors );?></small> </blockquote>
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
		if( count( $titles ) == count( $description ) && count( $icons ) == count( $titles ) )
		{
		?>
<section class="info_service">
    <div class="container">
        <div class="row sub_content">
            <?php
				if( count( $titles ) == count( $description ) && count( $icons ) == count( $titles ) )
				{
					for($i = 0 ; $i < count( $titles ) ; $i ++ ){
				?>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="serviceBox_2"> <i class="fa fa-<?php echo $icons[ $i ];?>"></i>
                    <h3><?php echo $titles[ $i ];?></h3>
                    <p><?php echo $description[ $i ];?></p>
                </div>
            </div>
            <?php
					}
				}
				?>
        </div>
    </div>
</section>
<?php
		}
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
