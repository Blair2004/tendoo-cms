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
				<?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                    <div class="col-lg-2">
                        <section class="panel">
                            <div class="panel-heading"> Afficher : </div>
                            <div class="panel-body">
                            	<form method="post" class="form">
                                	<div class="form-group">
                                    	<label class="label-control">Le caroussel</label>
                                        <select name="showCarrousel" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option 
											<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_CAROUSSEL',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_CAROUSSEL'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_CAROUSSEL',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_CAROUSSEL'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Eléments r&eacute;cents</label>
                                        <select name="showLastest" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_LASTEST',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_LASTEST'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_LASTEST',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_LASTEST'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Eléments au top</label>
                                        <select name="showFeatured" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php
										if(is_array($lib_options))
										{ 
											if(array_key_exists('SHOW_FEATURED',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_FEATURED'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_FEATURED',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_FEATURED'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Dossier d'&eacute;l&eacute;ments</label>
                                        <select name="showTabShowCase" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php
										if(is_array($lib_options))
										{ 
											if(array_key_exists('SHOW_TABSHOWCASE',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_TABSHOWCASE'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_TABSHOWCASE',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_TABSHOWCASE'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Liste d'info.</label>
                                        <select name="showSmallDetails" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_SMALLDETAILS',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_SMALLDETAILS'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_SMALLDETAILS',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_SMALLDETAILS'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Gallerie d'image</label>
                                        <select name="showGallery" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_GALLERY',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_GALLERY'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_GALLERY',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_GALLERY'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">"&agrave; propos de nous"</label>
                                        <select name="showAboutUs" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_ABOUTUS',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_ABOUTUS'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_ABOUTUS',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_ABOUTUS'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">"nos partenaires"</label>
                                        <select name="showPartner" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <option <?php
										if(is_array($lib_options))
										{ 
											if(array_key_exists('SHOW_PARTNERS',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_PARTNERS'] == "0")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="0">Non</option>
                                            <option <?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SHOW_PARTNERS',$lib_options[0]))
											{ 
												if($lib_options[0]['SHOW_PARTNERS'] == "1")
												{
													?> selected="selected" <?php
												}
											};
										}
											?> value="1">Oui</option>
                                        </select>
                                    </div>
                                    <input name="section1" type="submit" value="Enregistrer" class="btn btn-info" />
                                </form>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4">
                        <section class="panel">
                            <div class="panel-heading"> Param&ecirc;tres des titres </div>
                            <div class="panel-body">
                            	<form class="form" method="post">
                                	<div class="form-group">
                                    	<label class="label-control">Titre Caroussel</label>
                                        <input name="carousselTitle" class="form-control" placeholder="Exemple : Acualit&eacute;" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('CAROUSSEL_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['CAROUSSEL_TITLE'] != "")
												{
													echo $lib_options[0]['CAROUSSEL_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre &eacute;l&eacute;ments r&eacute;cents</label>
                                        <input name="lastestTitle" class="form-control" placeholder="Exemple : Acualit&eacute;" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('LASTEST_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['LASTEST_TITLE'] != "")
												{
													echo $lib_options[0]['LASTEST_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre &eacute;l&eacute;ments en avant</label>
                                        <input name="featuredTitle" class="form-control" placeholder="Exemple : Au top" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('FEATURED_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['FEATURED_TITLE'] != "")
												{
													echo $lib_options[0]['FEATURED_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre dossier d'&eacute;l&eacute;ments</label>
                                        <input name="tabShowCaseTitle" class="form-control" placeholder="Exemple : Nos informations" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('TABSHOWCASE_TITLE	',$lib_options[0]))
											{ 
												if($lib_options[0]['TABSHOWCASE_TITLE	'] != "")
												{
													echo $lib_options[0]['TABSHOWCASE_TITLE	'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre Liste d'information textuelle</label>
                                        <input name="smarTitle" class="form-control" placeholder="Exemple : Nos services" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('SMALLDETAIL_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['SMALLDETAIL_TITLE'] != "")
												{
													echo $lib_options[0]['SMALLDETAIL_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre Gallerie</label>
                                        <input name="galleryTitle" class="form-control" placeholder="Exemple : Gallerie photo" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('GALSHOWCASE_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['GALSHOWCASE_TITLE'] != "")
												{
													echo $lib_options[0]['GALSHOWCASE_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre "&agrave; propos de nous"</label>
                                        <input name="aboutUsTitle" class="form-control" placeholder="Exemple : A propos de nous" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('ABOUTUS_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['ABOUTUS_TITLE'] != "")
												{
													echo $lib_options[0]['ABOUTUS_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                	<div class="form-group">
                                    	<label class="label-control">Titre "nos partenaire"</label>
                                        <input name="partnerTitle" class="form-control" placeholder="Exemple : Nos partenaires" value="<?php 
										if(is_array($lib_options))
										{
											if(array_key_exists('PARTNER_TITLE',$lib_options[0]))
											{ 
												if($lib_options[0]['PARTNER_TITLE'] != "")
												{
													echo $lib_options[0]['PARTNER_TITLE'];
												}
											};
										}
											?>" />
                                    </div>
                                    <input type="submit" name="section2" value="Enregistrer" class="btn btn-info" />
                                </form>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-3">
                        <section class="panel">
                            <div class="panel-heading"> Que faut-il afficher dans :</div>
                            <div class="panel-body">
                                <form method="post" class="form">
                                	<div class="form-group">
                                    	<label class="label-control">Le caroussel</label>
                                        <select name="CarousselmoduleExtension" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <?php
											if(is_array($apizedMod))
											{
												foreach($apizedMod as $a)
												{
													if(is_array($lib_options))
													{
														if(array_key_exists('ON_CAROUSSEL',$lib_options[0]))
														{
															if($lib_options[0]['ON_CAROUSSEL'] == $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'])
															{
												?>
                                                <option selected="selected" value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
															else
															{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
														}
														else
														{
													?>
													<option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
													<?php
														}
													}
													else
													{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
													}
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Les éléments r&eacute;cents</label>
                                        <select name="LastestExtension" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <?php
											if(is_array($apizedMod))
											{
												foreach($apizedMod as $a)
												{
													if(is_array($lib_options))
													{
														if(array_key_exists('ON_LASTEST',$lib_options[0]))
														{
															if($lib_options[0]['ON_LASTEST'] == $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'])
															{
												?>
                                                <option selected="selected" value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
															else
															{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
														}
														else
														{
													?>
													<option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
													<?php
														}
													}
													else
													{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
													}
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Les éléments au top</label>
                                        <select name="FeaturedExtension" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <?php
											if(is_array($apizedMod))
											{
												foreach($apizedMod as $a)
												{
													if(is_array($lib_options))
													{
														if(array_key_exists('ON_FEATURED',$lib_options[0]))
														{
															if($lib_options[0]['ON_FEATURED'] == $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'])
															{
												?>
                                                <option selected="selected" value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
															else
															{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
														}
														else
														{
													?>
													<option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
													<?php
														}
													}
													else
													{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
													}
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Le dossier d'&eacute;l&eacute;ments</label>
                                        <select name="TabShowCaseExtension" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <?php
											if(is_array($apizedMod))
											{
												foreach($apizedMod as $a)
												{
													if(is_array($lib_options))
													{
														if(array_key_exists('ON_TABSHOWCASE',$lib_options[0]))
														{
															if($lib_options[0]['ON_TABSHOWCASE'] == $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'])
															{
												?>
                                                <option selected="selected" value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
															else
															{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
														}
														else
														{
													?>
													<option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
													<?php
														}
													}
													else
													{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
													}
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">La liste d'information textuelle</label>
                                        <select name="SmallDetailsExtension" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <?php
											if(is_array($apizedMod))
											{
												foreach($apizedMod as $a)
												{
													if(is_array($lib_options))
													{
														if(array_key_exists('ON_SMALLDETAILS',$lib_options[0]))
														{
															if($lib_options[0]['ON_SMALLDETAILS'] == $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'])
															{
												?>
                                                <option selected="selected" value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
															else
															{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
														}
														else
														{
													?>
													<option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
													<?php
														}
													}
													else
													{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
													}
												}
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">La gallerie d'image</label>
                                        <select name="GalleryExtension" class="form-control">
                                        	<option value="">Choisir...</option>
                                            <?php
											if(is_array($apizedMod))
											{
												foreach($apizedMod as $a)
												{
													if(is_array($lib_options))
													{
														if(array_key_exists('ON_GALLERY',$lib_options[0]))
														{
															if($lib_options[0]['ON_GALLERY'] == $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'])
															{
												?>
                                                <option selected="selected" value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
															else
															{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
															}
														}
														else
														{
													?>
													<option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
													<?php
														}
													}
													else
													{
												?>
                                                <option value="<?php echo $a['API_MODULE_NAMESPACE'].'/'.$a['API_NAMESPACE'];?>"><?php echo $a['API_HUMAN_NAME'];?></option>
                                                <?php
													}
												}
											}
											?>
                                        </select>
                                    </div>
                                    <input type="submit" name="section3" value="Enregistrer" class="btn btn-info" />
                                </form>
                            </div>
                        </section>
                    </div>
                    <div class="col-sm-3">
                        <section class="panel">
                            <div class="panel-heading"> Limite des &eacute;l&eacute;ments &agrave; afficher dans :</div>
                            <div class="panel-body">
                                <form method="post" class="form">
                                    <div class="form-group">
                                        <label class="label-control">Le caroussel</label>
                                        <select name="carousselLimit" class="form-control">
                                            <option value="">Choisir...</option>
                                            <?php
                                            for($i = 1;$i<= 30;$i++)
                                            {
												if(is_array($lib_options))
												{
													if(array_key_exists('CAROUSSEL_LIMIT',$lib_options[0]))
													{
														if((int)$lib_options[0]['CAROUSSEL_LIMIT'] == $i)
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
													else
													{
														?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
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
                                    <div class="form-group">
                                        <label class="label-control">Les éléments r&eacute;cents</label>
                                        <select name="lastestLimit" class="form-control">
                                            <option value="">Choisir...</option>
                                            <?php
                                            for($i = 1;$i<= 30;$i++)
                                            {
												if(is_array($lib_options))
												{
													if(array_key_exists('LASTEST_LIMIT',$lib_options[0]))
													{
														if((int)$lib_options[0]['LASTEST_LIMIT'] == $i)
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
													else
													{
														?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
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
                                    <div class="form-group">
                                        <label class="label-control">Les éléments au top</label>
                                        <select name="featuredLimit" class="form-control">
                                            <option value="">Choisir...</option>
                                            <?php
                                            for($i = 1;$i<= 30;$i++)
                                            {
												if(is_array($lib_options))
												{
													if(array_key_exists('FEATURED_LIMIT',$lib_options[0]))
													{
														if((int)$lib_options[0]['FEATURED_LIMIT'] == $i)
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
													else
													{
														?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
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
                                    <div class="form-group">
                                        <label class="label-control">Le dossier d'&eacute;l&eacute;ments</label>
                                        <select name="tabShowCaseLimit" class="form-control">
                                            <option value="">Choisir...</option>
                                            <?php
                                            for($i = 1;$i<= 30;$i++)
                                            {
												if(is_array($lib_options))
												{
													if(array_key_exists('TABSHOWCASE_LIMIT',$lib_options[0]))
													{
														if((int)$lib_options[0]['TABSHOWCASE_LIMIT'] == $i)
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
													else
													{
														?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
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
                                    <div class="form-group">
                                        <label class="label-control">La liste d'information textuelle</label>
                                        <select name="smartLimit" class="form-control">
                                            <option value="">Choisir...</option>
                                            <?php
                                            for($i = 1;$i<= 30;$i++)
                                            {
												if(is_array($lib_options))
												{
													if(array_key_exists('SMALLDETAILS_LIMIT',$lib_options[0]))
													{
														if((int)$lib_options[0]['SMALLDETAILS_LIMIT'] == $i)
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
													else
													{
														?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
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
                                    <div class="form-group">
                                        <label class="label-control">La gallerie d'image</label>
                                        <select name="galleryLimit" class="form-control">
                                            <option value="">Choisir...</option>
                                            <?php
                                            for($i = 1;$i<= 30;$i++)
                                            {
												if(is_array($lib_options))
												{
													if(array_key_exists('GALLERY_LIMIT',$lib_options[0]))
													{
														if((int)$lib_options[0]['GALLERY_LIMIT'] == $i)
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
													else
													{
														?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php
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
                                    <input name="section4" type="submit" value="Enregistrer" class="btn btn-info" />
                                </form>
                            </div>
                        </section>
</div>
					<br />
                    <div class="col-lg-11">
                        <section class="panel">
                            <div class="panel-heading"> Param&ecirc;tres du contenu statique </div>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <form method="post" class="form">
                                        <div class="form-group">
                                        <?php
										$default1	=	'';
										if(is_array($lib_options))
										{
											if(array_key_exists('ABOUTUS_CONTENT',$lib_options[0]))
											{
												$default1	=	$lib_options[0]['ABOUTUS_CONTENT'];
											}
										}
										?>
                                            <label class="label-control">A propos de nous</label>
                                            <?php echo $this->core->hubby->getEditor(array('name'=>'aboutUsContent','defaultValue'	=>	$default1));?>
                                        </div>
                                        <input name="section5" type="submit" value="Enregistrer" class="btn btn-info" />
                                    </form>
                                </div>
                                <div class="col-lg-12">
                                    <form method="post" class="form">
                                    	<?php
										$default2	=	'';
										if(is_array($lib_options))
										{
											if(array_key_exists('PARTNERS_CONTENT',$lib_options[0]))
											{
												$default2	=	$lib_options[0]['PARTNERS_CONTENT'];
											}
										}
										?>
                                        <div class="form-group">
                                            <label class="label-control">Nos partenaires</label>
                                            <?php echo $this->core->hubby->getEditor(array('name'=>'ourPartner','defaultValue'	=>	$default2));?>
                                        </div>
                                        <input  name="section6" type="submit" value="Enregistrer" class="btn btn-info" />
                                    </form>
                                </div>
							</div>
                        </section>
                    </div>
                </section>
                <secttion class="wrapper">
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
