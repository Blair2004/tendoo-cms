<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<h4><?php echo __( 'App Keys' , 'aauth');?></h4>
<div class="list-group">
<?php
if( is_array( $apps ) && $apps ) {
    ?>
    <?php echo tendoo_info( __( 'Click on any key to revoke it' , 'aauth') );?>
    <?php
    foreach( $apps as $app ) {
        $app    =   (array)$app;
?>
    <li class="list-group-item">
        <h4 class="list-group-item-heading"><?php echo $app[ 'app_name' ];?><a href="<?php echo site_url( array( 'rest', 'core', 'app_api', 'revoke', $app[ 'id' ] ) );?>" class="api_keys pull-right"><i class="fa fa-remove"></i></a></h4>
        <p class="list-group-item-text"><?php echo sprintf( __( 'Scopes : %s' , 'aauth'), $app[ 'scopes' ] );?><br>
            <small><?php echo sprintf( __( 'Created on : %s' , 'aauth'), $app[ 'date_created' ] );?></small><br>
            <small><?php echo sprintf( __( 'Expire on : %s' , 'aauth'), $app[ 'expire' ] );?></small><br>
            <small><?php echo sprintf( __( 'Keys : %s' , 'aauth'), $app[ 'key' ] );?></small>
        </p>
    </li>
<?php
    }
} else {
    ?>
    <a href="#" class="list-group-item"><?php echo __( 'No application is linked to this account.' , 'aauth');?></a>
    <?php
}
?>
</div>
<script type="text/javascript">
$( document ).ready( function(){
    $( '.api_keys' ).bind( 'click', function(){
        $this   =   $( this );
        bootbox.confirm( '<?php echo __( 'Would you like to revoke this App key ?' , 'aauth');?>', function( action ){
            if( action ) {
                $.ajax({
                    url     :   $this.attr( 'href' ),
                    success     :   function(){
                        $this.fadeOut( 500, function(){
                            $(this).closets( 'li' );
                        })
                    },
                    method  :   'DELETE'
                })
            }
        });
        return false;
    })
})
</script>
