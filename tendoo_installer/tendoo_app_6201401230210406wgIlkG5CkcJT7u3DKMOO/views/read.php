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
               <div class="row">
                  <div class="col-lg-8 col-sm-8">
                     <section class="panel">
                        <div class="panel-body">
                           <?php
								$user	=	$this->users_global->getUser($getSpeContact[0]['USER_ID']);
								if($user)
								{
									$nameSurname	=	$user['NAME'].' - '.$user['SURNAME'];
								}
								else
								{
									$nameSurname	=	'';
								}
								?>
                           <div class="clearfix m-b"> <small class="text-muted pull-right"><?php echo $this->instance->date->timespan($getSpeContact[0]['DATE']);?></small> <a href="#" class="thumb-sm pull-left m-r"> <img src="" class="img-circle bg-danger"> </a>
                              <div class="clear"> <a href="#"><strong><?php echo ucwords($getSpeContact[0]['USER_NAME']).' ['.$nameSurname.']';?></strong></a> <small class="block text-muted"><?php echo $getSpeContact[0]['USER_COUNTRY'] == '0' ? 'Pays Inconnu' : $getSpeContact[0]['USER_COUNTRY'];?>, <?php echo $getSpeContact[0]['USER_CITY']  == '0' ? 'Ville Inconnu' : $getSpeContact[0]['USER_CITY'];?></small> </div>
                           </div>
                           <p> <?php echo $getSpeContact[0]['USER_CONTENT'];?> </p>
                        </div>
                        <footer class="panel-footer pos-rlt">
                           <div class="row">
                              <div class="col-lg-4"> <span class="text-muted">@ : <?php echo $getSpeContact[0]['USER_MAIL'];?></span> </div>
                              <div class="col-lg-4"> <span class="text-muted"><i class="icon-phone"></i> : <?php echo $getSpeContact[0]['USER_PHONE'] == '0' ? 'indisponible' : $getSpeContact[0]['USER_PHONE'];?></span> </div>
                              <div class="col-lg-4"> <span class="text-muted">www : <?php echo $getSpeContact[0]['USER_WEBSITE'] == '0' ? 'Indisponible' : $getSpeContact[0]['USER_WEBSITE'];?></span> </div>
                           </div>
                        </footer>
                        <footer class="panel-footer pos-rlt"> <span class="arrow top"></span> 
                        <a href="<?php echo $this->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$getSpeContact[0]['ID']));?>" class="btn btn-danger btn-sm">Supprimer le message</a> 
                        <a href="<?php echo $this->url->site_url(array('admin','open','modules',$module[0]['ID']));?>" class="btn btn-info btn-sm">Revenir</a> </footer>
                     </section>
                  </div>
                  <div class="col-lg-4">
                  <?php
						if($user)
						{
							if(strtolower($user['PSEUDO']) != strtolower($this->users_global->current('PSEUDO')))
							{
						?>
                        <form method="post">
                     <section class="panel">
                           <textarea class="form-control input-lg no-border" name="messageToSender" rows="8" placeholder="R&eacute;pondre &agrave; <?php echo ucwords($user['PSEUDO']);?>..."></textarea>
                        <footer class="panel-footer bg-light lter">
                        	<input type="hidden" name="userTo" value="<?php echo $user['PSEUDO'];?>" />
                           <button class="btn btn-info pull-right" type="submit">R&eacute;pondre</button>
                           <ul class="nav nav-pills">
                           </ul>

                        </footer>
                     </section>
                        </form>
						<?php
							}
							else
							{
								?>
                        <section class="panel">
                        <div class="panel-heading">Erreur</div>
                        <div class="panel-body">
                        	<?php echo tendoo_warning('Vous ne pouvez vous faire un message ...');?>
                        </div>
                     </section>
                        <?php
							}
						}
						else
						{
							?>
                     <section class="panel">
                        <div class="panel-heading">Erreur</div>
                        <div class="panel-body">
                        	<?php echo tendoo_warning('Cet utilisateur n\'est pas inscrit pour recevoir une r&eacute;ponse.');?>
                        </div>
                     </section>
                     <?php
						}
						?>
                  </div>
               </div>
            </section>
         </section>
      </section>
      <footer class="footer bg-white b-t"> </footer>
      </section>
      </section>
      <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
