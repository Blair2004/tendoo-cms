<div class="table-responsive">
    <table class="table table-striped m-b-none" tableMultiSelect>
        <thead>
            <tr>
                <th width=""><input type="checkbox"></th>
                <th width="300"><?php _e( 'Name' );?></th>
                <th><?php _e( 'Description' );?></th>
                <th><?php _e( 'Created on' );?></th>
            </tr>
        </thead>
        <tbody>
        <form method="post" id="bulkSelect">
        <?php
        if(count($getCat) > 0)
        {
            foreach($getCat as $g)
            {
        ?>
            <tr>
                <td><input type="checkbox" name="cat_id[]" value="<?php echo $g['ID'];?>"></td>
                <td><a class="view" href="<?php echo module_url( array( 'category' , 'manage' , $g[ 'ID' ] ) , 'blogster' );?>"><?php echo $g['CATEGORY_NAME'];?></a></td>
                <td><?php echo $g['DESCRIPTION'];?></td>
                <td><?php echo get_instance()->date->time($g['DATE']);?></td>
            </tr>
        <?php
            }
        }
        else
        {
            ?>
            <tr>
                <th colspan="3"><?php _e( 'No category to displays' );?></th>
            </tr>
            <?php
        }
        ?>
        </form>
        </tbody>
    </table>
</div>