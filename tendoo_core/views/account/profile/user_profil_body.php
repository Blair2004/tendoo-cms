<?php echo $smallHeader;?>
<section class="bg-light lt">
    <div class="panel-content">
        <div class="wrapper scrollable">
		<?php
		$unset		=	'Non sp&eacute;cifi&eacute;';
		?>
            <section class="panel">
                <h4 class="font-thin padder">Détails</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>Pseudo : <?php echo $user[0]['PSEUDO'];?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Nom : <?php echo  $user[0]['NAME'] == '' ? 'Non sp&eacute;cifi&eacute;' :  $user[0]['NAME']?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Pr&eacute;nom : <?php echo  $user[0]['SURNAME'] == '' ? 'Non sp&eacute;cifi&eacute;' : $user[0]['SURNAME']?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Sexe : <?php echo $user[0]['SEX'] == '' ? 'Non speacute;cifi&eacute;' : $user[0]['SEX']?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder">Contact</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>Email : <?php echo $user[0]['EMAIL'] == '' ? 'Non sp&eacute;cifi&eacute;' : $user[0]['EMAIL'];?></p>
                    </li>
                    <li class="list-group-item">
                        <p>T&eacute;l&eacute;phone : <?php echo $user[0]['PHONE'] == '' ? 'Non sp&eacute;cifi&eacute;' : $user[0]['PHONE'];?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder">Emplacement g&eacute;ographique</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>Pays : <?php echo $user[0]['STATE'] == '' ? $unset : $user[0]['PHONE'];?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Ville : <?php echo $user[0]['TOWN'] == '' ? $unset : $user[0]['TOWN'];?></p>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</section>
