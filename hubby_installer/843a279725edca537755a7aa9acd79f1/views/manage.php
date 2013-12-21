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
                	<div class="row">
                    	<div class="col-lg-4">
                    <section class="panel">
                        <div class="panel-heading"> Ajouter un nouveau fichier </div>
                        <div class="panel-body">
                        	<form method="post" action="">
                            	<div class="input-group input-group-sm">
                                  <span class="input-group-addon">Titre du fichier</span>
                                  <input type="text" name="file_name" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Titre du fichier">
                                </div>
                                <hr class="line line-dashed">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon">Description</span>
                                  <textarea style="height:200px;" type="text" name="file_description" class="form-control" value="<?php echo $getFile[0]['TITLE'];?>" placeholder="Titre du fichier"><?php echo $getFile[0]['DESCRIPTION'];?></textarea>
                                </div>
                                <hr class="line line-dashed">
                                <input type="hidden" name="content_id" value="<?php echo $id;?>">
                                <input class="btn btn-info" type="submit" value="Modifier la page" name="edit_file">
                                <input class="btn btn-danger" type="submit" name="delete_file" value="Supprimer le fichier">
                            </form>
                        </div>
                    </section>
                    	</div>
                        <div class="col-lg-8">
                        	<section class="panel">
                        <div class="panel-heading"> Editer l'image </div>
                        <div class="panel-body">
                            <?php
							if(in_array(strtolower($getFile[0]['FILE_TYPE']),array('jpg','png')))
							{
							?>
                        	<form method="post" class="" action="" id="coords">
                                <img id="target" style="width:100%;" src="<?php echo $this->core->url->main_url().$repository_dir.'/'.$getFile[0]['FILE_NAME'];?>" />
                                <hr class="line line-dashed">
                                <input type="hidden" size="4" id="x1" name="x1" />
                                <input type="hidden" size="4" id="y1" name="y1" />
                                <input type="hidden" size="4" id="x2" name="x2" />
                                <input type="hidden" size="4" id="y2" name="y2" />
                                <input type="hidden" size="4" id="w" name="w" />
                                <input type="hidden" size="4" id="h" name="h" />
                                
                                <input type="hidden" name="image_id" value="<?php echo $getFile[0]['ID'];?>">
                                <div class="input-group input-group-sm">
                                  <span class="input-group-addon">Nouveau nom du fichier</span>
                                  <input type="text" class="form-control" name="file_new_name" value="<?php echo $lib->getName().'.'.strtolower($getFile[0]['FILE_TYPE']);?>" disabled="disabled"  placeholder="Nom du fichier">
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
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
