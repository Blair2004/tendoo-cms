<form method="post" class="panel-body">
    <div class="form-group">
        <label class="control-label"><?php _e( 'Author' );?></label>
        <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['AUTEUR'] == '' ? __( 'Unspecified' ) : $speComment['AUTEUR'];?>" />
    </div>
    <div class="form-group">
        <label class="control-label"><?php _e( 'Related Post' );?></label>
        <input class="form-control" type="text" disabled="disabled" value="<?php echo $speComment['ARTICLE_TITLE'];?>" />
    </div>
    <div class="form-group">
        <label class="control-label"><?php _e( 'Status' );?></label>
        <?php echo $speComment['SHOW'] == '0'	? __( 'Unapproved' ) : __( 'Approved' );?>
    </div>
    <div class="form-group">
        <label class="control-label"><?php _e( 'Comment' );?></label>
        <textarea class="form-control" disabled="disabled" name="currentComment" placeholder="<?php _e( 'Type a comment' );?>"><?php echo $speComment['CONTENT'];?></textarea>
    </div>
    <input name="hiddenId" value="<?php echo $speComment['ID'];?>" type="hidden" />
    <?php
    if($speComment['SHOW'] == '0')
    {
        ?>
    <input class="btn btn-success" name="approve" value="<?php _e( 'Approuve' );?>" type="submit" />
        <?php
    }
    else
    {
        ?>
    <input class="btn btn-warning" name="disapprove" value="<?php _e( 'Disapprove' );?>" type="submit" />
        <?php
    }
        ?>
        <input class="btn btn-danger" type="submit" value="<?php _e( 'Delete' );?>" name="delete" />
</form>