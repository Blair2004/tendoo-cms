<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted">Installer une application Tendoo</p>
                    </div>
                     <div class="col-sm-8">
                        <button data-step="1" data-position="left" data-intro="<strong>Bienvenue sur Tendoo <?php echo TENDOO_VERSION;?></strong><br>Nous allons maintenant vous présenter Tendoo, si vous êtes prêt cliquez sur 'Suivant'.<br><br>Vous pouvez également utiliser les flèches directionnelles pour naviguer dans cette visite guidée." launch_visit type="button" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i><?php 
                      if($this->users_global->current('ADMIN_INDEX_VISIT') == '0')
                      {
                      ?> <span>Cliquez pour une visite</span><?php
                      }
                      ?></button>
                      </div>
                      <?php 
                      if($this->users_global->current('ADMIN_INDEX_VISIT') == '0')
                      {
                      ?>
                        <script type="text/javascript">
                            $('[launch_visit]').bind('click',function(){
                                tendoo.doAction('<?php echo $this->url->site_url(array('admin','ajax','setViewed?page=ADMIN_INDEX_VISIT'));?>',function(){
                                },{});
                            });
                        </script>
                      <?php
                      }
                      ?>
                      
                    </div>
                </div>
               
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> 
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php echo fetch_error_from_url();?>
					<?php echo output('notice');?>
                    <div class="row">
                    	<div class="col-lg-6">
                        	<section class="panel">
                            	<div class="panel-heading">Envoyer un fichier</div>
                                <form method="post" class="panel-body" enctype="multipart/form-data">
                                	<div class="form-group">
                                    	<p>Installer une application. Le fichier doit n&eacute;cessairement est constitu&eacute; sous forme de fichier zip. Cette application doit &ecirc;tre compatible avec la verison actuelle du CMS. la version actuelle est : <strong><?php echo get('core_version');?></strong>. Assurez-vous d'avoir t&eacute;l&eacute;charger cette application depuis un emplacement s&ucirc;r.</p>
                                        <label class="control-label">Application Tendoo</label>
                                        <input name="installer_file" type="file" class="form-control">
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Installer" />
                                </form>
                            </section>
                        </div>
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
					</div>
                </section>
            </section>
        </section>
    </section>