<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-heading"> Param&ecirc;tres avanc&eacute;s </div>
                            <div class="panel-body">
                            	<p class="paragraph">Avec la gestion de la vitrine, personnaliser votre page d'accueil. D&eacute;finissez les &eacute;l&eacute;ments qui apparaissent et leur quantit&eacute;. La vitrine est divis&eacute;e en plusieurs parties, dans chaque partie, veuillez choisir les informations qui doivent &ecirc;tre affich&eacute;ees.</p>
                                    <div class="span8">
                                        <form method="post">
                                            <div class="checkbox"> 
                                                <label class="checkbox-custom"> 
                                                	<input type="checkbox" name="allowPublicComment" checked="checked"> 
                                                    <i class="icon-unchecked"></i>
                                                    Carroussel et &eacute;l&eacute;ments assimil&eacute;s 
                                                    <input class="btn btn-sm btn-info" type="submit" value="<?php
                        echo $element	=	($elementOptions['CAROUSSEL']	=== TRUE) ? 'Retirer de la vitrine' : 'Ajouter &agrave; la vitrine';?>" name="toggle_carroussel" style="margin-left:10px;" />
                        						</label> 
                        					</div>
                                        </form>
                                    </div>
                                    <div class="span8">
                                        <form method="post">
                                            <?php
                        		if(is_array($newsModule) && count($newsModule) > 0)
                        		{
									?>
                                            <div class="bg-primary" style="padding:10px">
                                                <h4 class="fg-color-white">Gestionnaire d'articles ou publications</h4>
                                                <div class="checkbox">
                                                <label class="checkbox-custom"> 
                                                	<input type="checkbox" name="allowPublicComment" checked="checked"> 
                                                    <i class="icon-unchecked"></i>
                                                    Afficher les articles ou publications
                                                    <input class="form-control" type="checkbox" name="on_caroussel" <?php
                                        echo $response	=	((bool)$newsOptions['CAROUSSEL']['SHOW'] === TRUE) ? 'checked="checked"' : ''
                                        ;?> value="TRUE"/>
                        						</label>
                                                </div>
                                                    
                                                <label>Nombre total des articles ou publications	:
                                                    <select name="caroussel_art_limit">
                                                        <?php
                                            for($i = 1;$i <= 20;$i++)
                                            {
                                                if($i == $newsOptions['CAROUSSEL']['LIMIT'])
                                                {
                                                    ?>
                                                        <option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
                                                        <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                }
                                            }
                                            ?>
                                                    </select>
                                                </label>
                                                <?php
                                        echo $newsOptionNotice->parse_notice();
                                        ?>
                                                <p>
                                                    <input type="submit" value="Enregistrer" />
                                                </p>
                                            </div>
                                            <?php
								}
                        		else
                        		{
								?>
                                            <p class="paragraph">Le gestionnaire d'article et de publication n'est pas install&eacute;, il ne peut pas figurer parmis les &eacute;l&eacute;ment de la vitrine</p>
                                            <?php
								};
                        		?>
                                        </form>
                                    </div>
                                    <div class="span8" style="margin-top:10px;">
                                        <form method="post" class="panel-body">
                                        	<div class="form-group"> 
                                                <label class="checkbox-custom">A la une et &eacute;l&eacute;ments assimil&eacute;s</label>
                                                <input class="btn btn-info btn-sm" type="submit" value="<?php
                                echo $element	=	($elementOptions['ONTOP']	=== TRUE) ? 'Retirer de la vitrine' : 'Ajouter &agrave; la vitrine';?>" name="toggle_ontop" />
											</div>
                                        </form>
                                    </div>
                                    <div class="span8">
                                        <form method="post">
                                            <?php
                                    if(is_array($newsModule) && count($newsModule) > 0)
                                    {
                                        ?>
                                            <div class="bg-color-darken fg-color-white" style="padding:10px;">
                                                <h4 class="fg-color-white">Gestionnaire d'articles ou publications</h4>
                                                <label>Afficher les articles ou publications	:
                                                    <input type="checkbox" name="news_showed_ontop" <?php
                                        echo $response	=	((bool)$newsOptions['ONTOP']['SHOW'] === TRUE) ? 'checked="checked"' : ''
                                        ;?> value="TRUE"/>
                                                </label>
                                                <label>Nombre total des articles ou publications	:
                                                    <select name="news_showed_ontop_limit">
                                                        <?php
                    for($i = 1;$i <= 20;$i++)
                    {
                        if($i == $newsOptions['ONTOP']['LIMIT'])
                        {
						?>
                                                        <option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
                                                        <?php
						}
						else
						{
							?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
						}
					}
					?>
                                                    </select>
                                                </label>
                                                <br />
                                                <?php echo $onTopNewsNotice->parse_notice();?>
                                                <p>
                                                    <input type="submit" value="Enregistrer" />
                                                </p>
                                            </div>
                                            <?php
				}
				else
				{
					?>
                                            <p class="paragraph">Le gestionnaire d'article et de publication n'est pas install&eacute;, il ne peut pas figurer parmis les &eacute;l&eacute;ment de la vitrine</p>
                                            <?php
				};
				?>
                                        </form>
                                    </div>
                                    <div class="span8" style="margin-top:10px;">
                                        <form method="post">
                                            <h5 class="float_box">Bloc d'information et &eacute;l&eacute;ments assimil&eacute;s<span class="floatR">
                                                <input type="submit" style="margin-left:10px;" value="<?php
                                echo $element	=	($elementOptions['INFOSMALLDETAILS']	=== TRUE) ? 'Retirer de la vitrine' : 'Ajouter &agrave; la vitrine';?>" name="toogle_infosmalldetails" />
                                                </span></h5>
                                        </form>
                                    </div>
                                    <div class="span8" style="margin-top:10px;">
                                        <form method="post">
                                            <?php
                            if(is_array($newsModule) && count($newsModule) > 0)
                            {
                                ?>
                                            <div class="bg-color-blue fg-color-white" style="padding:10px;">
                                                <h4 class="fg-color-white">Gestionnaire d'articles ou publications</h4>
                                                <label>Afficher les articles ou publications	:
                                                    <input type="checkbox" name="news_on_infodetails" <?php
                                echo $response	=	((bool)$newsOptions['INFOSMALLDETAILS']['SHOW'] === TRUE) ? 'checked="checked"' : ''
                                ;?> value="TRUE"/>
                                                </label>
                                                <label>Nombre total des articles ou publications	:
                                                    <select name="infodetails_art_limit">
                                                        <?php
                                            for($i = 1;$i <= 20;$i++)
                                            {
                                                if($i == $newsOptions['INFOSMALLDETAILS']['LIMIT'])
                                                {
                                                    ?>
                                                        <option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
                                                        <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
                                                }
                                            }
                                            ?>
                                                    </select>
                                                </label>
                                                <br />
                                                <?php echo $Sf_newsNotice->parse_notice();?>
                                                <p>
                                                    <input type="submit" value="Enregistrer" />
                                                </p>
                                            </div>
                                            <?php
                            }
                            else
                            {
                                ?>
                                            <p class="paragraph">Le gestionnaire d'article et de publication n'est pas install&eacute;, il ne peut pas figurer parmis les &eacute;l&eacute;ment de la vitrine</p>
                                            <?php
                            };
                            ?>
                                        </form>
                                    </div>
                            </div>
                        </section>
                    </div>
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
