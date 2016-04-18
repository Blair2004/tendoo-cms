<?php
return; // Deprecated

$this->Gui->add_meta( array(
	'type'			=>		'box-primary',
	'namespace'		=>		'Nexo_licence',
	'title'			=>		__( 'Licence', 'nexo' ),
	'col_id'		=>		2,
	'gui_saver'		=>		true,
	'footer'		=>		array(
		'submit'	=>		array(
			'label'	=>		__( 'Sauvegarder les réglages', 'nexo' )
		)
	),
	'use_namespace'	=>		false,
) );


$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_license',
	'label'		=>	__( 'Licence d\'utilisation', 'nexo' ),
	'placeholder'=>	__( 'Veuillez préciser votre licence.', 'nexo' ),
) , 'Nexo_licence' , 2 );

$this->Gui->add_item( array(
	'type'		=>	'text',
	'name'		=>	'nexo_license_name_to',
	'label'		=>	__( 'License attribuée à', 'nexo' ),
	'placeholder'=>	__( 'Veuillez préciser un nom', 'nexo' ),
) , 'Nexo_licence' , 2 );

ob_start();
?>
<button type="button" class="check-license btn btn-primary">Verifier la licence</button>
<script type="text/javascript">
$(document).ready(function(e) {
	$('.check-license').bind('click', function(){
		$.ajax('<?php echo site_url( array( 'dashboard', 'Nexo_license' ) );?>', {
			success : function( e ){
				if( e == 'unable-to-connect' ) {
					bootbox.alert( '<?php echo addslashes( __( "Impossible de se connecter. La licence n'a pas pu être validée", 'nexo' ) );?>' );
				} else if( e == 'license-has-expired' ) {
					bootbox.alert( '<?php echo addslashes( __( 'Cette license à expiré.', 'nexo' ) );?>' );
				} else if( e == 'license-updated' ) {
					bootbox.alert( '<?php echo addslashes( __( 'La license a été renouvellée.', 'nexo' ) );?>' );
				} else {
					bootbox.alert( '<?php echo addslashes( __( "Une erreur s'est produite durant la validation de la licence. La license est incorrecte ou le code renvoyé par le serveur est inattendu.", 'nexo' ) );?>' );
				}
			}
		})
	});
});
</script>
<br />
<br />
<?php
$output		=	ob_get_clean();

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	$output
), 'Nexo_licence', 2 );