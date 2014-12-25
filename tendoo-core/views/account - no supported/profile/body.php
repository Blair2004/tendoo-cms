<?php echo $smallHeader;?>
<section class="bg-light lt">
    <div class="panel-content">
        <div class="wrapper scrollable">
            <section class="panel">
                <h4 class="font-thin padder"><?php _e( 'Profile Details' );?></h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p><?php _e( 'Pseudo' );?> : <?php echo $this->instance->users_global->current('PSEUDO');?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Nom' );?> : <?php echo $this->instance->users_global->current('NAME');?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Surname' );?> : <?php echo $this->instance->users_global->current('SURNAME');?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Sex' );?> : <?php echo $this->instance->users_global->current('SEX');?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder"><?php _e( 'Contact Details' );?></h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p><?php _e( 'Email' );?> : <?php echo $this->instance->users_global->current('EMAIL');?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'Cellphone' );?> : <?php echo $this->instance->users_global->current('PHONE');?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder"><?php _e( 'Location Details' );?></h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p><?php _e( 'State' );?> : <?php echo $this->instance->users_global->current('STATE');?></p>
                    </li>
                    <li class="list-group-item">
                        <p><?php _e( 'City' );?> : <?php echo $this->instance->users_global->current('TOWN');?></p>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</section>
