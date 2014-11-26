<?php
if($state === true)
{
	?>
   	tendoo.notice.alert('Les privil&egrave;ges syst&egrave;me ont &eacute;t&eacute; mis &agrave; jour.','success');
    <?php
}
else
{
	?>
    tendoo.notice.alert('Une erreur s\'est produite durant la mise &agrave; jour des privil&egrave;ges syst&egrave;me','warning');
    <?php
}
?>