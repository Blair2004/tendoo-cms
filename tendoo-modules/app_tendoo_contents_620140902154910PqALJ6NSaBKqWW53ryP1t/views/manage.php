<?php echo $lmenu;?>
<section id="content">
<section class="bigwrapper"><?php echo $inner_head;?>
            
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-4">
                        <form method="post">
                            <input type="button" class="btn btn-sm btn-white editInfo" value="Modifer" />
                            <input type="button" class="btn btn-sm btn-danger deleteFile" value="Supprimer" />
                        </form>
                    </div>
                    <div class="col-sm-4 text-center">
                        <?php
				if(in_array(strtolower($getFile[0]['FILE_TYPE']),array('jpg','png')))
				{
				?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-white showALook"><i class="icon-shopping-cart"></i>Aperçu de l'image</a>
                        <?php
				}
				?>
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">
                        <form method="post">
                            <input type="button" class="btn btn-sm btn-white overwrite" value="Redimensioner" />
                            <input type="button" class="btn btn-sm btn-white editInfo" value="Cr&eacute;er une copie" />
                        </form>
                    </div>
                </div>
            </footer>
            <section class="scrollable" id="pjax-container">
                <header>
                    <div class="row b-b m-l-none m-r-none">
                        <div class="col-sm-4">
                            <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                            <p class="block text-muted"><?php echo get_page('description');?></p>
                        </div>
                    </div>
                </header>
                <section class="bigwrapper">
                    <section class="wrapper"> <?php echo output('notice');?>  <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                        <div class="row">
                            <div class="col-lg-3">
                                <section class="panel">
                                    <div class="panel-heading"> Modifier les informations du fichier </div>
                                    <div class="panel-body">
                                        <form method="post" action="">
                                            <div class="input-group input-group-sm"> <span class="input-group-addon">Titre du fichier</span>
                                                <input type="text" name="file_name" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Titre du fichier">
                                            </div>
                                            <hr class="line line-dashed">
                                            <div class="form-group">
                                                <textarea style="height:200px;" type="text" name="file_description" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Description du fichier"><?php echo $getFile[0]['DESCRIPTION'];?></textarea>
                                            </div>
                                            <hr class="line line-dashed">
                                            <input type="hidden" name="content_id" value="<?php echo $id;?>">
                                            <input class="btn btn-info btn-sm" type="submit" value="Modifier" name="edit_file">
                                            <input class="btn btn-danger btn-sm" type="submit" name="delete_file" value="Supprimer le fichier">
                                        </form>
                                    </div>
                                </section>
                                <section class="panel">
                                    <div class="panel-heading"> Remplacer par un autre fichier</div>
                                    <div class="panel-body">
                                        <form method="post" action="" enctype="multipart/form-data">
                                            <div class="input-group input-group-sm"> <span class="input-group-addon">Nouveau fichier</span>
                                                <input type="file" name="new_file" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Titre du fichier">
                                            </div>
                                            <hr class="line line-dashed">
                                            <input type="hidden" name="content_id" value="<?php echo $id;?>">
                                            <input class="btn btn-info" type="submit" name="change_file" value="Remplacer le fichier">
                                        </form>
                                    </div>
								</section>
                            </div>
                            <div class="col-lg-9">
                                <section class="panel">
                                    <div class="panel-heading"> Editer l'image </div>
                                    <div class="panel-body">
                                    	
                                        <?php
							if(in_array(strtolower($getFile[0]['FILE_TYPE']),array('jpg','png')))
							{
							?>
                                        <form method="post" class="" action="" id="coords">
                                        	
                                            <div style="width:100%;overflow:scroll">
                                            <img id="target" src="<?php echo $this->instance->url->main_url().$repository_dir.'/'.$getFile[0]['FILE_NAME'];?>" />
                                            </div>
                                            <hr class="line line-dashed">
                                            <input type="hidden" size="4" id="x1" name="x1" />
                                            <input type="hidden" size="4" id="y1" name="y1" />
                                            <input type="hidden" size="4" id="x2" name="x2" />
                                            <input type="hidden" size="4" id="y2" name="y2" />
                                            <input type="hidden" size="4" id="w" name="w" />
                                            <input type="hidden" size="4" id="h" name="h" />
                                            <input type="hidden" name="image_id" value="<?php echo $getFile[0]['ID'];?>">
                                            <div class="input-group input-group-sm"> <span class="input-group-addon">Nouveau nom du fichier</span>
                                                <input type="text" class="form-control" name="file_new_name" value="<?php echo $fileNewName.'.'.strtolower($getFile[0]['FILE_TYPE']);?>" disabled="disabled"  placeholder="Nom du fichier">
                                            </div>
                                            <hr class="line line-dashed">
                                            <input class="btn btn-info" type="submit" value="Ecraser l'image" name="overwrite_file">
                                            <input class="btn btn-danger" type="submit" name="create_new_file" value="Enregistrer sous un nouveau nom">
                                        </form>
                                        <?php
							}
							else
							{
								?>
                                        Ce fichier ne peut pas faire l'objet d'une &eacute;dition
                                        <?php
							}
							?>
                                    </div>
                                    <script type="text/javascript">

  jQuery(function($){

    var jcrop_api;

    $('#target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords
    },function(){
      jcrop_api = this;
    });

    $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

  });

  // Simple event handler, called from onChange and onSelect
  // event handlers, as per the Jcrop invocation above
  function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function clearCoords()
  {
    $('#coords input').val('');
  };
</script> 
                                </section>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
            <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
<script>
		$('.editInfo').click(function(){
			$('*[name="edit_file"]').trigger('click');
		});
		$('.deleteFile').click(function(){
			$('*[name="delete_file"]').trigger('click');
		});
		$('.overwrite').click(function(){
			$('*[name="overwrite_file"]').trigger('click');
		});
		$('.showALook').bind('click',function(){
			tendoo.modal.show('<img src="<?php echo $this->instance->url->main_url().'tendoo-modules/'.$module[0]['encrypted_dir'].'/content_repository/'.$getFile[0]['FILE_NAME'];?>" alt="<?php echo $getFile[0]['FILE_NAME'];?>">');
		});
		</script>