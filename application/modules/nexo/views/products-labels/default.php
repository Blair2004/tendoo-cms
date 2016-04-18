<?php
/**
 * Starting Cache
 * Cache should be manually restarted
**/

global $Options;

$pp_row_limit	=	$pp_row;

if( ! $products_labels = $cache->get( $shipping_id ) || @$_GET[ 'refresh' ] == 'true' )
{
	ob_start();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo sprintf( __( 'Etiquettes des produits : %s &mdash; Nexo POS', 'nexo' ), $shipping_id );?></title>
<link rel="stylesheet" media="all" href="<?php echo module_url( 'nexo' ) . '/bower_components/bootstrap/dist/css/bootstrap.min.css';?>" />
</head>

<body>
	<div class="container-fluid">
    	<div class="hideOnPrint">
            <br>
            <form action="">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><?php _e( 'Circonscrire les articles', 'nexo' );?></button>
                  </span>
                  <input name="products_ids" type="text" class="form-control" placeholder="<?php _e( 'Spécifier les identifiants des produits', 'nexo' );?>">
                  <input type="hidden" name="refresh" value="true">
                </div><!-- /input-group -->
            </form>
            <br>
            <div class="btn-group" role="group" aria-label="...">
                <a href="<?php echo site_url( array( 'dashboard', 'nexo', 'arrivages', 'lists' ) );?>" class="btn btn-default">
	                <?php _e( 'Revenir à la liste des collections', 'nexo' );?>
                </a>
                <a href="<?php echo current_url() . '?refresh=true';?>" class="btn btn-default">
	                <?php _e( 'Désactiver le cache', 'nexo' );?>
                </a>
            </div>
            <br><br>
        </div>
		<table class="table table-bordered">
        	<thead>
				<tr>
                	<td colspan="<?php echo $pp_row_limit;?>"><?php _e( 'Etiquettes des produits', 'nexo' );?></td>
                </tr>
            </thead>
            <tbody>
            <?php 
			if( count( $products ) > 0 )
			{
				$start		=	1;
				foreach( $products as $product ) {
					
					$shipping		=	$this->Nexo_Shipping->get_shipping( $shipping_id, 'as_id' );
					
					// Parcours des produits restants
					for( $i = 0; $i < intval( $product[ 'QUANTITE_RESTANTE' ] ) ; $i++ ) {
						// Balise d'ouverture
						if( $start == 0 ) {
							echo '<tr>';
						}
					?>
					<td style="width:<?php echo ceil( 100 / $pp_row_limit );?>%;float:left;">
                    	<h4 class="text-center" style="margin:3px 0;"><?php echo $Options[ 'site_name' ];?></h4>
                    	<strong><?php echo sprintf( __( 'Nom : %s', 'nexo' ), $product[ 'DESIGN' ] );?></strong><br>
                        <small><?php echo sprintf( __( '<strong>Prix de vente</strong> : %s', 'nexo' ), 
							$this->Nexo_Misc->display_currency( 'before' ) . 
							$product[ 'PRIX_DE_VENTE' ] . 
							$this->Nexo_Misc->display_currency( 'after' ) );?>
						</small><br>
                        <small><?php echo sprintf( __( '<strong>Collection</strong> : %s', 'nexo' ), $shipping[0][ 'TITRE' ] );?></small><br>
                        <small><?php echo sprintf( __( '<strong>Code Barre</strong> : %s', 'nexo' ), $product[ 'CODEBAR' ] );?></small>
                        <hr style="margin:5px 0 10px;">
                    	<img style="width:100%;" src="<?php echo upload_url() . '/codebar/' . $product[ 'CODEBAR' ] . '.jpg';?>">
                    </td>
					<?php
						// Inclusion ou non de la balise de fin
						if( $start == $pp_row_limit ) {
							echo '</tr>';
							$start = 1;
						} else {
							$start++;
						}

					}					
				}
					
			} else {
				?>
                <tr>
                	<td colspan="<?php echo $pp_row_limit;?>"><?php _e( 'Aucun produit disponible', 'nexo' );?></td>
                </tr>
                <?php
			}
			?>
            </tbody>
        </table>
    </div>
</body>
</html>
<style>
@media print {
	.hideOnPrint {
		display:none !important;
	}
}
</style>
<?php
if( ! $cache->get( $shipping_id ) || @$_GET[ 'refresh' ] == 'true' )
{
	$cache->save( $shipping_id, ob_get_contents(), 999999999 ); // long time
}