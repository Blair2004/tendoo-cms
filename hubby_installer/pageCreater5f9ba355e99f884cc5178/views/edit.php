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
                    <section class="panel">
                        <div class="panel-heading"> Modifier une page </div>
                        <div class="span8"> 
                            <form method="post" action="" class="panel-body">
                                <div class="form-group text">
                                	<label class="label-control">Titre de la page</label>
                                    <input class="form-control" type="text" name="page_title" value="<?php echo $pageInfo[0]['TITLE'];?>" placeholder="Titre">
                                </div>
                                <div class="form-group text">
	                                <label class="label-control">Description de la page</label>
                                    <input class="form-control" type="text" name="page_description" value="<?php echo $pageInfo[0]['DESCRIPTION'];?>" placeholder="Description">
                                </div>
                                <div class="form-group text">
                                    <label for="page_content"><span>Contenu</span> :</label>
                                    <?php echo $this->core->hubby->getEditor(array('width'=>900,'height'=>500,'name'=>'page_content','id'=>'editor','defaultValue'=>$pageInfo[0]['CONTENT']));?>
                                </div>
                                <hr class="specialline">
                                <input type="hidden" name="page_id" value="<?php echo $pageInfo[0]['ID'];?>">
                                <input type="submit" value="Modifier la page">
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>