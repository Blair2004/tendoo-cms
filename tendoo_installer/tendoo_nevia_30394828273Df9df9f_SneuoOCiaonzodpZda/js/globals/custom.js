 /*-----------------------------------------------------------------------------------
/* Custom Scripts
-----------------------------------------------------------------------------------*/

/* ----------------- Start Document ----------------- */
(function($){
	$(document).ready(function(){

/*----------------------------------------------------*/
/*	Navigation
/*----------------------------------------------------*/

	$(".menu li").hover(
			function () {
				$(this).find('ul:first').css({
					visibility: "visible",
					display: "none"
				}).stop(true, true).fadeIn(100);
			},
			function () {
				$(this).find('ul:first').css({
					visibility: "visible",
					display: "block"
				}).stop(true, true).fadeOut(100);
			}
	);

	selectnav('responsive', {
		label: 'Menu',
		nested: true,
		indent: '&nbsp;&nbsp;&nbsp;'
	});


/*----------------------------------------------------*/
/*	Carousel
/*----------------------------------------------------*/

// Add classes for other carousels
var $carousel = $('.recent-blog-jc, .recent-work-jc');

var scrollCount;

function adjustScrollCount() {
	if( $(window).width() < 768 ) {
		scrollCount = 1;
	} else {
		scrollCount = 3;
	}

}

function adjustCarouselHeight() {

	$carousel.each(function() {
		var $this    = $(this);
		var maxHeight = -1;
		$this.find('li').each(function() {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});
		$this.height(maxHeight);
	});
}
function initCarousel() {
	adjustCarouselHeight();
	adjustScrollCount();
	var i = 0;
	var g = {};
	$carousel.each(function() {
		i++;

		var $this = $(this);
		g[i] = $this.jcarousel({
			animation           : 600,
			scroll              : scrollCount
		});
		$this.jcarousel('scroll', 0);
		 $this.prev().find('.jcarousel-prev').bind('active.jcarouselcontrol', function() {
			$(this).addClass('active');
		}).bind('inactive.jcarouselcontrol', function() {
			$(this).removeClass('active');
		}).jcarouselControl({
			target: '-='+scrollCount,
			carousel: g[i]
		});

		$this.prev().find('.jcarousel-next').bind('active.jcarouselcontrol', function() {
			$(this).addClass('active');
		}).bind('inactive.jcarouselcontrol', function() {
			$(this).removeClass('active');
		}).jcarouselControl({
			target: '+='+scrollCount,
			carousel: g[i]
		});

		$this.touchwipe({
		wipeLeft: function() {
			$this.jcarousel('scroll','+='+scrollCount);
		},
		wipeRight: function() {
			$this.jcarousel('scroll','-='+scrollCount);
		}
	});

	});
}
$(window).load(function(){
	initCarousel();
});

$(window).resize(function () {
	$carousel.each(function() {
		var $this = $(this);
		$this.jcarousel('destroy');
	});
	initCarousel();
});


/*----------------------------------------------------*/
/*	Sidebar 
/*----------------------------------------------------*/

	window.resizesidebar = function() {
		var windowwidth = $(window).width();
		if(windowwidth > 768) {
			var contheight = Math.max($(".eleven.floated").outerHeight(true));
			var sbheight = Math.max($("aside.sidebar").outerHeight(true));
			if(contheight<sbheight) {
				$('.eleven.floated').css('min-height',sbheight);
			}
		} else {
			$('div.sidebar').css('min-height','auto');
			$('.eleven.floated').css('min-height','auto');
		}
	};
	$(window).load(function() {
		window.resizesidebar();
	});
	$(window).resize(function () { window.resizesidebar(); });


/*----------------------------------------------------*/
/*	Alert Boxes
/*----------------------------------------------------*/

	$(document.body).pixusNotifications({
		speed: 300,
		animation: 'fadeAndSlide',
		hideBoxes: false
	});


/*----------------------------------------------------*/
/*	Tabs
/*----------------------------------------------------*/

	var $tabsNav    = $('.tabs-nav'),
		$tabsNavLis = $tabsNav.children('li'),
		$tabContent = $('.tab-content');

	$tabsNav.each(function() {
		var $this = $(this);

		$this.next().children('.tab-content').stop(true,true).hide()
											 .first().show();

		$this.children('li').first().addClass('active').stop(true,true).show();
	});

	$tabsNavLis.on('click', function(e) {
		var $this = $(this);

		$this.siblings().removeClass('active').end()
			 .addClass('active');

		$this.parent().next().children('.tab-content').stop(true,true).hide()
													  .siblings( $this.find('a').attr('href') ).fadeIn();

		e.preventDefault();
	});


/*----------------------------------------------------*/
/*	Accordion
/*----------------------------------------------------*/

	var $accor = $('.accordion');

	$accor.each(function() {
		$(this).addClass('ui-accordion ui-widget ui-helper-reset');
		$(this).find('h3').addClass('ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all');
		$(this).find('div').addClass('ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom');
		$(this).find("div").hide().first().show();
		$(this).find("h3").first().removeClass('ui-accordion-header-active ui-state-active ui-corner-top').addClass('ui-accordion-header-active ui-state-active ui-corner-top');
		$(this).find("span").first().addClass('ui-accordion-icon-active');
	});

	$trigger = $accor.find('h3');

	$trigger.on('click', function(e) {
		var location = $(this).parent();

	   if( $(this).next().is(':hidden') ) {
			$triggerloc = $('h3',location);
			$triggerloc.removeClass('ui-accordion-header-active ui-state-active ui-corner-top').next().slideUp(300);
			$triggerloc.find('span').removeClass('ui-accordion-icon-active');
			$(this).find('span').addClass('ui-accordion-icon-active');
			$(this).addClass('ui-accordion-header-active ui-state-active ui-corner-top').next().slideDown(300);
		}
		e.preventDefault();
	});


/*----------------------------------------------------*/
/*	Toggle
/*----------------------------------------------------*/

	$(".toggle-container").hide();
	$(".trigger").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});
	$(".trigger").click(function(){
		$(this).next(".toggle-container").slideToggle();
	});

	$(".trigger.opened").toggle(function(){
		$(this).removeClass("active");
		}, function () {
		$(this).addClass("active");
	});

	$(".trigger.opened").addClass("active").next(".toggle-container").show();


/*----------------------------------------------------*/
/*	Tooltip
/*----------------------------------------------------*/

 $('.container').tooltip({
      selector: "a.tooltip"
    })


/*----------------------------------------------------*/
/*	Isotope Portfolio Filter
/*----------------------------------------------------*/

	$(window).load(function(){
		$('#portfolio-wrapper').isotope({
			  itemSelector : '.isotope-item',
				layoutMode : 'fitRows'
		});
		$('#filters a.selected').trigger("click");
	});
	$('#filters a').click(function(e){
		e.preventDefault();

		var selector = $(this).attr('data-option-value');
		$('#portfolio-wrapper').isotope({ filter: selector });

		$(this).parents('ul').find('a').removeClass('selected');
		$(this).addClass('selected');
	});


/*----------------------------------------------------*/
/*	Skill Bar Animation
/*----------------------------------------------------*/

		setTimeout(function(){

		$('.skill-bar .skill-bar-content').each(function() {
			var me = $(this);
			var perc = me.attr("data-percentage");

			var current_perc = 0;

			var progress = setInterval(function() {
				if (current_perc>=perc) {
					clearInterval(progress);
				} else {
					current_perc +=1;
					me.css('width', (current_perc)+'%');
				}

				me.text((current_perc)+'%');

			}, 10);

		});

	},10);


/*----------------------------------------------------*/
/*	Fancybox2
/*----------------------------------------------------*/

	$('[rel=fancybox]').fancybox({
		type        : 'image',
		openEffect  : 'elastic',
		closeEffect	: 'elastic',
		nextEffect  : 'elastic',
		prevEffect  : 'elastic',
		helpers : {
			title : {
				type : 'inside'
			},
			overlay : {
				css : {
					'background' : 'rgba(0, 0, 0, 0.85)'
				}
			}
		}
	});

	$('[rel=fancybox-gallery]').fancybox({
		openEffect  : 'elastic',
		closeEffect	: 'elastic',
		nextEffect  : 'elastic',
		prevEffect  : 'elastic',

		helpers : {
			title : {
				type : 'inside'
			},
			buttons	: {},
			overlay : {
				css : {
					'background' : 'rgba(0, 0, 0, 0.85)'
				}
			}
		},

	});


/*----------------------------------------------------*/
/*	Layer Slider
/*----------------------------------------------------*/

	$('#layerslider').layerSlider({
		skin : 'fullwidth',
		hoverPrevNext 			: true,
		navStartStop 			: false,
		navButtons				: false,
		autoPlayVideos			: false,
		animateFirstLayer		: false

	});


/*----------------------------------------------------*/
/*	FlexSlider
/*----------------------------------------------------*/
	$(window).load(function() {
	  $('.flexslider').flexslider({
		animation: "fade",              //String: Select your animation type, "fade" or "slide"
		slideshow: true,                // Animate slider automatically
		slideshowSpeed: 7000,           // Set the speed of the slideshow cycling, in milliseconds
		animationSpeed: 400             // Set the speed of animations, in milliseconds
	  });
	});


/*----------------------------------------------------*/
/*	Portfolio Filters
/*----------------------------------------------------*/

	function DropDown(el) {
		this.dd = el;
		this.opts = this.dd.find('ul.option-set > li');
		this.placeholder = this.dd.children('span');
		this.val = [];
		this.index = [];
		this.initEvents();
	}

	DropDown.prototype = {
		initEvents : function() {
			var obj = this;

			obj.dd.on('click', function(event){
				$(this).toggleClass('active');
				event.stopPropagation();
			});
		obj.opts.on('click',function(){
				var opt = $(this);
				obj.val = opt.text();
				obj.index = opt.index();
				obj.placeholder.text('' + obj.val);
			});
		}
	}

	$(function() {

		var dd = new DropDown( $('#filters') );

		$(document).click(function() {
			$('.filters-dropdown').removeClass('active');
		});

		$(".option-set").click(function() {
			$('.filters-dropdown').toggleClass('active');
		});

	});


/* ------------------ End Document ------------------ */
});

})(this.jQuery);



