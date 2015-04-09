<!-- Step 1 -->
<div class="content">
    <div data-stepContent >
        <div class="hero-unit">
            <div class="row">
                <div class="col-lg-7" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 style="margin:0;"><i class="fa fa-child"></i> <?php echo sprintf( __( 'Welcome on %s' ) , get('core_version') );?></h1>
                            <smaill><?php _e( 'A new way to create blogs and Web Apps easilly.' );?></small>
                            <hr class="line-dashed">
                            <p><?php _e( 'Thanks for using Tendoo to create your blog or for your webapp. Tendoo Foundation Specially give thanks to all contributors and is proud to release this new version of Tendoo CMS.' );?></p>
                            <p><?php _e( "If you're new, you can read user guides in order to know how to use each features of Tendoo. It's hightly recommended that you start by this steps before." );?></p>
                            <p><?php _e( "There is also guidse for advanced users and for developers. those guides has been simplified to ease reading." );?></p>
                            <p><?php _e( "Enough talking !!! enjoy this tour by reading what's new." );?></p>
                            <p> 
                                <a class="btn <?php echo theme_button_class();?> btn-large" href="http://tendoo-cms.readme.io"><?php _e( 'Read Beginner Tutorials' );?></a> 
                                <a data-requestType="silent" data-url="<?php echo get_instance()->url->site_url( array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" dismissmodal id="quitTour"> <?php _e( 'I got it' );?> </a> 
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center"> <i class="fa fa-gift" style="font-size:350px;dislay:compact;width:auto;margin-top:40px;"></i> </div>
            </div>
        </div>
    </div>
        <br>
    <!-- Step 2 -->
    <div data-stepContent >
        <div class="hero-unit">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <!--<div class="col-lg-4"> 
                            <img style="width:100%;" src="<?php echo get_instance()->url->img_url('Hub_back.png');?>" alt="girl"> 
                            <img style="width:100%;margin-top:10px;" src="<?php echo get_instance()->url->img_url('install_apps.jpg');?>" alt="girl"> 
                        </div>-->
                        <div class="col-lg-12">
                            <h1 style="margin:0;"><i class="fa fa-star"></i> <?php _e( 'What\'s new ?' );?></h1>
                            <smaill><?php _e( 'Current tendoo changes' );?></small>
                            <hr class="line-dashed">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4><i class="fa fa-list"></i> <?php _e( 'New menu interface' );?></h4>
                                    <p><?php _e( 'there are many changes that have been made for this release. The first and the most visible is the menu interface. Previously those menus was expanded with an aside dropdown menu. Now menu are expanded at the bottom.' );?></p>
                                    <p><?php _e( 'Session has been added to menu. This feature expand a specifc menu matching current URI request' );?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4><i class="fa fa-dashboard"></i> <?php _e( 'Unique dashboard for everything' );?></h4>
                                    <p><?php _e( 'Previous versions was using separate controller (account and admin). For this release, everything has been joined into an unique dashboard and some useless features has been disabled.
    This eases simple and fastest management of dashboard items.' );?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4><i class="fa fa-shield"></i> <?php _e( 'Role permission eased' );?></h4>
                                    <p><?php _e( 'Roles permissions and management has been simplified using new library GUI. For developers, Roles API has been separated from Core API.' );?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <h4><i class="fa fa-magic"></i> <?php _e( 'Improved API' );?></h4>
                                    <p><?php _e( 'This measure has been taken to reduce learning curve and to boost the app development.' );?></p>
                                </div>
                            </div>
                            <p> 
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
        <br>
    <!-- Step 3 -->
    <div data-stepContent >
        <div class="hero-unit">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                            <h1 style="margin:0;"><i class="fa fa-send"></i> <?php _e( 'Getting Started' );?></h1>
                            <smaill><?php _e( 'Your first steps' );?></small>
                            <hr class="line-dashed">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4><i class="fa fa-cogs"></i> <?php _e( 'Change Settings' );?></h4>
                                    <p><?php _e( 'Settings are very important for your web site. If you want to change timezone, date format, site name & description, registration access, role access, tendoo mode, everything is made there.
    You can change setting right now if you wish.' );?></p>
                                    <a class="btn <?php echo theme_button_class();?> btn-large" href="<?php echo get_instance()->url->site_url( array( 'admin' , 'settings?disable=tour' ) );?>"> <?php _e( 'Change Settings' );?> </a> 
                                </div>
                                <div class="col-lg-6">
                                    <h4><i class="fa fa-users"></i> <?php _e( 'Create users' );?></h4>
                                    <p><?php _e( 'Create users can be very useful for you if registration is explicitly disabled. It will helps you create a big administrators team, especially since roles are build for this case.
    Let start creating user and give him a specific role within your team.' );?></p>
                                    <a class="btn <?php echo theme_button_class();?> btn-large" href="<?php echo get_instance()->url->site_url( array( 'admin' , 'users' , 'create?disable=tour' ) );?>"> <?php _e( 'Create Users' );?> </a> 
                                </div>
                            </div>
                            <div class="row">
                                <hr class="line-dashed" />
                                <div class="col-lg-4">
                                    <h4><i class="fa fa-list"></i> <?php _e( 'Setup menu' );?></h4>
                                    <p><?php _e( 'Creating menu helps you to split your work into several parts. It helps also your visitors to know exactly where to find something. With this new release of Tendoo, you can create several menu with submenu. Those menu will been displayed as default theme menu.
    We\'re working on a new feature : unlimited menus for themes.' );?></p>
                                    <a class="btn <?php echo theme_button_class();?> btn-large" href="<?php echo get_instance()->url->site_url( array( 'admin' , 'controllers?disable=tour' ) );?>"> <?php _e( 'Create Menus' );?> </a> 
                                </div>
                                <div class="col-lg-4">
                                    <h4><i class="fa fa-pencil"></i> <?php _e( 'Start writing' );?></h4>
                                    <p><?php _e( 'When you\'re done with all first steps, you can now start writing posts. Tendoo uses Blogster as posts module. It has been updated for this 1.4 release, enjoy it !!!' );?></p>
                                    <a class="btn <?php echo theme_button_class();?> btn-large" href="<?php echo get_instance()->url->site_url( array( 'admin' , 'open' , 'modules' , 'blogster' , 'publish?disable=tour' ) );?>"> <?php _e( 'Write a new post' );?> </a> 
                                </div>
                                <div class="col-lg-4">
                                    <h4><i class="fa fa-file"></i> <?php _e( 'Create static page' );?></h4>
                                    <p><?php _e( 'unlike posts, pages aren\'t structured. They usually used for Home Page or for other items such as contact page, portfolio, landing page, forum, etc. Page features are extended with shortcode (like posts also). You can install specific module with shortcodes features.' );?></p>
                                    <a class="btn <?php echo theme_button_class();?> btn-large" href="<?php echo get_instance()->url->site_url( array( 'admin' , 'open' , 'modules' , 'pages_editor' , 'create?disable=tour' ) );?>"> <?php _e( 'Create a new page' );?> </a> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <hr class="line-dashed" />	
                                    <p> 
                                <a data-requestType="silent" data-url="<?php echo get_instance()->url->site_url( array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" dismissmodal id="quitTour"> <?php _e( 'I got it' );?> </a> 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4"> <i class="fa fa-graduation-cap" style="font-size:300px"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- Step 4 -->
    <div data-stepContent >
        <div class="hero-unit">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8" style="background: linear-gradient(120deg, #FFFFFF 50%,rgba(255,255,255,0) 80%)">
                            <h1 style="margin:0;"><i class="fa fa-bug"></i> <?php _e( 'About contribution' );?></h1>
                            <smaill><?php _e( 'So you want to get involved ?' );?></small>
                            <hr class="line-dashed">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><?php _e( 'Two main contributions are feasible. Testers contribution or Developers contribution. 
    Tester Contribution is very simple. After this tour, while using tendoo, if something wrong, you can report it as issue on github.
    Developers contribution is also simple, just clone tendoo cms repository and submit pull-requests.
    Everything is done through Github where tendoo is hosted. We\'re waiting four your contribution to help tendoo be the best tools for creating web apps and websites.' );?>
                                </p></div>
                                <div class="col-lg-6">
                                    <h4><i class="fa fa-eye"></i> <?php _e( 'Testers contribution' );?></h4>
                                    <p><?php _e( 'Are you a warned user ? if something is not right or can be improved, just let us know. We\'re working every day on tendoo to give users the best experience than  ever. You can help us doing this. Thanks for you reports.' );?></p>
                                    <a target="_blank" class="btn <?php echo theme_button_class();?> btn-large" href="https://github.com/Blair2004/tendoo-cms/issues/new"> <?php _e( 'Report Issue on Github' );?> </a> 
                                </div>
                                <div class="col-lg-6">
                                    <h4><i class="fa fa-code"></i> <?php _e( 'Developpers contribution' );?></h4>
                                    <p><?php _e( 'Tendoo is written in PHP/Mysql. His source code is hosted on Github, and docs on <a href="http://tendoo.readme.io">tendoo.readme.io</a>. You can start reading documentation before exploring code. But first of all you have to determine which kind of developer you are (core developper or apps developper). Whatever your choice. everything is feasible. thanks for your contribution.' );?></p>
                                    <a target="_blank" class="btn <?php echo theme_button_class();?> btn-large" href="https://github.com/Blair2004/tendoo-cms"> <?php _e( 'Explore Code' );?> </a> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <hr class="line-dashed" />	
                                    <p> 
                                <a data-requestType="silent" data-url="<?php echo get_instance()->url->site_url( array('admin','ajax','toggleFirstVisit'));?>" class="btn <?php echo theme_button_false_class();?> btn-large" dismissmodal id="quitTour"> <?php _e( 'I got it' );?> </a> 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4"> <i class="fa fa-users" style="font-size:350px"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
			var wizard	=	'<section class="wizmodal">'+ 
								'<div class="wizard clearfix">'+
									'<ul class="steps">'+
										'<li data-target="#step1" class="active" >'+
										'<span class="badge badge-info">1</span><?php _e( 'Welcome' );?></li>'+
										'<li data-target="#step2" class=""><span class="badge">2</span><?php _e( "What\'s new ?" );?></li>'+
										'<li data-target="#step3" class=""><span class="badge">3</span><?php _e( 'Getting Started' );?></li>'+
										'<li data-target="#step4" class=""><span class="badge">4</span><?php _e( 'What about contributing ?' );?></li>'+
										//'<li data-target="#step5" class=""><span class="badge">5</span>Par où commencer ?</li>'+
									'</ul>'+
									'<div class="actions">'+
										'<button type="button" class="btn btn-white btn-xs btn-prev"><?php _e( 'Previous' );?></button>'+
										'<button type="button" class="btn btn-white btn-xs btn-next"><?php _e( 'Next' );?></button>'+
									'</div>'+
								'</div>'+
								// '<img class="backgroundImg" src="<?php echo get_instance()->url->img_url('tendoo_1.jpg');?>" style="position:absolute;">'+
								'<div class="step-content" style="">'+
									'<div class="step-pane active" id="step1">This is step 1</div>'+
									'<div class="step-pane" id="step2">This is step 2</div>'+
									'<div class="step-pane" id="step3">This is step 3</div>'+
									'<div class="step-pane" id="step4">This is step 4</div>'+
									//'<div class="step-pane" id="step5">This is step 5</div>'+
								'</div>'+
							'</section>';
			$(document).ready(function(){
				// tendoo.window.title( '<?php echo sprintf( __( 'Welcome on %s' ) , get('core_version') );?>' ).show(wizard);
				var steps	=	1;
				$('[data-stepContent]').each(function(){
					$('.wizmodal').find('#step'+steps).html($(this).html());
					steps++;
				});
				tendoo.silentAjax.bind(); // bind Event
				$('#quitTour').bind('click',function(){
					$modal	=	$(this).closest('.modal-dialog');
					$button	=	$($modal).find('[data-dismiss="modal"]').trigger('click');
				});
				var counter	=	1;
				$('.wizmodal ul[class="steps"] li').each(function(){
					$(this).data('id',counter);
					counter++;
				});
				$('.wizmodal .actions button:eq(0)').bind('click',function(){
					if($('.wizmodal ul[class="steps"] li[class="active"]').length == 0)
					{
						$('.wizmodal ul[class="steps"] li').eq(0).addClass('active').find('.badge').addClass('badge-info');
						
					}
					var activeId	=	$('.wizmodal ul[class="steps"] li[class="active"]').data('id');
					if(activeId > 1)
					{
						$('.wizmodal ul[class="steps"]')
							.find('li')
							.removeClass('active')
							.find('.badge')
							.removeClass('badge-info');
						$('.wizmodal ul[class="steps"]')
							.find('li')
							.eq(parseInt(activeId)-2)
							.addClass('active')
							.find('.badge')
							.addClass('badge-info');
						$('.wizmodal .step-content')
							.children()
							.hide()
							.removeClass('active');
						$('.wizmodal .step-content')
							.children()
							.eq(parseInt(activeId)-2)
							.addClass('active')
							.show();
					}
				});
				$('.wizmodal .actions button:eq(1)').bind('click',function(){
					if($('.wizmodal ul[class="steps"] li[class="active"]').length == 0)
					{
						$('.wizmodal ul[class="steps"] li').eq(0).addClass('active').find('.badge').addClass('badge-info');;
					}
					var activeId	=	$('.wizmodal ul[class="steps"] li[class="active"]').data('id');
					// Si le nom d'enfant est inférieur à l'identifiant de la page en cours, on parcours (+1)
					if(activeId < $('.wizmodal ul[class="steps"]').find('li').length)
					{
						$('.wizmodal ul[class="steps"]').children('li')
							.removeClass('active')
							.find('.badge')
							.removeClass('badge-info');
						$('.wizmodal ul[class="steps"]').children('li')
							.eq(parseInt(activeId))
							.addClass('active')
							.find('.badge')
							.addClass('badge-info');
								
						$('.wizmodal .step-content')
							.children()
							.each(function(){
								$(this).hide().removeClass('active');
							})
						$('.wizmodal .step-content')
							.children()
							.eq(parseInt(activeId))
							.addClass('active')
							.show();
					}
				});
				$('.proceed').bind('click',function(){
					$('.actions button:eq(1)').trigger('click');
				});
			});
			</script>
<style type="text/css">
			@media (width: 1280px)
			{
				.wizmodal .logo_Girls
				{
					width:73.9%;position:absolute;top:0px;right:0;
				}
			}
			</style>
