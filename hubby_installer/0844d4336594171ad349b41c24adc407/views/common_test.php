<?php
		/*$theme->defineContactAddress('Notre contact', 'utilisez ces num&eacute;ros pour nous contacter');
		$theme->defineContactContent('besoin d\'aide ? contactez nous');
		$theme->defineContactAddressItem('phone','3992039394');
		$theme->defineContactAddressItem('phone','2304958576');
		$theme->defineContactAddressItem('email','fakecontact@fakebox.com');
		$theme->defineContactFormHeader();
		$theme->parseContact();*/
		
		/*$theme->defineFeaturedProductTitle('Un titre');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->defineFeaturedProducts('TItre','Contenu','http://localhost/autoSlide/img/photos/1.jpg','200','#');
		$theme->parseIndex();*/
		$theme->defineCartListPanelButton('Un bouton','#');
		$theme->defineCartListPanelButton('Un bouton','#');
		$theme->defineCartListPanelButton('Un bouton','#');
		$theme->defineCartListPanelButton('Un bouton','#');
		for($i = 0;$i < 10;$i++)
		{
			$theme->defineCartListElement('Un produit','Une description lorem ipso doloe a  eoie eaeo eua eu aeu oeaia d oqinc ei rlap e dcu e ehaue ahsg eor ;dp xmqp epaoei ruty x,e hdiq e ','http://localhost/autoSlide/img/photos/1.jpg','300','#','#');
		}
		$theme->parseCartList();
		