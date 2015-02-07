<?php
// Settings Width
$this->gui->cols_width( 1 , 2 );
$this->gui->cols_width( 2 , 2 );
// Creating meta Boxes

$general_settings		=	core_meta_namespace( array( 'admin' , 'settings' , 'general_settings' ) );

$this->gui->set_meta( array(
	'title'		=>		__( 'General Settings' ),
	'namespace'	=>		$general_settings,
	'form_wrap'	=>		array(
		'method'		=>	'post',
		'gui_saver'		=>	true,
		'submit_text'	=>	__( 'Save Settings' )
	)
) )->push_to( 1 );

foreach( force_array( get_instance()->date->getFuseau() ) as $_timezone )
{
	$value[]	=	riake( 'Code' , $_timezone );
	$text[]		=	riake( 'Index' , $_timezone ) . ' - ' . riake( 'States' , $_timezone );
}

$this->gui->set_item( array(
	'type'		=>		'select',
	'name'		=>		'site_timezone',
	'value'		=>		$value,
	'text'		=>		$text,
	'placeholder'=>		__( 'Select a timezone' ),
	'label'		=>		__( 'Select a timezone' ),
	'active'	=>		riake( 'site_timezone' , $options )
) )->push_to( $general_settings );

$timeformat		=	array(
	'%d-%m-%Y'	=>	'%d-%m-%Y (' . get_instance()->date->datetime( '%d' ) . '-' . get_instance()->date->datetime( '%m' ) . '-' . get_instance()->date->datetime( '%Y' ) . ')',
	'%Y/%m/%d'	=>	'%Y/%m/%d (' . get_instance()->date->datetime( '%Y' ) . '/' . get_instance()->date->datetime( '%m' ) . '/' . get_instance()->date->datetime( '%d' ) . ')',
	'%Y-%m-%Y'	=>	'%Y-%m-%Y (' . get_instance()->date->datetime( '%Y' ) . '-' . get_instance()->date->datetime( '%m' ) . '-' . get_instance()->date->datetime( '%d' ) . ')'
);
foreach( $timeformat as $value => $text )
{
	$timeformat_text[]	=	$text;
	$timeformat_value[]	=	$value;
}

$this->gui->set_item( array(
	'type'		=>		'select',
	'name'		=>		'site_timeformat',
	'value'		=>		$timeformat_value,
	'text'		=>		$timeformat_text,
	'placeholder'=>		__( 'Select a time format' ),
	'label'		=>		__( 'Select a time format' ),
	'active'	=>		riake( 'site_timeformat' , $options )
) )->push_to( $general_settings );

$this->gui->set_item( array(
	'type'		=>		'text',
	'name'		=>		'site_name',
	'value'		=>		riake( 'site_name' , $options ),
	'label'		=>		__( 'Website name' ),
	'placeholder'=>		__( 'Enter the website name' )
) )->push_to( $general_settings );

$this->gui->set_item( array(
	'type'		=>		'textarea',
	'name'		=>		'site_description',
	'value'		=>		riake( 'site_description' , $options ),
	'label'		=>		__( 'Website description' ),
	'placeholder'=>		__( 'Enter the website description' ),
	'description'=>		__( 'Just say a little more about this website' )
) )->push_to( $general_settings );

// Advanced settings metabox

$advanced_settings		=	core_meta_namespace( array( 'admin' , 'settings' , 'advanced' ) );

$this->gui->set_meta( array(
	'title'		=>		__( 'Advanced Settings' ),
	'namespace'	=>		$advanced_settings,
	'form_wrap'	=>		array(
		'method'		=>	'post',
		'gui_saver'		=>	true,
		'submit_text'	=>	__( 'Save Settings' )
	)
) )->push_to( 2 );

$this->gui->set_item( array(
	'type'		=>		'select',
	'placeholder'=>		__( 'Select Tendoo Mode' ),
	'description'=>		__( 'This option allow you to turn tendoo into "web app" mode, which disable front-end, related modules and themes interface.' ),
	'name'		=>		'tendoo_mode',
	'text'		=>		array( __( 'Website mode' ) , __( 'WebApp mode' ) ),
	'value'		=>		array( 'website' , 'webapp' ),
	'label'		=>		__( 'Tendoo mode' ),
	'active'	=>		riake( 'tendoo_mode' , $options )
) )->push_to( $advanced_settings );

