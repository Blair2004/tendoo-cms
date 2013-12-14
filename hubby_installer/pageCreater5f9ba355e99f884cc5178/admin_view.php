<?php 
if(isset($loadSection))
{
	if($loadSection == 'main')
	{
		?>
<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Editeur de pages<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Liste des pages</h2>
                    <?php echo $this->core->notice->parse_notice();?>
                    <?php echo notice_from_url();?>
                	<table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Titre</td>
                                <td>Description</td>
                                <td>Date de creation</td>
                                <td>Auteur</td>
                                <td>Lien</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
            if(count($getPages) > 0)
            {
                foreach($getPages as $g)
                {
                    $user	=	$this->core->users_global->getUser($g['AUTHOR'])
            ?>
                <tr>
                    <td><a href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'edit',$g['ID']));?>"><?php echo $g['TITLE'];?></a></td>
                    <td><?php echo $g['DESCRIPTION'];?></td>
                    <td><?php echo $g['DATE'];?></td>
                    <td><?php echo $user['PSEUDO'];?></td>
                    <td><a href="<?php echo $this->core->url->site_url(array('hub_pages','index',$g['ID']));?>"><?php echo $this->core->url->site_url(array('hub_pages','index',$g['ID']));?></a></td>
                    <td><a onClick="if(confirm('Voulez-vous vraiment supprimer cette page ?')){return true;}else{return false};" href="<?php echo $this->core->url->site_url(array('admin','open','modules',$module[0]['ID'],'delete',$g['ID']));?>">Supprimer</a></td>
                </tr>
            <?php
                }
            }
            else
            {
                ?>
                <tr>
                    <td colspan="6">Aucune page n'a &eacute;t&eacute; cr&eacute;e.</td>
                </tr>
                <?php
            }
            ?>
            			</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
        <?php
	}
	else if($loadSection == 'create')
	{
		?>
        
<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Editeur de page<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Cr&eacute;er une page</h2>
                    <?php echo $this->core->notice->parse_notice();?>
                    <?php echo notice_from_url();?>
					<?php echo validation_errors('<strong class="error">','</strong>'); ?>
                    <form method="post" action="">
                        <div class="input-control text">
                            <input type="text" name="page_title" placeholder="Titre">
						</div>
                        <div class="input-control text">
                            <input type="text" name="page_description" placeholder="Description">
						</div>
                        <div class="input-control textarea">
                            <?php echo $this->core->hubby->getEditor(array('name'=>'page_content','id'=>'editor'));?>
						</div>
                        <input type="submit" value="Cr&eacute;er la page">
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>            
        <?php
	}
	else if($loadSection == 'edit')
	{
		?>
<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Editeur de pages<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->core->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Modifier une page</h2>
                    <?php echo $this->core->notice->parse_notice();?>
                    <?php echo notice_from_url();?>
                	<form method="post" action="" class="jNice">
                        <div class="input-control text">
                            <input type="text" name="page_title" value="<?php echo $pageInfo[0]['TITLE'];?>" placeholder="Titre">
                        </div>
                        <div class="input-control text">
                            <input type="text" name="page_description" value="<?php echo $pageInfo[0]['DESCRIPTION'];?>" placeholder="Description">
                        </div>
                        <div class="input-control text">
                            <label for="page_content"><span>Contenu</span> :</label>
                            <?php echo $this->core->hubby->getEditor(array('width'=>900,'height'=>500,'name'=>'page_content','id'=>'editor','defaultValue'=>$pageInfo[0]['CONTENT']));?>
                        </div>
                        <hr class="specialline">
                        <input type="hidden" name="page_id" value="<?php echo $pageInfo[0]['ID'];?>">
                        <input type="submit" value="Modifier la page">
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>
        <?php
	}
}
else
{
	?>
    Error Occured During loading.
    <?php
}
?>