(function()
{
	$.fn.pixusNotifications = function(options)
	{
		var defaults = {
			speed: 200,
			animation: 'fade',
			hideBoxes: false
		};

		var options = $.extend({}, defaults, options);

		return this.each(function()
		{
			var wrapper = $(this),
				notification = wrapper.find('.notification'),
				content = notification.find('p'),
				title = content.find('strong'),
				closeBtn = $('<a class="close" href="#"><i class="icon-remove"></i></a>');

			$(document.body).find('.notification').each(function(i)
			{
				var i = i+1;
				$(this).attr('id', 'notification_'+i);
			});

			notification.filter('.closeable').append(closeBtn);

			closeButton = notification.find('> .close');

			closeButton.click(function()
			{
				hideIt( $(this).parent() );
				return false;
			});

			function hideIt(object)
			{
				switch(options.animation)
				{
					case 'fade': fadeIt(object);     break;
					case 'slide': slideIt(object);     break;
					case 'box': boxAnimIt(object);     break;
					case 'fadeAndSlide': fadeItSlideIt(object);     break;
					default: fadeItSlideIt(object);
				}
			};

			function fadeIt(object)
			{	object
				.fadeOut(options.speed);
			}
			function slideIt(object)
			{	object
				.slideUp(options.speed);
			}
			function fadeItSlideIt(object)
			{	object
				.fadeTo(options.speed, 0, function() { slideIt(object) } );
			}
			function boxAnimIt(object)
			{	object
				.hide(options.speed);
			}

			if (options.hideBoxes){}

			else if (! options.hideBoxes)
			{
				notification.css({'display': 'block', 'visiblity': 'visible'});
			}

		});
	};
})();


