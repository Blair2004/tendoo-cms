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
                        <div class="panel-heading"> Cr&eacute;er une cat&eacute;gogrie </div>
                        <div class="span8"> 
                            <form method="post" action="">
                                <div class="input-control text">
                                    <input type="text" name="page_title" placeholder="Titre">
                                </div>
                                <div class="input-control text">
                                    <input type="text" name="page_description" placeholder="Description">
                                </div>
                                <div class="input-control textarea">
                                    <?php echo $this->core->hubby->getEditor(array('name'=>'page_content','id'=>'editor'));?>
                                </div>
                                <input type="submit" value="Cr&eacute;er la page">
                            </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
