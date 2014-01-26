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
                	<section class="panel">
                    	<div class="panel-heading">
                        Attributeur de contenu & modification
                        </div>
                        <div class="wrapper">
                            <?php echo Tendoo_info("Le contenu dont il s'agit est une page cr&eacute;e depuis le module : Editeur de page HTML");?>
                            <form method="post" class="panel-body">
                            <div class="form-group select">
                            	<select name="content_id" class="form-control">
                                    <option value="">Choisir un contenu</option>
                                    <?php
									if(count($pageList) > 0)
									{
										foreach($pageList as $p)
										{
											if($p['ID']	==	$attachement['PAGE_REFTOPAGE']['PAGE_HTML'])
											{
										?>
									<option selected="selected" value="<?php echo $p['ID'];?>"><?php echo $p['TITLE'];?></option>
                                        <?php
											}
											else
											{
										?>
									<option value="<?php echo $p['ID'];?>"><?php echo $p['TITLE'];?></option>
                                        <?php
											}
										}
									}
									?>
                                </select>
                            </div>
                            <input type="hidden" value="<?php echo $control[0]['ID'];?>" name="page_id" />
                            <input class="btn btn-success btn-sm" type="submit" value="Affecter le contenu">
                        </form>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>