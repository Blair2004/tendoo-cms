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
        <section class="wrapper"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
          <div class="row">
            <div class="col-lg-4">
              <div class="panel">
                <div class="panel-heading"> Afficher les champs : </div>
                <div class="panel-body">
                <?php
				if(is_array($getFields) && count($getFields) > 0)
				{
					$visible	=	$getFields[0];
				?>
                  <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du nom</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input <?php echo $visible['SHOW_NAME'] == '1' ? 'checked="checked"' : '';?> type="checkbox" name="showName" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">De l'Email</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input <?php echo $visible['SHOW_MAIL'] == '1' ? 'checked="checked"' : '';?> type="checkbox" name="showEmail" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du num&eacute;ro de t&eacute;l&eacute;phone</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input <?php echo $visible['SHOW_PHONE'] == '1' ? 'checked="checked"' : '';?> type="checkbox" name="showPhone" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du site web</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input <?php echo $visible['SHOW_WEBSITE'] == '1' ? 'checked="checked"' : '';?> type="checkbox" name="showWebSite" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du pays</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input <?php echo $visible['SHOW_COUNTRY'] == '1' ? 'checked="checked"' : '';?> type="checkbox" name="showCountry" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du Ville</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input <?php echo $visible['SHOW_CITY'] == '1' ? 'checked="checked"' : '';?> type="checkbox" name="showCity" />
                          <span></span> </label>
                      </div>
                    </div>
                    <hr class="line line-dashed" />
                    <input type="submit" name="showFields" value="Enregistrer les modifications" class="btn btn-info" />
                  </form>
				<?php
				}
				else
				{
				?>
                  <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du nom</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input type="checkbox" name="showName" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">De l'Email</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input type="checkbox" name="showEmail" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du num&eacute;ro de t&eacute;l&eacute;phone</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input type="checkbox" name="showPhone" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du site web</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input type="checkbox" name="showWebSite" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du pays</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input type="checkbox" name="showCountry" />
                          <span></span> </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-7">
                        <label class="control-label">Du Ville</label>
                      </div>
                      <div class="col-sm-5">
                        <label class="switch">
                          <input type="checkbox" name="showCity" />
                          <span></span> </label>
                      </div>
                    </div>
                    <hr class="line line-dashed" />
                    <input type="submit" name="showFields" value="Enregistrer les modifications" class="btn btn-info" />
                  </form>
				<?php
				}
				?>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="panel">
                <div class="panel-heading"> <i class="icon-phone-sign"></i> Information de contact </div>
                <div class="panel-body">
                  <form method="post" class="form">
                    <div class="input-group">
                      <div class="row">
                        <div class="col-md-4">
                          <select name="contactType" class="form-control">
                            <option value="">Type</option>
                            <option value="phone">T&eacute;l&eacute;phone</option>
                            <option value="email">Email</option>
                            <option value="mobile">Mobile</option>
                            <option value="fax">Fax</option>
                            <option value="address">Boite Postale</option>
                            <option value="skype">Adresse Skype</option>
                            <option value="facebook">Adresse Facebook</option>
                            <option value="googleplus">Google +</option>
                            <option value="twitter">Twitter</option>
                          </select>
                        </div>
                        <div class="col-md-5">
                          <input type="text" class="form-control"  name="contactNew">
                        </div>
                        <span class="input-group-btn">
                        <button class="btn btn-info" type="submit" name="addContact">Ajouter</button>
                        </span> </div>
                    </div>
                  </form>
                  <hr class="line line-dashed" />
                  <section style="height:300px" class="scrollbar scroll-y m-b">
                    <?php
									if(is_array($getContact))
									{
										if(count($getContact) > 0)
										{
											foreach($getContact as $g)
											{
										?>
                    <form method="post" action="" class="form">
                      <div class="input-group"> <span class="input-group-btn">
                        <?php
												if($g['CONTACT_TYPE'] == 'phone')
												{
													?>
                        <button class="btn btn-default" type="submit"><i class="fa fa-phone"></i></button>
                        <?php	
												}
												else if($g['CONTACT_TYPE'] == 'email')
												{
													?>
                        <button class="btn btn-default" type="submit">@</button>
                        <?php	
												}
												else if($g['CONTACT_TYPE'] == 'mobile')
												{
													?>
                        <button class="btn btn-default" type="submit"><i class="fa fa-mobile"></i></button>
                        <?php	
												}
												else if($g['CONTACT_TYPE'] == 'address')
												{
													?>
                        <button class="btn btn-default" type="submit"><i class="fa fa-envelope-alt"></i></button>
                        <?php	
												}
												else if($g['CONTACT_TYPE'] == 'fax')
												{
													?>
                        <button class="btn btn-default" type="submit"><i class="fa fa-print"></i></button>
                        <?php	
												}
												else
												{
													?>
                        <button class="btn btn-default" type="submit">?</button>
                        <?php	
												}
												?>
                        </span>
                        <input type="hidden" name="contactId" value="<?php echo $g['ID'];?>" />
                        <input type="text" value="<?php echo $g['CONTACT_TEXT'];?>" disabled="disabled" class="form-control">
                        <span class="input-group-btn">
                        <button class="btn btn-default" name="removeContact" type="submit"><i class="fa fa-times"></i></button>
                        </span> </div>
                    </form>
                    <br />
                    <?php
											}
										}
										else
										{
											?>
                    <h5>Aucune information de contact disponible.</h5>
                    <?php
										}
									}
									?>
                  </section>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="panel">
                <div class="panel-heading"> Contenu du contact : </div>
                <div class="panel-body"> 
					<form method="post">
					<?php echo tendoo_info('Remplissez les informations qui vous concerne, ou votre entreprise ou votre activ&eacute;');?> <?php echo $this->core->tendoo->getEditor(array(
										'name'			=>	'contact_description',
										'id'			=>	'contact_description_id',
										'defaultValue'	=>	array_key_exists(0,$gDescription) ? $gDescription[0]['FIELD_CONTENT'] : ''
									));?>
                  <hr class="line line-dashed" />
                  <input type="submit" name="contact_description_submit" value="Enregistrer les modifications" class="btn btn-info" />
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </section>
    </section>
    </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
