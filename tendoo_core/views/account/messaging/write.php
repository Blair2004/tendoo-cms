<?php echo $smallHeader;?>
<section class="scrollable bg-light lt">
    <div class="panel-content">
        <div class="scrollable wrapper"> <?php echo $this->core->notice->parse_notice();?>
            <div class="panel">
            	<div class="panel-heading">
                    <div class="btn-group">
                    <?php include_once(VIEWS_DIR.'account/messaging/menu.php');?>
                    </div>
                </div>
                <form method="post" class="panel-body">
                    <div class="form-group">
                        <label class="control-label">Pseudo du correspondant</label>
                        <input type="text" class="form-control" name="receiver" placeholder="Pseudo du correspondant" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Contenu du message</label>
                        <textarea class="form-control" name="content" placeholder="Contenu du message"></textarea>
                    </div>
                    <input class="btn btn-sm btn-info" type="submit" value="Envoyer" />
                    <input class="btn btn-sm btn-danger" type="reset" value="Tout effacer" />
                </form>
                <div class="wrapper">
                    <?php
$field_1	=	(form_error('receiver')) ? form_error('receiver') : 'Ce pseudo doit correspondre à l\'un des pseudo valide.';
$field_2	=	(form_error('content')) ? form_error('content') : 'Le contenu du message.';
?>
                    <p><?php echo $field_1; ?></p>
                    <p><?php echo $field_2; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