$this->gui->set_item( array(
	'type'		=>		'select',
	'placeholder'=>		__( 'Choose option' ),
	'description'=>		__( 'This option allow you to enable automatic updates.' ),
	'name'		=>		'tendoo_update',
	'text'		=>		array( __( 'Yes and report me what\'s new' ) , __( 'Yes, but in silent' ), __( 'No, just let me know' ) , __( 'No and don\'t let me know' ) ),
	'value'		=>		array( 'yes' , 'silent_mode' , 'report' , 'disconnected' ),
	'label'		=>		__( 'Enable automatic update' ),
	'active'	=>		riake( 'tendoo_update' , $options )
) )->push_to( $advanced_settings );

$this->gui->set_item( array(
	'type'		=>		'select',
	'placeholder'=>		__( 'Choose option' ),
	'description'=>		__( 'This option enable registration on your website.' ),
	'name'		=>		'tendoo_registration_status',
	'text'		=>		array( __( 'Yes' ) , __( 'No' ) ),
	'value'		=>		array( 1 , 0 ),
	'label'		=>		__( 'Anyone can register ?' ),
	'active'	=>		riake( 'tendoo_registration_status' , $options )
) )->push_to( $advanced_settings );

$this->gui->set_item( array(
	'type'		=>		'select',
	'placeholder'=>		__( 'Choose option' ),
	'description'=>		__( 'You can enable role selection on registration. You may need to set on roles, which ones are selectable. Be careful of the role you define available for registration.' ),
	'name'		=>		'tendoo_role_selection',
	'text'		=>		array( __( 'Yes' ) , __( 'No' ) ),
	'value'		=>		array( 1 , 0 ),
	'label'		=>		__( 'Allow role selection' ),
	'active'	=>		riake( 'tendoo_role_selection' , $options )
) )->push_to( $advanced_settings );

$this->gui->set_item( array(
	'type'		=>		'select',
	'placeholder'=>		__( 'Choose option' ),
	'description'=>		__( 'This option allow you to open dashboard for role available on registration.' ),
	'name'		=>		'tendoo_open_dashboard',
	'text'		=>		array( __( 'Yes' ) , __( 'No' ) ),
	'value'		=>		array( 1 , 0 ),
	'label'		=>		__( 'Open dashboard' ),
	'active'	=>		riake( 'tendoo_open_dashboard' , $options )
) )->push_to( $advanced_settings );

// Widget Content
$this->gui->set_meta( array(
) )->push_to( 2 );

$this->gui->get();
return;
?>
<?php echo get_core_vars( 'inner_head' );?>