/**
 * jQuery Plugin to obtain touch gestures from iPhone, iPod Touch, iPad, and Android mobile phones
 * Common usage: wipe images (left and right to show the previous or next image)
 *
 * @author Andreas Waltl, netCU Internetagentur (http://www.netcu.de)
 */
(function($){$.fn.touchwipe=function(settings){var config={min_move_x:20,min_move_y:20,wipeLeft:function(){},wipeRight:function(){},wipeUp:function(){},wipeDown:function(){},preventDefaultEvents:true};if(settings)$.extend(config,settings);this.each(function(){var startX;var startY;var isMoving=false;function cancelTouch(){this.removeEventListener('touchmove',onTouchMove);startX=null;isMoving=false}function onTouchMove(e){if(config.preventDefaultEvents){e.preventDefault()}if(isMoving){var x=e.touches[0].pageX;var y=e.touches[0].pageY;var dx=startX-x;var dy=startY-y;if(Math.abs(dx)>=config.min_move_x){cancelTouch();if(dx>0){config.wipeLeft()}else{config.wipeRight()}}else if(Math.abs(dy)>=config.min_move_y){cancelTouch();if(dy>0){config.wipeDown()}else{config.wipeUp()}}}}function onTouchStart(e){if(e.touches.length==1){startX=e.touches[0].pageX;startY=e.touches[0].pageY;isMoving=true;this.addEventListener('touchmove',onTouchMove,false)}}if('ontouchstart'in document.documentElement){this.addEventListener('touchstart',onTouchStart,false)}});return this}})(jQuery);


