<?php
if($state === true)
{
	?>
    $.Dialog({
        'title' : 'Mise &agrave; jour r&eacute;ussie',
        'content' : 'Les privil&egrave;ges syst&egrave;mes ont &eacute;t&eacute; correctement mis &agrave; jour.',
        'draggable' : false,
        'overlay' : true,
        'closeButton' : true,
        'buttonsAlign': 'right',
        'keepOpened' : false,
        'position' : {
        'zone' : 'center'
        },
        'buttons' : {
            'Fermer' : {
                'action': function(){}
            }
        }
    });
    <?php
}
else
{
	?>
    $.Dialog({
        'title' : 'Erreur',
        'content' : 'Une erreur s\'est produit durant la mise &agrave; jour des actions system. Veuillez re-essayer.',
        'draggable' : false,
        'overlay' : true,
        'closeButton' : true,
        'buttonsAlign': 'right',
        'keepOpened' : false,
        'position' : {
        'zone' : 'center'
        },
        'buttons' : {
            'Fermer' : {
                'action': function(){}
            }
        }
    });
    <?php
}
?>