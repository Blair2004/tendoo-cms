<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted">Installer une application hubby</p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> 
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php echo notice_from_url();?>
					<?php echo $this->core->notice->parse_notice();?>
                    <?php echo $success;?>
                    <div class="row">
                    	<div class="col-lg-6">
                        	<section class="panel">
                            	<div class="panel-heading">Envoyer un fichier</div>
                                <form method="post" class="panel-body" enctype="multipart/form-data">
                                	<div class="form-group">
                                    	<p>Installer une application. Le fichier doit n&eacute;cessairement est constitu&eacute; sous forme de fichier zip. Cette application doit &ecirc;tre compatible avec la verison actuelle du CMS. la version actuelle est : <strong><?php echo $this->core->hubby->getVersion();?></strong>. Assurez-vous d'avoir t&eacute;l&eacute;charger cette application depuis un emplacement s&ucirc;r.</p>
                                        <label class="control-label">Application Hubby</label>
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
                                    	<p>L'adresse vers laquelle le fichier d'installation de l'application hubby sera t&eacute;l&eacute;charger doit être une adresse valide, Assurez-vous que le fichier &agrave; t&eacute;l&eacute;charger soit un fichier compatible &agrave; la version actuelle d'hubby. La version actuelle est : <strong><?php echo $this->core->hubby->getVersion();?></strong>. </p>
                                        <p class="control-label"><strong>Application Hubby</strong></p>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <input  class="form-control" name="installer_link" type="text" placeholder="Lien, exemple : https://codeload.github.com/Blair2004/hubby-cms/zip/master">
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
                                        <p>Le proc&eacute;d&eacute; de d&eacute;compression permet d'indiquer que le fichier zip qui sera t&eacute;l&eacute;charg&eacute; peut contenir un dossier &agrave; la racine qui est inexploitable par hubby, mais qui contient l'application. En choissant <strong>"Utiliser le dossier de la racine"</strong> Hubby utilisera le permier dossier de la racine comme dossier de l'application. En revanche en selectionant <strong>"Normal"</strong> Hubby consid&egrave;rera que le fichier zip contient toute l'application.</p> 
                                </form>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>