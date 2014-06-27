<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-4">
                	<div bulkSelect target="#bulkSelect">
                        <select name="action" class="input-sm form-control input-s-sm inline">
                            <option value="0">Actions groupés</option>
                            <option value="delete">Supprimer</option>
                        </select>
                        <button class="btn btn-sm btn-white">Exécuter</button>
                    </div>
                </div>
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">Affiche <?php echo $paginate[1];?> + <?php echo $paginate[2];?> catégorie(s)</small> </div>
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
                <section class="wrapper"> 
					<?php echo output('notice');?> 
					
                    <?php echo fetch_error_from_url();?>
                	<section class="panel">
                    	<div class="panel-heading">
                        Liste des cat&eacute;gories cr&eacute;es
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none" tableMultiSelect>
                                <thead>
                                    <tr>
                                    	<th width=""><input type="checkbox"></th>
                                        <th width="300">Nom</th>
                                        <th>Description</th>
                                        <th>Date de cr&eacute;ation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <form method="post" id="bulkSelect">
                                <?php
                                if(count($getCat) > 0)
                                {
                                    foreach($getCat as $g)
                                    {
                                ?>
                                    <tr>
                                    	<td><input type="checkbox" name="cat_id[]" value="<?php echo $g['ID'];?>"></td>
                                        <td><a class="view" href="<?php echo $this->instance->url->site_url(array('admin','open','modules',$module[0]['ID'],'category','manage',$g['ID']));?>"><?php echo $g['CATEGORY_NAME'];?></a></td>
                                        <td><?php echo $g['DESCRIPTION'];?></td>
                                        <td><?php echo $this->instance->date->time($g['DATE']);?></td>
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
                                </form>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
            </section>
        </section>
        
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav">EEE</a> </section>