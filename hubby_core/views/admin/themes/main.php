<div id="body">
    <div class="page secondary with-sidebar">
        <div id="canvasBubbles" style="position:absolute; top:0; height:100px; width:100%;float:left;"></div>
        <div class="page-header" style="position:relative;">
            <div class="page-header-content">
                <h1>Gestionnaire des th&egrave;mes<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','menu'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="body-text">
                    <h2>Liste des th&egrave;mes</h2>
                    <div>
                        <?php echo validation_errors('<p class="error">', '</p>');?>
                        <?php $this->core->notice->parse_notice();?>
                        <?php echo notice_from_url();?>
                    </div>
                    <br />
                	<table class="hub_table bordered">
                        <thead>
                            <tr>
                                <td >Nom</td>
                                <td >Auteur</td>
                                <td >Description</td>
                                <td >Etat</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($Themes))
                        {
                            if(count($Themes) > 0)
                            {
                                foreach($Themes as $t)
                                {
                                    if($t['ACTIVATED']== '')
                                    {
                                        $t['ACTIVATED']	= 'Inactif';
                                    }
                                    else if($t['ACTIVATED']	==	 'TRUE')
                                    {
                                        $t['ACTIVATED']	=	'Activ&eacute;';
                                    }
                                ?>
                            <tr>
                                <td ><a class="view" href="<?php echo $this->core->url->site_url(array('admin','themes','config',$t['ID']));?>"><?php echo $t['NAMESPACE'];?></a></td>
                                <td ><?php echo $t['AUTHOR'];?></td>
                                <td ><?php echo $t['DESCRIPTION'];?></td>
                                <td ><?php echo $t['ACTIVATED'];?></td>
                                <td ><a class="view" href="<?php echo $this->core->url->site_url(array('admin','themes','manage',$t['ID']));?>">Param&ecirc;tre avanc&eacute;</a></td>
                            </tr>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                            <tr>
                                <td colspan="5">Aucun th&egrave;me n'est install&eacute;.</td>
                            </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>