<?php

	// $this->set_css($this->default_theme_path.'/bootstrap/css/flexigrid.css');
	$this->set_js_lib($this->default_theme_path.'/bootstrap/js/jquery.form.js');
    $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.form.min.js');
	$this->set_js_config($this->default_theme_path.'/bootstrap/js/flexigrid-edit.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>
<div id='main-table-box'>
	<?php echo form_open( $update_url, 'method="post" id="crudForm"  enctype="multipart/form-data"'); ?>
	<div class='form-div'>
		<?php
		$counter = 0;
			foreach($fields as $field)
			{
				$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
				$counter++;
		?>
            <div class="form-group <?php echo $even_odd?>" id="<?php echo $field->field_name; ?>_field_box">
                <label for="exampleInputEmail1">
					<?php echo $input_fields[$field->field_name]->display_as; ?>
					<?php echo ($input_fields[$field->field_name]->required)? " <span class='required label label-danger'>*</span> " : ""; ?>
				</label>
	            <?php echo $input_fields[$field->field_name]->input;?>
            </div>

		<?php }?>
		<?php if(!empty($hidden_fields)){?>
		<!-- Start of hidden inputs -->
			<?php
				foreach($hidden_fields as $hidden_field){
					echo $hidden_field->input;
				}
			?>
		<!-- End of hidden inputs -->
		<?php }?>
		<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
		<div id='report-error' class='report-div error'></div>
		<div id='report-success' class='report-div success'></div>
	</div>
    <div class="buttons-box">
        <div class="btn-group" role="group">
            <input id="form-button-save" type='submit' value='<?php echo $this->l('form_save'); ?>'  class="btn btn-success"/>
          </div>
<?php 	if(!$this->unset_back_to_list) { ?>
        <div class="btn-group" role="group">
            <input class="btn btn-primary" type='button' value='<?php echo $this->l('form_save_and_go_back'); ?>' id="save-and-go-back-button"  class="btn btn-large"/>
        </div>
        <div class="btn-group" role="group">
            <input class="btn btn-danger"  type='button' value='<?php echo $this->l('form_cancel'); ?>' class="btn btn-large" id="cancel-button" />
        </div>
<?php 	} ?>
        <div class='form-button-box' style="display:none;">
            <div class='small-loading' id='FormLoading'><?php echo $this->l('form_insert_loading'); ?></div>
        </div>
        <div class='clear'></div>
    </div>
	<?php echo form_close(); ?>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
	var message_update_error = "<?php echo $this->l('update_error')?>";
</script>