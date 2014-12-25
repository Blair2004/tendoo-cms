<?php echo $smallHeader;?>
<section class="bg-light lt">
    <div class="panel-content">
        <div class="wrapper scrollable">
		<?php
		$unset		=	__( 'Unset' );
		?>
            <section class="panel">
                <h4 class="font-thin padder">Détails</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p><?php _e( 'Pseudo' );?> : <?php echo $user[0]['PSEUDO'];?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Name' );?> : <?php echo  $user[0]['NAME'] == '' ? 'Non sp&eacute;cifi&eacute;' :  $user[0]['NAME']?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Surname' );?> : <?php echo  $user[0]['SURNAME'] == '' ? 'Non sp&eacute;cifi&eacute;' : $user[0]['SURNAME']?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Sex' );?> : <?php echo $user[0]['SEX'] == '' ? 'Non speacute;cifi&eacute;' : $user[0]['SEX']?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder"><?php _e( 'Contact Details' );?></h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p><?php _e( 'Email' );?> : <?php echo $user[0]['EMAIL'] == '' ? 'Non sp&eacute;cifi&eacute;' : $user[0]['EMAIL'];?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Cellphone' );?> : <?php echo $user[0]['PHONE'] == '' ? 'Non sp&eacute;cifi&eacute;' : $user[0]['PHONE'];?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder"><?php _e( 'Location Details' );?></h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p><?php _e( 'Country' );?> : <?php echo $user[0]['STATE'] == '' ? $unset : $user[0]['PHONE'];?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'City' );?> : <?php echo $user[0]['TOWN'] == '' ? $unset : $user[0]['TOWN'];?></p>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</section>
