function tendoo_controllers(){
	var edited			=	false;
	var logC			=	false; // afficher un log d'activité
	this.setEditStatus	=	function(e){
		edited			=	e;
	};
	// Parcours des enfants et attributions d'identifiant, mais également attributions de parent.
	var __loopChilds	=	function(c){
		var position	=	0;
		$(c).each(function(){
			position++;
			// Si le controlleur est enfant, donc le parent existe
			if($(this).parent().closest('[controllers]').length > 0)
			{
				// Identifiant du parent.
				var p_cname			=	$(this).parent().closest('[controllers]').find('[controller_cname]').val();
				// Priorité du controleur parcouru
				var cpriority		=	$(this).find('[controller_main]').val();
				if(cpriority == 'TRUE')
				{
					// Modification de la priorité.
					$(this).find('[controller_main]').eq(0).val('FALSE');
					// Suppression de la l'identification (comme principal).
					$(this).find('#controller_priority_status').html('');
					// Définition du premier frère comme principale
					$('.dd .dd-list').eq(0).find('[controllers]').eq(0).find('[controller_main]').eq(0).val('TRUE');
					$('.dd .dd-list').eq(0).find('[controllers]').eq(0).find('#controller_priority_status').eq(0).html('<small>- Index</small>');
					// Signification de la modification à l'utilisateur
					tendoo.notice.timeout(10000).alert('Un contrôleur enfant ne peut pas être défini comme principal, le premier contrôleur est désormais défini comme principal','warning');
				}
				// 
				if(logC === true)
				{
					$(this).find('.controller_name').eq(0).html('[ Position : '+position+' ; Parent : '+p_cname+']');
				}
				// alert($(this).closest('[controllers]').closest('[controllers]').html());
				// attribution en tant que parent à l'enfant.
				$(this).find('[controller_parent]').eq(0).val(p_cname);
			}
			else
			{
				if(logC === true)
				{
					$(this).find('.controller_name').eq(0).html('[ Position : '+position+' ; Parent : "none" ]');
				}
				// alert($(this).find('[controller_parent]').val());
				// Pour indiquer que le controlleur se trouve à la racine du menu
				$(this).find('[controller_parent]').eq(0).val('none');
			}
			if($(this).find('.dd-list').length > 0)
			{
				// Seulement lorsqu'il y a des enfants.
				if($(this).find('.dd-list').eq(0).children().length > 0)
				{
					// Affectation d'id de positionnement aux enfants
					__loopChilds($(this).find('.dd-list').eq(0).children());
				}
			}
		});
	};
	$('.dd').nestable({
		listNodeName	:	"ol",
		itemNodeName	:	"li",
		maxDepth		:	10,
		expandBtnHTML	:	'<button data-action="expand" class="dd-nodrag btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i></button>',
		collapseBtnHTML	:	'<button data-action="collapse" class="dd-nodrag btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i></button>'
	});
	$('.dd').on('change', function(e) {
		// Recupération de l'élément actuellement glissé
		__loopChilds($('.dd .dd-list').eq(0).children()); // Parcours des enfants
	});
	$('.remove_controller').bind('click',function(e){
		// Arrêter la propagation pour désactiver le "Drag"
		e.stopImmediatePropagation();
		var $this	=	$(this);
		tendoo.modal.confirm('Souhaitez-vous réellement supprimer ce contrôleur ? <br>La suppression d\'un contrôleur parent supprimera également ses enfants.<br><br><small>Pour remédier à une suppréssion, ne sauvegardez pas vos modifications</small>',function(){
			$this.closest('.dd-item').hide(500,function(){
				$(this).remove();
			});
		})
		return false;
		//
	});
}
$(document).ready(function(){
	tendoo.controllers	=	new tendoo_controllers()
});