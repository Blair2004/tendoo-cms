<div class="input-group">
  <span class="input-group-addon" id="basic-addon1"><?php _e( "Réinitialisation", "Nexo" );?></span>
  <select class="form-control" id="Nexo_restaure_value">
  	<option value=""><?php _e( 'Sélectionner une valeur', 'nexo' );?></option>
    <option value="empty_shop"><?php _e( 'Vider complètement la boutique', 'nexo' );?></option>
    <option value="empty_with_demo"><?php _e( 'Vide la boutique et restaure les données démos', 'nexo' );?></option>
  </select>
  <span class="input-group-btn">
    <button class="btn btn-default" type="button" id="Nexo_restaure"><?php _e( 'Reinitialiser', 'nexo' );?></button>
  </span>
</div>
<br />

<?php echo tendoo_info( __( 'Ce privilège n\'est accordé qu\'aux utilisateurs ayant le rôle de gestionnaire de la boutique ou d\'administrateur du site. Utilisez cette option pour reinitialiser la boutique. Un rapport d\'activité sera enregistré.', 'nexo' ) );?>

<?php echo tendoo_warning( __( 'La réinitialisation de la boutique entrainera suppréssion de toutes les données actives: produits, catégories, rayons, fournisseurs, arrivage, commandes, clients et les réglages', 'nexo' ) );?>

<script type="text/javascript">
var	NexoRestaure	=	new function(){
	
	this.AllowEnterPress	=	false;
	
	this.__get		=	function( option ){
		if( option == 'restaure_value' ) {
			return $( '#Nexo_restaure_value' ).val();
		}
	}
	// 
	this.prompt		=	function(){
		if( NexoRestaure.__get( 'restaure_value' ) == '' ) {
			tendoo.notify.warning(
				'<?php echo addslashes( __( 'Attention !', 'nexo' ) );?><br>', 
				'<?php echo addslashes( __( 'Une option de réinitialisation doit être choisie.', 'nexo' ) );?>'
			);
			return true; // abord the process
		}
		bootbox.prompt({
			title: '<?php echo addslashes( __( 'Veuillez entrer votre mot de passe', 'nexo' ) );?>',
			callback: function(result) {
				if( result == '' ){
					tendoo.notify.warning( 
						'<?php echo addslashes( __( 'Mot de passe réquis', 'nexo' ) );?><br>', 
						'<?php echo addslashes( __( 'Vous devez spécifier un mot de passe.', 'nexo' ) );?>'
					);
				} else if( result != null ){
					NexoRestaure.doReset( result );
				}
			},
			buttons	: {
				confirm : {
				  label: "<?php echo addslashes( __( 'Restaurer', 'nexo' ) );?>",
				  className: "btn-success restaure-confirm",
				  callback: function() {
					Example.show("great success");
				  }
				},
			}
		});
		// Change text input to password
		$( '.restaure-confirm' ).closest( '.modal-content' ).find( '.modal-body input[type="text"]' ).attr( 'type', 'password' );

		$( '.restaure-confirm' ).closest( '.modal-content' ).find( '.modal-body input[type="password"]' ).bind( 'focus', function(){
			NexoRestaure.AllowEnterPress	=	true;
		});
		$( '.restaure-confirm' ).closest( '.modal-content' ).find( '.modal-body input[type="password"]' ).bind( 'blur', function(){
			NexoRestaure.AllowEnterPress	=	false;
		});
	}
	//
	this.doReset	=	function( password ){
		$.ajax( '<?php echo site_url( array( 'dashboard', 'nexo', 'reset_shop' ) );?>', {
			success	:	function(a){
				if( _.isObject( a ) ) {
					eval( 'tendoo.notify.' + a.type + '( "<?php echo addslashes( __( 'Attention', 'nexo' ) );?><br>", a.msg );' );
				}
			},
			dataType: 	"json",
			type: 'POST',
			data	:	_.object([ '_nexo_uz_pwd', 'reset_type' ], [ password, NexoRestaure.__get( 'restaure_value' ) ] )
		});
	};
};
$( '#Nexo_restaure' ).bind( 'click', function(){
	NexoRestaure.prompt();
});
$(document).keypress(function(e) {
	if( e.which == 13 && NexoRestaure.AllowEnterPress == true ) {
		$('.restaure-confirm' ).trigger( 'click' );
	}
});
</script>