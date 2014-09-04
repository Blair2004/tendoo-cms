<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                    
                </div>
                <div class="col-sm-4 text-center">  </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        <?php 
                if(is_array($paginate[4]))
                {
                    foreach($paginate[4] as $p)
                    {
                        ?>
                        <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
                        <?php
                    }
                }
            ?>
                    </ul>
                </div>
            </div>
        </footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo output('notice');?>  <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
                    <section class="panel">
                        <div class="panel-heading"> Liste des fichiers </div>
                        <table class="table table-striped b-t text-sm">
                            <thead>
                                <tr>
                                    <th>Aperçu</th>
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
                            $user	=	$this->instance->users_global->getUser($t['AUTHOR']);
                    ?>
                                <tr>
                                    <td><img style="width:50px;height:50px;" src="<?php echo $this->instance->url->main_url().'tendoo-modules/'.$opened_module['encrypted_dir'].'/content_repository/'.$t['FILE_NAME'];?>" alt="<?php echo $t['FILE_NAME'];?>"></td>
                                    <td><a href="<?php echo $this->instance->url->site_url(array('admin','open','modules',$opened_module['namespace'],'manage',$t['ID']));?>"><?php echo $t['TITLE'];?></a></td>
                                    <td><?php echo word_limiter($t['DESCRIPTION'],200);?></td>
                                    <td><a href="<?php echo $this->instance->url->main_url().'tendoo-modules/'.$opened_module['encrypted_dir'].'/content_repository/'.$t['FILE_NAME'];?>"><?php echo $t['FILE_NAME'];?></a></td>
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
