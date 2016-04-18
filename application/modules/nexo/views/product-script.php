<script type="text/javascript">
function isInt(n){
		return Number(n)===n && n%1===0;
	}
	function isFloat(n) {
		return n === +n && n !== (n|0);
	}
	function show_PRIX_DE_VENTE()
	{
		var prix_da		=	isNaN( parseInt( $('[name="PRIX_DACHAT"]').val() ) ) ? 0 : parseInt( $('[name="PRIX_DACHAT"]').val() );
		var frais_acess	=	isNaN( parseInt( $('[name="FRAIS_ACCESSOIRE"]').val() ) ) ? 0 : parseInt( $('[name="FRAIS_ACCESSOIRE"]').val() );
		var TAUX_DE_MARGE	=	! isFloat( parseFloat( $('[name="TAUX_DE_MARGE"]').val() ) ) && ! isInt( parseFloat( $('[name="TAUX_DE_MARGE"]').val() ) ) ? 0 : parseFloat( $('[name="TAUX_DE_MARGE"]').val() );
		var prix_vente	=	( prix_da + frais_acess ) * TAUX_DE_MARGE;
		$( '#PRIX_DE_VENTE_AFFICHE h3 .price' ).text( prix_vente );
		//
	}
	function check_if_product_exists()
	{
		var text		=	$('[name="DESIGN"]').val();
		$.ajax( tendoo.dashboard_url  + '/nexo/rest/get/nexo_articles/DESIGN',{
			success	:	function( a ){
				__check_if_product_exist( a );
			},
			data	:	{
				'key'	:	text
			},
			type:'POST',
			dataType:"json"
			
		});
	}
	function automate_taux_de_marge()
	{
		var whished_price	=	isInt( parseInt( $('[name="PRIX_DE_VENTE"]').val() ) ) ? parseInt( $('[name="PRIX_DE_VENTE"]').val() ) : 0;
		// var taux_de_marge	=	$('[name="TAUX_DE_MARGE"]').val();
		var FRAIS_ACCESSOIRE	=	parseInt( $('[name="FRAIS_ACCESSOIRE"]').val() );
		var PRIX_DACHAT		=	parseInt( $('[name="PRIX_DACHAT"]').val() );
		//
		var cout_dachat		=	( parseInt( FRAIS_ACCESSOIRE ) + parseInt( PRIX_DACHAT ) )
		var real_tmarge		=	whished_price / cout_dachat;
		
		$('[name="TAUX_DE_MARGE"]').val( real_tmarge ).focus().keyup().blur();
		$('[name="PRIX_DE_VENTE"]').focus();
	}
	function __check_if_product_exist( passed )
	{
		if( passed.length > 0 )
		{
			bootbox.confirm( '<?php _e( 'Un produit avec cette désignation existe déjà, souhaitez-vous pré-remplir ce formulaire ?', 'nexo' );?>' , function( result ){
				$('[name="TAUX_DE_MARGE"]').val( passed[0].TAUX_DE_MARGE );
				$('[name="PRIX_DE_VENTE"]').val( passed[0].PRIX_DE_VENTE );
				$('[name="PRIX_DACHAT"]').val( passed[0].PRIX_DACHAT );
				$('[name="REF_RAYON"]').val( passed[0].REF_RAYON );
				$('[name="FRAIS_ACCESSOIRE"]').val( passed[0].FRAIS_ACCESSOIRE );
			})
		}
	}

$(document).ready( function(){
	$('#PRIX_DE_VENTE_field_box' ).after( '<div id="PRIX_DE_VENTE_AFFICHE" class="form-field-box even"><h3>' + '<?php echo __( 'Prix', 'nexo' );?>'  + ' : <span class="price"></span></h3><div/>' );
		$('[name="PRIX_DACHAT"]').bind( 'keyup' , function(){
			show_PRIX_DE_VENTE();
		})
		$('[namep="FRAIS_ACCESSOIRE"]').bind( 'keyup' , function(){
			show_PRIX_DE_VENTE();
		})
		$('[name="TAUX_DE_MARGE"]').bind( 'keyup' , function(){
			show_PRIX_DE_VENTE();
		})
		$('[name="DESIGN"]').bind( 'blur' , function(){
			check_if_product_exists();
		});
		$('[name="PRIX_DE_VENTE"]').bind( 'keyup' , function(){
			automate_taux_de_marge();
		});
	});
	
</script>