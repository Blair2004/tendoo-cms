<?php 
if(isset($loadSection))
{
	if($loadSection == 'main')
	{
		?>

<div id="body">
  <div class="page secondary with-sidebar">
    <div class="page-header">
      <div class="page-header-content">
        <h1>Gestionnaire de contenu<small></small></h1>
        <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a> </div>
    </div>
    <?php echo $lmenu;?>
    <div class="page-region">
      <div class="page-region-content">
        <div class="hub_table"> <?php echo notice_from_url();?>
          <div class="grid">
            <div class="row">
              <p class="paragraph">Avec la gestion de la vitrine, personnaliser votre page d'accueil. D&eacute;finissez les &eacute;l&eacute;ments qui apparaissent et leur quantit&eacute;. La vitrine est divis&eacute;e en plusieurs parties, dans chaque partie, veuillez choisir les informations qui doivent &ecirc;tre affich&eacute;ees.</p>
              <div class="span8">
                <form method="post">
                  <h2 class="float_box">Carroussel et &eacute;l&eacute;ments assimil&eacute;s <span class="floatR">
                    <input type="submit" value="<?php
                        echo $element	=	($elementOptions['CAROUSSEL']	=== TRUE) ? 'Retirer de la vitrine' : 'Ajouter &agrave; la vitrine';?>" name="toggle_carroussel" style="margin-left:10px;" />
                    </span></h2>
                </form>
              </div>
              <div class="span8">
                <form method="post">
                  <?php
                        		if(is_array($newsModule) && count($newsModule) > 0)
                        		{
									?>
                  <div class="bg-color-green fg-color-white" style="padding:10px">
                    <h4 class="fg-color-white">Gestionnaire d'articles ou publications</h4>
                    <label>Afficher les articles ou publications
                      <input type="checkbox" name="on_caroussel" <?php
                                        echo $response	=	((bool)$newsOptions['CAROUSSEL']['SHOW'] === TRUE) ? 'checked="checked"' : ''
                                        ;?> value="TRUE"/>
                    </label>
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
                <form method="post">
                  <h2>A la une et &eacute;l&eacute;ments assimil&eacute;s <span class="floatR">
                    <input type="submit" value="<?php
                                echo $element	=	($elementOptions['ONTOP']	=== TRUE) ? 'Retirer de la vitrine' : 'Ajouter &agrave; la vitrine';?>" name="toggle_ontop" />
                    </span> </h2>
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
                  <h2 class="float_box">Bloc d'information et &eacute;l&eacute;ments assimil&eacute;s<span class="floatR">
                    <input type="submit" style="margin-left:10px;" value="<?php
                                echo $element	=	($elementOptions['INFOSMALLDETAILS']	=== TRUE) ? 'Retirer de la vitrine' : 'Ajouter &agrave; la vitrine';?>" name="toogle_infosmalldetails" />
                    </span></h2>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
	}
}
else
{
	?>
Error Occured During loading.
<?php
}
?>
