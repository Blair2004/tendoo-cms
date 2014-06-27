<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo output('notice');?>  <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                    <section class="panel">
                        <div class="panel-heading"> Les des messages </div>
                        <table class="table table-striped b-t text-sm">
                            <thead>
                                <tr>
                                    <th width="150">Auteur du message</th>
                                    <th>Membre du site <?php echo $options[0]['SITE_NAME'];?></th>
                                    <th>Email</th>
                                    <th>Date de publication</th>
                                    <th>Etat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							if($retreiContact)
							{
								foreach($retreiContact as $f)
								{
								?>
                                <tr>
                                	<td><a href="<?php echo $this->url->site_url(array('admin','open','modules',$module[0]['ID'],'check',$f['ID']));?>"><?php echo $f['USER_NAME'];?></a></td>
                                    <td><?php echo $this->users_global->getUser($f['USER_ID']) == true ? 'Oui' : 'Non';?></td>
                                    <td><?php echo $f['USER_MAIL'];?></td>
                                    <td><?php echo $this->instance->date->timespan($f['DATE']);?></td>
                                    <td><?php echo $f['STATE'] == '0' ? 'Non lu' : 'Lu';?></td>
                                    <td><a href="<?php echo $this->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$f['ID']));?>">Supprimer</a></td>
                                </tr>
                                <?php
								}
							}
							else
							{
								?>
                                <tr>
                                	<th colspan="5">Aucun message disponible.</th>
                                </tr>
                                <?php
							}
							?>
                            </tbody>
                        </table>
                    </section>
                </section>
            </section>
        </section>
        <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-4">
                        
                    </div>
                    <div class="col-sm-4 text-center">  </div>
                    <div class="col-sm-4 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <?php 
					if(is_array($paginate[4]))
					{
						foreach($paginate[4] as $p)
						{
							?>
                            <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
                            <?php
						}
					}
				?>
                        </ul>
                    </div>
                </div>
            </footer>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
