<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
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
					<?php echo validation_errors(); ?> 
                    <section class="panel">
                        <div class="panel-heading"> Cr&eacute;er une nouvelle page </div>
                        <div class="span8"> 
                            <form method="post" class="panel-body">
                                <div class="form-group text">
                                    <input class="form-control" type="text" name="page_title" placeholder="Titre">
                                </div>
                                <div class="form-group text">
                                    <input class="form-control" type="text" name="page_description" placeholder="Description">
                                </div>
                                <div class="form-group textarea">
                                    <?php echo $this->core->tendoo->getEditor(array('name'=>'page_content','id'=>'editor'));?>
                                </div>
                                <input class="btn btn-info btn-sm" type="submit" value="Cr&eacute;er la page">
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
