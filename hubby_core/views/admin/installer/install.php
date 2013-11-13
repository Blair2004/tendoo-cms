<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Installer une application<small>Module ou th&egrave;me.</small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','index'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <div>
                        <?php echo validation_errors('<p class="error">', '</p>');?>
                        <?php $this->core->notice->parse_notice();?>
                        <?php echo notice_from_url();?>
                    </div>
                    <div class="grid">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="span12 bg-color-red fg-color-white padding10">
                                <p>
                                Installer une application. Le fichier doit n&eacute;cessairement est constitu&eacute; sous forme de fichier zip. Cette application doit &ecirc;tre compatible avec la verison actuelle du CMS. la version actuelle est : <strong><?php echo $this->core->hubby->getVersion();?></strong>. Assurez-vous d'avoir t&eacute;l&eacute;charger cette application depuis un emplacement s&ucirc;r.</p>
                                <p><label>Application Hubby (Zip) :</label><input  type="file" name="installer_file"></p>
                                <input type="submit" value="Installer">
                                </div>
                            </div>
                        </form>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>