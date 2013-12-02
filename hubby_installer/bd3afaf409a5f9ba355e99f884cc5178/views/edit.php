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
                    <section class="panel">
                        <div class="panel-heading"> Modifier le widget : <?php echo $getWidget[0]['WIDGET_HEAD'];?></div>
                        <div class="panel-body">
                            <?php
							if($getWidget[0]['WIDGET_REFERING_OBJ_NAMESPACE'] == '')
							{
							?>
                            <div class="span9">
                                <form method="post">
                                    <div class="form-group text">
                                        <input class="form-control"  type="text" name="widget_title" placeholder="Entrer l'intitulé du widget" value="<?php echo $getWidget[0]['WIDGET_HEAD'];?>" />
                                        <input class="form-control"  type="hidden" name="widget_id" value="<?php echo $getWidget[0]['ID'];?>" />
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control"  name="widget_description"><?php echo $getWidget[0]['WIDGET_DESCRIPTION'];?></textarea>
                                    </div>
                                    <div class="form-group textarea">
                                    <?php echo $this->core->hubby->getEditor(array('id'=>'editor','name'=>'widget_content','placeholder'=>"Contenu du widget",'defaultValue'=>$getWidget[0]['WIDGET_CONTENT']));?>
                                    </div>
                                    <p><input class="btn btn-info btn-sm"  type="submit" value="Modifer" /></p>
                                </form>
                            </div>
                            <?php
							}
							else
							{
								?>
							<div class="span9">
                                <form method="post">
                                    <div class="form-group text">
                                        <input class="form-control"  type="text" name="widget_title" placeholder="Entrer l'intitulé du widget" value="<?php echo $getWidget[0]['WIDGET_HEAD'];?>" />
                                        <input class="form-control"  type="hidden" name="widget_id" value="<?php echo $getWidget[0]['ID'];?>" />
                                    </div>
                                    <div class="form-group textarea">
                                        <textarea class="form-control"  name="widget_description"><?php echo $getWidget[0]['WIDGET_DESCRIPTION'];?></textarea>
                                    </div>
                                    <div class="form-group textarea">
                                    <select class="form-control"  name="widget_ref">
                                        <option value="">Choisir...</option>
                                        <?php
                                        if(is_array($finalMod))
                                        {
                                            foreach($finalMod as $f)
                                            {
												if($f['MODULE_NAMESPACE'].'/'.$f['WIDGET_NAMESPACE'] == $getWidget[0]['WIDGET_REFERING_OBJ_NAMESPACE'].'/'.$getWidget[0]['WIDGET_REFERING_NAME'])
												{
                                                ?>
                                        <option selected="selected" value="<?php echo $f['MODULE_NAMESPACE'];?>/<?php echo $f['WIDGET_NAMESPACE'];?>"><?php echo $f['WIDGET_HUMAN_NAME'];?></option>
                                                <?php
												}
												else
												{
												?>
                                        <option value="<?php echo $f['MODULE_NAMESPACE'];?>/<?php echo $f['WIDGET_NAMESPACE'];?>"><?php echo $f['WIDGET_HUMAN_NAME'];?></option>
                                                <?php
												}
                                            }
                                        }
                                        ?>
                                    </select>
                                  </div>
                                    <p><input class="btn btn-info btn-sm"  name="updateSpecial" type="submit" value="Modifer" /></p>
                                </form>
                            </div>
                                <?php
							}
							?>
                        </div>
                    </section>
                    
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>