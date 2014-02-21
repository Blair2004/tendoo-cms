<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                    
                </div>
                <div class="col-sm-4 text-center">  </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <?php 
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                        <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
                        <?php
						}
					}
				?>
                    </ul>
                </div>
            </div>
        </footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                    <div class="row">
                        <div class="col-lg-8">
                            <section class="panel">
                                <div class="panel-heading"> Liste des modules installés </div>
                                <table class="table table-striped">
                                    <tbody>
                                        <?php
                                            if($mod_nbr > 0)
                                            {
                                                foreach($modules as $mod)
                                                {
                                                    $appIcon	=	$this->core->tendoo_admin->getAppImgIco($mod['NAMESPACE']);
                                                    ?>
                                        <tr>
                                            <td>
                                            <a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$mod['ID']));?>">
											<?php
                                                    if($appIcon)
                                                    {
                                                    ?>
                                                <img src="<?php echo $appIcon;?>" style="height:70px;width:70px;">
                                                <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                <i class="icon-puzzle-piece" style="font-size:70px;float:left;height:70px;width:70px;"></i>
                                                <?php
                                                    }
                                                    ?>
                                                    </a></td>
                                            <td class="action"><strong> <a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$mod['ID']));?>"><?php echo $mod['HUMAN_NAME'];?></a> </strong> <br>
                                                <em><small><?php echo $mod['AUTHOR'];?></small></em> <br>
                                                <?php echo $mod['DESCRIPTION'];?> <br>
                                                <small title="Unique : S'applique à un contr&ocirc;leur uniquement. Globale : S'applique &agrave; tous les contr&ocirc;leurs" style="font-size:10px;"><?php echo ($mod['TYPE'] == 'GLOBAL') ? 'Globale' : 'Unique';?></small>
                                                <strong><small style="float:right;font-size:10px;"><?php echo ($mod['APP_VERS'] == '') ? 'Version Inconnue' : 'v.'.$mod['APP_VERS'];?></small></strong></td>
                                            <td class="action"><a class="delete" href="<?php echo $this->core->url->site_url(array('admin','uninstall','module',$mod['ID']));?>"><i style="font-size:25px;" class="icon-trash" title="D&eacute;sintaller"></i></a></td>
                                            <td><?php
                                                    if($mod['ACTIVE'] == '0')
                                                    {
                                                        ?>
                                                <a class="delete" href="<?php echo $this->core->url->site_url(array('admin','active','module',$mod['ID']));?>"><i style="font-size:25px;" class="icon-remove-sign" title="Clickez pour activer"></i></a>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                <a class="delete" href="<?php echo $this->core->url->site_url(array('admin','unactive','module',$mod['ID']));?>"><i style="font-size:25px;" class="icon-ok-sign" title="Clickez pour d&eacute;sactiver"></i></a>
                                                <?php
                                                    }
                                                    ?></td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                            else
                                            {
                            ?>
                                        <tr>
                                            <td colspan="6">Aucun module install&eacute;</td>
                                        </tr>
                                        <?php
                        }
                                            ?>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                        <div class="col-lg-4">
                            <section class="panel">
                                <div class="panel-heading">Rechercher une application</div>
                                <div class="panel-body">
                                	<p>Vous rechercher une application, tapez les mots cl&eacute;s qui caract&eacute;risent votre application. Exemple : "boutique eCommerce", "sitemap", "facebook". Assurez-vous d'avoir choisi le type de votre application (module ou th&egrave;me) et lancer votre recherche.</p>
                                    <div class="input-group">
                                        <input type="text" id="appendedInput" class="input-sm form-control">
                                        <div class="input-group-btn">
                                            <button class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown"> 
                                                <span class="dropdown-label">Choisir le type</span> 
                                                <span class="caret"></span> 
                                            </button>
                                            <ul class="dropdown-menu dropdown-select pull-right">
                                                <li class=""> 
                                                	<a href="#">
                                                    <input type="radio" value="Modules" name="type">
                                                    Module</a> 
												</li>
                                                <li class="active"> 
                                                	<a href="#">
                                                    <input type="radio" value="Themes" name="type">
                                                    Th&egrave;me</a> 
												</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr class="line line-dashed" />
                                    <input type="submit" value="Rechercher" class="btn btn-primary btn-sm" />
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
