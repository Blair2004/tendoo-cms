<?php
	// $this->set_css($this->default_theme_path.'/bootstrap/css/flexigrid.css');
	$this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
	$this->set_js_lib($this->default_javascript_path.'/common/lazyload-min.js');

	if (!$this->is_IE7()) {
		$this->set_js_lib($this->default_javascript_path.'/common/list.js');
	}

	$this->set_js($this->default_theme_path.'/bootstrap/js/cookies.js');
	$this->set_js($this->default_theme_path.'/bootstrap/js/flexigrid.js');

    $this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.form.min.js');

	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.numeric.min.js');
	$this->set_js($this->default_theme_path.'/bootstrap/js/jquery.printElement.min.js');

	/** Fancybox */
	$this->set_css($this->default_css_path.'/jquery_plugins/fancybox/jquery.fancybox.css');
	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.fancybox-1.3.4.js');
	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.easing-1.3.pack.js');

	/** Jquery UI */
	$this->load_js_jqueryui();

?>
<script type='text/javascript'>
	var base_url = '<?php echo base_url();?>';

	var subject = '<?php echo addslashes($subject); ?>';
	var ajax_list_info_url = '<?php echo $ajax_list_info_url; ?>';
	var unique_hash = '<?php echo $unique_hash; ?>';

	var message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";

</script>

<div id='list-report-error' class='report-div error'></div>
<div id='list-report-success' class='report-div success report-list' <?php if($success_message !== null){?>style="display:block"<?php }?>>
    <?php
if($success_message !== null){?>
    <p><?php echo $success_message; ?></p>
    <?php }
?>
</div>
<div class="flexigrid" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
    <div id="hidden-operations" class="hidden-operations"></div>
    <!--<div class="mDiv">
        <div class="ftitle"> &nbsp; </div>
        <div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle"> <span></span> </div>
    </div>-->
	<?php echo form_open( $ajax_list_url, 'method="post" id="filtering_form" class="filtering_form" autocomplete = "off" data-ajax-list-info-url="'.$ajax_list_info_url.'"'); ?>
    <div id='main-table-box' class="main-table-box">
        <?php if(!$unset_add || !$unset_export || !$unset_print){?>
        <div class="row">
            <div class="col-lg-12 grocery_buttons">
                <div class="form-inline">
                    <?php if(!$unset_add){?>
                    <div class="btn-group"> <a href='<?php echo $add_url?>' title='<?php echo $this->l('list_add'); ?> <?php echo $subject?>' class='btn btn-default add-anchor add_button'> <?php echo $this->l('list_add'); ?> <?php echo $subject?> </a> </div>
                    <?php }?>
                    <?php if(!$unset_export) { ?>
                    <div class="btn-group"> <a class="export-anchor btn btn-default" data-url="<?php echo $export_url; ?>" target="_blank">
                        <div class="fbutton">
                            <div> <span class="export"><?php echo $this->l('list_export');?></span> </div>
                        </div>
                        </a> </div>
                    <?php } ?>
                    <?php if(!$unset_print) { ?>
                    <div class="btn-group"> <a class="print-anchor btn btn-default" data-url="<?php echo $print_url; ?>">
                        <div class="fbutton">
                            <div> <span class="print"><?php echo $this->l('list_print');?></span> </div>
                        </div>
                        </a> </div>
                    <?php }?>
                    
                    <div class="form-group">
                        <div class="pReload btn btn-default ajax_refresh_and_loading" id='ajax_refresh_and_loading'> <span class="fa fa-refresh"></span>
                            <?php _e( 'Refresh Current Page' );?>
                        </div>
                        <label class="sr-only" for="search_text"></label>
                        <div class="input-group">
                            <div class="input-group-addon"><?php echo $this->l('list_search');?>:</div>
                            <input type="text" class="form-control qsbsearch_fieldox search_text" id="search_text" name="search_text" placeholder="<?php echo $this->l('list_search');?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control" name="search_field" id="search_field" style="width:250px;">
                                <option value=""><?php echo $this->l('list_search_all');?></option>
                                <?php foreach($columns as $column){?>
                                <option value="<?php echo $column->field_name?>"><?php echo $column->display_as?>&nbsp;&nbsp;</option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <input type="button" value="<?php echo $this->l('list_search');?>" class="btn btn-primary crud_search" id='crud_search'>
                    <input type="button" class="btn btn-primary search_clear" id="search_clear" value="<?php echo $this->l('list_clear_filtering');?>" />
                    
                </div>
            </div>
        </div>
        <br />
        <?php }?>
        <div id='ajax_list' class="ajax_list"> <?php echo $list_view?> </div>
        
        <table class="pDiv table table-bordered">
            <tr class="pDiv2">
                <td class="pGroup"><div class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <?php list($show_lang_string, $entries_lang_string) = explode('{paging}', $this->l('list_show_entries')); ?>
                                    <?php echo $show_lang_string; ?></div>
                                <select name="per_page" id='per_page' class="per_page form-control">
                                    <?php foreach($paging_options as $option){?>
                                    <option value="<?php echo $option; ?>" <?php if($option == $default_per_page){?>selected="selected"<?php }?>><?php echo $option; ?>&nbsp;&nbsp;</option>
                                    <?php }?>
                                </select>
                                <div class="input-group-addon"><?php echo $entries_lang_string; ?></div>
                            </div>
                        </div>
                    </div>
                    <input type='hidden' name='order_by[0]' id='hidden-sorting' class='hidden-sorting' value='<?php if(!empty($order_by[0])){?><?php echo $order_by[0]?><?php }?>' />
                    <input type='hidden' name='order_by[1]' id='hidden-ordering' class='hidden-ordering'  value='<?php if(!empty($order_by[1])){?><?php echo $order_by[1]?><?php }?>'/></td>
                <td class="pGroup"><div class="pPrev btn btn-default prev-button"> <span>
                        <?php _e( '&laquo; Previous Page' );?>
                        </span> </div>
                    <div class="pNext btn btn-default next-button" > <span>
                        <?php _e( 'Next Page &raquo;' );?>
                        </span> </div></td>
                <td class="pGroup">
                	<div class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><?php echo $this->l('list_page'); ?> </div>
                                <input name='page' type="text" value="1" size="4" id='crud_page' class="crud_page form-control">
                                <div class="input-group-addon"><?php echo $this->l('list_paging_of'); ?> <span id='last-page-number' class="last-page-number"><?php echo ceil($total_results / $default_per_page)?></span></div>
                            </div>
                        </div>
                    </div></td>
                <td class="pGroup">
                	<div class="pFirst btn btn-default first-button"> <span>
                        <?php _e( '&laquo; First Page' );?>
                        </span> </div>
                    <div class="pLast btn btn-default last-button"> <span>
                        <?php _e( 'Last Page &raquo;' );?>
                        </span> </div></td>
                <td class="pGroup form-group"><p class="pPageStat">
                <label>
                    <?php $paging_starts_from = "<span id='page-starts-from' class='page-starts-from'>1</span>"; ?>
                    <?php $paging_ends_to = "<span id='page-ends-to' class='page-ends-to'>". ($total_results < $default_per_page ? $total_results : $default_per_page) ."</span>"; ?>
                    <?php $paging_total_results = "<span id='total_items' class='total_items'>$total_results</span>"?>
                    <?php echo str_replace( array('{start}','{end}','{results}'),
                                                array($paging_starts_from, $paging_ends_to, $paging_total_results),
                                                $this->l('list_displaying')
                                               ); ?> </p></label>
                                               </td>
            </tr>
            <div style="clear: both;"> </div>
        </table>
        </div>
         <?php echo form_close(); ?>
</div>
