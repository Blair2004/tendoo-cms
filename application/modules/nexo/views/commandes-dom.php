<div class="row">
    <div class="col-lg-8">
        <div class="box box-primary">
            <div class="box-body" id="codebar-wrapper"> </div>
        </div>
        <div class="box box-primary" id="filter-wrapper" style="display:none;">
            <div class="box-header">
                <?php _e( 'Articles disponibles', 'nexo' );?>
            </div>
            <div class="box-body" style="max-height:400px;overflow-y:scroll;overflow-x: hidden;">
                <div class="row" id="filter-list"> </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <?php _e( 'Liste des articles', 'nexo' );?>
            </div>
            <table class="table Nexo-cart-table" style="font-size:20px;">
                <thead>
                    <tr>
                        <td><?php _e( 'Désignation', 'nexo' );?></td>
                        <td><?php _e( 'Prix Unitaire', 'nexo' );?></td>
                        <td><?php _e( 'Quantité', 'nexo' );?></td>
                        <td><?php _e( 'Prix Total', 'nexo' );?></td>
                        <td><?php _e( 'Opération', 'nexo' );?></td>
                    </tr>
                </thead>
                <tbody style="font-size:15px;">
                    <tr class="cart-empty">
                        <td colspan="5"><?php _e( 'Panier vide.', 'nexo' );?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-body" id="box-price">
                <h3><?php echo sprintf( __( 'Total : %s <span class="Nexo-cart-total-price ">0</span> %s' ), 
				$this->Nexo_Misc->display_currency( 'before' ), 
				$this->Nexo_Misc->display_currency( 'after' ) );?></h3>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body no-padding">
                <table class="table table-striped" id="cart-price-list">
                    <thead>
                        <tr>
                            <td><h4>
                                    <?php _e( 'Caisse', 'nexo' );?>
                                </h4></td>
                            <td width="150"><h4 id="discount-wrapper"></h4></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  class="bg-success">
                            <td><h4>
                                    <?php _e( 'Total :', 'nexo' );?>
                                </h4></td>
                            <td><h4> 
                            	<span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'after' );?> </span> 
                                <span class="Nexo-cart-total-price pull-right" style="margin-right:10px;">0</span> 
                                <span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'before' );?> </span> 
                                </h4></td>
                        </tr>
                        <tr class="bg-success">
                            <td><h4>
                                    <?php _e( 'Perçu :', 'nexo' );?>
                                </h4></td>
                            <td><h4> 
                            	<span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'after' );?> </span> 
                                <span class="Nexo-cart-received  pull-right" style="margin-right:10px;">0</span> 
                                <span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'before' );?> </span> 
                                </h4></td>
                        </tr>
                        <tr class="bg-danger">
                            <td><h4>
                                    <?php _e( 'Charge :', 'nexo' );?>
                                </h4></td>
                            <td><h4> 
                            	<span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'after' );?> </span> 
                                <span class="Nexo-cart-global-charge pull-right" style="margin-right:10px;">0</span> 
                                <span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'before' );?> </span> 
                                </h4></td>
                        </tr>
                        <tr class="bg-warning">
                            <td><h4>
                                    <?php _e( 'Reste :', 'nexo' );?>
                                </h4></td>
                            <td><h4> 
                            	<span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'after' );?> </span> 
                                <span class="Nexo-cart-left pull-right" style="margin-right:10px;">0</span> 
                                <span class="pull-right" style="margin-right:10px;"><?php echo $this->Nexo_Misc->display_currency( 'before' );?> </span> 
                                </h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-primary" id="checkout">
                    <?php _e( 'Valider la commande', 'nexo' );?>
                    </button>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body" id="box-price">
            	<?php global $order_id;?>
                <?php if( $order_id ) :?>
	                <a class="btn btn-primary" href="<?php echo site_url( array( 'dashboard', 'nexo', 'print', 'order_receipt', $order_id . '?refresh=true' ) );?>"><?php _e( 'Imprimer', 'nexo' );?></a>
                <?php endif;?>
                <a class="btn btn-success" href="<?php echo site_url( array( 'dashboard', 'nexo', 'commandes', 'lists' ) );?>"><?php _e( 'Retour', 'nexo' );?></a>
            </div>
        </div>
    </div>
</div>
