<?php
/**
 * Starting Cache
 * Cache should be manually restarted
**/

if( ! $order_cache = $cache->get( $order[ 'order' ][0][ 'ID' ] ) || @$_GET[ 'refresh' ] == 'true' )
{
	ob_start();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo sprintf( __( 'Order ID : %s &mdash; Nexo Shop Receipt', 'nexo' ), $order[ 'order' ][0][ 'CODE' ] );?></title>
<link rel="stylesheet" media="all" href="<?php echo css_url( 'nexo' ) . '/bootstrap.min.css';?>" />
</head>

<body>
<?php global $Options;?>
<div class="container-fuild">
    <div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                    <strong><?php echo $Options[ 'site_name' ];?></strong> <br>
                    <?php echo @$Options[ 'nexo_shop_street' ];?> <br>
                    <?php echo @$Options[ 'nexo_shop_pobox' ];?> <br>
                    <abbr title="<?php _e( 'Téléphone', 'nexo' );?>"><?php _e( 'P:', 'nexo' );?></abbr> <?php echo @$Options[ 'nexo_shop_phone' ];?>
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p> <em><?php echo mdate( __( 'Date: %d/%m/%Y', 'nexo' ), strtotime( $order[ 'order' ][0][ 'DATE_CREATION' ] ) );?></em> </p>
                    <p> <em><?php echo sprintf( __( 'Ticket : #%s' ), 
						$order[ 'order' ][0][ 'CODE' ] );?></em> </p>
					<p> <em><?php echo sprintf( __( 'Type de la commande: %s', 'nexo' ), $this->Nexo_Checkout->get_order_type( $order[ 'order' ][0][ 'TYPE' ] ) );?></em></p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1><?php _e( 'Ticket de caisse', 'nexo' );?></h1>
                </div>
                </span>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-8"><?php _e( 'Produits', 'nexo' );?></th>
                            <th>#</th>
                            <th class="col-md-2 text-center"><?php _e( 'Prix', 'nexo' );?></th>
                            <th class="col-md-2 text-center"><?php _e( 'Total', 'nexo' );?></th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
						$total_global	=	0;
						$total_unitaire	=	0;
						
						foreach( $order[ 'products' ] as $_produit ) {
							
							$total_global 	+= 	intval( $_produit[ 'PRIX_TOTAL' ] );
							$total_unitaire	+=	intval( $_produit[ 'PRIX' ] )
						?>
                        <tr>
                            <td class=""><em><?php echo $_produit[ 'DESIGN' ];?></em></td>
                            <td class="" style="text-align: center"> <?php echo $_produit[ 'QUANTITE' ];?> </td>
                            <td class="text-center">
                            <?php echo $this->Nexo_Misc->display_currency( 'before' );?>
							<?php echo intval( $_produit[ 'PRIX' ] );?>
                            <?php echo $this->Nexo_Misc->display_currency( 'after' );?>
                            </td>
                            <td class="text-center">
                            <?php echo $this->Nexo_Misc->display_currency( 'before' );?>
							<?php echo intval( $_produit[ 'PRIX_TOTAL' ] );?>
                            <?php echo $this->Nexo_Misc->display_currency( 'after' );?>
                            </td>
                        </tr>
                        <?php 
						}
						?>
                        <tr>
                            <td class=""><em><?php _e( 'Total', 'nexo' );?></em></td>
                            <td class="" style="text-align: center"> </td>
                            <td class="text-center">
                            <?php echo sprintf( 
								__( '%s %s %s', 'nexo' ), 
								$this->Nexo_Misc->display_currency( 'before' ), 
								intval( $total_unitaire ),
								$this->Nexo_Misc->display_currency( 'after' ) 
							);?>
                            </td>
                            <td class="text-center">
                            <?php echo sprintf( 
								__( '%s %s %s', 'nexo' ), 
								$this->Nexo_Misc->display_currency( 'before' ), 
								intval( $total_global ),
								$this->Nexo_Misc->display_currency( 'after' ) 
							);?>
                            </td>
                        </tr>
                        <tr>
                            <td class=""><em><?php _e( 'Ristourne', 'nexo' );?></em></td>
                            <td class="" style="text-align: center"> </td>
                            <td class="text-center"></td>
                            <td class="text-center">
                            <?php echo sprintf( 
								__( '%s %s %s', 'nexo' ), 
								$this->Nexo_Misc->display_currency( 'before' ), 
								intval( $_produit[ 'RISTOURNE' ] ),
								$this->Nexo_Misc->display_currency( 'after' ) 
							);?>
                            </td>
                        </tr>
                        <tr>
                            <td class=""><em><?php _e( 'Remise expresse', 'nexo' );?></em></td>
                            <td class="" style="text-align: center"> </td>
                            <td class="text-center"></td>
                            <td class="text-center">
                            <?php echo sprintf( 
								__( '%s %s %s', 'nexo' ), 
								$this->Nexo_Misc->display_currency( 'before' ), 
								intval( $_produit[ 'REMISE' ] ),
								$this->Nexo_Misc->display_currency( 'after' ) 
							);?>
                            </td>
                        </tr>
                        <tr>
                            <td class=""><em><?php _e( 'Somme perçu', 'nexo' );?></em></td>
                            <td class="" style="text-align: center"> </td>
                            <td class="text-center"></td>
                            <td class="text-center">
                            <?php echo sprintf( 
								__( '%s %s %s', 'nexo' ), 
								$this->Nexo_Misc->display_currency( 'before' ), 
								intval( $_produit[ 'SOMME_PERCU' ] ),
								$this->Nexo_Misc->display_currency( 'after' ) 
							);?>
                            </td>
                        </tr>
                        <?php
						$terme		=	intval( $Options[ 'nexo_order_comptant' ] ) == intval( $order[ 'order' ][0][ 'TYPE' ] ) ? __( '&Agrave; rembourser :', 'nexo' ) : __( 'Somme due :', 'nexo' );
						?>
                        <tr>
                            <td class="text-right" colspan="3"><h4><strong><?php echo $terme;?></strong></h4></td>
                            <td class="text-center text-danger"><h4><strong>
                            <?php echo $this->Nexo_Misc->display_currency( 'before' );?>
							<?php echo 
							abs( intval( $order[ 'order' ][0][ 'TOTAL' ] ) - 
							(	
								intval( $order[ 'order' ][0][ 'REMISE' ] ) +
								intval( $order[ 'order' ][0][ 'RABAIS' ] ) +
								intval( $order[ 'order' ][0][ 'RISTOURNE' ] ) + 
								intval( $order[ 'order' ][0][ 'SOMME_PERCU' ] )
							) )
							;?>
							<?php echo $this->Nexo_Misc->display_currency( 'after' );?>
                            </strong>
                            </h4></td>
                        </tr>
                    </tbody>
                </table>
                <div class="container-fluid hideOnPrint">
                    <div class="row hideOnPrint">
                        <div class="col-lg-6">
                            <a href="<?php echo site_url( array( 'dashboard', 'nexo', 'commandes', 'lists', 'edit', $order[ 'order' ][0][ 'ID' ] ) );?>" class="btn btn-success btn-lg btn-block"><?php _e( 'Modifier la commande', 'nexo' );?></a>
                        </div>
                        <div class="col-lg-6">
                            <a href="<?php echo site_url( array( 'dashboard', 'nexo', 'commandes', 'lists' ) );?>" class="btn btn-success btn-lg btn-block"><?php _e( 'Revenir à la liste des produits', 'nexo' );?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
@media print {
	.hideOnPrint {
		display:none !important;
	}
}
</style>
</body>
</html>
<?php
if( ! $cache->get( $order[ 'order' ][0][ 'ID' ] ) || @$_GET[ 'refresh' ] == 'true' )
{
	$cache->save( $order[ 'order' ][0][ 'ID' ], ob_get_contents(), 999999999 ); // long time
}