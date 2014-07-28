<?php
$appIconApi	=	get_core_vars('admin_icons');
$options	=	get_options();
if(current_user('OPEN_APP_TAB') == '0')
{
  $icon_1	=	'';
  $collapse	=	'collapse';
}
else
{
  $icon_1	=	'active';
  $collapse	=	'';
}
?>
<div class="icon-grid panel-body" style="margin:0;padding:0;">
<?php
if($appIconApi)
{
    foreach($appIconApi as $a)
    {
        eval($options[0]['ADMIN_ICONS']);
        if(isset($icons) && count($icons) > 1)
        {
            foreach($icons as $i)
            {
                if($i	==	$a['ICON_MODULE_NAMESPACE'].'/'.$a['ICON_NAMESPACE'])
                {
                    // .'?ajax=true' we're no more accessing ajax content, but directly app.
        ?>
<div class="tendoo-icon-set" data-url="<?php echo $this->url->site_url(array('admin','open','modules',$a['ICON_MODULE']['ID']));?>"> <img class="G-icon" src="<?php echo $this->tendoo_admin->getAppImgIco($a['ICON_MODULE']['NAMESPACE']);?>">
<p><?php echo word_limiter($a['ICON_MODULE']['HUMAN_NAME'],4);?></p>
<!--<span class="badge up bg-info m-l-n-sm">300</span>--> 
</div>
<?php
                }
            }
        }
        else
        {
            echo tendoo_info('Aucune icone disponible. Activez les icones depuis <a href="'.$this->url->site_url(array('admin','setting')).'"><strong>les param&egrave;tres</strong></a>.');
        }
    }
}
else
{
    echo tendoo_info('Aucune icone disponible. Activez les icones depuis <a href="'.$this->url->site_url(array('admin','setting')).'"><strong>les param&egrave;tres</strong></a>.');
}
?>
</div>
<!-- <div class="panel">
    <header class="panel-heading">
        <ul class="nav nav-pills pull-right">
            <li> <a data-requestType="silent" data-url="<?php echo $this->url->site_url(array('admin','ajax','toogle_app_tab'));?>" href="#" class="panel-toggle text-muted <?php echo $icon_1;?>"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
        </ul>
        Applications </header>
    <div class="panel-body clearfix <?php echo $collapse;?>">
        
            
        </div>
    </div>
</div>
-->