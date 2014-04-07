<?php echo $lmenu;?>
<section id="content">
  <section class="vbox"><?php echo $inner_head;?>
    <footer class="footer bg-white b-t">
		<div class="row m-t-sm text-center-xs">
			<div class="col-sm-2" id="ajaxLoading"> </div>
			<div class="col-sm-6 text-right text-center-xs"> </div>
			<div class="col-sm-4 text-right text-center-xs"> <a class="submit_article btn btn-white">Mettre &agrave; jour</a> </div>
		</div>
    </footer>
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
          <form method="post" class="submitForm">
          <div class="row">
            <div class="col-lg-9">
                <input type="hidden" value="<?php echo $getSpeNews[0]['ID'];?>" name="article_id">
                <input class="form-control" value="<?php echo $getSpeNews[0]['TITLE'];?>" type="text" name="news_name" placeholder="Titre de l'article">
                <br />
                <?php echo $this->core->tendoo->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content','defaultValue'=>$getSpeNews[0]['CONTENT']));?>
            </div>
            <div class="col-lg-3">
                <section class="panel">
                    <div class="panel-heading">Options</div>
                    <div class="panel-body"> 
                        <div class="form-group"> 
					<div id="articleKeyWords" class="pillbox clearfix m-b"> 
						<ul> 
						<?php
						$keyWords	=	$news->getNewsKeyWords($getSpeNews[0]['ID']);
						if(count($keyWords) > 0)
						{
							foreach($keyWords as $k)
							{
								?>
								<li class="label bg-primary"><input type="hidden" name="artKeyWord[]" value="<?php echo $k['KEYWORDS'];?>"><?php echo $k['KEYWORDS'];?></li>
								<?php
							}
						}
						?>
							<input class="addKeyWord" placeholder="Ajouter un mot clé" type="text"> 
						</ul> 
					</div>
				  </div>
				  <script type="text/javascript">
					function __bindKeyWordRemovalListener()
					{
						$('#articleKeyWords').find('.label').each(function(){
							if(typeof $(this).attr('bindKeyWordRemovalListenerBinded') == 'undefined')
							{
								$(this).attr('bindKeyWordRemovalListenerBinded','true');
								$(this).bind('click',function(){
									$(this).fadeOut(500,function(){
										$(this).remove();
									});
								});
							}
						})
					}
						
					$(document).ready(function(){
						$('.addKeyWord').focusin(function(){
							$(this).keydown(function(e,f){
								if(e.which == 13)
								{
									if($(this).val() != '')
									{
										$(this).before('<li class="label bg-primary"><input type="hidden" name="artKeyWord[]" value="'+$(this).val()+'">'+$(this).val()+'</li>');
										$(this).val('');
										__bindKeyWordRemovalListener();
									}
								}
							});
						});
						__bindKeyWordRemovalListener();
					});
				  </script>
                        <div class="form-group">
						<?php
						if($getSpeNews[0]['ETAT'] == 1)
						{
							$push_directly_filler	=	'selected="selected"';
							$draft_filler			=	'';
						}
						else
						{
							$push_directly_filler	=	'';
							$draft_filler			=	'selected="selected"';
						}
						?>
                            <select class="form-control" name="push_directly">
                                <option value="">Choisir une action</option>
                                <option <?php echo $push_directly_filler;?> value="1">Publier directement l'article</option>
                                <option <?php echo $draft_filler;?> value="2">Enregistrer dans les brouillons</option>
                            </select>
                        </div>
						<div class="form-group">
							<button class="btn btn-primary input-sm form-control creatingCategory" data-form-url="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'ajax','createCategory'));?>" type="button">Ajouter une cat&eacute;gorie</button>
						</div>
                        <div class="form-group">
                            <select class="form-control" name="category">
                                <option value="">Choisir la cat&eacute;gorie</option>
                                <?php
                        foreach($categories as $c)
                        {
							if($c['ID'] == $getSpeNews[0]['CATEGORY_ID'])
							{
                        ?>
                                <option selected="selected" value="<?php echo $c['ID'];?>"><?php echo $c['CATEGORY_NAME'];?></option>
                                <?php
							}
							else
							{
                        ?>
                                <option value="<?php echo $c['ID'];?>"><?php echo $c['CATEGORY_NAME'];?></option>
                                <?php
							}
                        }
                        ?>
                            </select>
                        </div>
                        <div class="form-group">
                        <?php
                        $fmlib->mediaLib_button(array(
                            'PLACEHOLDER'		=>		'Lien vers l\'aperçu',
                            'NAME'				=>		'thumb_link',
							'TEXT'				=>		'Image Aperçu',
							'VALUE'				=>		$getSpeNews[0]['THUMB']
                        ));	
                        ?>
                        </div>
                        <div class="form-group">
                        <?php
                        $fmlib->mediaLib_button(array(
                            'PLACEHOLDER'		=>		'Lien vers l\'image',
                            'NAME'				=>		'image_link',
                            'GOTO'				=>		'selection',
							'TEXT'				=>		'Image Taille R&eacute;elle',
							'VALUE'				=>		$getSpeNews[0]['IMAGE']
                        ));	
                        ?>
                        </div>
                        <?php
                        $fmlib->mediaLib_load();
                        ?>
                        <div class="form-group">
                        	<input type="submit editArticleSave" style="display:none" value="Enregistrer les modifications" class="btn btn-info" />
                        </div>
                    </div>
                </section>
            </div>
            </div>
          </form>
        </section>
      </section>
    </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
	<script>
		$(document).ready(function(){
			$('.submit_article').bind('click',function(){
				$('.submitForm').submit();
			});
		});
		</script>