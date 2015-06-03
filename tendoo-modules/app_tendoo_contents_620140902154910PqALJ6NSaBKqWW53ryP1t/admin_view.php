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
                <h1>Gestionnaire de contenu<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->instance->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                
			</div>
		</div>
	</div>
</div>
        <?php
	}
	else if($loadSection == 'upload')
	{
		?>
        
<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Gestionnaire de contenu<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->instance->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Envoyer un fichier</h2>
                    
				</div>
			</div>
		</div>
	</div>
</div>            
        <?php
	}
	else if($loadSection == 'manage')
	{
		?>
<div id="body">
    <div class="page secondary with-sidebar">
        <div class="page-header">
            <div class="page-header-content">
                <h1>Editeur de fichiers<small></small></h1>
            <a class="back-button big page-back" href="<?php echo $this->instance->url->site_url(array('admin','modules'));?>"></a></div>
        </div>
        <?php echo $lmenu;?>          
        <div class="page-region">
            <div class="page-region-content">
                <div class="hub_table">
                	<h2>Modifier une page</h2>
                    <?php echo output('notice');?>
                    <?php echo fetch_notice_from_url();?>
                	
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
    Error occurred During loading.
    <?php
}
?>