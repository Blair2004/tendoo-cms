<?php echo $smallHeader;?>
<section class="scrollable bg-light lt">
    <div class="panel-content">
        <div class="scrollable wrapper"> <?php echo output('notice');?>
            <div class="panel">
            	<div class="panel-heading">
                    <div class="btn-group">
                    <?php include_once(VIEWS_DIR.'account/messaging/menu.php');?>
                    </div>
                </div>
                <form method="post" class="panel-body">
                    <div class="form-group">
                        <label class="control-label"><?php _e( 'Receiver' );?></label>
                        <input type="text" class="form-control" name="receiver" placeholder="<?php _e( 'Type a valid pseudo' );?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php _e( 'Message content' );?></label>
                        <textarea class="form-control" name="content" placeholder="<?php _e( 'Message content' );?>"></textarea>
                    </div>
                    <input class="btn btn-sm btn-info" type="submit" value="<?php _e( 'Send' );?>" />
                    <input class="btn btn-sm btn-danger" type="reset" value="<?php _e( 'Reset' );?>" />
                </form>
                <div class="wrapper">
                    <?php
$field_1	=	(form_error('receiver')) ? form_error('receiver') : __( 'This pseudo must be valid' );
$field_2	=	(form_error('content')) ? form_error('content') : __( 'Message content' );
?>
                    <p><?php echo $field_1; ?></p>
                    <p><?php echo $field_2; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
