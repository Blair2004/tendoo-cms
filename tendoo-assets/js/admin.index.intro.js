// JavaScript Document
var intro;
var adminIndexIntro	=	function(){
	// AdminIndexIntro attribut sur la première balise "section" d'un vue principale
	if($('[adminIndexIntro]').length > 0)
	{
		$('[launch_visit]').bind('click',function(){
			introJs().start();
		});
	}
};
$(document).ready(function(){
	admin_intro		=	new adminIndexIntro();
});