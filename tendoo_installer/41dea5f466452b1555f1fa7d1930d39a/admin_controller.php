<?php
class tendoo_index_manager_admin_controller extends Libraries
{
	public function __construct($data)
	{
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		parent::__construct();
		__extends($this);
		$this->instance					=	get_instance();
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$this->data						=	$data;
		$this->moduleData				=&	$this->data['module'][0];
		// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		if(!$this->tendoo_admin->actionAccess('tendoo_index_manager','tendoo_index_manager'))
		{
			$this->url->redirect(array('admin','index?notice=accessDenied'));
		}
		$this->lib						=	new tendoo_index_manager_library;
		$this->data['inner_head']		=	$this->load->view('admin/inner_head',$this->data,true);
		$this->data['lmenu']			=	$this->load->view(VIEWS_DIR.'/admin/left_menu',$this->data,true,TRUE);
	}
	public function index()
	{
		$this->data['supportedELement']	=	$this->tendoo_admin->getActiveThemeSupportedItems();
		$this->data['apizedMod']		=	$this->lib->getApiModules();
		// 
		$this->load->library('form_validation');
		if($this->input->post('section1'))
		{
			$notice['error'] 		=	0;
			$notice['success'] 		=	0;
			$this->form_validation->set_rules('showCarrousel', 'Afficher le caroussel','trim|required|numeric');
			$this->form_validation->set_rules('showLastest', 'Afficher les &eacute;l&eacute;ments r&eacute;cents','trim|required|numeric');
			$this->form_validation->set_rules('showFeatured', 'Afficher les &eacute;l&eacute;ments au top','trim|required|numeric');
			$this->form_validation->set_rules('showTabShowCase', 'Affichier le dossier d\'&eacute;l&eacute;ments','trim|required|numeric');
			$this->form_validation->set_rules('showSmallDetails', 'Afficher liste d\'information textuelle','trim|required|numeric');
			$this->form_validation->set_rules('showGallery', 'Afficher gallerie d\'image','trim|required|numeric');
			$this->form_validation->set_rules('showAboutUs', '"&agrave; propos de nous"','trim|required|numeric');
			$this->form_validation->set_rules('showPartner', '"nos partenaires"','trim|required|numeric');
			if($this->form_validation->run())
			{
				$showCarroussel	=	$this->input->post('showCarrousel');
				$showAboutUs	=	$this->input->post('showAboutUs');
				$showFeatures	=	$this->input->post('showFeatured');
				$showGallery	=	$this->input->post('showGallery');
				$showLastest	=	$this->input->post('showLastest');
				$showPartners	=	$this->input->post('showPartner');
				$showSD			=	$this->input->post('showSmallDetails');
				$showTabShowCase=	$this->input->post('showTabShowCase');
				
				$exe	=	$this->lib->setFirstOptions($showCarroussel,$showAboutUs,$showFeatures,$showGallery,$showLastest,$showPartners,$showSD,$showTabShowCase);
				if($exe)
				{
					$notice['success']++;
				}
				else
				{
					$notice['error']++;
				}
			}
			else
			{
				$notice['error']++;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('carousselTitle', 'Titre Caroussel','trim|min_length[0]');
			$this->form_validation->set_rules('lastestTitle', 'Titre &eacute;l&eacute;ments r&eacute;cents','trim|min_length[0]');
			$this->form_validation->set_rules('featuredTitle', 'Titre &eacute;l&eacute;ments en avant','trim|min_length[0]');
			$this->form_validation->set_rules('tabShowCaseTitle', 'Titre dossier d\'&eacute;l&eacute;ments','trim|min_length[0]');
			$this->form_validation->set_rules('smarTitle', 'Titre Liste d\'information textuelle','trim|min_length[0]');
			$this->form_validation->set_rules('galleryTitle', 'Titre Gallerie','trim|min_length[0]');
			$this->form_validation->set_rules('aboutUsTitle', 'Titre "&agrave; propos de nous"','trim|min_length[0]');
			$this->form_validation->set_rules('partnerTitle', 'Titre "nos partenaire"','trim|min_length[0]');
			if($this->form_validation->run())
			{
				$aboutUsTitle		=	$this->input->post('aboutUsTitle');
				$partnersTitle		=	$this->input->post('partnerTitle');
				$galshowCaseTitle	=	$this->input->post('galleryTitle');
				$featuredTitle		=	$this->input->post('featuredTitle');
				$carousselTitle		=	$this->input->post('carousselTitle');
				$smallDetailsTItle	=	$this->input->post('smarTitle');
				$tabShowCaseTitle	=	$this->input->post('tabShowCaseTitle');
				$lastestTitle		=	$this->input->post('lastestTitle');
				
				$exe	=	$this->lib->setSecondOptions($aboutUsTitle,$partnersTitle,$galshowCaseTitle,$featuredTitle,$carousselTitle,$smallDetailsTItle,$tabShowCaseTitle,$lastestTitle);
				if($exe)
				{
					$notice['success']++;
				}
				else
				{
					$notice['error']++;
				}
			}
			else
			{
				$notice['error']++;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('CarousselmoduleExtension', 'Le caroussel','trim|min_length[0]');
			$this->form_validation->set_rules('LastestExtension', 'Les éléments r&eacute;cents','trim|min_length[0]');
			$this->form_validation->set_rules('FeaturedExtension', 'Les éléments au top','trim|min_length[0]');
			$this->form_validation->set_rules('TabShowCaseExtension', 'Le dossier d\'&eacute;l&eacute;ments','trim|min_length[0]');
			$this->form_validation->set_rules('SmallDetailsExtension', 'La liste d\'informations textuelles','trim|min_length[0]');
			$this->form_validation->set_rules('GalleryExtension', 'La gallerie d\'image','trim|min_length[0]');
			if($this->form_validation->run())
			{
				$onCaroussel	=	$this->input->post('CarousselmoduleExtension');
				$onFeatured		=	$this->input->post('FeaturedExtension');
				$onGallery		=	$this->input->post('GalleryExtension');
				$onLastest		=	$this->input->post('LastestExtension');
				$smallDetails	=	$this->input->post('SmallDetailsExtension');
				$onTabShowCase	=	$this->input->post('TabShowCaseExtension');
				$exec	=	$this->lib->setThridOptions($onCaroussel,$onFeatured,$onGallery,$onLastest,$smallDetails,$onTabShowCase);
				if($exe)
				{
					$notice['success']++;
				}
				else
				{
					$notice['error']++;
				}
			}
			else
			{
				$notice['error']++;
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('carousselLimit', 'Le caroussel','trim|numeric');
			$this->form_validation->set_rules('lastestLimit', 'Les éléments r&eacute;cents','trim|numeric');
			$this->form_validation->set_rules('featuredLimit', 'Les éléments au top','trim|numeric');
			$this->form_validation->set_rules('tabShowCaseLimit', 'Le dossier d\'&eacute;l&eacute;ments','trim|numeric');
			$this->form_validation->set_rules('smartLimit', 'La liste d\'information textuelle','trim|numeric');
			$this->form_validation->set_rules('galleryLimit', 'La gallerie d\'image','trim|numeric');
			if($this->form_validation->run())
			{
				$carousselLimit				=		$this->input->post('carousselLimit');
				$lastestLimit				=		$this->input->post('lastestLimit');
				$featuredLimit				=		$this->input->post('featuredLimit');
				$galleryLimit				=		$this->input->post('galleryLimit');
				$tabShowCaseLimit			=		$this->input->post('tabShowCaseLimit');
				$smallDetailsLimit			=		$this->input->post('smartLimit');
				
				$exe	=	$this->lib->setFiftOptions($carousselLimit,$featuredLimit,$lastestLimit,$galleryLimit,$tabShowCaseLimit,$smallDetailsLimit);
				if($exe)
				{
					$notice['success']++;
				}
				else
				{
					$notice['error']++;
				}
			}
			else
			{
				$notice['error']++;
			}
			notice('push',tendoo_info($notice['success'].' élément(s) enregistré(s), '.$notice['error'].' erreur(s)'));
		}
		
		if($this->input->post('section5'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('aboutUsContent', '&agrave; propos de nous','trim');
			if($this->form_validation->run())
			{
				if($this->lib->setQuadOptions($_POST['aboutUsContent']))
				{
					notice('push',fetch_error('done'));
				}
				else
				{
					notice('push',fetch_error('error_occured'));
				}
			}
		}
		
		if($this->input->post('section6'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('ourPartner', 'Nos partenaires','trim|required');
			if($this->form_validation->run())
			{
				if($this->lib->setSixOptions($this->input->post('ourPartner')))
				{
					notice('push',fetch_error('done'));
				}
				else
				{
					notice('push',fetch_error('error_occured'));
				}
			}
		}
		$this->data['lib_options']		=	$this->lib->getOptions();
		set_page('title','tendoo Index Manager');
		$this->instance->visual_editor->loadEditor(1);
		
		return $this->data['body']		=	$this->load->view(MODULES_DIR.$this->data['module'][0]['ENCRYPTED_DIR'].'/views/main.php',$this->data,TRUE,TRUE,$this);
	}
}
