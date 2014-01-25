<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
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
                <section class="wrapper"> 
					<?php echo $this->core->notice->parse_notice();?> 
					<?php echo $success;?>
                    <?php echo notice_from_url();?>
                    <?php echo Tendoo_info('Afin de pouvoir li&eacute;er un contr&ocirc;leur que vous avez cr&eacute;e &agrave; une page HTML, ils est n&eacute;cessiare que ce contr&ocirc;leur ait comme module ce module');?>
                	<section class="panel">
                    	<div class="panel-heading">
                        Liste des contr&ocirc;leurs compatibles
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th>Nom du contr&ocirc;leur</th>
                                        <th>Attach&eacute; &agrave; un contenu</th>
                                        <th>Acc&eacute;der au contenu</th>
                                        <th>Lien vers la page</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
                                    if(is_array($supportedPages))
                                    {
                                        foreach($supportedPages as $s)
                                        {
                                            $control	=	$this->core->tendoo_admin->get_pages($s['PAGE_CNAME']);
                                            $isAttached	=	$rtp_lib->isAttached($s['ID']);
                                            ?>
                                    <tr>
                                        <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$data['_Tendoo_vars']['module'][0]['ID'],'page_edit',$s['PAGE_CNAME']));?>"><?php echo $s['PAGE_NAMES'];?></a></td>
                                        <td><?php echo $isAttached == true ? "Oui" : "Non";?></td>
                                        <td>
                                            <?php
                                            if($isAttached)
                                            {
                                                ?>
                                                <a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$isAttached['MODULE']['ID'],'page_edit',$isAttached['PAGE_HTML'][0]['ID']));?>"><?php echo $s['PAGE_NAMES'];?></a>
                                                <?php
                                            }
                                            else
                                            {
                                                echo 'Indisponible';
                                            }
                                            ?>
                                        </td>
                                        <td><a href="<?php echo $this->core->url->site_url(array($s['PAGE_CNAME']));?>"><?php echo $this->core->url->site_url(array($s['PAGE_CNAME']));?></a></td>
                                    </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                    <tr>
                                        <td colspan="4">Aucun contr&ocirc;leur pris en charge</td>
                                    </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                    
                </div>
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm"></small> </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                     <?php 
					 if(isset($paginate))
					 {
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                            <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
							<?php
						}
					}
					 }
				?>
                    </ul>
                </div>
            </div>
        </footer>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>