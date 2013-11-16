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
					</div>
                </section>
            </section>
        </section>
    </section>