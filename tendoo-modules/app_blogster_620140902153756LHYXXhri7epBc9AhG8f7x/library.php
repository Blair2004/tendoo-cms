<?php
/// -------------------------------------------------------------------------------------------------------------------///
$or['categoryCreated']			=	tendoo_success('La cat&eacute;gorie &agrave; &eacute;t&eacute; correctement cr&eacute;e');
$or['categoryAldreadyCreated']	=	tendoo_error('Cette cat&eacute;gorie existe d&eacute;j&agrave;');
$or['unknowCat']				=
$or['unknowCategory']			=	tendoo_error('Cette cat&eacute;gorie est inexistante');
$or['unknowKeyWord']			=	tendoo_error('Mot-clé introuvable.');
$or['categoryUpdated']			=	tendoo_success('La mise &agrave; jour &agrave; r&eacute;ussie');
$or['categoryDeleted']			=	tendoo_success('La cat&eacute;gorie &agrave; &eacute;t&eacute; supprim&eacute; avec succ&egrave;s');
$or['artCreated']				=	tendoo_success('L\'article à correctement été crée.');
$or['categoryNotEmpty']			=	tendoo_error('Cette cat&eacute;gorie ne peut pas &ecirc;tre supprim&eacute;e, car il existe des publications qui y sont rattach&eacute;es. Changez la cat&eacute;gorie de ces publications avant de supprimer cette cat&eacute;gorie.');
$or['unknowArticle']			=	tendoo_error('Article introuvable');
$or['noCategoryCreated']		=	tendoo_error(' Avant de publier un article, vous devez cr&eacute;er une cat&eacute;gorie.');
$or['connectToComment']			=	tendoo_error(' Vous devez &ecirc;tre connect&eacute; pour commenter.');
$or['unknowComments']			=	tendoo_error(' Commentaire introuvable.');
$or['commentDeleted']			=	tendoo_success('<i class="icon-checkmark"></i> Commentaire supprim&eacute;.');
$or['submitedForApproval']		=	tendoo_success('<i class="icon-checkmark"></i> Votre commentaire &agrave; &eacute;t&eacute; soumis pour une examination.');
foreach( $or as $key => $notice_text ){
	declare_notice($key,$notice_text);
}
if(class_exists('tendoo_admin'))
{
	class blogster_library extends Libraries
	{
		private $data;
		public function __construct()
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			parent::__construct();
			__extends($this);
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$this->module	=	get_modules( 'filter_namespace' , 'blogster' );
			$this->data		=	array();
			$this->instance	=	get_instance();
			$this->user		=&	$this->users_global;
			$this->mod_repo	=	MODULES_DIR.$this->module[ 'encrypted_dir' ].'/';
			// Post les articles programmés.
			$this->postScheduledArt();
		}
		public function retreiveCat($id)
		{
			$this->db			->from('tendoo_news_category')
									->where('ID',$id);
			$query					= $this->db->get();
			$data					=	$query->result_array();
			if(count($data) == 0)
			{
				return 
				array(
					'name'		=>'Categorie Inconnu',
					'id'		=>0,
					'desc'		=>''
				);
			}
			else
			{
				return array(
					'name'		=>$data[0]['CATEGORY_NAME'],
					'id'		=>$data[0]['ID'],
					'desc'		=>$data[0]['DESCRIPTION']
				);
			}
		}
		public function datetime()
		{
			return $this->date->datetime();
		}
		public function countNews($action = 'default')
		{
			if($action == 'mines')
			{
				$this->db->where('AUTEUR',$this->users_global->current('ID'));
			}
			else if($action == 'scheduled')
			{
				$this->db->where('SCHEDULED',1);
			}
			else if( $action == 'published' ){
				$this->db->where( 'SCHEDULED' , 0 );
				$this->db->where( 'ETAT' , 1 );
			}
			else if( $action == 'draft' ){
				$this->db->where( 'ETAT' , 0 );
			}
			$query = $this->db->get('tendoo_news');
			return count($query->result_array());
		}
		public function getNews($start = NULL,$end = NULL,$scheduled_only	=	FALSE,$filter	=	'default')
		{
			$this->db		->select('*')
							->from('tendoo_news');
			if($scheduled_only == TRUE || $filter	== 'scheduled')
			{
				$this->db->where('SCHEDULED',1);
			}
			if($filter	==	'mines')
			{
				$this->db->where('AUTEUR',$this->users_global->current('ID'));
			}
			if(is_numeric($start) && is_numeric($end))
			{
							$this->db
							->order_by('DATE','desc')
							->limit($end,$start);
			}
			$query			=	$this->db->get();
			return $query->result_array();
		}
		public function getNewsKeyWords($newsid)
		{
			$this->db	
				->select('*')
				->join('tendoo_news_ref_keywords','tendoo_news_keywords.ID = tendoo_news_ref_keywords.KEYWORDS_REF_ID','right')
				->where('tendoo_news_ref_keywords.NEWS_REF_ID',$newsid);
			$query	=	$this->db->get('tendoo_news_keywords');
			return $query->result_array();
		}
		public function getKeyWords($start = NULL,$end = NULL,$filter = 'all')
		{
			if(is_numeric($start) && is_numeric($end))
			{
				$this->db->limit($end,$start);
			}
			if($filter	==	'article_keyWords')
			{
				$this->db->where('NEWS_REF_ID',$start);
			}
			if($filter	==	'keywords')
			{
				$this->db->where('ID',$start);
			}
			$query	=	$this->db->get('tendoo_news_keywords');
			return $query->result_array();
		}
		/*
			Publie un article, prend comme paramètre : 
				le titre, 
				le contenu, 
				l'etat (1,2,3,4)(publié, brouillon, programmé, en examen), 
				le lien vers l'image, 
				le lien vers l'aperçu, 
				l'identifiant de la catégorie, 
				si cet article est publié pendant l'installation de Tendoo [True/False], si oui, l'auteur sera le super administrateur, 
				les mots clés : tableau non associatif
				la date de programmation au format "dd-mm-YY", 
				le temps de programmation au format "H:i"
			Renvoi un tableau associatif contenant les informations de l'article publié.
		*/
		public function publish_news($title,$content,$state,$image,$thumb,$cat = array(),$first_admin = FALSE,$key_words= array(),$scheduledDate=FALSE,$scheduledTime=FALSE)
		{
			if($first_admin == FALSE)
			{
				$scheduled			=	0;
				// Si une date est définie comme date de publication
				if(!in_array($scheduledDate,array('',FALSE)))
				{
					// Si l'heure n'est pas précisé l'article sera publié a 00h
					$scheduledTime	=	in_array($scheduledTime,array(FALSE,'')) ? '00:00' : $scheduledTime; 
					$cur_date	=	$this->tendoo->createDateFromString('d-m-Y H:i',$scheduledDate.' '.$scheduledTime);
					$date		=	$cur_date->format('Y-m-d H:i:s');
					$state	=	3; // Pour indiquer que l'article à été programmé.
					$scheduled		=	1; // Programmé [1:TRUE]
				}
				else
				{
					$date	=	$this->date->datetime();
				}
				$content		=	array(
					'TITLE'			=> $title == false ? 'Article sans titre' : $title,
					'CONTENT'		=> $content,
					'IMAGE'			=> $image	==	false ? $this->url->img_url('Hub_back.png') : $image,
					'THUMB'			=> $thumb	==	false ? $this->url->img_url('Hub_back.png') : $thumb,
					'AUTEUR'		=> $this->user->current('ID'),
					'ETAT'			=> $state	==	false ? 2 : $state,
					'DATE'			=> $date,
					'URL_TITLE'		=> $this->instance->string->urilizeText($title,'-'),
					'SCHEDULED'		=>	$scheduled
				);
			}
			else
			{
				$content		=	array(
				'TITLE'			=> $title,
				'URL_TITLE'		=> $this->instance->string->urilizeText($title,'-'),
				'CONTENT'		=> $content,
				'IMAGE'			=> $image,
				'THUMB'			=>	$thumb,
				'AUTEUR'		=> 1,// Usefull when no admin is created to anticipate super admin creation
				'ETAT'			=> $state,
				'DATE'			=> $this->date->datetime(),
				//'CATEGORY_ID'	=> $cat
				);
				$cat			=	array(1); // Enregistrement d'une catégorie Fictive.
			}
			$this->db->insert('tendoo_news',$content);
			// Recupération de l'identifiant de cet article
			$query			=	$this->db->limit(1,0)->order_by('ID','desc')->get('tendoo_news');
			$getLastNews	=	$query->result_array(); 
			if(count($key_words) > 0 && $key_words != false) // Préparation des mots clés.
			{
				foreach($key_words as $k)
				{
					// Créer un mots clée et recupérer son identifiant.
					$kWordDatas	=	$this->createKeyWordOrGetKeyWord($k);
					$final_key_words[]	=	array(
						'NEWS_REF_ID'			=>	$getLastNews[0]['ID'],
						'KEYWORDS_REF_ID'		=>	$kWordDatas['ID']
					);
				}
			}
			else
			{
				$final_key_words	=	array();
			}
			if(count($final_key_words) > 0) // Ajout des mots clé à l'article (ajout des identifiants)
			{
				foreach($final_key_words as $f)
				{
					$this->db->insert('tendoo_news_ref_keywords',$f);
				}
			}
			// Enregistrement de plusieurs catégories
			if(is_array($cat))
			{
				foreach($cat as $c)
				{
					if($this->getSpeCat($c))
					{
						$field	=	array(
							'NEWS_REF_ID'		=>	$getLastNews[0]['ID'],
							'CATEGORY_REF_ID'	=>	$c
						);
						$this->db->insert('tendoo_news_ref_category',$field);
					}
				}
			}
			// Retourne les inforamtions de l'article récemment publié.
			return $getLastNews;
		}
		public function edit($id,$title,$content,$state,$image,$thumb,$cat = array(),$key_words	=	array(),$scheduledDate = FALSE, $scheduledTime	=	FALSE)
		{
			$scheduled			=	0;
			// Si une date est définie comme date de publication
			if(!in_array($scheduledDate,array('',FALSE)))
			{
				// Si l'heure n'est pas précisé l'article sera publié a 00h
				$scheduledTime	=	in_array($scheduledTime,array(FALSE,'')) ? '00:00' : $scheduledTime; 
				$cur_date	=	$this->tendoo->createDateFromString('d-m-Y H:i e',$scheduledDate.' '.$scheduledTime);
				$date		=	$cur_date->format('Y-m-d H:i:s');
				$state	=	3; // Pour indiquer que l'article à été programmé.
				$scheduled		=	1; // Programmé [1:TRUE]
			}
			else
			{
				$date	=	$this->date->datetime();
			}
			$content	=	array(
				'TITlE'			=> $title,
				'URL_TITLE'		=> $this->instance->string->urilizeText($title,'-'),
				'CONTENT'		=> $content,
				'ETAT'			=> $state,
				'IMAGE'			=> $image,
				'THUMB'			=>	$thumb,
				'AUTEUR'		=> $this->user->current('ID'),
				'DATE'			=> $date,
				// 'CATEGORY_ID'	=> $cat,
				'SCHEDULED'		=>	$scheduled
			);
			$final_key_words	=	array();
			if(count($key_words) > 0) // Préparation des mots clés.
			{
				if(is_array($key_words))
				{
					foreach($key_words as $k)
					{
						// Créer un mots clée et recupérer son identifiant.
						$kWordDatas	=	$this->createKeyWordOrGetKeyWord($k);
						$final_key_words[]	=	array(
							'NEWS_REF_ID'			=>	$id,
							'KEYWORDS_REF_ID'		=>	$kWordDatas['ID']
						);
					}
				}
			}
			// Reinitialisation des mots clés sinon ils seront ajoutés aux anciens
			$this->db->where('NEWS_REF_ID',$id)->delete('tendoo_news_ref_keywords');
			if(count($final_key_words) > 0) // Ajout des mots clé à l'article (ajout des identifiants)
			{
				foreach($final_key_words as $f)
				{
					$this->db->insert('tendoo_news_ref_keywords',$f);
				}
			}
			// Suppression des anciens catégories enregistrer pour éviter une accumulation des mêmes catégories.
			$this->db->where('NEWS_REF_ID',$id)->delete('tendoo_news_ref_category');
			// Enregistrement des categories
			// Enregistrement de plusieurs catégories
			if(is_array($cat))
			{
				foreach($cat as $c)
				{
					if($this->getSpeCat($c))
					{
						$field	=	array(
							'NEWS_REF_ID'	=>	$id, // identifiant de l'article en cours d'édition
							'CATEGORY_REF_ID'	=>	$c
						);
						$this->db->insert('tendoo_news_ref_category',$field);
					}
				}
			}
			// Enregistrement des informations
			$this->db->where('ID',$id);
			if($this->db->update('tendoo_news',$content))
			{
				return $this->getSpeNews($id);
			}
			return false;
		}
		public function getSpeNews($id)
		{
			$this->db	->where(array('ID'=>$id));
			$query			=	$this->db->get('tendoo_news');
			$result			=	$query->result_array();
			if(count($result) > 0)
			{
				return $result;
			}
			return false;
		}
		public function moveSpeNewsToDraft($id)
		{
			$article	=	$this->getSpeNews($id);
			if($article)
			{
				$datetime	=	$this->date->datetime();
				return $this->db	
				->where(array('ID'=>$id))
				->update('tendoo_news',array(
					'ETAT'		=>		0,
					'SCHEDULED'	=>		0,
					'DATE'		=>		$datetime
				));
			}
			return false;
		}
		public function publishSpeNews($id)
		{
			$article	=	$this->getSpeNews($id);
			if($article)
			{
				$datetime	=	$this->date->datetime();
				return $this->db	
				->where(array('ID'=>$id))
				->update('tendoo_news',array(
					'ETAT'		=>		1,
					'DATE'		=>		$datetime,
					'SCHEDULED'	=>		0
				));
			}
			return false;
		}
		public function countCat()
		{
			$query	=	$this->db->get('tendoo_news_category');
			return count($query->result_array());
		}
		/**
		*		Crée un mots clé et renvoi les informations du mot clé crée.
		**/
		public function createKeyWordOrGetKeyWord($name)
		{
			$query	=	$this->db->where('URL_TITLE',$this->instance->string->urilizeText($name,'-'))->get('tendoo_news_keywords');
			$result	=	$query->result_array();
			// Si le mots clé existe
			if(count($result) > 0)
			{
				return $result[0];
			}
			else
			{
				$exec	=	$this->db->insert('tendoo_news_keywords',array(
					'TITLE'				=>		$name,
					'URL_TITLE'			=>		$this->instance->string->urilizeText($name,'-'),
					'DESCRIPTION'		=>		'mot clé sans description'
				));
				if($exec)
				{
					return $this->createKeyWordOrGetKeyWord($name);
				}
			}
			return false;				
		}
		public function getArticlesRelatedCategory($id)
		{
			$query	=	$this->db->where('NEWS_REF_ID',$id)->get('tendoo_news_ref_category');
			$result	=	$query->result_array();
			foreach($result as &$r)
			{
				// Si la catégorie n'existe plus, supprimer l'entrée.
				if(!$this->getSpeCat($r['CATEGORY_REF_ID']))
				{
					unset($r);
				}
			}
			return $result;
		}
		public function deleteSpeNews($id)
		{
			if($this->getSpeNews($id))
			{
				$this->db->where('REF_ART',$id)->delete('tendoo_comments');
				// L'on ne supprime plus les mots clés contenu dans l'article.
				$this->db->where('NEWS_REF_ID',$id)->delete('tendoo_news_ref_category');
				$this->db->where('ID',$id)->delete('tendoo_news');
				return true;
			}
			return false;
		}
		public function createKeyWord($title,$description)
		{
			$query	=	$this->db->where('URL_TITLE',strtolower($this->instance->string->urilizeText($title,'-')))->get('tendoo_news_keywords');
			$result	=	$query->result_array();
			if(count($result) == 0)
			{
				$this->db->insert('tendoo_news_keywords',array(
					'TITLE'				=>	$title,
					'URL_TITLE'			=>	$this->instance->string->urilizeText($title,'-'),
					'DESCRIPTION'		=>	$description
				));
				return array(
					'message'	=>	'Le mot clé à correctement été crée',
					'alertType'	=>	'notice',
					'status'	=>	'success',
					'response'	=>	''
				);
			}
			return array(
				'message'	=>	'mot clé existant, veuillez choisir un autre titre',
				'alertType'	=>	'modal',
				'status'	=>	'warning',
				'response'	=>	''
			);
		}
		/*
			Recupère les catégories à partir d'un index spécifié "$start" à une limite déterminée "$end"
			ou Recupère une catégorie dont l'identifiant est fourni "$start" lorsque "$end" vaut "NULL"
				renvoie un tableau.
		*/
		public function getCat($start = null,$end = null)
		{
			if($start == null && $end == null)
			{
				$query	=	$this->db->get('tendoo_news_category');
			}
			else if($start != null && $end == null)
			{
				$query	=	$this->db->where('ID',$start)->get('tendoo_news_category');
				$ar		=	$query->result_array();
				return $ar[0];
			}
			else
			{
				$query	=	$this->db->limit($end,$start)->order_by('ID','desc')->get('tendoo_news_category');
			}
			return $query->result_array();
		}
		public function getSpeCat($id)
		{
			$query	=	$this->db->where('ID',$id)->get('tendoo_news_category');
			$ar		=	$query->result_array();
			if(count($ar) == 0)
			{
				return array('CATEGORY_NAME'=>'Cat&eacute;gorie inconnue');
			}
			return $ar[0];
		}
		/*
			crée une catégorie avec un nom "$name" et une description "$description"
				renvoie une chaine de caractère soit : categoryCreated lorsque l'opération réussi, soit : categoryAldreadyCreated.
		*/
		public function createCat($name,$description)
		{
			$query  = $this->db->where('URL_TITLE',$this->instance->string->urilizeText($name,'-'))->get('tendoo_news_category');
			if(count($query->result_array()) == 0)
			{
				$array	=	array(
					'CATEGORY_NAME'	=>$name,
					'URL_TITLE'		=>$this->instance->string->urilizeText($name,'-'),
					'DESCRIPTION'	=>$description,
					'DATE'			=>$this->date->datetime()
				);
				$this->db->insert('tendoo_news_category',$array);
				// Recupération des identifiants de la nouvelle catégorie
				$query  = $this->db->where('CATEGORY_NAME',$name)->get('tendoo_news_category');
				return $query->result_array();
			}
			return false;
		}
		/*
			Modifie une catégorie dont l'identifiant est déterminé avec le paramètre "$id", et remplace le nom "$name" et la description de la catégorie "$description".
		*/
		public function editCat($id,$name,$description)
		{
			$query  = $this->db->where('ID',$id)->get('tendoo_news_category');
			if(count($query->result_array()) > 0)
			{
				$array	=	array(
					'CATEGORY_NAME'	=>$name,
					'URL_TITLE'		=>$this->instance->string->urilizeText($name,'-'),
					'DESCRIPTION'	=>$description,
					'DATE'			=>$this->date->datetime()
				);
				$this->db->where('ID',$id)->update('tendoo_news_category',$array);
				return 'categoryUpdated';
			}
			return 'unknowCat';
		}
		/*
			Supprime une catégorie dont l'identifiant est déterminé.
		*/
		public function deleteCat($id)
		{
			$query	=	$this->db->select('*')
			->from('tendoo_news_ref_category')
			->join('tendoo_news_category','tendoo_news_ref_category.CATEGORY_REF_ID = tendoo_news_category.ID','inner')
			->join('tendoo_news','tendoo_news.ID = tendoo_news_ref_category.NEWS_REF_ID','inner')
			->where('tendoo_news_category.ID',$id)
			->get();
			if($query->result_array())
			{
				return 'categoryNotEmpty';
			}
			else
			{
				$this->db->where('ID',$id)->delete('tendoo_news_category');
				$this->db->where('CATEGORY_REF_ID',$id)->delete('tendoo_news_ref_category');
				return 'categoryDeleted';
			}
		}
		public function deleteBulkCat($array)
		{
			$notice['error']	=	0;
			$notice['success']	=	0;
			foreach($array as $c)
			{
				$exec	=	$this->deleteCat($c);
				if($exec	==	'categoryDeleted')
				{
					$notice['success']++;
				}
				else
				{
					$notice['error']++;
				}					
			}
			return $notice;
		}
		/*
			Renvoie une int avec le nombre de commentaires postés.
		*/
		public function countComments()
		{
			$query	=	$this->db->get('tendoo_comments');
			$result	=	$query->result_array();
			return count($result);
		}
		/*
			Recupère les commentaires à partir d'un index spécifié à une limite déterminée.
				renvoie un tableau.
		*/
		public function getComments($start	=	null,$end = null)
		{
			if(is_numeric($start) && is_numeric($end))
			{
				$this->db->limit($end,$start);
			}
			else if(is_numeric($start) && !is_numeric($end))
			{
				$this->db->where('ID',$start);
			}
			$query	=	$this->db->order_by('ID','desc')->get('tendoo_comments');
			$result	=	$query->result_array();
			return $result;
		}
		public function setBlogsterSetting($validateComments,$allowPublicComments)
		{
			/* 
			/*	1 : TRUE; 0 : FALSE
			*/
			$query	=	$this->db->get('tendoo_news_setting');
			$result	=	$query->result_array();
			if(count($result) > 0)
			{
				if($allowPublicComments)
				{
					$APC	=	1;
				}
				else
				{
					$APC	=	0;
				}
				if($validateComments)
				{
					$VC		=	1;
				}
				else
				{
					$VC		=	0;
				}
				return $this->db->update('tendoo_news_setting',array(
					'EVERYONEPOST'		=>	$APC,
					'APPROVEBEFOREPOST'	=>	$VC // Vlidate comments
				));
			}
			else
			{
				if($allowPublicComments)
				{
					$APC 		=	1; // Allow pulic comments
				}
				else
				{
					$APC 		=	0; // Allow pulic comments
				}
				if($validateComments)
				{
					$VC		=	1;
				}
				else
				{
					$VC		=	0;
				}
				return $this->db->insert('tendoo_news_setting',array(
					'EVERYONEPOST'			=>		$APC,	
					'APPROVEBEFOREPOST'		=>		$VC,	
				));
			}
		}
		public function getBlogsterSetting()
		{
			$query	=	$this->db->get('tendoo_news_setting');
			$result	=	$query->result_array();
			if(!$result)
			{
				return 	array(
					'EVERYONEPOST'				=>	1,
					'APPROVEBEFOREPOST'			=>	1
				);
			}
			return array_key_exists(0,$result) ? $result[0] : false;
		}
		public function getSpeComment($id)
		{
			$query		=	$this->db->where(array('ID'=>$id))->get('tendoo_comments');
			$result		=	$query->result_array();
			if(count($result) == 0): return false;endif; // return false if comment doesn't exist
			if($result[0]['AUTEUR'] == '0')
			{
				$result[0]['AUTEUR']	=	$result[0]['OFFLINE_AUTEUR'];
			}
			$article	=	$this->getSpeNews($result[0]['REF_ART']);
			$result[0]['ARTICLE_TITLE']	=	$article[0]['TITLE'];
			return $result[0];
		}
		public function approveComment($id)
		{
			if($comment	=	$this->getSpeComment($id)) // If comment exist
			{
				return $this->db->where('ID',$id)->update('tendoo_comments',array('SHOW'=>'1'));
			}
			return false;
		}
		public function disapproveComment($id)
		{
			if($comment	=	$this->getSpeComment($id)) // If comment exist
			{
				return $this->db->where('ID',$id)->update('tendoo_comments',array('SHOW'=>'0'));
			}
			return false;
		}
		public function deleteComment($id)
		{
			if($comment	=	$this->getSpeComment($id)) // If comment exist
			{
				return $this->db->where(array('ID'=>$id))->delete('tendoo_comments');
			}
			return false;
		}
		/*
			Publie les articles programmés.
		*/
		public function getAllPopularKeyWords($limit	=	5,$start = NULL, $end = NULL)
		{
			if(is_numeric($start) OR is_numeric($end))
			{
				if(is_numeric($start) AND !is_numeric($end))
				{
					$query		=	$this->db->where('ID',$start)->get('tendoo_news_keywords');
				}
				else
				{
					$query		=	$this->db->limit($end,$start)->get('tendoo_news_keywords');
				}
			}
			else
			{
				if($limit != 'all' && (int) is_numeric($limit))
				{
					$query		=	$this->db->limit($limit,0)->get('tendoo_news_keywords');
				}
				else
				{
					$query		=	$this->db->get('tendoo_news_keywords');
				}
			}
			$fullyUsed	=	0; // Nombre total d'utilisation de tous les mots clés.
			$finalStats	=	array(); // statistiques globales.
			foreach($query->result_array() as $q)
			{
				$tags	=	$this->db->where('KEYWORDS_REF_ID',$q['ID'])->get('tendoo_news_ref_keywords');
				$finalStats[]	=	array(
					'ID'			=>	$q['ID'],
					'TITLE'			=>	$q['TITLE'],
					'DESCRIPTION'	=>	$q['DESCRIPTION'],
					'USED'			=>	count($tags->result_array()) // nombre de fois que le mot clé est utilisé.
				);
				$fullyUsed+=count($tags); // ajout du nombre de fois que le mot clé est utilisé à la liste de mots clé utilisé
			}
			// Création de statistique
			foreach($finalStats as &$stats)
			{
				$stats['PERCENT']	=	($stats['USED'] / $fullyUsed) * 100;
			}	
			return $finalStats;			
		}
		public function deleteKeyWords($id)
		{
			$query	=	$this->db->where('ID',$id)->get('tendoo_news_keywords');
			$result	=	$query->result_array();
			$notice['success']	=	0;
			if($result)
			{
				foreach($result as $ref_kw)
				{
					// Comptabilisation des référents
					// Suppréssion de l'utilisation des mots clés dans tous les articles
					$_query		=	$this->db->where('KEYWORDS_REF_ID',$ref_kw['ID'])->get('tendoo_news_ref_keywords');
					$notice['success']	=	count($_query->result_array());
					$this->db->where('KEYWORDS_REF_ID',$ref_kw['ID'])->delete('tendoo_news_ref_keywords');
				}
				if($this->db->where('ID',$result[0]['ID'])->delete('tendoo_news_keywords'))
				{
					return array(
						'status'	=>	'success',
						'alertType'	=>	'notice',
						'message'	=>	'Le mot clé à correctement été supprimé. '.$notice['success'].' référent(s) a/ont été supprimé.',
						'response'	=>	''
					);
				}
				return array(
					'status'	=>	'warning',
					'alertType'	=>	'modal',
					'message'	=>	'Une erreur s\'est produite durant la supprésion du mot clé, celui-ci est peut être inexistant. '.$notice['success'].' référent(s) a/ont été supprimé.',
					'response'	=>	''
				);
			}
			return array(
				'status'	=>	'warning',
				'alertType'	=>	'modal',
				'message'	=>	'Mot-clé introuvable, la supprésion à échouée.',
				'response'	=>	''
			);
		}
		public function postScheduledArt()
		{
			$news	=	$this->getNews(null,null,TRUE);
			if($news)
			{
				$currentTime	=	strtotime($this->date->datetime());
				foreach($news as $n)
				{
					$postTime	=	strtotime($n['DATE']);
					if($currentTime > $postTime)
					{
						$this->db->where('ID',$n['ID'])
							->update('tendoo_news',array(
								'SCHEDULED'	=>	0,
								'ETAT'		=>	1
							));
					}
				}
				return true;
			}
			return false;
		}
		public function export()
		{
			$categories			=	$this->getCat();
			$articles			=	$this->getNews();
			$comments			=	$this->getComments();
			$articles_keyWords	=	$this->getKeyWords();
			// Creating Categories
			$fullArray			=	array();
			$fullArray['CATEGORY']	=	$categories;
			$fullArray['ARTICLES']	=	$articles;
			$fullArray['KEYWORDS']	=	$articles_keyWords;
			$fullArray['COMMENTS']	=	$comments;
			
			return json_encode($fullArray,JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);
		}
		public function doImport($fullArray)
		{
			if(count($fullArray) > 0)
			{
				$status		=	array();
				$status['success']	=	0;
				$status['error']	=	0;
				foreach($fullArray as $key	=>	$value)
				{
					if(in_array($key,array('ARTICLES','CATEGORY','KEYWORDS','COMMENTS')))
					{
						switch($key)
						{
							case "ARTICLES" :
							$table	=	"tendoo_news";
							break;
							case "CATEGORY"	:	
							$table	=	"tendoo_news_category";
							break;
							case "KEYWORDS" :
							$table	=	"tendoo_news_keywords";
							break;
							case "COMMENTS"	:
							$table	=	"tendoo_comments";
							break;
						}
						// Removing all Articles
						$this->db->empty_table($table);
						// Loading Articles
						foreach($value as $inputs)
						{
							if($this->db->insert($table,$inputs))
							{
								$status['success']++;
							}
							else 
							{
								$status['error'];
							}
						}							
					}
				}
				return $status;
			}
			return false;
		}
	}
}
if(class_exists('tendoo'))
{
	class News_smart
	{
		private $data;
		public function __construct($data	=	array())
		{
			__extends($this);
			$this->data		=&	$data;
			$this->users	=&	$this->users_global;
			// Post ScheduledArt()
			$this->postScheduledArt();
		}
		public function getCatForWidgets($start = null, $end = null)
		{
			if(is_numeric($start) && is_numeric($end))
			{
				// SELECTIONNE LES CATEGORIES PAR ORDRE décroissant D'article publié dans la catégorie
				$query	=	$this->db
				->select('*, tendoo_news_category.ID as CAT_ID, 
				(SELECT COUNT(*) FROM `'.DB_ROOT.'tendoo_news_ref_category` WHERE CATEGORY_REF_ID	=	CAT_ID) as TOTAL_ARTICLES')
				->from('tendoo_news_category')
				->order_by('TOTAL_ARTICLES','desc')
				->limit($end,$start)
				->get();
				return $query->result_array();
			}
			return false;
		}
		public function getCat($start = null,$end = null)
		{
			if($start == null && $end == null)
			{
				$query	=	$this->db->get('tendoo_news_category');
			}
			else if(is_numeric($start) && !is_numeric($end))
			{
				$query	=	$this->db->where('ID',$start)->get('tendoo_news_category');
				$ar		=	$query->result_array();
				if($ar)
				{
					return $ar[0];
				}
				return false;
			}
			else
			{
				$query	=	$this->db->limit($end,$start)->order_by('ID','desc')->get('tendoo_news_category');
			}
			return $query->result_array();
		}
		public function retreiveCat($id)
		{
			$this->db				->from('tendoo_news_category')
									->where('ID',$id);
			$query					= $this->db->get();
			$data					=	$query->result_array();
			if(count($data) == 0)
			{
				return 
				array(
					'name'		=>'Categorie Inconnu',
					'url'		=>'#',
					'desc'		=>''
				);
			}
			else
			{
				return array(
					'name'		=>$data[0]['CATEGORY_NAME'],
					'url'		=>$this->url->site_url($this->url->controller()).'/category/'.$this->instance->string->urilizeText($data[0]['CATEGORY_NAME']).'/'.$id,
					'desc'		=>$data[0]['DESCRIPTION']
				);
			}
		}
		public function getNews($start = NULL,$end = NULL,$showScheduled	=	FALSE)
		{
			$this->db->from('tendoo_news');					
			if($showScheduled	==	TRUE)
			{
				$this->db->where('SCHEDULED',1)->where('ETAT',3);
			}
			else
			{
				$this->db->where('ETAT',1);
			}
			if(is_numeric($start) && is_numeric($end))
			{
				$this->db
					->order_by('DATE','desc')
					->limit($end,$start);
			}
			$query 					= $this->db->get();
			return $query->result_array();
		}
		public function countNews()
		{
			$this->db			->where(array('ETAT'=>1));
			$query = $this->db	->get('tendoo_news');
			return count($query->result_array());
		}
		public function getSpeNews($element,$showAsAdmin	=	FALSE,$filter = 'filter_url_title')
		{
			if($showAsAdmin)
			{
				if($filter == 'filter_url_title')
				{
					$this->db	->where(array('URL_TITLE'=>$element));
				}
				else if($filter == 'filter_id')
				{
					$this->db	->where(array('ID'=>$element));
				}
			}
			else
			{
				if($filter == 'filter_url_title')
				{
					$this->db	->where(array('URL_TITLE'=>$element));
				}
				else if($filter == 'filter_id')
				{
					$this->db	->where(array('ID'=>$element));
				}
			}
			$query			=	$this->db->get('tendoo_news');
			$result			=	$query->result_array();
			if($result)
			{
				return $result;
			}
			return false;
		}
		public function countComments($id)
		{
			$option			=	$this->getBlogsterSetting();
			if($option['APPROVEBEFOREPOST'] == 1) // Get only approuved comments
			{
				$this->db->where('SHOW',1);
			}
			$this->db			->where(array('REF_ART'=>$id));
			$query = $this->db	->get('tendoo_comments');
			return count($query->result_array());
		}
		public function getComments($id,$start,$end,$order = "asc")
		{
			if($id != FALSE)
			{
				$option			=	$this->getBlogsterSetting();
				if($option['APPROVEBEFOREPOST'] == 1) // Get only approuved comments
				{
					$this->db->where('SHOW',1);
				}
				$this->db			->where(array('REF_ART'=>$id));
			}
			if(is_numeric((int)$start) && is_numeric((int)$end))
			{
				$this->db->limit($end,$start);
			}
			$query = $this->db->order_by('ID',$order)->get('tendoo_comments');
			return $query->result_array();
			
		}
		public function postComment($id,$content,$auteur,$email,$interface	=	'public',$user_id	=	1)
		{
			if($interface == 'public')
			{
				if(!$this->users->isConnected())
				{
					$user_id 			=	'0';
				}
				else
				{
					$user_id 			=	$this->users->current('ID');
					$auteur				=	'';
					$email				=	$this->users->current('EMAIL');
				}
				$option			=	$this->getBlogsterSetting();

				$autoApprove	= (int)$option['APPROVEBEFOREPOST'] == 1 ? 	0 : 1;
				
				$comment					=	array(
					'REF_ART'				=> 	$id,
					'CONTENT'				=> 	$content,
					'AUTEUR'				=> 	$user_id,
					'OFFLINE_AUTEUR'		=>	$auteur,
					'OFFLINE_AUTEUR_EMAIL'	=>	$email,
					'DATE'					=> 	$this->date->datetime(),
					'SHOW'					=>	$autoApprove
				);
				return $this->db	->insert('tendoo_comments',$comment);
			}
			else if($interface == 'system')
			{
				$user_id 					=	$user_id;
				$email						=	$email;
				//------------------------------------------------------->
				$comment					=	array(
					'REF_ART'				=> 	$id,
					'CONTENT'				=> 	$content,
					'AUTEUR'				=> 	0,
					'OFFLINE_AUTEUR'		=>	$auteur,
					'OFFLINE_AUTEUR_EMAIL'	=>	$email,
					'DATE'					=> 	$this->date->datetime(),
					'SHOW'					=>	1
				);
				//------------------------------------------------------->
				return $this->db->insert('tendoo_comments',$comment);
			}
		}
		public function countArtFromCat($catid)
		{
			$this->db			->where('ETAT',1)
									->where('CATEGORY_ID',$catid);
			$query = $this->db	->get('tendoo_news');
			return count($query->result_array());
		}
		public function getArtFromCat($catid,$start = null,$end = null)
		{
			$this->db			->where('ETAT',1)
								->where('CATEGORY_ID',$catid);
			if(is_numeric($start) && is_numeric($end))
			{
				$this->db->order_by('ID','desc')->limit($end,$start);
			}
			$query = $this->db	->get('tendoo_news');
			return $query->result_array();
		}
		public function getBlogsterSetting()
		{
			$query	=	$this->db->get('tendoo_news_setting');
			$result	=	$query->result_array();
			if(!$result)
			{
				return 	array(
					'EVERYONEPOST'				=>	1,
					'APPROVEBEFOREPOST'			=>	1
				);
			}
			return array_key_exists(0,$result) ? $result[0] : false;
		}
		public function pushView($arid)
		{
			$art	=	$this->getSpeNews($arid);
			if($art)
			{
				return $this->db->where('ID',$arid)->update('tendoo_news',array(
					'VIEWED'		=>	(int)$art[0]['VIEWED']+1
				));
			}
			return false;
		}
		public function getMostViewed($start,$end)
		{
			$this->db			->from('tendoo_news')
								->where('ETAT',1)
								->order_by('VIEWED','DESC')
								->limit($end,$start);
			$query 				= $this->db->get();
			return $query->result_array();
		}
		public function getNewsKeyWords($newsid)
		{
			$this->db->select('*')
				->from('tendoo_news_ref_keywords')
				->join('tendoo_news_keywords','tendoo_news_keywords.ID = tendoo_news_ref_keywords.KEYWORDS_REF_ID','inner')	
				->where('tendoo_news_ref_keywords.NEWS_REF_ID',$newsid);
			$query	=	$this->db->get();
			return $query->result_array();
		}
		/*
			Publie les articles programmés.
		*/
		public function postScheduledArt()
		{
			$news	=	$this->getNews(null,null,TRUE);
			if($news)
			{
				$currentTime	=	strtotime($this->date->datetime());
				foreach($news as $n)
				{
					$postTime	=	strtotime($n['DATE']);
					if($currentTime > $postTime)
					{
						$this->db->where('ID',$n['ID'])
							->update('tendoo_news',array(
								'SCHEDULED'	=>	0,
								'ETAT'		=>	1
							));
					}
				}
				return true;
			}
			return false;
		}
		/**
		*
		**/
		public function getAllPopularKeyWords($limit	=	5)
		{
			if($limit != 'all' && (int) is_numeric($limit))
			{
				$query		=	$this->db->limit($limit,0)->get('tendoo_news_keywords');
			}
			else
			{
				$query		=	$this->db->get('tendoo_news_keywords');
			}
			$fullyUsed	=	0; // Nombre total d'utilisation de tous les mots clés.
			$finalStats	=	array(); // statistiques globales.
			foreach($query->result_array() as $q)
			{
				$tags	=	$this->db->where('KEYWORDS_REF_ID',$q['ID'])->get('tendoo_news_ref_keywords');
				$finalStats[]	=	array(
					'ID'		=>	$q['ID'],
					'TITLE'		=>	$q['TITLE'],
					'USED'		=>	count($tags), // nombre de fois que le mot clé est utilisé.
					'URL_TITLE'	=>	$q['URL_TITLE']
				);
				$fullyUsed+=count($tags); // ajout du nombre de fois que le mot clé est utilisé à la liste de mots clé utilisé
			}
			// Création de statistique
			foreach($finalStats as &$stats)
			{
				$stats['PERCENT']	=	round($stats['USED'] / $fullyUsed);
			}	
			return $finalStats;			
		}
		public function getSpeCat($id)
		{
			$query	=	$this->db->where('ID',$id)->get('tendoo_news_category');
			$ar		=	$query->result_array();
			if(count($ar) == 0)
			{
				return array('CATEGORY_NAME'=>'Cat&eacute;gorie inconnue');
			}
			return $ar[0];
		}
		public function getArticlesRelatedCategory($id)
		{
			$query	=	$this->db->where('NEWS_REF_ID',$id)->get('tendoo_news_ref_category');
			$result	=	$query->result_array();
			foreach($result as &$r)
			{
				// Si la catégorie n'existe plus, supprimer l'entrée.
				$categoryDetails	=	$this->getSpeCat($r['CATEGORY_REF_ID']);
				if(!$categoryDetails)
				{
					unset($r);
				}
				else
				{
					// ajout des informations de la catégorie dans tableau des catégories de l'article.
					$r['CATEGORY_NAME']			=	$categoryDetails['CATEGORY_NAME'];
					$r['CATEGORY_ID']			=	$categoryDetails['ID'];
					$r['CATEGORY_DESCRIPTION']	=	$categoryDetails['DESCRIPTION'];
					$r['CATEGORY_CREATION_DATE']=	$categoryDetails['DATE'];
					$r['CATEGORY_URL_TITLE']	=	$categoryDetails['URL_TITLE'];
				}
			}
			return $result;
		}
		// 0.5
		public function categoryExists($element,$filter	=	'filter_id')
		{
			switch($filter)
			{
				case 'filter_id' : 
					$this->db->where('ID',$element);
				break;
				case 'filter_url_title' :
					$this->db->where('URL_TITLE',$element);
				break;
			}
			$query	=	$this->db->get('tendoo_news_category');
			$status	=	$query->result_array();
			if($status)
			{
				return $status;
			}
			return false;
		}
		public function getCategoryArticles($category_id,$start = null, $end = null)
		{
			$this->db->select('*')
				->from('tendoo_news_ref_category')
				->join('tendoo_news_category','tendoo_news_category.ID = tendoo_news_ref_category.CATEGORY_REF_ID','inner')
				->join('tendoo_news','tendoo_news.ID = tendoo_news_ref_category.NEWS_REF_ID','inner')
				->where('tendoo_news_category.ID',$category_id)
				->order_by('tendoo_news.DATE','desc');			
			if(is_numeric($start) && is_numeric($end))
			{
				$this->db->limit($end,$start);
			}
			$query	=	$this->db->get();				
			return $query->result_array();
		}
		public function keyWordExists($element,$filter = 'filter_url_title')
		{
			if($filter	==	'filter_title')
			{
				$query	=	$this->db->where('TITLE',$element)->get('tendoo_news_keywords');
			}
			else if($filter == 'filter_id')
			{
				$query	=	$this->db->where('ID',$element)->get('tendoo_news_keywords');
			}
			else if($filter == 'filter_url_title')
			{
				$query	=	$this->db->where('URL_TITLE',$element)->get('tendoo_news_keywords');
			}
			if(!$query->result_array())
			{
				return false;
			}
			return $query->result_array();
		}
		public function getKeyWordsArticles($element,$start = null,$end = null,$filter = 'filter_url_title')
		{
			$this->db->select('*')
				->from('tendoo_news_ref_keywords')
				->join('tendoo_news_keywords','tendoo_news_keywords.ID = tendoo_news_ref_keywords.KEYWORDS_REF_ID','inner')
				->join('tendoo_news','tendoo_news.ID = tendoo_news_ref_keywords.NEWS_REF_ID','inner');
			if($filter == 'filter_url_title')
			{
				$this->db->where('tendoo_news_keywords.URL_TITLE',$element);			
			}
			else if($filter == 'filter_id')
			{
				$this->db->where('tendoo_news_keywords.ID',$element);			
			}
			else if($filter == 'filter_title')
			{
				$this->db->where('tendoo_news_keywords.TITLE',$element);			
			}
			if(is_numeric($start) && is_numeric($end))
			{
				$this->db->limit($end,$start);
			}
			$this->db->order_by('tendoo_news.DATE','desc');
			$query	=	$this->db->get();				
			return $query->result_array();
		}
	}	
}