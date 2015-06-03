<input class="form-control" type="text" name="news_name" placeholder="<?php _e( 'Post Title' );?>">
<br />
<?php echo get_instance()->visual_editor->getEditor(array('class'=>'form-control','id'=>'editor','name'=>'news_content'));?>