<section id="content">
<section class="hbox stretch">
    <?php echo get_core_vars( 'lmenu' );?>
    <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted">
                            <?php echo get_page('description');?>
                        </p>
                    </div>
                    <div class="col-sm-8">
                        <a href="#" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i> </a>
                    </div>
                </div>
            </header>
            <section class="wrapper w-f">
                <?php echo output('notice');?> <?php echo validation_errors('<p class="error">', '</p>');?> <?php echo fetch_notice_from_url();?>
                <section class="panel">
                    <header class="panel-heading bg-light">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="active"><a href="#autorisation" data-toggle="tab"><?php echo translate('Permissions');?></a></li>
                            <?php
								if(get_instance()->users_global->isSuperAdmin()) // Setting is now reserved to super admin
								{
								?>
                            <li><a href="#datasetting" data-toggle="tab"><?php echo translate('Website Settings');?></a></li>
                            <li><a href="#security" data-toggle="tab"><?php echo translate('Security');?></a></li>
                            <?php
								}
								?>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="datasetting">
                                <form method="post" class="panel-body">
                                    <?php
										if(get_instance()->users_global->current('REF_ROLE_ID') == 'SUPERADMIN')
										{
										?>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php _e( 'Select time zone' );?>
                                        </label>
                                        <?php $default	=	riake( 'site_timezone' , $options ) == '' ? 'UTC' : riake( 'site_timezone' , $options );?>
                                        <select name="newHoraire" class="input-sm form-control">
                                            <?php $fuso		=	get_instance()->date->getFuseau();
											foreach($fuso as $f)
											{
												if( riake( 'site_timezone' , $options ) == $f['Code'])
												{
												?>
                                            <option selected="selected" value="<?php echo $f['Code'];?>"><?php echo $f['Index'].' - '.$f['States'];?></option>
                                            <?php
												}
												else
												{
													?>
                                            <option value="<?php echo $f['Code'];?>"><?php echo $f['Index'].' - '.$f['States'];?></option>
                                            <?php
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php _e( 'Name of website' );?>
                                        </label>
                                        <input type="text" name="newName" class="form-control" value="<?php echo riake( 'site_name' , $options );?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php _e( 'Link for Logo' );?>
                                        </label>
                                        <input type="text" name="newLogo" value="<?php echo riake( 'site_logo' , $options );?>" class="form-control">
                                        <div class="">
                                            <span class="bg-white input-group-addon"><img src="<?php echo riake( 'site_logo' , $options );?>"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?php
											$format	=	riake( 'site_timeformat' , $options );
											?>
                                        <label class="control-label">
                                            <?php _e( 'Set time format' );?>
                                        </label>
                                        <select name="newFormat" class="input-sm form-control inline">
                                            <option value="">
                                            <?php _e( 'Select...' );?>
                                            </option>
                                            <option <?php echo $format == 'type_1' ? 'selected="selected"' : '';?> value="type_1">J m A (29 %month% 2013)</option>
                                            <option <?php echo $format == 'type_2' ? 'selected="selected"' : '';?> value="type_2">J/m/A (29/06/2013)</option>
                                            <option <?php echo $format == 'type_3' ? 'selected="selected"' : '';?> value="type_3">A/m/J (2013/06/29)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <?php
											$tendoo_mode	=	riake( 'tendoo_mode' , $options );
											?>
                                        <label class="control-label">
                                            <?php _e( 'Set Tendoo Mode' );?>
                                        </label>
                                        <select name="tendoo_mode" class="input-sm form-control inline">
                                            <option <?php echo $tendoo_mode == 'website' ? 'selected="selected"' : '';?> value="website">
                                            <?php _e( 'WebSite Mode' );?>
                                            </option>
                                            <option <?php echo $tendoo_mode == 'webapp' ? 'selected="selected"' : '';?> value="webapp">
                                            <?php _e( 'WebApp Mode' );?>
                                            </option>
                                        </select>
                                    </div>
                                    <?php
										}
										?>
                                    <input class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="<?php _e( 'Save Settings' );?>"/>
                                </form>
                            </div>
                            <div class="tab-pane active" id="autorisation">
                                <?php echo tendoo_warning('Veuillez patienter la notification de r&eacute;ssite, confirmant l\'enregistrement des modifications.');?>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h4>
                                            <?php _e( 'Main Settings' );?>
                                        </h4>
                                        <?php
											if(get_instance()->users_global->isSuperAdmin()) // Setting is now reserved to super admin
											{
											?>
                                        <form fjax method="post" action="<?php echo get_instance()->url->site_url(array('admin','ajax','toogleStoreAccess'));?>">
                                            <div class="form-group">
                                                <label>
                                                    <?php
														if( riake( 'connect_to_store' , $options ) == "1")
														{
														?>
                                                    <input type="submit" name="storeToggle" class="btn btn-sm <?php echo theme_button_class();?>" value="<?php _e( 'Turn off the connection to the Store' );?>">
                                                    <?php
														}
														else
														{
														?>
                                                    <input type="submit" name="storeToggle" class="btn btn-sm <?php echo theme_button_class();?>" value="<?php _e( 'Turn on the connection to the Store' );?>">
                                                    <?php
														}
														;?>
                                                </label>
                                                <script>
													$(document).ready(function(){
														$('[name="storeToggle"]').bind('click',function(){
															if($(this).val() == 'Activer la connexion au Store')
															{
																$(this).attr('value','<?php _e( 'Turn off the connection to the Store' );?>');
															}
															else
															{
																$(this).attr('value','<?php _e( 'Turn on the connection to the Store' );?>');
															}
														});
													});
													</script>
                                            </div>
                                        </form>
                                        <?php
											}
											?>
                                        <form fjax method="post" action="<?php echo get_instance()->url->site_url(array('admin','ajax','toggleFirstVisit'));?>">
                                            <div class="form-group">
                                                <label>
                                                    <?php 
														if( get_user_meta( 'first_visit' ) == 1)
														{
														?>
                                                    <input type="submit" name="firstVisitToggle" class="btn btn-sm <?php echo theme_button_class();?>" value="<?php _e( 'Hide the tour' );?>">
                                                    <?php
														}
														else
														{
														?>
                                                    <input type="submit" name="firstVisitToggle" class="btn btn-sm <?php echo theme_button_class();?>" value="<?php _e( 'Enable the tour' );?>">
                                                    <?php
														}
														;?>
                                                </label>
                                                <script>
													$(document).ready(function(){
														$('[name="firstVisitToggle"]').bind('click',function(){
															if($(this).val() == '<?php _e( 'Hide the tour' );?>')
															{
																$(this).attr('value','<?php _e( 'Enable the tour' );?>');
															}
															else
															{
																$(this).attr('value','<?php _e( 'Hide the tour' );?>');
															}
														});
													});
													</script>
                                            </div>
                                        </form>
                                        <!-- Fin "modifier le statut des pages"-->
                                    </div>
                                    <div class="col-lg-4">
                                        <h4>
                                            <?php _e( 'Icons and Applications' );?>
                                        </h4>
                                        <form method="post">
                                            <div class="form-group">
                                                <div class="panel">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <td><?php _e( 'module' );?></td>
                                                                <td width="100"><?php _e( 'Display' );?></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <input type="hidden" name="showIcon[]" value="" />
                                                        <?php
																if($appIconApi)
																{
																	foreach($appIconApi as $_a)
																	{
																		
																			eval(riake( 'admin_icons' , $options ));
																			if(!isset($icons))
																			{
																				$icons	=	array(0);
																			}
																			$visibleIcons	=	$icons;
																			$val	=	'';
																			foreach($visibleIcons as $s)
																			{
																				if($s	===	$_a['ICON_MODULE']['namespace'].'/'.$_a['ICON_NAMESPACE'])
																				{
																					$val	=	'checked="checked"';
																					break;
																				}
																			}
																				
																		?>
                                                        <tr>
                                                            <td><?php echo $_a['ICON_MODULE']['name'];?></td>
                                                            <td><label class="label-control switch">
                                                                    <input type="checkbox" name="showIcon[]" <?php echo $val;?>  value="<?php echo $_a['ICON_MODULE']['namespace'].'/'.$_a['ICON_NAMESPACE'];?>"  />
                                                                    <span style="height:20px;"></span> </label></td>
                                                        </tr>
                                                        <?php
																		
																	}
																}
																else
																{
																	?>
                                                        <tr>
                                                            <td colspan="2"><?php _e( 'No icon available' );?></td>
                                                        </tr>
                                                        <?php
																}
																?>
                                                            </tbody>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                            <input name="appicons" class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="<?php _e( 'Save Settings' );?>"/>
                                        </form>
                                    </div>
                                    <div class="col-lg-5">
                                        <h4>
                                            <?php _e( 'Widgets' );?>
                                        </h4>
                                        <form method="post">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td><?php _e( 'Icon' );?></td>
                                                        <td><?php _e( 'Module' );?></td>
                                                        <td><?php _e( 'Status' );?></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $declared_admin_widgets	=	get_core_vars('admin_widgets');
                                                        if(count($declared_admin_widgets) > 0)
                                                        {
															if( is_array( $declared_admin_widgets ) ){
																foreach($declared_admin_widgets as $w)
																{
																	?>
                                                    <tr>
                                                        <td><?php echo $w['widget_title'];?></td>
                                                        <td><?php echo $w['module_namespace'];?></td>
                                                        <td><label class="label-control switch">
                                                                <input <?php
																if($this->users_global->isAdminWidgetEnabled($w['widget_namespace'].'/'.$w['module_namespace']) && get_instance()->users_global->adminWidgetHasWidget() )
																{
																	echo "checked";
																}
																?> type="checkbox" name="widget_action[]" value="<?php echo $w['widget_namespace'];?>/<?php echo $w['module_namespace'];?>" />
                                                                <span></span> </label>
                                                            <input type="hidden" name="widget_namespace[]" value="<?php echo $w['widget_namespace'];?>/<?php echo $w['module_namespace'];?>"></td>
                                                    </tr>
                                                    <?php
																}
															}
															else {
																?>
                                                    <tr>
                                                        <td colspan="3"><?php _e( 'No widget available' );?></td>
                                                    </tr>
                                                    <?php
															}
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                    <tr>
                                                        <td colspan="3"><?php _e( 'No widget available' );?></td>
                                                    </tr>
                                                    <?php
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
                                            <input type="submit" class="btn <?php echo theme_button_class();?>" value="<?php _e( 'Save Settings');?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- SECURITY -->
                            
                            <?php
								if(get_instance()->users_global->isSuperAdmin()) // Setting is now reserved to super admin
								{
								?>
                            <div class="tab-pane" id="security">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <?php
											$checked	=	( riake( 'allow_privilege_selection' , $options ) == "1") ? 'checked="checked"' : "";
											?>
                                        <form method="post">
                                            <h3>
                                                <?php _e( 'Privilege' );?>
                                            </h3>
                                            <div class="form-group">
                                                <label class="label-control">
                                                    <?php _e( 'allow privilege selection' );?>
                                                    :
                                                    <input class="input-control" name="allow_priv_selection" type="checkbox" value="1" style="min-width:20px;" <?php echo $checked;?> />
                                                </label>
                                                <p>
                                                    <?php _e( 'You can define among the privileges that you have created, those who are available upon registration by users. Remember to choose among the privileges you have created those who will be available to the public.' );?>
                                                </p>
                                            </div>
                                            <input name="allow_priv_selection_button" class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="<?php _e( 'Save Settings' );?>"/>
                                        </form>
                                        <br>
                                        <form method="post" >
                                            <div class="form-group">
                                                <label class="label-control">
                                                    <?php _e( 'Open access to public administration privileges' );?>
                                                </label>
                                                <p>
                                                    <?php _e( 'It is important to know that this option prevent any part of the user open to the public privileges to access the administration area, regardless of the fact that the shares have been added to the various privileges available to the public. Similarly, when a privilege ceases to have accéssible publicly, any user that is part of this privilege can now access the administration area.' );?>
                                                </p>
                                                <select name="publicPrivAccessAdmin" class="form-control">
                                                    <option value="">
                                                    <?php _e( 'choose' );?>
                                                    </option>
                                                    <?php
														if( riake( 'public_priv_access_admin' , $options ) == 0)
														{
															?>
                                                    <option value="1">
                                                    <?php _e( 'Yes' );?>
                                                    </option>
                                                    <option selected="selected" value="0">
                                                    <?php _e( 'No' );?>
                                                    </option>
                                                    <?php
														}
														else if( riake( 'public_priv_access_admin' , $options ) == 1)
														{
															?>
                                                    <option selected="selected" value="1">
                                                    <?php _e( 'No' );?>
                                                    </option>
                                                    <option value="0">
                                                    <?php _e( 'No' );?>
                                                    </option>
                                                    <?php
														}
														else
														{
															?>
                                                    <option value="1">
                                                    <?php _e( 'Yes' );?>
                                                    </option>
                                                    <option value="0">
                                                    <?php _e( 'NO' );?>
                                                    </option>
                                                    <?php
														}
														?>
                                                </select>
                                            </div>
                                            <input name="publicPrivAccessAdmin_button" class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="<?php _e( 'Save Settings' );?>"/>
                                        </form>
                                    </div>
                                    <div class="col-lg-4">
                                        <form method="post">
                                            <h3>
                                                <?php _e( 'Registration' );?>
                                            </h3>
                                            <div class="form-group">
                                                <label class="label-control">
                                                    <?php _e( 'Open Registration' );?>
                                                </label>
                                                <select name="allowRegistration" class="form-control">
                                                    <option value="">
                                                    <?php _e( 'Choose' );?>
                                                    </option>
                                                    <?php
														if( riake( 'allow_registration' , $options ) == 0)
														{
															?>
                                                    <option value="1">
                                                    <?php _e( 'Yes' );?>
                                                    </option>
                                                    <option selected="selected" value="0">
                                                    <?php _e( 'No' );?>
                                                    </option>
                                                    <?php
														}
														else if( riake( 'allow_registration' , $options ) == 1)
														{
															?>
                                                    <option selected="selected" value="1">
                                                    <?php _e( 'Yes' );?>
                                                    </option>
                                                    <option value="0">
                                                    <?php _e( 'No' );?>
                                                    </option>
                                                    <?php
														}
														else
														{
															?>
                                                    <option value="1">
                                                    <?php _e( 'Yes' );?>
                                                    </option>
                                                    <option value="0">
                                                    <?php _e( 'No' );?>
                                                    </option>
                                                    <?php
														}
														?>
                                                </select>
                                            </div>
                                            <input name="autoriseRegistration" class="btn btn-sm <?php echo theme_button_class();?>" type="submit" value="<?php _e( 'Save Settings' );?>"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
								}
								?>
                        </div>
                    </div>
                </section>
            </section>
			</section>
        </section>
    </section>
</section>
