<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
			<div class="row m-t-sm text-center-xs">
				<div class="col-sm-4">
					
				</div>
				<div class="col-sm-4 text-center"> <small class="text-muted inline m-t-sm m-b-sm">Montre <?php echo $paginate[1];?> &agrave; <?php echo $paginate[2];?> sur <?php echo $ttPrivileges;?> El&eacute;ments</small> </div>
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
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <div class="wrapper w-f">
                <div class="hub_table">
                	<?php echo validation_errors('<p class="error">', '</p>');?>
					<?php $this->core->notice->parse_notice();?>
                    <?php echo notice_from_url();?>
                    <section class="panel">
                        <div class="wrapper b-b font-bold">Liste des privil&egrave;ges</div>
                        <table class="table table-striped m-b-none">
                            <thead>
                                <tr>
                                    <td width="150">Identifiant</td>
                                    <td width="200">Nom</td>
                                    <td>Description</td>
                                    <td>Cr&eacute;&eacute;</td>
                                    <td title="Acc&eacute;ssible au public">Acc. au Pub.</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								if(count($getPriv) > 0)
								{
									foreach($getPriv as $g)
									{
									?>
                                    <tr>
                                    	<td><a href="<?php echo $this->core->url->site_url(array('admin','system','edit_priv',$g['PRIV_ID']));?>"><?php echo $g['PRIV_ID'];?></a></td>
                                    	<td><?php echo $g['HUMAN_NAME'];?></td>
                                        <td><?php echo $g['DESCRIPTION'];?></td>
                                        <td><?php echo timespan(strtotime($g['DATE']),$this->core->tendoo->timestamp());?></td>
                                        <td><?php echo $g['IS_SELECTABLE'] == "1" ? "Oui" : "Non";?></td>
                                        <td><a href="<?php echo $this->core->url->site_url(array('admin','system','delete_priv',$g['PRIV_ID']));?>">Supprimer</a></td>
                                    </tr>
                                    <?php
									}
								}
								else
								{
									?>
                                    <tr>
                                    	<td colspan="6">Aucun privil&egrave;ge cr&eacute;e</td>
                                    </tr>
                                    <?php
								}
								?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </section>
    </section>
</section>