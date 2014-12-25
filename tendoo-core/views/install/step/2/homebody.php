<section class="panel">
    <?php echo $this->load->the_view( 'install/step/menu' , true );?>
    <div class="step-content">
        <div class="step-pane active" id="step2">
            <div class="row">
                <div class="col-lg-7">
                    <div class="col-lg-13">
                        <h4><i class="fa fa-exchange"></i><?php echo translate('Connecting to database');?></h4>
                        <div>
                            <?php echo translate('before using tendoo, you must define database login information.');?>
                        </div>
                    </div>
                    <?php 
									$form_response	=	validation_errors('<li>', '</li>');
									ob_start();
									output('notice');
									$query_error	=	strip_tags(ob_get_contents());
									ob_end_clean();
									if($form_response)
									{
										?>
                    <div class="col-lg-13">
                        <div class="panel-body">
                            <?php echo tendoo_error('<strong>'.translate( 'Error occured. Please check your form data.' ).'</strong><br><br>'.$form_response);?>
                        </div>
                    </div>
                    <?php
									}
									else if($query_error)
									{
										?>
                    <div class="col-lg-13">
                        <div class="panel-body">
                            <?php echo tendoo_error('<strong>'.translate('Error Occured').'</strong><br><br>'.$query_error);?>
                        </div>
                    </div>
                    <?php
									}
									?>
                </div>
                <div class="col-lg-5">
                    <h4><i class="fa fa-bullseye"></i><?php echo translate('Database Login Informations');?></h4>
                    <div class="form-group">
                        <label class="host_name"><?php echo translate('Host Name');?></label>
                        <input name="host_name" value="localhost" type="text" placeholder="<?php _e( 'localhost' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="user_name"><?php echo translate('User Name');?></label>
                        <input name="user_name" value="root" type="text" placeholder="<?php _e( 'Use Name' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="host_password"><?php echo translate('User Password');?></label>
                        <input name="host_password" type="text" placeholder="<?php _e( 'Password' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="db_name"><?php echo translate('Database Name');?></label>
                        <input name="db_name" value="tendoo" type="text" placeholder="<?php _e( 'Database' );?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="extension_name"><?php echo translate('Table Prefix');?></label>
                        <input name="extension_name" type="text" placeholder="<?php _e( 'lumax_' );?>" class="form-control" value="lumax_">
                    </div>
                    <div class="form-group">
                        <select class="input-sm form-control input-s-sm inline" name="db_type" style="color:#333;background:#FFF;">
                            <option value="" style="color:#333"><?php echo translate('Database Type');?></option>
                            <option value="mysql" selected style="color:#333">Mysql</option>
                            <option value="mysqli" style="color:#333">Mysql Lite</option>
                            <option value="sqlite" style="color:#333">Sql Lite</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="line line-dashed">
                    </div>
                    <button style="float:right" type="submit" class="btn btn-info"><?php echo translate('Next Step');?></button>
                </div>
            </div>
        </div>
    </div>
</section>
