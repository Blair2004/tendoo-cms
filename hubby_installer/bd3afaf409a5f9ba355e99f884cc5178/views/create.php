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
                    <div class="col-lg-6">
                        <section class="panel">
                            <div class="panel-heading"> Widget Simple </div>
                            <div class="panel-body">
                                <form method="post">
                                    <div class="form-group text">
                                        <label class="label-control">Intitul&eacute; du widget</label>
                                        <input class="form-control" type="text" name="widget_title" placeholder="Intitulé du widget" />
                                    </div>
                                    <div class="form-group">
                                        <label class="label-control">Description du widget</label>
                                        <textarea class="form-control" name="widget_description" placeholder="Description du widget"></textarea>
                                    </div>
                                    <div class="form-group textarea">
                                        <label class="label-control">Contenu du widget</label>
                                        <?php echo $this->core->hubby->getEditor(array('id'=>'editor','name'=>'widget_content','placeholder'=>"Contenu du widget"));?> </div>
                                    <p>
                                        <input class="btn btn-info btn-sm" type="submit" value="Cr&eacute;er le widget" />
                                    </p>
                                </form>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel">
                            <div class="panel-heading">Widget avanc&eacute;</div>
                            <div class="panel-body">
                                <form method="post">
                                    <div class="form-group">
                                    	<label class="label-control">Intitulé du widget</label>
                                        <input class="form-control" type="text" name="widget_title" placeholder="Intitulé du widget" />
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Description du widget</label>
                                        <textarea class="form-control" name="widget_description" placeholder="Description du widget"></textarea>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Extension des modules (widgets disponible)</label>
                                        <select class="form-control" name="widget_ref">
                                            <option value="">Choisir...</option>
                                            <?php
						if(is_array($finalMod))
						{
							foreach($finalMod as $f)
							{
								?>
                                            <option value="<?php echo $f['MODULE_NAMESPACE'];?>/<?php echo $f['WIDGET_NAMESPACE'];?>"><?php echo $f['WIDGET_HUMAN_NAME'];?></option>
                                            <?php
							}
						}
						?>
                                        </select>
                                    </div>
                                    <p>
                                        <input class="btn btn-info btn-sm" name="createSpecial" type="submit" value="Cr&eacute;er le widget" />
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
