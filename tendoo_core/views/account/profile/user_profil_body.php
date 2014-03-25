<?php echo $smallHeader;?>
<section class="bg-light lt">
    <div class="panel-content">
        <div class="wrapper scrollable">
            <section class="panel">
                <h4 class="font-thin padder">Détails</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>Pseudo : <?php echo $this->core->users_global->current('PSEUDO');?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Nom : <?php echo $this->core->users_global->current('NAME');?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Pr&eacute;nom : <?php echo $this->core->users_global->current('SURNAME');?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Sexe : <?php echo $this->core->users_global->current('SEX');?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder">Contact</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>Email : <?php echo $this->core->users_global->current('EMAIL');?></p>
                    </li>
                    <li class="list-group-item">
                        <p>T&eacute;l&eacute;phone : <?php echo $this->core->users_global->current('PHONE');?></p>
                    </li>
                </ul>
            </section>
            <section class="panel">
                <h4 class="font-thin padder">Emplacement g&eacute;ographique</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <p>Pays : <?php echo $this->core->users_global->current('STATE');?></p>
                    </li>
                    <li class="list-group-item">
                        <p>Ville : <?php echo $this->core->users_global->current('CITY');?></p>
                    </li>
                </ul>
            </section>
        </div>
    </div>
</section>
