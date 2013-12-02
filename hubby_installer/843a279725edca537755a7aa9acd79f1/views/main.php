<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> 
					<?php echo $this->core->notice->parse_notice();?> <?php echo $success;?> <?php echo notice_from_url();?> <?php echo validation_errors(); ?>
                    <section class="panel">
                        <div class="panel-heading"> Liste des fichiers </div>
                        <table class="table table-striped b-t text-sm">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Description</th>
                                    <th>Nom du fichier</th>
                                    <th>Type</th>
                                    <th>Auteur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                    if(count($files) > 0)
                    {
                        foreach($files as $t)
                        {
                            $user	=	$this->core->users_global->getUser($t['AUTHOR']);
                    ?>
                                <tr>
                                    <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'manage',$t['ID']));?>"><?php echo $t['TITLE'];?></a></td>
                                    <td><?php echo word_limiter($t['DESCRIPTION'],200);?></td>
                                    <td><a href="<?php echo $this->core->url->main_url().'hubby_modules/'.$data['_hubby_vars']['module'][0]['ENCRYPTED_DIR'].'/content_repository/'.$t['FILE_NAME'];?>"><?php echo $t['FILE_NAME'];?></a></td>
                                    <td><?php echo $t['FILE_TYPE'];?></td>
                                    <td><?php echo $user == true ? $user['PSEUDO'] : "Utilisateur Introuvable";?></td>
                                </tr>
                                <?php
                        }
                    }
                    else
                    {
                        ?>
                                <tr>
                                    <td colspan="5">Aucun fichier disponible</td>
                                </tr>
                                <?php
                    }
                    ?>
                            </tbody>
                        </table>
                    </section>
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
