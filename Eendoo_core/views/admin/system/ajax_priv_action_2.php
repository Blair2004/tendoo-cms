<?php
if($state === true)
{
	?>
   Tendoo.notice.alert('Les privil&egrave;ges communs ont &eacute;t&eacute; correctement mis &agrave; jour.');
    <?php
}
else
{
	?>
    Tendoo.notice.alert('Une erreur s\'est produit durant la mise &agrave; jour des actions communes. Veuillez re-essayer.');
    <?php
}
?>