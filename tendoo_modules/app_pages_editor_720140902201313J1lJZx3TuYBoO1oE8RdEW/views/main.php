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
                            <option value="draft">Brouilllon</option>
                        </select>
                        <button class="btn btn-sm btn-white">Exécuter</button>
                    </div>
                </div>
                <div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm"></small> </div>
                <div class="col-sm-4 text-right text-center-xs">
                    <?php bootstrap_pagination_parser( $paginate );?>
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
                        Liste des page cr&eacute;&eacute;es
                        </div>
                        <div class="table-responsive">
                            <table tableMultiSelect class="table table-striped m-b-none">
                                <thead>
                                    <tr>
                                    	<th width="40"><input type="checkbox" id="check_all" /></th>
                                        <th width="500">Titre</th>
                                        <th>Auteur</th>
                                        <th>Atatché à </th>
                                        <th>Date de creation</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>	
                                	<form id="bulkSelect" method="post">
                                	<?php
									if( is_array( $get_pages ) && count( $get_pages ) > 0 ){
										foreach( $get_pages as $_pages ){
												$author			=	get_instance()->users_global->getUser( $_pages[ 'AUTHOR' ] );
												$controller		=	get_instance()->tendoo->get_controllers( 'filter_cname' , $_pages[ 'CONTROLLER_REF_CNAME' ] ); 
											?>
									<tr>
                                    	<td><input type="checkbox" name="page_id[]" value="<?php echo $_pages[ 'ID' ];?>" /></td>
                                    	<td><a href="<?php echo module_url( array( 'edit' , $_pages[ 'ID' ] ) );?>"><?php echo return_if_array_key_exists( 'TITLE' , $_pages );?> <?php echo $_pages[ 'STATUS' ] == 0 ? '<span class="text-muted">[ Brouillon ]</span>' : '';?></a></td>
                                        <td><?php echo $author[ 'PSEUDO' ];?></td>
                                        <td>
										<?php echo 
											return_if_array_key_exists( 'PAGE_TITLE' , $controller[0] )
												? return_if_array_key_exists( 'PAGE_TITLE' , $controller[0] ) : "Aucun contrôleur";
										;?></td>
                                        <td><?php echo $this->date->timespan( $_pages[ 'DATE' ] );?></td>
                                        <td>
                                        	<?php 
											if( is_array( $controller ) ){
												?>
                                                <a href="<?php echo get_instance()->url->site_url(array( $controller[0][ 'PAGE_CNAME' ] ) );?>">Voir la page</a>
                                                <?php
											}
											else{
												if( is_array( $_pages[ 'THREAD' ] ) ){
												?>
                                                <a href="<?php echo get_instance()->url->site_url( $_pages[ 'THREAD' ] );?>">Voir la page</a>
                                                <?php
												}
												else {
													echo is_string( $_pages[ 'THREAD' ] ) ? $_pages[ 'THREAD' ] : '';
												}
											}
											?>
                                        </td>
                                    </tr>                                            
                                            <?php
										}
									}
									else
									{
										?>
                                        <tr>
                                        	<td colspan="5">Aucun page disponible. <a href="<?php echo module_url( array( 'create' ) );?>">Cliquez ici pour créer une nouvelle page</a>.</td>
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
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>