<?php echo get_core_vars( 'inner_head' );?>

<section>
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        <section>
            <section class="vbox">
                <section class="scrollable">
                    <section id="pjax-container">
                        <header>
                            <div class="row b-b m-l-none m-r-none">
                                <div class="col-sm-4">
                                    <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                                    <p class="block text-muted">
                                        <?php echo get_page('description');?>
                                    </p>
                                </div>
                                <div class="col-sm-8">
                                    <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/gestion-des-contrôleurs" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i> </a>
                                </div>
                            </div>
                        </header>
                        <section>
                            <section class="wrapper w-f">
                                <?php echo output('notice');?>
                                <div class="row">
                                    <div class="col-lg-5">
                                        <section class="panel">
                                            <div class="panel-heading">
                                                <?php _e( 'Create a controller' );?>
                                            </div>
                                            <form id="controller_form" fjax action="<?php echo $this->instance->url->site_url(array('admin','ajax','create_controller'));?>" method="post" class="panel-body">
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <?php _e( 'Controller name' );?>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="<?php _e( 'Controller name' );?>" name="page_name" class="form-control">
                                                        <span class="input-group-btn">
                                                        <button 
											type="button"
											class="btn btn-info" 
											data-toggle="popover" 
											data-html="true" 
											data-placement="bottom" 
											data-content="<div style='width:200px'><?php _e( 'It will be used on links' );?></div>" 
											title="" 
											data-original-title="<?php _e( 'Controller name' );?>">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">
                                                        <?php _e( 'Controller Code' );?>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="<?php _e( 'Controller Code' );?>" name="page_cname" class="form-control">
                                                        <span class="input-group-btn">
                                                        <button 
                                            type="button"
                                            class="btn btn-info" 
                                            data-toggle="popover" 
                                            data-html="true" 
                                            data-placement="bottom" 
                                            data-content="<div style='width:250px'><?php echo sprintf( __( 'This text will be used on URL. The word must not have spaces and specials caracters. dashes and underscores are accepted. Example : %s or %s' ) , $this->instance->url->main_url() . 'index.php/<strong>nouvelle-page</strong>' , $this->instance->url->main_url() . 'index.php/<strong>blog</strong></div>' );?>" 
                                            title="" 
                                            data-original-title="<?php _e( 'Controller Code' );?>">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"><?php _e( 'Controller title' );?></label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="<?php _e( 'Controller title' );?>" name="page_title" class="form-control">
                                                        <span class="input-group-btn">
                                                        <button 
                                            type="button"
                                            class="btn btn-info" 
                                            data-toggle="popover" 
                                            data-html="true" 
                                            data-placement="bottom" 
                                            data-content="&lt;div style='width:250px'&gt;<?php _e( 'Will be used as controller title.' );?>.</div>" 
                                            title="" 
                                            data-original-title="Titre du contrôleur">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"><?php _e( 'Controller description' );?></label>
                                                    <textarea name="page_description" class="form-control" placeholder="<?php _e( 'Controller description' );?>"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php _e( 'Keywords' );?></label>
                                                    <textarea name="page_keywords" class="form-control" placeholder="<?php _e( 'Keywords' );?>"></textarea>
                                                </div>
                                                <input type="hidden" name="page_parent" value="none">
                                                <div class="form-group">
                                                    <label class="control-label"><?php _e( 'Use link' );?></label>
                                                    <div class="input-group">
                                                        <input name="page_link" class="form-control" placeholder="<?php _e( 'Use link' );?>" />
                                                        <span class="input-group-btn">
                                                        <button 
                                            type="button"
                                            class="btn btn-info" 
                                            data-toggle="popover" 
                                            data-html="true" 
                                            data-placement="top" 
                                            data-content="<div style='width:250px'><?php _e( 'Instead of binding module, you can use a link.' );?></div>" 
                                            title="" 
                                            data-original-title="<?php _e( 'Use link instead of binding module.' );?>">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"><?php _e( 'Available on menu ?' );?></label>
                                                    <div class="input-group">
                                                        <select class="form-control inline" name="page_visible">
                                                            <option value=""><?php _e( 'Choose option' );?></option>
                                                            <option value="TRUE"><?php _e( 'True' );?></option>
                                                            <option value="FALSE"><?php _e( 'False' );?></option>
                                                        </select>
                                                        <span class="input-group-btn">
                                                        <button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'><?php _e( 'This Controller will be visible on menu.' );?>.</div>" 
													title="" 
													data-original-title="<?php _e( 'Sets controller visibility on menu.' );?>">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"><?php _e( 'Set as default ?' );?></label>
                                                    <div class="input-group">
                                                        <select name="page_priority" class="form-control inline">
                                                            <option value=""><?php _e( 'Choose option' );?></option>
                                                            <option value="TRUE"><?php _e( 'Yes' );?></option>
                                                            <option selected="selected" value="FALSE"><?php _e( 'No' );?></option>
                                                        </select>
                                                        <span class="input-group-btn">
                                                        <button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'><?php echo sprintf( __( 'While accessing %s, this controller will be used.' ) , get_instance()->url->main_url() );?>.</div>" 
													title="" 
													data-original-title="<?php _e( 'Set as main controller' );?>">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label"><?php _e( 'Bind a module to this controller' );?></label>
                                                    <div class="input-group">
                                                        <select class="form-control inline" name="page_module">
                                                            <option value=""><?php _e( 'Choose option' );?></option>
                                                            <option value="#LINK#"><?php _e( 'Use link instead' );?></option>
                                                            <?php
												foreach($get_mod as $g) 
												{
													?>
                                                            <option value="<?php echo $g['namespace'];?>"><?php echo $g['name'];?></option>
                                                            <?php
												}
												?>
                                                        </select>
                                                        <span class="input-group-btn">
                                                        <button 
													type="button"
													class="btn btn-info" 
													data-toggle="popover" 
													data-html="true" 
													data-placement="top" 
													data-content="<div style='width:250px'><?php _e( 'Choose how a controller will be openable.' );?></div>" 
													title="" 
													data-original-title="<?php _e( 'Sets controller module or link.' );?>">?</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <hr class="line line-dashed">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-success" value="<?php _e( 'Create a new controller' );?>">
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                    <div class="TENDOO_MENU">
                                        <div class="col-lg-7">
                                            <button class="btn btn-primary btn-sm" data-action="expand-all" type="button"><?php _e( 'Expand All' );?></button>
                                            <button class="btn btn-primary btn-sm" data-action="collapse-all" type="button"><?php _e( 'Collapse All' );?></button>
                                        </div>
                                        <script type="text/javascript">
							$('[data-action="expand-all"]').bind('click',function(){
								$('.dd').nestable('expandAll');
							});
							$('[data-action="collapse-all"]').bind('click',function(){
								$('.dd').nestable('collapseAll');
							});
							</script>
                                        <form method="POST" controller_form class="col-lg-7">
                                            <div class="dd">
                                                <ol class="dd-list">
                                                    <?php
									if($get_pages)
									{
										foreach($get_pages as $g)
										{		
											?>
                                                    <!--  data-id="1"  -->
                                                    <li class="dd-item" controllers c_id="<?php echo $g['ID'];?>" c_name="<?php echo $g['PAGE_NAMES'];?>" c_cname="<?php echo $g['PAGE_CNAME'];?>" c_title="<?php echo $g['PAGE_TITLE'];?>">
                                                        <input type="hidden" controller_title name="controller[title][]" value="<?php echo $g['PAGE_TITLE'];?>">
                                                        <input type="hidden" controller_description name="controller[description][]" value="<?php echo $g['PAGE_DESCRIPTION'];?>">
                                                        <input type="hidden" controller_main name="controller[main][]" value="<?php echo $g['PAGE_MAIN'];?>">
                                                        <input type="hidden" controller_module name="controller[module][]" value="<?php echo is_array($g['PAGE_MODULES']) ? $g['PAGE_MODULES']['namespace'] : $g['PAGE_MODULES'];?>">
                                                        <input type="hidden" controller_parent name="controller[parent][]" value="<?php echo $g['PAGE_PARENT'];?>">
                                                        <input type="hidden" controller_name name="controller[name][]" value="<?php echo $g['PAGE_NAMES'];?>">
                                                        <input type="hidden" controller_cname name="controller[cname][]" value="<?php echo $g['PAGE_CNAME'];?>">
                                                        <input type="hidden" controller_keywords name="controller[keywords][]" value="<?php echo $g['PAGE_KEYWORDS'];?>">
                                                        <input type="hidden" controller_link name="controller[link][]" value="<?php echo $g['PAGE_LINK'];?>">
                                                        <input type="hidden" controller_visible name="controller[visible][]" value="<?php echo $g['PAGE_VISIBLE'];?>">
                                                        <input type="hidden" controller_id name="controller[id][]" value="<?php echo $g['ID'];?>">
                                                        <div class="dd-handle">
                                                            <span controller_name_visible> <?php echo $g['PAGE_NAMES'];?> </span> <span id="controller_priority_status">
                                                            <?php
												if($g['PAGE_MAIN'] == 'TRUE')
												{
													?>
                                                            - <small><?php _e( 'Index' );?></small>
                                                            <?php
												}
												?>
                                                            </span>
                                                            <div style="float:right">
                                                                <button class="edit_controller dd-nodrag btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i></button>
                                                                <button class="remove_controller dd-nodrag btn btn-warning btn-sm" type="button"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                        <ol class="dd-list">
                                                            <?php
												$this->instance->tendoo_admin->getChildren($g['PAGE_CHILDS']);
												?>
                                                        </ol>
                                                    </li>
                                                    <?php
										}
									}
									else
									{
										?>
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <?php _e( 'No controller available.' );?>
                                                        </div>
                                                    </div>
                                                    <?php
									}
                        ?>
                                                </ol>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <script type"text/javascript">
					function bootCScript()
					{
						$('[controller_save_edits]').bind('click',function(){
							// Lorsque le contrôleur sera modifié, modifier le status de l'édition des contrôleurs
							tendoo.controllers.setEditStatus(false);
							$('[controller_form]').trigger('submit');
						});
						$('.edit_controller').each(function(){
							if(!$(this).attr('binded'))
							{
								$(this).attr('binded','true');
								$(this).bind('click',function(){
									var data	=	$(this).closest('[controllers]');
									// Ce contrôleur a-t-il des parents ?
									var hasparent		=	$(data).parent().closest('[controllers]').length == 0 ? false : true;
									tendoo.window
									.title('<?php _e( 'Edit a controller' );?> &raquo; '+$(data).find('[controller_title]').val())
									.show($('#prototype').html());
									// Metas
									var p_title			=	$(data).find('[controller_title]').val();
									var p_name			=	$(data).find('[controller_name]').val();
									var p_cname			=	$(data).find('[controller_cname]').val();
									var p_description	=	$(data).find('[controller_description]').val();
									var p_module		=	$(data).find('[controller_module]').val();
									var p_keywords		=	$(data).find('[controller_keywords]').val();
									// var p_parent		=	$(data).find('[controller_parent]').val();
									var p_main			=	$(data).find('[controller_main]').val();
									var p_link			=	$(data).find('[controller_link]').val();							
									var p_visible		=	$(data).find('[controller_visible]').val();							
									// 
									var parent			=	$('.modal-body');
									$(parent).find('[name="page_name"]').val(p_name);

									$(parent).find('[name="page_title"]').val(p_title);
									$(parent).find('[name="page_cname"]').val(p_cname);
									$(parent).find('[name="page_description"]').val(p_description);
									$(parent).find('[name="page_module"]').val(p_module);
									$(parent).find('[name="page_keywords"]').val(p_keywords);
									// $(parent).find('[name="page_parent"]').val(p_parent);
									$(parent).find('[name="page_priority"]').val(p_main);
									$(parent).find('[name="page_link"]').val(p_link);
									$(parent).find('[name="page_visible"]').val(p_visible);
									if(hasparent) // Si c'est un enfant
									{
										 $(parent).find('[name="page_priority"]').attr('disabled','disabled').attr('title','<?php _e( "A child controller can\'t be set a main." );?>');
									}
									//
									if(!$(parent).find('[prototype_submiter]').attr('binded'))
									{
										$(parent).find('[prototype_submiter]').attr('binded','true');
										$(parent).find('[prototype_submiter]').bind('click',function(){
											// Eq pour recupérer les premières occurences, afin de ne pas affecter les enfants également.
											var prority =	$(parent).find('[name="page_priority"]').val();
											$(data).find('[controller_title]').eq(0).val($(parent).find('[name="page_title"]').val());
											$(data).find('[controller_name]').eq(0).val($(parent).find('[name="page_name"]').val());
											$(data).find('[controller_name_visible]').eq(0).html($(parent).find('[name="page_name"]').val());
											$(data).find('[controller_cname]').eq(0).val($(parent).find('[name="page_cname"]').val());
											$(data).find('[controller_description]').eq(0).val($(parent).find('[name="page_description"]').val());
											$(data).find('[controller_module]').eq(0).val($(parent).find('[name="page_module"]').val());
											$(data).find('[controller_keywords]').eq(0).val($(parent).find('[name="page_keywords"]').val());
											// $(parent).find('[name="page_parent"]').val(p_parent);
											$(data).find('[controller_link]').eq(0).val($(parent).find('[name="page_link"]').val());
											$(data).find('[controller_visible]').eq(0).val($(parent).find('[name="page_visible"]').val());
											// Si ce contrôleur est un enfant, il ne peut pas être définit comme principal
											if($(data).parent().closest('[controllers]').length == 0)
											{
												// Tout simplement nous ne prennont pas en charge les controleurs enfant, dans la modifications de la priorité
												if(prority == 'TRUE')
												{
													// Remplacement de toutes les valeurs des contrôleurs pour définir cette dernière comme principale, depuis le parent ".TENDOO_MENU".
													$('.TENDOO_MENU').find('[controller_main]').val("FALSE");
													// Suppression du status "index" sur les autres contrôleurs
													$('.TENDOO_MENU').find('#controller_priority_status').html('');
													// Définition du status actuel du controleur définit par défaut
													$(data).find('#controller_priority_status').html('<small>- Index</small>');
												}
												// Définition de la priorité du contrôleur.
												$(data).find('[controller_main]').eq(0).val(prority);
											}
											//
											tendoo.notice.alert('<?php _e( 'Controller updated !' );?>','success');
											tendoo.controllers.setEditStatus(true);
										});	
									}									
								});
							}
						});
					}						
					$(document).ready(function(){
						bootCScript();
					});
					</script>
                                <div id="prototype" style="display:none">
                                    <section class="vbox stretch">
                                        <section id="content">
                                            <section class="hbox stretch">
                                                <section class="vbox">
                                                <section class="scrollable" id="pjax-container">
                                                    <section class="hbox stretch">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <form id="controller_form" fjax action="<?php echo $this->instance->url->site_url(array('admin','ajax','create_controller'));?>" method="post" class="panel-body">
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-xs-4">
                                                                                    <label class="control-label"><?php _e( 'Controller name' );?></label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" placeholder="<?php _e( 'Controller name' );?>" name="page_name" class="form-control">
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                        type="button"
                                                        class="btn btn-info" 
                                                        data-toggle="popover" 
                                                        data-html="true" 
                                                        data-placement="bottom" 
                                                        data-content="<div style='width:200px'><?php _e( 'Will be displayed.' );?></div>" 
                                                        title="" 
                                                        data-original-title="<?php _e( 'Controller name' );?>">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <label class="control-label"><?php _e( 'Controller Slug' );?></label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" placeholder="<?php _e( 'Controller Slug' );?>" name="page_cname" class="form-control">
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                        type="button"
                                                        class="btn btn-info" 
                                                        data-toggle="popover" 
                                                        data-html="true" 
                                                        data-placement="bottom" 
                                                        title="" 
                                                        data-original-title="Code du contrôleur">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <label class="control-label"><?php _e( 'Controller title' );?></label>
                                                                                    <div class="input-group">
                                                                                        <input type="text" placeholder="<?php _e( 'Controller title' );?>" name="page_title" class="form-control">
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                        type="button"
                                                        class="btn btn-info" 
                                                        data-toggle="popover" 
                                                        data-html="true" 
                                                        data-placement="bottom" 
                                                        title="" 
                                                        data-original-title="Titre du contrôleur">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label"><?php _e( 'Controller description' );?></label>
                                                                            <textarea name="page_description" class="form-control" placeholder="<?php _e( 'Controller description' );?>"></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label><?php _e( 'Keywords' );?></label>
                                                                            <textarea name="page_keywords" class="form-control" placeholder="Mots clés du contrôleur"></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-xs-6">
                                                                                    <label class="control-label"><?php _e( 'Use Link' );?></label>
                                                                                    <div class="input-group">
                                                                                        <input name="page_link" class="form-control" placeholder="<?php _e( 'Use Link' );?>" />
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                        type="button"
                                                        class="btn btn-info" 
                                                        data-toggle="popover" 
                                                        data-html="true" 
                                                        data-placement="top" 
                                                        title="" 
                                                        data-original-title="Emplacement du contrôleur">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <label class="control-label"><?php _e( 'Available on menu' );?></label>
                                                                                    <div class="input-group">
                                                                                        <select class="form-control inline" name="page_visible">
                                                                                            <option value=""><?php _e( 'Choose option' );?></option>
                                                                                            <option value="TRUE"><?php _e( 'Visible' );?></option>
                                                                                            <option value="FALSE"><?php _e( 'Hidden' );?></option>
                                                                                        </select>
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                        type="button"
                                                        class="btn btn-info" 
                                                        data-toggle="popover" 
                                                        data-html="true" 
                                                        data-placement="top" 
                                                        title="" 
                                                        data-original-title="Visibilit&eacute; du contrôleur">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label"><?php _e( 'Bind a module' );?></label>
                                                                                    <div class="input-group">
                                                                                        <select class="form-control inline" name="page_module">
                                                                                            <option value=""><?php _e( 'Choose an option' );?></option>
                                                                                            <option value="#LINK#"><?php _e( 'Use link instead' );?></option>
                                                                                            <?php
                                                        foreach($get_mod as $g) 
                                                        {
                                                            ?>
                                                                                            <option value="<?php echo $g['namespace'];?>"><?php echo $g['name'];?></option>
                                                                                            <?php
                                                        }
                                                        ?>
                                                                                        </select>
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                            type="button"
                                                            class="btn btn-info" 
                                                            data-toggle="popover" 
                                                            data-html="true" 
                                                            data-placement="top" 
                                                            title="" 
                                                            data-original-title="Module attach&eacute; au contrôleur">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label"><?php _e( 'Set as default' );?></label>
                                                                                    <div class="input-group">
                                                                                        <select name="page_priority" class="form-control inline">
                                                                                            <option value=""><?php _e( 'Choose option' );?></option>
                                                                                            <option value="TRUE"><?php _e( 'Yes' );?></option>
                                                                                            <option value="FALSE"><?php _e( 'No' );?></option>
                                                                                        </select>
                                                                                        <span class="input-group-btn">
                                                                                        <button 
                                                            type="button"
                                                            class="btn btn-info" 
                                                            data-toggle="popover" 
                                                            data-html="true" 
                                                            data-placement="top" 
                                                            title="" 
                                                            data-original-title="Définir comme page principale">?</button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>
                                                </section>
                                                <footer class="footer bg-white b-t">
                                                    <div class="row m-t-sm text-center-xs">
                                                        <div class="col-sm-8">
                                                        </div>
                                                        <div class="col-sm-4 text-right text-center-xs">
                                                            <input prototype_submiter type="button" data-dismiss="modal" class="btn btn-sm <?php echo theme_class();?>" value="<?php _e( 'Update controller details' );?>">
                                                        </div>
                                                    </div>
                                                </footer>
                                                </section>
                                            </section>
                                        </section>
                                    </section>
                                </div>
                            </section>
                        </section>
                    </section>
                </section>
                <footer class="footer bg-white b-t">
                    <div class="row m-t-sm text-center-xs">
                        <div class="col-sm-2" id="ajaxLoading">
                        </div>
                        <div class="col-sm-10 text-right text-center-xs">
                            <input controller_save_edits type="button" data-dismiss="modal" class="btn btn-sm <?php echo theme_class();?>" value="<?php _e( 'Save settings' );?>">
                        </div>
                    </div>
                </footer>
            </section>
        </section>
    </section>
</section>
