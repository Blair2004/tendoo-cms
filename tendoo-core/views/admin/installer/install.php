<?php
$this->gui->cols_width( 1 , 4 );

$this->gui->set_meta( array(
	'type'		=>		'panel',
	'title'		=>		__( 'Install/Update Apps' ),
	'namespace'	=>		core_meta_namespace( array( 'admin' , 'installer' ) ),
	'form_wrap'	=>		array(
		'submit_text'	=>	__( 'Install' ),
		'enctype'		=>	'multipart/form-data'
	)
) )->push_to( 1 );

$this->gui->set_item( array(
	'type'		=>		'file',
	'name'		=>		'installer_file',
	'label'		=>		__( 'Choose a file to upload' ),
	'description'	=>	__( sprintf( 'Install new app. The install file must necessary be a zip file, and should be compatible with your current Tendoo Version : <strong>%s</strong>. Be safe, and install app from secure provider.' , get( 'core_id' ) ) )
) )->push_to( core_meta_namespace( array( 'admin' , 'installer' ) ) );

$this->gui->get();
return ;
?>

<?php echo get_core_vars( 'inner_head' );?>
<section id="w-f">
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo translate( 'install a new application' );?></p>
                    </div>
                     <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/installer-une-application" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
                        </a>
                    </div>
                </div>
               
            </header>
            <section class="scrollable wrapper"> 
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php echo fetch_error_from_url();?>
					<?php echo output('notice');?>
                    <div class="row">
                    	<div class="col-lg-6">
                        	<section class="panel">
                            	<div class="panel-heading"><?php _e( 'Install new app' );?></div>
                                <form method="post" class="panel-body" enctype="multipart/form-data">
                                	<div class="form-group">
                                    	<p><?php _e( sprintf( 'Install new app. The install file must necessary be a zip file, and should be compatible with your current Tendoo Version : <strong>%s</strong>. Be safe, and install app from secure provider.' , get( 'core_id' ) ) );?>
                                        <br />
                                        <?php echo tendoo_info( __( 'Themes and modules can be installed through this interface.' ) );?>
                                        </p>
                                        <label class="control-label"><?php _e( 'Choose your file' );?></label>
                                        <input name="installer_file" type="file" class="form-control">
                                    </div>
                                    <input type="submit" class="btn btn-info" value="<?php _e( 'Start installation' );?>" />
                                </form>
                            </section>
                        </div>
                        <!--
                        <div class="col-lg-6">
                        	<section class="panel">
                            	<div class="panel-heading">Depuis une adresse url</div>
                                <form method="post" class="panel-body" enctype="multipart/form-data">
                                	<div class="form-group">
                                    	<p>L'adresse vers laquelle le fichier d'installation de l'application Tendoo sera t&eacute;l&eacute;charger doit être une adresse valide, Assurez-vous que le fichier &agrave; t&eacute;l&eacute;charger soit un fichier compatible &agrave; la version actuelle de tendoo. La version actuelle est : <strong><?php echo get('core_version');?></strong>. </p>
                                        <p class="control-label"><strong>Application Tendoo</strong></p>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <input  class="form-control" name="installer_link" type="text" placeholder="Lien, exemple : https://codeload.github.com/Blair2004/Tendoo-cms/zip/master">
                                            </div>
                                            <div class="col-lg-5">
                                                <select name="downloadType" class="form-control">
                                                    <option value="">Proc&eacute;d&eacute; de d&eacute;compression</option>
                                                    <option value="github">Utiliser le dossier de la racine</option>
                                                    <option value="default">Normal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Installer" />
                                    <hr class="line line-dashed">
                                        <p>Le proc&eacute;d&eacute; de d&eacute;compression permet d'indiquer que le fichier zip qui sera t&eacute;l&eacute;charg&eacute; peut contenir un dossier &agrave; la racine qui est inexploitable par Tendoo, mais qui contient l'application. En choissant <strong>"Utiliser le dossier de la racine"</strong> Tendoo utilisera le permier dossier de la racine comme dossier de l'application. En revanche en selectionant <strong>"Normal"</strong> Tendoo consid&egrave;rera que le fichier zip contient toute l'application.</p> 
                                </form>
                            </section>
                        </div>
                        -->
					</div>
                </section>
        </section>
    </section>