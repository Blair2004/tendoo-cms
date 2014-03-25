jQuery(window).load(function() {

  jQuery('#slidebox').flexslider({
        animation: "fade",
        directionNav:true,
        controlNav:false
      });
    
  /* Navigation */

	jQuery('#submenu ul.sfmenu').superfish({ 
		delay:       500,								// 0.1 second delay on mouseout 
		animation:   { opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: true								// disable drop shadows 
	});	  
    
    jQuery('#topmenu').mobileMenu({
			prependTo:'.mobilenavi'
			});	
	
    
});


