<?php
	/**
	*
	**/
	function return_if_array_key_exists($key,$array){
		if(is_array($array))
		{
			return array_key_exists($key, $array) ? $array[ $key ] : FALSE;
		}
		return false;
	}
	/**
	*	riake @lias return_if_array_key_exists( )
	**/
	function riake( $key  , $array ){
		return return_if_array_key_exists( $key , $array );
	}
	/**
	*	get_blog_post() : Recupère tous les articles du blog (Not Documented)
	**/
	function get_blog_posts(){
		if(count( get_active_theme_vars( 'blog_posts_clone' ) ) > 0 && get_active_theme_vars( 'blog_posts_clone' ) !== FALSE)
		{
			$saved_post	=	get_active_theme_vars( 'blog_posts_clone' );
			$blog_post	=	new stdClass;
			$blog_post->title		=	return_if_array_key_exists( 'TITLE' , $saved_post[0] );
			$blog_post->content		=	return_if_array_key_exists( 'CONTENT' , $saved_post[0] );
			$blog_post->author		=	return_if_array_key_exists( 'AUTHOR' , $saved_post[0] );
			$blog_post->author_link	=	get_instance()->url->site_url(array('account','profile',$saved_post[0]['AUTHOR']['PSEUDO']));
			
			$blog_post->full		=	return_if_array_key_exists( 'FULL' , $saved_post[0] );
			$blog_post->thumb		=	return_if_array_key_exists( 'THUMB' , $saved_post[0] );
			$blog_post->timestamp	=	return_if_array_key_exists( 'TIMESTAMP' , $saved_post[0] );
			$blog_post->categories	=	return_if_array_key_exists( 'CATEGORIES' , $saved_post[0] );
			$blog_post->keywords	=	return_if_array_key_exists( 'KEYWORDS' , $saved_post[0] );
			$blog_post->comments	=	return_if_array_key_exists( 'COMMENTS' , $saved_post[0] );
			$blog_post->link		=	return_if_array_key_exists( 'LINK' , $saved_post[0] );
			// Retire la publication du tableau
			array_shift($saved_post);
			set_active_theme_vars( 'blog_posts_clone' , $saved_post);
			// Return
			return $blog_post;
		}
		return false;
	}
	/**
	*	set_blog_post()
	**/
	function set_blog_post($array)
	{
		$title			=	return_if_array_key_exists( 'title' , $array );
		$content		=	return_if_array_key_exists( 'content' , $array );
		$thumb			=	return_if_array_key_exists( 'thumb' , $array );
		$full			=	return_if_array_key_exists( 'full' , $array );
		$author			=	return_if_array_key_exists( 'author' , $array );
		$link			=	return_if_array_key_exists( 'link' , $array );
		$timestamp		=	return_if_array_key_exists( 'timestamp' , $array );
		$categories		=	return_if_array_key_exists( 'categories' , $array );
		$keywords		=	return_if_array_key_exists( 'keywords' , $array );
		$comments		=	return_if_array_key_exists( 'comments' , $array );
		
		if($title)
		{
			$saved_post		=	get_active_theme_vars( 'blog_posts' ) 
				? get_active_theme_vars( 'blog_posts' ) : array();
			$saved_post		=	get_active_theme_vars( 'blog_posts_clone' ) 
				? get_active_theme_vars( 'blog_posts_clone' ) : array();
			$saved_post[]	=		array(
				'AUTHOR'			=>	$author, // est un tableau associatif [PSEUDO],[ID],[EMAIL] ...
				'CONTENT'			=>	$content,
				'THUMB'				=>	$thumb,
				'FULL'				=>	$full,
				'LINK'				=>	$link,
				'TITLE'				=>	$title,
				'TIMESTAMP'			=>	$timestamp,
				'CATEGORIES'		=>	$categories, // forme array('TITLE'	=>	'','LINK'	=>	'', 'DESCRIPTION'	=>	'');
				'KEYWORDS'			=>	$keywords, // array('TITLE' => '', 'LINK' =>	'', 'DESCRIPTION' 	=> '');
				'COMMENTS'			=>	$comments
			);
			set_active_theme_vars( 'blog_posts_clone' , $saved_post );
			return set_active_theme_vars( 'blog_posts' , $saved_post );
		}
		return false;
	}	
	/**
	*	have_blog_posts()
	**/
	function have_blog_posts(){
		return get_active_theme_vars( 'blog_posts_clone' ) !== false ? true : false;
	}
	/**
	*	loop_categories() : parcours les categories et renvoie plusieurs liens
	**/
	function loop_categories($categories, $divider = ',' , $wrap = "", $wrapper_class = "" , $wrapper_id = ""){
		if(in_array($wrap , array('ul', 'ol', 'span')))
		{
			?>
			<<?php echo $wrap;?> 
				<?php if($wrapper_class != ""){ ;?> class="<?php echo $wrapper_class;?>" <?php };?>
				<?php if($wrapper_id != ""){ ;?> id="<?php echo $wrapper_id;?>" <?php };?>
			>
			<?php
		}
		for($i = 0 ; $i < count($categories) ; $i++ )
		{
			if(in_array($wrap , array('ul', 'ol')))
			{
				?>
				<li>
				<?php
			}
			if(isset($categories[$i + 1]))
			{
				$marge	=	", ";
			}
			else
			{
				$marge	=	"";	
			}
			?><a href="<?php echo $categories[ $i ][ 'LINK' ];?>"><?php echo $categories[ $i ][ 'TITLE' ];?></a><?php echo $marge;?><?php
			if(in_array($wrap , array('ul', 'ol')))
			{
				?>
				</li>
				<?php
			}
		}
		if(in_array($wrap , array('ul', 'ol', 'span')))
		{
			?>
			</<?php echo $wrap;?>>
			<?php
		}}
	/**
	*	loop_tags()	:	Parcours les mots-clés
	**/
	function loop_tags($tags,$options){
		return loop_helper($tags,$options);
	}
	function loop_helper($array,$options = array())	{
		$divider		=	return_if_array_key_exists('divider',$options);
		$wrapper		=	return_if_array_key_exists('wrapper',$options);
		$wrapper_class	=	return_if_array_key_exists('wrapper_class',$options);
		$wrapper_id		=	return_if_array_key_exists('wrapper_id',$options);
		$li_class		=	return_if_array_key_exists('li_class',$options);
		$li_id			=	return_if_array_key_exists('li_id',$options);
		$item_class	=	(return_if_array_key_exists('item_class',$options) != false ) 
				? 'class="'.return_if_array_key_exists('item_class',$options).'"' 
					: '';
			$item_id	=	(return_if_array_key_exists('item_id',$options) != false ) 
				? 'id="'.return_if_array_key_exists('item_id',$options).'"' 
					: '';
		if(in_array(return_if_array_key_exists('wrapper',$options), array('ul', 'ol', 'span' ), true))
		{
			?>
            <<?php echo $wrapper;?>
            	<?php if($wrapper_class != ''){ ?>
                	class="<?php echo $wrapper_class;?>"
				<?php };?>
                <?php if($wrapper_id != ""){?>
                	id="<?php echo $wrapper_id;?>"
				<?php };?>
             > 
			<?php
		}
		for($i=0 ; $i < count($array) ; $i++)
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			if(in_array($wrapper, array('ul', 'ol')))
			{
				?>
				<li <?php echo ($li_id != false) ? $li_id : '' ?>>
				<?php
			}
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			if(isset($array[ $i + 1] ))
			{
				// Si aucun divider n'est envoyé, on verifie
				$divider	= ($divider != false) ? $divider.' ' : '';
			}
			else
			{
				$divider	=	'';
			}
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			?><a href="<?php echo $array[ $i ][ 'LINK' ];?>" <?php echo $item_class;?> <?php echo $item_id;?>><?php echo $array[ $i ][ 'TITLE' ];?></a><?php echo $divider;?><?php
			if(in_array($wrapper, array('ul', 'ol')))
			{
				?></li><?php
			}
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		}
		if(in_array(return_if_array_key_exists('wrapper',$options), array('ul', 'ol', 'span' ), true))
		{
			?>
             </<?php echo return_if_array_key_exists('wrapper',$options);?>>
            <?php
		}
	}
	/**
	*	get_blog_single()
	**/
	function get_blog_single(){
		if(($saved_post	=	get_active_theme_vars( 'blog_single' )) == TRUE )
		{
			$blog_post	=	new stdClass;
			$blog_post->title		=	return_if_array_key_exists( 'TITLE' , $saved_post );
			$blog_post->content		=	return_if_array_key_exists( 'CONTENT' , $saved_post );
			$blog_post->author		=	return_if_array_key_exists( 'AUTHOR' , $saved_post );
			$blog_post->author_link	=	get_instance()->url->site_url(array('account','profile',$saved_post['AUTHOR']['PSEUDO']));
			$blog_post->full		=	return_if_array_key_exists( 'FULL' , $saved_post );
			$blog_post->thumb		=	return_if_array_key_exists( 'THUMB' , $saved_post );
			$blog_post->timestamp	=	return_if_array_key_exists( 'TIMESTAMP' , $saved_post );
			$blog_post->categories	=	return_if_array_key_exists( 'CATEGORIES' , $saved_post );
			$blog_post->keywords	=	return_if_array_key_exists( 'KEYWORDS' , $saved_post );
			$blog_post->comments	=	return_if_array_key_exists( 'COMMENTS' , $saved_post );
			$blog_post->link		=	return_if_array_key_exists( 'LINK' , $saved_post );	
			return $blog_post;
		}
		return false;
	}
	/**
	*	set_blog_single()
	**/
	function set_blog_single( $array )
	{
		$title			=	return_if_array_key_exists( 'title' , $array );
		$content		=	return_if_array_key_exists( 'content' , $array );
		$thumb			=	return_if_array_key_exists( 'thumb' , $array );
		$full			=	return_if_array_key_exists( 'full' , $array );
		$author			=	return_if_array_key_exists( 'author' , $array );
		$link			=	return_if_array_key_exists( 'link' , $array );
		$timestamp		=	return_if_array_key_exists( 'timestamp' , $array );
		$categories		=	return_if_array_key_exists( 'categories' , $array );
		$keywords		=	return_if_array_key_exists( 'keywords' , $array );
		$comments		=	return_if_array_key_exists( 'comments' , $array );
		
		$saved_post		=		array(
				'AUTHOR'			=>	$author, // est un tableau associatif [PSEUDO],[ID],[EMAIL] ...
				'CONTENT'			=>	$content,
				'THUMB'				=>	$thumb,
				'FULL'				=>	$full,
				'LINK'				=>	$link,
				'TITLE'				=>	$title,
				'TIMESTAMP'			=>	$timestamp,
				'CATEGORIES'		=>	$categories, // forme array('TITLE'	=>	'','LINK'	=>	'', 'DESCRIPTION'	=>	'');
				'KEYWORDS'			=>	$keywords, // array('TITLE' => '', 'LINK' =>	'', 'DESCRIPTION' 	=> '');
				'COMMENTS'			=>	$comments
		);
		return set_active_theme_vars( 'blog_single' , $saved_post );		
	}
	function have_blog_single(){
		return get_active_theme_vars( 'blog_single' ) ? true : false;
	}
	/**
	*	get_blog_comments()
	**/
	function get_blog_comments(){
		if(($saved_comments	=	get_active_theme_vars( 'blog_comments' )) == TRUE )
		{
			$comments	=	new stdClass;
			$comments->author		=	return_if_array_key_exists( 'AUTHOR' , $saved_comments[0] );
			$comments->author_link	=	return_if_array_key_exists( 'AUTHORLINK' , $saved_comments[0] );
			$comments->content		=	return_if_array_key_exists( 'CONTENT' , $saved_comments[0] );
			$comments->timestamp	=	return_if_array_key_exists( 'TIMESTAMP' , $saved_comments[0] );
			array_shift( $saved_comments );
			set_active_theme_vars( 'blog_comments' , $saved_comments );
			return $comments;
		}
		return false;
	}
	/**
	*	set_blog_comment() : défini un commentaire pour un article
	**/
	function set_blog_comment( $array ){
		$saved_comments		=	get_active_theme_vars( 'blog_comments' ) ? get_active_theme_vars( 'blog_comments' ) : array();
		$author				=	return_if_array_key_exists( 'author' , $array );
		$content			=	return_if_array_key_exists( 'content' , $array );
		$timestamp			=	return_if_array_key_exists( 'timestamp' , $array );
		$author_link		=	return_if_array_key_exists( 'authorlink' , $array );
		
		$saved_comments[]	=	array(
			'AUTHOR'		=>	$author,
			'AUTHORLINK'	=>	$author_link,
			'CONTENT'		=>	$content,
			'TIMESTAMP'		=>	$timestamp
		);
		
		return set_active_theme_vars( 'blog_comments' , $saved_comments );
	}
	function have_blog_comments(){
		return get_active_theme_vars( 'blog_comments' ) ? true : false;
	}
	/**
	*	set_form
	**/
	function declare_form( $namespace , $config ){
		set_active_theme_vars( $namespace . '_dom' , $config );
	}
	function set_form($name_space, $array){
		$saved_fields				=	get_active_theme_vars( $name_space ) ? get_active_theme_vars( $name_space ) : array();
		$new_field =	new stdClass;
		$new_field->type			=	return_if_array_key_exists( 'type' , $array );
		$new_field->name			=	return_if_array_key_exists( 'name' , $array );
		$new_field->placeholder		=	return_if_array_key_exists( 'placeholder' , $array );
		$new_field->value			=	return_if_array_key_exists( 'value' , $array );
		$new_field->text			=	return_if_array_key_exists( 'text' , $array );
		$saved_fields[]				=	$new_field;
		
		set_active_theme_vars( $name_space , $saved_fields );
	}
	function parse_form( $form_namespace ){
		if( get_active_theme_vars( $form_namespace ))
		{
			$array						=	get_active_theme_vars( $form_namespace . '_dom' );
			$do_use_text				=	return_if_array_key_exists( 'do_use_text' , $array );
			$each_input_field_class		=	return_if_array_key_exists( 'each_input_field_class' , $array );
			$each_input_field_id		=	return_if_array_key_exists( 'each_input_field_id' , $array );
			$each_textarea_field_class	=	return_if_array_key_exists( 'each_textarea_field_class' , $array );
			$each_textarea_field_id		=	return_if_array_key_exists( 'each_textarea_field_id' , $array );
			$each_button_field_class	=	return_if_array_key_exists( 'each_button_field_class' , $array );
			$each_button_field_id		=	return_if_array_key_exists( 'each_button_field_id' , $array );
			$before_each_input_field	=	return_if_array_key_exists( 'before_each_input_field' , $array );
			$after_each_input_field		=	return_if_array_key_exists( 'after_each_input_field' , $array );
			$before_each_textarea_field	=	return_if_array_key_exists( 'before_each_textarea_field' , $array );
			$after_each_textarea_field	=	return_if_array_key_exists( 'after_each_textarea_field' , $array );
			$before_each_button_field	=	return_if_array_key_exists( 'before_each_button_field' , $array );
			$after_each_button_field	=	return_if_array_key_exists( 'after_each_button_field' , $array );
			$before_each_field_text		=	return_if_array_key_exists( 'before_each_field_text' , $array );
			$after_each_field_text		=	return_if_array_key_exists( 'after_each_field_text' , $array );
			
			foreach( get_active_theme_vars( $form_namespace ) as $field )
			{
				if(in_array($field->type, array('text','password')))
				{
					?>
					<?php echo $before_each_input_field;?>
                    	<?php if( $do_use_text ) : ?>
							<?php echo $before_each_field_text;?>
                                <?php echo $field->text;?>
                            <?php echo $after_each_field_text;?>
                        <?php endif;?>
						<input 
							type="<?php echo $field->type;?>" 
							class="<?php echo $each_input_field_class;?>" 
							id="<?php echo $each_input_field_id;?>" 
							placeholder="<?php echo $field->placeholder;?>" 
							name="<?php echo $field->name;?>" 
							value="<?php echo $field->value;?>">
					<?php echo $after_each_input_field;?>
					<?php
						
				}
				else if(in_array($field->type, array('submit','button','reset')))
				{
					?>
					<?php echo $before_each_button_field;?>
					<input type="<?php echo $field->type;?>" value="<?php echo $field->value;?>" class="<?php echo $each_button_field_class;?>" id="<?php echo $each_button_field_id;?>" >
					<?php echo $after_each_button_field;?>
					<?php
				}
				else if($field->type	==	'textarea')
				{
					?>
					<?php echo $before_each_textarea_field;?>
						<?php if( $do_use_text ) : ?>
							<?php echo $before_each_field_text;?>
                                <?php echo $field->text;?>
                            <?php echo $after_each_field_text;?>
                        <?php endif;?>
							<textarea rows="8" name="<?php echo $field->name;?>" class="<?php echo $each_textarea_field_class;?>" id="<?php echo $each_textarea_field_id;?>"  placeholder="<?php echo $field->placeholder;?>"><?php echo $field->value;?></textarea>
					<?php echo $after_each_textarea_field;?>
					<?php
				}
				else if($field->type	==	'hidden')
				{
					?><input type="hidden" name="<?php echo $field->name;?>"><?php
				}
			}
		}
		return false;
	}
	/**
	*	parse_notices
	**/
	function parse_notices( $array ){
		$before_notice				=	return_if_array_key_exists( 'before_notice' , $array );
		$after_notice				=	return_if_array_key_exists( 'after_notice' , $array );		
		$notices					=	get_instance()->notice->get_notice_array();
		
		if(is_array( $notices )){
			foreach( $notices as $notice )
			{
				echo $before_notice;
				echo $notice;
				echo $after_notice;
			}
		}
	}
	/**
	*	parse_pagination()
	**/
	function set_pagination( $array ){
		return set_active_theme_vars( 'theme_pagination' , $array );
	};
	function parse_pagination( $array ){
		if( $array == 'return' )
		{
			return get_active_theme_vars( 'theme_pagination' );
		}
		else
		{
			if(is_array( parse_pagination( 'return' ) ) )
			{
				$item_class			=	return_if_array_key_exists( 'item_class' , $array );
				$item_active_class	=	return_if_array_key_exists( 'item_active_class' , $array );
				$item_id			=	return_if_array_key_exists( 'item_id' , $array );
				$li_class			=	return_if_array_key_exists( 'li_class' , $array );
				$li_active_class	=	return_if_array_key_exists( 'li_active_class' , $array );
				$li_id				=	return_if_array_key_exists( 'li_id' , $array );
				$parent_class		=	return_if_array_key_exists( 'parent_class' , $array );
				$parent_id			=	return_if_array_key_exists( 'parent_id' , $array );
				$parent				=	return_if_array_key_exists( 'parent' , $array );
				$wrapper			=	return_if_array_key_exists( 'wrapper' , $array );
				$wrapper_class		=	return_if_array_key_exists( 'wrapper_class' , $array );
				$wrapper_id			=	return_if_array_key_exists( 'wrapper_id' , $array );
				
				$pagination	=	parse_pagination( 'return' );
				if( return_if_array_key_exists( 'innerLink' , $pagination ) )
				{
					if( in_array( $wrapper , array('nav' , 'div')))
					{
						echo '<'.$wrapper . ' class="'.$wrapper_class.'"' . ' id="' . $wrapper_id . '" >';
					}
					if( in_array( $parent , array('ul' , 'ol')))
					{
						echo '<'.$parent . ' class="'.$parent_class.'"' . ' id="' . $parent_id . '" >';
					}
					foreach($pagination[ 'innerLink' ]  as $page )
					{
						if( $page[ 'state' ] == 'active' )
						{
							$li_class	.=	' '.$li_active_class;
							$item_class	.= 	' '.$item_active_class;
						}
						?>
                        <li class="<?php echo $li_class;?>" id="<?php echo $li_id;?>">
                        	<a class="<?php echo $item_class;?>" id="<?php echo $item_id;?>" href="<?php echo $page[ 'link' ];?>"><?php echo $page[ 'text' ];?></a>
                        </li>
                        <?php						
					}
					if( in_array( $parent , array('ul' , 'ol')))
					{
						echo '</'.$parent .' >';
					}
					if( in_array( $wrapper , array('nav' , 'div')))
					{
						echo '</'.$wrapper. ' >';
					}
				}
			}
		}
	}
	function pagination_exists(){
		if( parse_pagination( 'return' ) )
		{
			return true;
		}
		return false;
	}
	/**
	*	theme_parse_menu : Affiche un menu avec les informations envoyée
	**/
	function theme_parse_menu($options) // add to doc new tendoo 1.2
	{
		function get_submenu($element,$real_options)
		{
			if($real_options['menu_limitation'] == "limitation_reached")
			{
				return false;
			}
			else
			{
				(int)$real_options['menu_limitation']--;
				if($real_options['menu_limitation'] == 0)
				{
					$real_options['menu_limitation'] == "limitation_reached";
				}
			}
			if(is_array($element))
			{
				if(array_key_exists('PAGE_CHILDS',$element))
				{
					if(is_array($element['PAGE_CHILDS']))
					{
						if(!is_array($real_options['li_parents']) || $real_options['li_parents'] != true)
						{
							$real_options['li_parents'] = array($real_options['li_parents']);
						}
						if(!is_array($real_options['li_parents_class']) || $real_options['li_parents_class'] != true)
						{
							$real_options['li_parents_class'] = array($real_options['li_parents_class']);
						}
						if(!is_array($real_options['li_parents_id']) || $real_options['li_parents_id'] != true)
						{
							$real_options['li_parents_id'] = array($real_options['li_parents_id']);
						}
						$li_parent					=	$real_options['li_parents'][0];
						if(count($real_options['li_parents']) > 0)
						{
							// When Classe is used, we shift it
							$real_options['li_parents']	=	array_shift($real_options['li_parents']);
						}
						$li_parent_class					=	$real_options['li_parents_class'][0];						
						if(count($real_options['li_parents_class']) >0)
						{
							$real_options['li_parents_class']	=	array_shift($real_options['li_parents_class']);
						}
						$li_parent_id					=	$real_options['li_parents_id'][0];
						if(count($real_options['li_parents_id']) >0)
						{
							$real_options['li_parents_id']	=	array_shift($real_options['li_parents_id']);
						}
						?>
<<?php echo $li_parent;?> class="<?php echo $li_parent_class;?>" 
                        id="<?php echo $li_parent_id;?>">
                        <?php
							foreach($element['PAGE_CHILDS'] as $childs)
							{
								if($childs['PAGE_MODULES'] == '#LINK#')
								{
									?>
                        <li> <a href="<?php echo $childs['PAGE_LINK'];?>"><?php echo $childs['PAGE_NAMES'];?></a>
    <?php get_submenu($childs,$real_options);?>
</li>
                        <?php
								}
								else
								{
									?>
                        <li> <a href="<?php echo get_instance()->url->site_url(array($childs['PAGE_CNAME']));?>"><?php echo $childs['PAGE_NAMES'];?></a>
    <?php get_submenu($childs,$real_options);?>
</li>
                        <?php
								}
							}
							?>
</<?php echo $li_parent;?>
<?php
					}
				}
			}
		}
		$CORE						=	get_instance();
		$default_options	=	array(
			'show_directly'			=>	true,
			'menu_limitation'		=>	0, // unfinite
			'base_ul_class'			=>	'',
			'base_ul_id'			=>	'',
			'li_parents_class'		=>	'', // can accept array for each childs in diffrent sublevel
			'li_parents_id'			=>	'', // same
			'li_parents'			=>	'ul', // can be array of childs for each submenus
			'li_a_has_child_class'	=>	'',
			'li_a_has_child_id'		=>	'',
			'li_a_has_child_attr'	=>	'',
			'parent'				=>	'',
			'parent_class'			=>	'',
			'li_active_class'		=>	'active',
			'li_default_class'		=>	'',
			// New
			'li_has_child_class'	=>	'',
			'li_has_child_id'		=>	''
		);
		$real_options		=	array_merge($default_options,$options);
		$real_options['parent']		=	in_array($real_options['parent'],array('div','nav',false)) ? $real_options['parent'] : 'div';		
		$array	=	get_core_vars('controllers');
		if($real_options['show_directly']	==	true)
		{
			if($real_options['parent'] != false)
			{
			?>
			<<?php echo $real_options['parent'];?> class="<?php echo $real_options['parent_class'];?>">
			<?php
			}
			?>
			<ul class="<?php echo $real_options['base_ul_class'];?>" id="<?php echo $real_options['base_ul_id'];?>">
			<?php
			foreach($array as $c)
			{
				$li_has_child_class	=	is_array($c['PAGE_CHILDS']) ? $real_options['li_has_child_class'] : '';
				$li_has_child_id		=	is_array($c['PAGE_CHILDS']) ? $real_options['li_has_child_id'] : '';
				$li_a_has_child_id		=	is_array($c['PAGE_CHILDS']) ? $real_options['li_a_has_child_id'] : '';
				$li_a_has_child_class	=	is_array($c['PAGE_CHILDS']) ? $real_options['li_a_has_child_class'] : '';
				$li_a_has_child_attr	=	is_array($c['PAGE_CHILDS']) ? $real_options['li_a_has_child_attr'] : '';
				?>
    <?php if($c["PAGE_CNAME"] == $CORE->url->controller())	{ ?>
    <?php if($c["PAGE_MODULES"] == "#LINK#")	{ ?>
    <li id="<?php echo $li_has_child_id;?>" class="<?php echo $li_has_child_class;?> <?php echo $real_options['li_active_class'];?> <?php echo $real_options['li_default_class'];?>"> <a 
                            <?php echo ($li_a_has_child_class != '') ? "class='".$li_a_has_child_class."'" : "";?>
                            <?php echo ($li_a_has_child_id != '') ? "id='".$li_a_has_child_id."'" : "";?>
                            <?php echo ($li_a_has_child_attr != '') ? $li_a_has_child_attr : "";?>
                            href="<?php echo $c["PAGE_LINK"];?>" title="<?php echo $c["PAGE_TITLE"];?>"> <?php echo ucwords($c["PAGE_NAMES"]);?> </a>
        <?php get_submenu($c,$real_options);?>
    </li>
    <?php } else { ?>
    <li id="<?php echo $li_has_child_id;?>" class="<?php echo $li_has_child_class;?> <?php echo $real_options['li_active_class'];?> <?php echo $real_options['li_default_class'];?>"> <a 
                            <?php echo ($li_a_has_child_class != '') ? "class='".$li_a_has_child_class."'" : "";?>
                            <?php echo ($li_a_has_child_id != '') ? "id='".$li_a_has_child_id."'" : "";?>
                            <?php echo ($li_a_has_child_attr != '') ? $li_a_has_child_attr : "";?>
                            href="<?php echo $CORE->url->site_url(array($c["PAGE_CNAME"]));?>" 
                            title="<?php echo $c["PAGE_TITLE"];?>"> <?php echo ucwords($c["PAGE_NAMES"]);?> </a>
        <?php get_submenu($c,$real_options);?>
    </li>
    <?php } ?>
    <?php }  else { ?>
    <?php if($c["PAGE_MODULES"] == "#LINK#")	{ ?>
    <li id="<?php echo $li_has_child_id;?>" class="<?php echo $li_has_child_class;?> <?php echo $real_options['li_default_class'];?>"> <a 
                            <?php echo ($li_a_has_child_class != '') ? "class='".$li_a_has_child_class."'" : "";?>
                            <?php echo ($li_a_has_child_id != '') ? "id='".$li_a_has_child_id."'" : "";?>
                            <?php echo ($li_a_has_child_attr != '') ? $li_a_has_child_attr : "";?>
                            href="<?php echo $c["PAGE_LINK"];?>" 
                            title="<?php echo $c["PAGE_TITLE"];?>"> <?php echo ucwords($c["PAGE_NAMES"]);?> </a>
        <?php get_submenu($c,$real_options);?>
    </li>
    <?php } else { ?>
    <li id="<?php echo $li_has_child_id;?>" class="<?php echo $li_has_child_class;?> <?php echo $real_options['li_default_class'];?>"> <a 
                            <?php echo ($li_a_has_child_class != '') ? "class='".$li_a_has_child_class."'" : "";?>
                            <?php echo ($li_a_has_child_id != '') ? "id='".$li_a_has_child_id."'" : "";?>
                            <?php echo ($li_a_has_child_attr != '') ? $li_a_has_child_attr : "";?>
                            href="<?php echo $CORE->url->site_url(array($c["PAGE_CNAME"]));?>" 
                            title="<?php echo $c["PAGE_TITLE"];?>"> <?php echo ucwords($c["PAGE_NAMES"]);?> </a>
        <?php get_submenu($c,$real_options);?>
    </li>
    <?php } ?>
    <?php } ?>
    <?php
			}
			?>
</ul>
		<?php if($real_options['parent'] != false)
        {
        ?>
        </<?php echo $real_options['parent'];?>>
        <?php
        }
        ?>
        <?php
		}		
	}
	/**
	*	declare_widget_dom() : définit un modèle pour les widgets en fonction de leur type
	**/
	function declare_widget( $zone , $type , $array){
		if(in_array( $type , array( 'tags' , 'categories' , 'search' , 'text' , 'images' , 'list' ) ) )
		{
			$widget	=	new stdClass;
			$widget->before_widget	=	return_if_array_key_exists( 'before_widget' , $array );
			$widget->after_widget	=	return_if_array_key_exists( 'after_widget' , $array );
			$widget->open_wrapper	=	return_if_array_key_exists( 'open_wrapper' , $array );
			$widget->close_wrapper	=	return_if_array_key_exists( 'close_wrapper' , $array );
			$widget->before_title	=	return_if_array_key_exists( 'before_title' , $array );
			$widget->after_title	=	return_if_array_key_exists( 'after_title' , $array );
			$widget->open_content	=	return_if_array_key_exists( 'open_content' , $array );
			$widget->close_content	=	return_if_array_key_exists( 'close_content' , $array );
			$widget->open_parent	=	return_if_array_key_exists( 'open_parent' , $array );
			$widget->close_parent	=	return_if_array_key_exists( 'close_parent' , $array );
			$widget->before_item	=	return_if_array_key_exists( 'before_item' , $array );
			$widget->after_item		=	return_if_array_key_exists( 'after_item' , $array );
			
			$widget->paginate		=	return_if_array_key_exists( 'paginate' , $array );
			
			$widget->item			=	return_if_array_key_exists( 'item' , $array );
			$widget->item_class		=	return_if_array_key_exists( 'item_class' , $array );
			$widget->item_id		=	return_if_array_key_exists( 'itme_id' , $array );
			// On ajoute la forme aux formes déjà existante, en cas complit la nouvelle écrasera l'ancienne
			$saved_form				=	get_active_theme_vars( $zone. '_widgets_types' ) 
				? get_active_theme_vars( $zone. '_widgets_types' ) : array();
			$saved_form[ $type ] 	=	$widget;
			// On enregistre le widget avec un espace nom définit $zone 
			return set_active_theme_vars( $zone. '_widgets_types' ,  $saved_form );
		}
		return false;
	}
	/**
	*	get_widgets(  ) : renvoi un widget
	**/
	function get_widgets( $zone , $callback	= "nothing" ){
		$widgets_form	=	get_active_theme_vars( $zone.'_widgets_types'  );
		$zone_widgets	=	get_active_theme_vars( $zone.'_widgets' );
		if( $callback	== "return_full_array" )
		{
			return $zone_widgets;
		}
		if( is_array( $zone_widgets ) )
		{
			foreach( $zone_widgets as  $widgets )
			{
				$model			=	return_if_array_key_exists( $widgets[ 'type' ] , $widgets_form );
				if($model)
				{
					echo $model->before_widget;
						echo $model->open_wrapper;
							echo $model->before_title;
								echo $widgets[ 'title' ];	
							echo $model->after_title;
							echo $model->open_content;
								echo $model->open_parent;
								if(is_array($widgets[ 'content' ]))
								{
									foreach($widgets[ 'content' ] as $_e)
									{
										echo $model->before_item;
											?> <a href="<?php echo return_if_array_key_exists( 'link' , $_e );?>" class="<?php echo $model->item_class;?>" id="<?php echo $model->item_id;?>"><?php echo return_if_array_key_exists( 'text' , $_e );?></a> <?php
										echo $model->after_item;
									}
								}
								else
								{
									echo $model->before_item;
										echo $widgets[ 'content' ];
									echo $model->after_item;
								}
								echo $model->close_parent;
							echo $model->close_content;
						echo $model->close_wrapper;
					echo $model->after_widget;
				}
				// Par défaut si aucun style n'est enregistré, 
				// by default if not dom style is defined
				else
				{
					if( !is_array( $widgets[ 'content' ] ))
					{
					?>
					<div class="widget_style_not_defined">
						<h4><?php echo $widgets[ 'title'];?></h4>
						<p><?php echo $widgets['content'];?></p>
					</div>
					<?php
					}
					else
					{
						?>
						<p>Le widget : <strong><?php echo $widgets[ 'title' ];?></strong> n'a pas été définit correctement, ou le thème actif n'est pas compatible avec ce widget.</p>
						<?php
					}
				}
			}
		}
	}
	/**
	*	set_widget( $title , $content , $type , $zone );
	**/
	function set_widget( $zone , $title , $content , $type ){
		$saved_widgets		=	get_active_theme_vars( $zone. '_widgets' ) 
			? get_active_theme_vars( $zone. '_widgets' ) : array();
		$saved_widgets[]	=	array(
			'title'			=>		$title,
			'content'		=>		$content,
			'type'			=>		$type
		);
		return set_active_theme_vars( $zone. '_widgets' , $saved_widgets );
	}
	/**
	*	declare_bread() : configure la forme des bread
	**/
	function declare_bread( $config ){
		$default	=	array(
			'divider' 			=>		'/',
			'wrapper'			=>		'ul',
			'wrapper_class'		=>		'wrapper-class',
			'wrapper_id'		=>		'wrappper-id',
			'item_class'		=>		'item-class',
			'item_id'			=>		'item-id',
			'text_before_bread'	=>		'',
			'container'			=>		'div',
			'container_class'	=>		'container-class',
			'container_id'		=>		'container-id',
			'word_limiter'		=>		10
		);
		$config		=	array_merge( $default , $config );
		return set_active_theme_vars( 'breadcrumbs_setup' , $config );
	};
	/**
	*	set_bread() : pour l'enregistrement des breadcrumbs
	**/
	function set_bread( $array ){
		// Si aucun breadcrumbs n'est enregistré, l'on créer un tableau vide.
		$saved_bread	=	get_active_theme_vars( 'breadcrumbs' ) ? get_active_theme_vars( 'breadcrumbs' ) : array();
		$link			=	return_if_array_key_exists( 'link' , $array ) ? return_if_array_key_exists( 'link' , $array ) : "#";
		$text			=	return_if_array_key_exists( 'text' , $array ) ? return_if_array_key_exists( 'text' , $array ) : "Empty";
		$saved_bread[]	=	array(
			'link'		=>	$link,
			'text'		=>	$text
		);
		return set_active_theme_vars( 'breadcrumbs' , $saved_bread );
	}
	/**
	*	get_bread()
	**/
	function get_breads( $rewrite_config = false ){
		if(is_array( $rewrite_config ))
		{
			setup_bread( $rewrite_config );
		}
		$saved_bread	=	get_active_theme_vars( 'breadcrumbs' );
		$config			=	get_active_theme_vars( 'breadcrumbs_setup' );
		echo '<' . $config['container'] . ' class="' . $config['container_class'] . '" id="'. $config['container_id'] . '" >';
			echo $config[ 'text_before_bread' ];
			echo '<' . $config['wrapper'] . ' class="' . $config['wrapper_class'] . '" id="'. $config['wrapper_id'] . '" >';
				for( $i = 0; $i < count( $saved_bread ) ; $i++ )
				{
					if( isset( $saved_bread[$i + 1 ] ) )
					{
						echo '<li>';
							echo '<a href="'. $saved_bread[$i][ 'link' ] .'">' . word_limiter( $saved_bread[$i][ 'text' ] , $config[ 'word_limiter' ] ) . '</a>';
						echo '</li>';
						if( $config[ 'divider' ] !== false )
						{
							echo '<li>'.$config[ 'divider' ].'</li>';
						}
					}
					else
					{
						echo '<li>';
							echo '<a href="'. $saved_bread[$i][ 'link' ] .'">' . word_limiter( $saved_bread[$i][ 'text' ] , $config[ 'word_limiter' ] ) . '</a>';
						echo '</li>';
					}
				}
			echo '</'. $config['wrapper'] . '>';
		echo '</'. $config['container'] . '>';
	};
	/**
	*	declare_item() : pour l'enregistrement des items
	**/
	function declare_item( $namespace , $config , $callback  = false){
		$saved_item					=	get_active_theme_vars( 'theme_items' ) ? get_active_theme_vars( 'theme_items' ) : array();

		$final[ 'has_loop' ]				=	return_if_array_key_exists( 'has_loop' , $config );
		$final[ 'before_loop' ]				=	return_if_array_key_exists( 'before_loop' , $config );
		$final[ 'after_loop' ]				=	return_if_array_key_exists( 'after_loop' , $config );
		$final[ 'the_loop_item' ]			=	return_if_array_key_exists( 'the_loop_item' , $config );
		$final[ 'draggable' ]				=	return_if_array_key_exists( 'draggable' , $config );
		$final[ 'description' ]				=	return_if_array_key_exists( 'description' , $config );
		$final[ 'human_name' ]				=	return_if_array_key_exists( 'human_name' , $config );
		$final[ 'namespace'	]				=	$namespace;
		$final[ 'callback' ]				=	$callback;
		$final[ 'is_static' ]				=	return_if_array_key_exists( 'is_static' , $config );
		$final[ 'item_loopable_fields' ]	=	return_if_array_key_exists( 'item_loopable_fields' , $config );
		$final[ 'item_global_fields' ]		=	return_if_array_key_exists( 'item_global_fields' , $config );
		
		$saved_item[ $namespace ]	=	$final;		
		
		return set_active_theme_vars( "theme_items" , $saved_item );
	}
	/**
	*	set_item
	**/
	function set_item( $namespace , $content ){
		$saved_items	=	get_active_theme_vars( 'items_datas' ) ? get_active_theme_vars( 'items_datas' ) : array();
		
		$saved_items[ $namespace ][] 	=	$content;

		return set_active_theme_vars( "items_datas" , $saved_items );
	}
	/**
	*	get_item( 'namespace' , 'associated_items' );
	*	events : set_items_vars
	**/
	function get_items( $namespace ){
		$saved_items	=	get_active_theme_vars( 'theme_items' );
		$style			=	return_if_array_key_exists( $namespace , $saved_items );
		if( $style ){
			
			$has_loop		=	return_if_array_key_exists( 'has_loop' , $style );
			$before_loop	=	return_if_array_key_exists( 'before_loop' , $style );
			$after_loop		=	return_if_array_key_exists( 'after_loop' , $style );
			$the_loop_item	=	return_if_array_key_exists( 'the_loop_item' , $style );
			$is_static		=	return_if_array_key_exists( 'item_loopable_fields' , $style ) && return_if_array_key_exists( 'item_global_fields' , $style );
			// Si l'élément est statique
			if( $is_static ){
				// $datas		=	$style;
				$th_setting	=	get_active_theme_vars( 'theme_settings' );
				$datas		=	return_if_array_key_exists( $namespace , $th_setting );
			} 
			else 
			{
				// Recupération depuis l'API
				$global_data	=	get_active_theme_vars( "items_datas" );
				// Recupérations depuis les données renvoyés
				$datas			=	return_if_array_key_exists( $namespace , $global_data );
			}
			if( is_array( $datas ) )
			{
				if( has_events( 'handle_' . $namespace ) )
				{
					trigger_events( 'handle_' . $namespace , $datas );
				}
				else
				{
					echo $before_loop;
					if( $has_loop === true ) // Si contient une boucle
					{
						// Looping Defined Vars and set them as variables
						
							foreach( $datas as $value )
							{
								if( is_array( $value ) ){
									foreach( $value as $key => $value )
									{
										// les key sont celles sur le tableau renvoyé par l'API
										$$key	=	$value;
										// If there are events declared
										if( has_events ( 'set_'.$namespace.'_items_vars' ) )
										{
											$$key	=	trigger_events( 'set_'.$namespace.'_items_vars' , array( $key , $value ) );
											// if triggered events return null, we don't consider events
											if( $$key == null )
											{
												$$key	=	$value;
											}
										}							
									}
								}
								// Looping the_loop_item as set on declare_items
								if( is_array( $the_loop_item ) )
								{
									foreach( $the_loop_item as $lines )
									{
										if( has_events( 'loop_'.$namespace.'_lines' ) )
										{
											$result	=	trigger_events( 'loop_'.$namespace.'_lines' , array( $lines ) );
											$lines	=	$result == null ? $lines : $result;
										}
										if(substr($lines,0,1) == "[" && substr($lines, -1) == "]")
										{
											$var	=	substr($lines,1,-1);
											echo isset( $$var ) ? $$var : $lines;
										}
										else
										{
											echo $lines;
										}
									}
								}
							}
					}
					echo $after_loop;
				}
			}
		}
	}
	/**
	*	get_static_items() : return available static items, as they are defined.
	**/
	function get_static_items(){
		return get_active_theme_vars( 'theme_sItems' );
	};
	/**
	*	form_exists( '' ) : verifie si un formulaire à été déclaré
	**/
	function form_dom_exists( $form_namespace ){
		return get_active_theme_vars( $form_namespace . '_dom' );
	}
	/**
	*	set_contact_page
	**/
	function set_contact_page( $datas ){
		$final[ 'address_title' ]		=	return_if_array_key_exists( 'address_title' , $datas );
		$final[ 'addresses' ]			=	return_if_array_key_exists( 'addresses' , $datas );
		$final[ 'about_us_title' ]		=	return_if_array_key_exists( 'about_us_title' , $datas );
		$final[ 'about_us' ]			=	return_if_array_key_exists( 'about_us' , $datas );
		$final[ 'form_title' ]			=	return_if_array_key_exists( 'form_title' , $datas );
		$final[ 'form_description' ]	=	return_if_array_key_exists( 'form_description' , $datas );
		$final[ 'map_code' ]			=	return_if_array_key_exists( 'map_code' , $datas );
		return set_active_theme_vars( 'contact_form_page' , $final );
	}
	function get_contact_page( $specific_key = null ){
		$contact_form_page				= 	get_active_theme_vars( 'contact_form_page' );
		if( $specific_key != null ){
			return return_if_array_key_exists( $specific_key , $contact_form_page );
		}
		return $contact_form_page;
	}