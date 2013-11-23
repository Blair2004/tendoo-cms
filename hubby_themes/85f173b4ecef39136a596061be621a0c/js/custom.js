// Jquery with no conflict
jQuery(document).ready(function($) {

	//##########################################
	// Tweet feed
	//##########################################
	
	$("#tweets").tweet({
        count: 3,
        username: "ansimuz"
    });
    
    //##########################################
	// HOME SLIDER
	//##########################################
	
    $('.home-slider').flexslider({
    	animation: "fade",
    	controlNav: true,
    	keyboardNav: true
    });
    
   	//##########################################
	// PROJECT SLIDER
	//##########################################
	
    $('.project-slider').flexslider({
    	animation: "fade",
    	controlNav: true,
    	directionNav: false,
    	keyboardNav: true
    });

    
	//##########################################
	// Superfish
	//##########################################
	
	$("ul.sf-menu").superfish({ 
        animation: {height:'show'},   // slide-down effect without fade-in 
        delay:     200 ,              // 1.2 second delay on mouseout 
        autoArrows:  false,
        speed: 200
    });
    
    //##########################################
	// PrettyPhoto
	//##########################################
	
	$('a[data-rel]').each(function() {
	    $(this).attr('rel', $(this).data('rel'));
	});
	
	$("a[rel^='prettyPhoto']").prettyPhoto();
    

	
	//##########################################
	// SIDEBAR
	//##########################################
	
    $('#sidebar-opener').click(function(){
    	$('#sidebar-content').slideDown();
    	$('#sidebar-closer').show();
    });
    
    $('#sidebar-closer').click(function(){
    	$('#sidebar-content').slideUp();
    	$('#sidebar-closer').hide();
    });
    
    //##########################################
	// Accordion box
	//##########################################

	$('.accordion-container').hide(); 
	$('.accordion-trigger:first').addClass('active').next().show();
	$('.accordion-trigger').click(function(){
		if( $(this).next().is(':hidden') ) { 
			$('.accordion-trigger').removeClass('active').next().slideUp();
			$(this).toggleClass('active').next().slideDown();
		}
		return false;
	});
	
	//##########################################
	// Toggle box
	//##########################################
	
	$('.toggle-trigger').click(function() {
		$(this).next().toggle('slow');
		$(this).toggleClass("active");
		return false;
	}).next().hide();
	
	//##########################################
	// Tabs
	//##########################################

    $(".tabs").tabs("div.panes > div", {effect: 'fade'});
	
	//##########################################
	// Masonry
	//##########################################
	
	
	function masonryStart(){
	
		// Destroy by default
		
		


		// Featured posts
		
		var $container = $('.featured');
		
		$container.imagesLoaded(function(){
			$container.masonry({
				itemSelector: 'figure',
				isAnimated: true
			});
		});
		
		// Text posts
		
		var $container2 = $('.text-posts');
		
		$container2.imagesLoaded(function(){
			$container2.masonry({
				itemSelector: 'li'
			});
		});
		
		// Home gallery
		
		var $container3 = $('.home-gallery');
		
		$container3.imagesLoaded(function(){
			$container3.masonry({
				itemSelector: 'li'
			});
		});
	
	}
		
	//##########################################
	// Tool tips
	//##########################################
	
	
	function tooltipPosition(){
		
		$('#social-bar a').poshytip('destroy');
		 
		 if( $(window).width() >= 992){
		 	$('#social-bar a').poshytip({
		    	className: 'tip-twitter',
				showTimeout: 1,
				alignTo: 'target',
				alignY: 'center',
				alignX: 'right',
				offsetX: 5,
				allowTipHover: false
		    });
		 }else{
		 	$('#social-bar a').poshytip({
		    	className: 'tip-twitter',
				showTimeout: 1,
				alignTo: 'target',
				alignY: 'center',
				alignX: 'left',
				offsetX: 5,
				allowTipHover: false
		    });
		 }
		 
	}// ends tooltipPosition
	
   
    
    $('.form-poshytip').poshytip({
		className: 'tip-twitter',
		showOn: 'focus',
		alignTo: 'target',
		alignX: 'right',
		alignY: 'center',
		offsetX: 5
	});
	
	//##########################################
	// Scroll to top
	//##########################################
	
        
    $('#to-top').click(function(){
		$('html, body').animate({ scrollTop: 0 }, 300);
	});
	
	//##########################################
	// Resize event
	//##########################################
	
	$(window).resize(function() {
		tooltipPosition();
		masonryStart();
	}).trigger("resize");


	
		
	
	
	//##########################################
	// Mobile nav
	//##########################################

	var mobnavContainer = $("#mobile-nav");
	var mobnavTrigger = $("#nav-open");
	
	mobnavTrigger.click(function(){
		mobnavContainer.slideToggle();
	});

    
//close			
});









