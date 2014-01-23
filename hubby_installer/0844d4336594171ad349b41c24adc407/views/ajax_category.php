<section class="hbox stretch"><?php echo $ajaxMenu;?>
    
    <section id="content">
        <section class="vbox">
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Liste des cat&eacute;gories</h4>
                        <div class="panel">
                            <table class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                        <th width="300">Nom</th>
                                        <th>Description</th>
                                        <th>Date de cr&eacute;ation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                if(count($getCat) > 0)
                {
                    foreach($getCat as $g)
                    {
                ?>
                                    <tr>
                                        <th><a class="view" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','manage',$g['ID'].'?ajax=true'));?>"><?php echo $g['CATEGORY_NAME'];?></a></th>
                                        <th><?php echo $g['DESCRIPTION'];?></th>
                                        <th><?php echo timespan(strtotime($g['DATE']));?></th>
                                    </tr>
                                    <?php
                    }
                }
                else
                {
                    ?>
                                    <tr>
                                        <th colspan="3">Aucune cat&eacute;gorie disponible</th>
                                    </tr>
                                    <?php
                }
                ?>
                                </tbody>
                            </table>
                        </div>
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <?php 
            if(is_array($paginate[4]))
            {
                foreach($paginate[4] as $p)
                {
                    ?>
                            <li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'].'?ajax=true';?>"><?php echo $p['text'];?></a></li>
                            <?php
                }
            }
            ?>
                        </ul>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>