/* ===========================================================
 * bootstrap-tooltip.js v2.0.4
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function(b){var a=function(d,c){this.init("tooltip",d,c)};a.prototype={constructor:a,init:function(f,e,d){var g,c;this.type=f;this.$element=b(e);this.options=this.getOptions(d);this.enabled=true;if(this.options.trigger!="manual"){g=this.options.trigger=="hover"?"mouseenter":"focus";c=this.options.trigger=="hover"?"mouseleave":"blur";this.$element.on(g,this.options.selector,b.proxy(this.enter,this));this.$element.on(c,this.options.selector,b.proxy(this.leave,this))}this.options.selector?(this._options=b.extend({},this.options,{trigger:"manual",selector:""})):this.fixTitle()},getOptions:function(c){c=b.extend({},b.fn[this.type].defaults,c,this.$element.data());if(c.delay&&typeof c.delay=="number"){c.delay={show:c.delay,hide:c.delay}}return c},enter:function(d){var c=b(d.currentTarget)[this.type](this._options).data(this.type);if(!c.options.delay||!c.options.delay.show){c.show()}else{c.hoverState="in";setTimeout(function(){if(c.hoverState=="in"){c.show()}},c.options.delay.show)}},leave:function(d){var c=b(d.currentTarget)[this.type](this._options).data(this.type);if(!c.options.delay||!c.options.delay.hide){c.hide()}else{c.hoverState="out";setTimeout(function(){if(c.hoverState=="out"){c.hide()}},c.options.delay.hide)}},show:function(){var g,c,i,e,h,d,f;if(this.hasContent()&&this.enabled){g=this.tip();this.setContent();if(this.options.animation){g.addClass("fade")}d=typeof this.options.placement=="function"?this.options.placement.call(this,g[0],this.$element[0]):this.options.placement;c=/in/.test(d);g.remove().css({top:0,left:0,display:"block"}).appendTo(c?this.$element:document.body);i=this.getPosition(c);e=g[0].offsetWidth;h=g[0].offsetHeight;switch(c?d.split(" ")[1]:d){case"bottom":f={top:i.top+i.height,left:i.left+i.width/2-e/2};break;case"top":f={top:i.top-h,left:i.left+i.width/2-e/2};break;case"left":f={top:i.top+i.height/2-h/2,left:i.left-e};break;case"right":f={top:i.top+i.height/2-h/2,left:i.left+i.width};break}g.css(f).addClass(d).addClass("in")}},setContent:function(){var c=this.tip();c.find(".tooltip-inner").html(this.getTitle());c.removeClass("fade in top bottom left right")},hide:function(){var c=this,d=this.tip();d.removeClass("in");function e(){var f=setTimeout(function(){d.off(b.support.transition.end).remove()},500);d.one(b.support.transition.end,function(){clearTimeout(f);d.remove()})}b.support.transition&&this.$tip.hasClass("fade")?e():d.remove()},fixTitle:function(){var c=this.$element;if(c.attr("title")||typeof(c.attr("data-original-title"))!="string"){c.attr("data-original-title",c.attr("title")||"").removeAttr("title")}},hasContent:function(){return this.getTitle()},getPosition:function(c){return b.extend({},(c?{top:0,left:0}:this.$element.offset()),{width:this.$element[0].offsetWidth,height:this.$element[0].offsetHeight})},getTitle:function(){var e,c=this.$element,d=this.options;e=c.attr("data-original-title")||(typeof d.title=="function"?d.title.call(c[0]):d.title);e=e.toString().replace(/(^\s*|\s*$)/,"");return e},tip:function(){return this.$tip=this.$tip||b(this.options.template)},validate:function(){if(!this.$element[0].parentNode){this.hide();this.$element=null;this.options=null}},enable:function(){this.enabled=true},disable:function(){this.enabled=false},toggleEnabled:function(){this.enabled=!this.enabled},toggle:function(){this[this.tip().hasClass("in")?"hide":"show"]()}};b.fn.tooltip=function(c){return this.each(function(){var f=b(this),e=f.data("tooltip"),d=typeof c=="object"&&c;if(!e){f.data("tooltip",(e=new a(this,d)))}if(typeof c=="string"){e[c]()}})};b.fn.tooltip.Constructor=a;b.fn.tooltip.defaults={animation:true,delay:0,selector:false,placement:"top",trigger:"hover",title:"",template:'<div class="ui-tooltip ui-widget ui-corner-all ui-widget-content"><div class="tooltip-arrow arrow bottom center"></div><div class="tooltip-inner"></div></div>'}}(window.jQuery);



