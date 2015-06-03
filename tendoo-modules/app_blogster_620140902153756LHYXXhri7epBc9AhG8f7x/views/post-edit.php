<input type="hidden" value="<?php echo $getSpeNews[0]['ID'];?>" name="article_id">
<input class="form-control" value="<?php echo $getSpeNews[0]['TITLE'];?>" type="text" name="news_name" placeholder="Titre de l'article">
<br />
<?php echo get_instance()->visual_editor->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content','defaultValue'=>$getSpeNews[0]['CONTENT'],'height'	=>	'800px'));?>