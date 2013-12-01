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
                <section class="wrapper"> 
					<?php echo $this->core->notice->parse_notice();?> 
					<?php echo $success;?> 
					<?php echo notice_from_url();?>
					<?php echo validation_errors(); ?> 
                    <div class="col-lg-6">
                    	<section class="panel">
                        <div class="panel-heading"> Param&ecirc;tres avanc&eacute;s </div>
                        <div class="span8">
                        <form method="post" class="panel-body">
                                <label  class="label-control switch" >
                                	<input type="checkbox" name="validateall" value="true" 
                                    <?php
                                    if($setting)
                                    {
                                        if(array_key_exists('APPROVEBEFOREPOST',$setting))
                                        {
                                        if($setting['APPROVEBEFOREPOST'] == "1")
                                        {
                                        ?>
                                        checked="checked"
                                        <?php
                                        }
                                    }
                                    }
                                    ?> />
									<span></span>
                                    <p style="display:inline-block;vertical-align:bottom;">Valider chaque commentaire avant de l'afficher</p>	
                                </label>
                            <label  class="label-control switch" style="vertical-align:inherit;">
                            	<input type="checkbox" name="allowPublicComment" value="true" <?php
								if($setting)
								{
									if(array_key_exists('EVERYONEPOST',$setting))
									{
										if($setting['EVERYONEPOST'] == "1")
										{
										?>
										checked="checked"
										<?php
										}
									}
								}
								?> />
                                <span class="helper"></span>
                                <p style="display:inline-block;vertical-align:bottom;">Commentaire ouvert au public</p>	
                            </label>
                            <hr class="line line-dashed" />
                            <input class="btn btn-sm btn-info" type="submit" value="Enregistrer les modifications" name="update">
                        </form>
                        </div>
					</section>
                    </div>
                    <div class="col-lg-6">
                        <section class="panel">
                            <div class="panel-heading">Param&ecirc;tres des widgets</div>
                            <div class="panel-body">
                            <h5>Widget - Categories</h5>
                            <form method="post">
                                <div class="form-group">
                                    <select name="limitcat" class="form-control">
                                        <option value="">Nombre total d'affichage</option>
                                        <?php
                                        for($i=1;$i<=50;$i++)
                                        {
                                            if($setting)
                                            {
                                                if(array_key_exists('WIDGET_CATEGORY_LIMIT',$setting))
                                                {
                                                    if($setting['WIDGET_CATEGORY_LIMIT']	==	$i)
                                                    {
                                                        ?>
                                            <option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php
                                                    }
                                                }
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
                                </div>
                                <input name="limit_submiter" type="submit" value="Enregistrer" class="btn btn-sm btn-info" />
                            </form>
                            </div>
                            <hr class="line" />
                            <div class="panel-body">
                            	<h5>Widget - Les articles les plus lues</h5>
                            	<form method="post">
                                <div class="form-group">
                                    <select class="form-control" name="mostreaded">
                                        <option value="">Nombre total d'affichage</option>
                                        <?php
                                        for($i=1;$i<=50;$i++)
                                        {
                                            if($setting)
                                            {
                                                if(array_key_exists('WIDGET_MOSTREADED_LIMIT',$setting))
                                                {
                                                    if($setting['WIDGET_MOSTREADED_LIMIT']	==	$i)
                                                    {
                                                        ?>
                                            <option selected="selected" value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                            <?php
                                                    }
                                                }
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
                                </div>
                                <input name="mostreaded_submiter" type="submit" value="Enregistrer" class="btn btn-sm btn-info" />
                            </form>
                            </div>
						</section>
					</div>
                    </section>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>