<script>
var NexoScreen			=	'edit';
var NexoCurrentClient	=	0;
var NexoCommandesEdit	=	new function(){
		this.GetOrder	=	function( orderID ){
			$.ajax( tendoo.dashboard_url  + '/nexo/rest/get/nexo_commandes/ID',{
				success	:	function( a ){
					NexoCommandes.AutomatePercentDiscount	=	false;
					NexoCommandes.SetOtherCharge( parseInt( a[0].RISTOURNE ) );
					// Si la ristourne est supérieure à 0
					if( parseInt( a[0].RISTOURNE ) > 0 ) {
						console.log( a[0].RISTOURNE );
						NexoCommandes.DisplayDiscountText( a[0].DISCOUNT_TYPE );
					}
					NexoCommandesEdit.GetOrderProducts( a[0].CODE );										
					// console.log( a );
					$( '#crudForm' ).append( '<input type="hidden" name="command_code" value="' + a[0].CODE + '">' );
				},
				data	:	{
					'key'	:	orderID
				},
				type:'POST',
				dataType:"json"
			});
		}
		this.GetOrderProducts	=	function( orderCode ){
			$.ajax( tendoo.dashboard_url  + '/nexo/rest/get/nexo_commandes_produits/REF_COMMAND_CODE',{
				success	:	function( a ){
					NexoCommandesEdit.FillCart( a )
				},
				data	:	{
					'key'	:	orderCode
				},
				type:'POST',
				dataType:"json"
			});
		}
		this.FillCart			=	function( a ){
			var products		=	new Array();
			_.each( a, function( value, key ) {
				$.ajax( tendoo.dashboard_url  + '/nexo/rest/get/nexo_articles/CODEBAR',{
					success	:	function( product_details ){
						/**
						 * On considere que comme le produit est en cours de modification, les produits sont remis en stock
						**/
						value					=	_.extend( value, product_details[0] );
						value.ADDED_TO_CART		=	parseInt( value.QUANTITE );
						value.QUANTITE_RESTANTE	=	parseInt( product_details[0].QUANTITE_RESTANTE ) + value.ADDED_TO_CART;
						value.QUANTITE_VENDU	= 	parseInt( product_details[0].QUANTITE_VENDU ) - value.ADDED_TO_CART;
						for( i = 1; i <= value.QUANTITE; i++ ){
							NexoCommandes.TreatProduct( new Array( value ) );	
						}						
					},
					data	:	{
						'key'	:	value.REF_PRODUCT_CODEBAR
					},
					type:'POST',
					dataType:"json"
				});
			});
		}
	}
	var url			=	document.location.href,
		urlToRemove	=	'<?php echo site_url( array( 'dashboard', 'nexo', 'commandes', 'lists', 'edit' ) );?>/',
		NexoOrderId	=	url.substr( urlToRemove.length );
$(document).ready(function(e) {		
	// Modification de l'écran	
	NexoCurrentClient	=	$( '[name="REF_CLIENT"]' ).val();
	NexoCommandesEdit.GetOrder( NexoOrderId );
});
</script>