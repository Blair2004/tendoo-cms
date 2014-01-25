<?php echo $lmenu;?>
<section id="content">
<section class="vbox">
<?php echo $inner_head;?>

<section class="scrollable" id="pjax-container">
<header>
    <div class="row b-b m-l-none m-r-none">
        <div class="col-sm-4">
            <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
            <p class="block text-muted"><?php echo $pageDescription;?></p>
        </div>
    </div>
</header>
<section class="scrollable wrapper">
<?php echo notice_from_url();?>
<?php
if($options[0]['SHOW_ADMIN_INDEX_STATS'] == "1")
{
		$currentTime	=	$this->core->tendoo->datetime();
		$dateArray		=	$this->core->tendoo->time(strtotime($currentTime),TRUE);
		$stats			=	$this->core->tendoo_admin->tendoo_visit_stats();
		$visitLine		=	'';
		$totalUnique	=	$stats['statistics']['unique'][$dateArray['y']][$dateArray['M']]['totalVisits'];
		$totalGlobal	=	$stats['statistics']['global'][$dateArray['y']][$dateArray['M']]['totalVisits'];
		$overAllUnique	=	$stats['statistics']['overAll']['unique']['totalVisits'];
		$overAllGlobal	=	$stats['statistics']['overAll']['global']['totalVisits'];
		//echo '<pre>';
		//print_r();
		//echo '</pre>';
		if(is_array($stats['ordered']))
		{
			foreach($stats['ordered'] as $year)
			{
				foreach($year as $month)
				{
					$uniqVisit[]	=	count($month);
				}
			}
			for($i=0;$i<count($uniqVisit);$i++)
			{
				if(array_key_exists($i+1,$uniqVisit))
				{
					$visitLine.=	$uniqVisit[$i].',';
				}
				else
				{
					$visitLine.=	$uniqVisit[$i];
				}
			}
		}
		else
		{
			$visitLine	=	'';
		}
}
		?>
<!-- data-toggle="tooltip" data-placement="right" title="" data-original-title="Statistiques sur le traffic de votre site." -->
<div class="row">
<div class="col-lg-9">
	<div class="icon-grid">
    <?php
	if(is_array($appIconApi))
	{
		foreach($appIconApi as $a)
		{
			eval($options[0]['ADMIN_ICONS']);
			if(isset($icons))
			{
				foreach($icons as $i)
				{
					if($i	==	$a['ICON_MODULE_NAMESPACE'].'/'.$a['ICON_NAMESPACE'])
					{
			?>
		<img data-toggle="tooltip" data-placement="right" title="<?php echo $a['ICON_HUMAN_NAME'];?>" data-original-title="Statistiques sur le traffic de votre site." class="G-icon" data-url="<?php echo $this->core->url->site_url(array('admin','open','modules',$a['ICON_MODULE']['ID'].'?ajax=true'));?>" src="<?php echo $this->core->tendoo_admin->getAppImgIco($a['ICON_MODULE']['NAMESPACE']);?>">
            <?php
					}
				}
			}
		}
	}
	?>
    </div>
    <ul class="list-group gutter list-group-lg list-group-sp sortable">
    <?php
	if($options[0]['SHOW_ADMIN_INDEX_STATS'] == "1")
	{
	?>
        <li class="list-group-item" draggable="true" style="padding:0px;" data-id="<?php echo $this->core->tendoo_admin->getGridId();?>">
            <header class="panel-heading bg-success lter"> <span class="pull-right"><?php echo $dateArray['month'];?></span> <span class="h4">Stats. sur <?php echo $this->core->tendoo_admin->getStatLimitation();?> mois<br>
                <small class="text-muted"></small> </span>
                <div class="text-center padder m-b-n-sm m-t-sm">
                    <div class="sparkline" data-type="line" data-resize="true" data-height="48" data-width="100%" data-line-width="2" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-data="
                [<?php echo $visitLine;?>]"></div>
                    <div class="sparkline inline"></div>
                </div>
            </header>
            <div class="panel-body" style="height:105px;">
                <div> <span class="text-muted">Visites ce mois (uniques/globales) :</span> <span class="h3 block"><?php echo $totalUnique;?>/<small><?php echo $totalGlobal;?></small></span> </div>
                <div><small>Visites uniques</small> : <span><?php echo $overAllUnique;?></span></div>
                <div><small>Visites r&eacute;guli&egrave;res</small> : <span><?php echo $overAllGlobal;?></span></div>
            </div>
        </li>
        <?php
	}
		?>
        <li class="list-group-item" draggable="true" style="padding:0px;" data-id="<?php echo $this->core->tendoo_admin->getGridId();?>">
        	<?php
					if($options[0]['SHOW_WELCOME'] == 'TRUE')
					{
					?>
        <div class="panel-body">
            <div class="carousel slide auto" id="c-slide">
                <ol class="carousel-indicators out" style="bottom:10px;">
                    <li data-target="#c-slide" data-slide-to="0" class=""></li>
                    <li data-target="#c-slide" data-slide-to="1" class=""></li>
                    <li data-target="#c-slide" data-slide-to="2" class="active"></li>
                </ol>
                <div class="carousel-inner" style="min-height:180px;" >
                    <div class="item">
                        <p class="text-center" style="padding:10px;"> <em class="h4 text-mute">B&acirc;tir une application web</em><br>
                            <small class="text-muted">Faites vos Premiers pas en tant que <a href="#">développeurs</a> ou en tant que <a href="#">simple utilisateur</a>, vous y trouverez un manuel adapt&eacute; &agrave; vos demandes. Si c'est votre premiere connexion, vous pouvez modifier les <a href="<?php echo $this->core->url->site_url('admin/setting');?>">param&ecirc;tres</a> de votre site web. D&eacute;counvrez toujours plus d'astuces sur la cr&eacute;ation d'application web dans le manuel d'instruction.</small> </p>
                    </div>
                    <div class="item">
                        <p class="text-center"> <em class="h4 text-mute">C'est quoi Tendoo ?</em><br>
                            <small class="text-muted">Tendoo vous permet de rapidement cr&eacute;er votre site web, sans avoir n&eacute;cessairement besoin d'un expert. La cr&eacute;ation et la gestion d'un site web ne pourra pas &ecirc;tre plus facile. Si vous d&eacute;butez, <a href="#">vous devez savoir ceci</a>, cependant si vous &ecirc;tes un habitu&eacute; de CMS, ce petit aperçu vous sera utile.</small> </p>
                    </div>
                    <div class="item active">
                        <p class="text-center"> <em class="h4 text-mute">Bienvenue sur <strong><?php echo $this->core->tendoo->getVersion();?></strong></em><br>
                            <small class="text-muted">L'&eacute;quipe vous remercie d'avoir choisi Tendoo comme application pour la cr&eacute;ation de votre site web / application web. Si vous demarrez sur Tendoo, consultez la <a href="http://Tendoo.site90.com/index.php/firstSteps/" target="_blank">documentation</a> sur les premiers pas, et commercez &agrave; personnaliser Tendoo.</small> </p>
                    </div>
                </div>
                <a class="left carousel-control" href="http://flatfull.com/themes/todo/components.html#c-slide" data-slide="prev"> <i class="icon-angle-left"></i> </a> <a class="right carousel-control" href="http://flatfull.com/themes/todo/components.html#c-slide" data-slide="next"> <i class="icon-angle-right"></i> </a> </div>
        </div>
    <?php
					}
					?>
        </li>
    </ul>
    <!-- <?php echo $this->core->tendoo_admin->getGridId();?>--> 
</div>
<div class="col-lg-3">
    <section class="panel">
        <header class="panel-heading bg-success">Statistiques</header>
        <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
            <li class="list-group-item">Modules install&eacute;s <span class="badge bg-success"><?php echo $ttModule;?></span></li>
            <li class="list-group-item">Th&egrave;mes install&eacute;s <span class="badge bg-success"><?php echo $ttTheme;?></span></li>
            <li class="list-group-item">Pages cr&eacute;ées <span class="badge bg-success"><?php echo $ttPages;?></span></li>
            <li class="list-group-item">Privil&egrave;ges cr&eacute;es <span class="badge bg-success"><?php echo $ttPrivileges;?></span></li>
        </ul>
    </section>
    <div class="panel-group m-b" id="accordion2">
        <div class="panel">
            <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> Collapsible Group Item #1 </a> </div>
            <div id="collapseOne" class="panel-collapse in">
                <div class="panel-body text-sm"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt. </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo"> Collapsible Group Item #2 </a> </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body text-sm"> Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"> Collapsible Group Item #3 </a> </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body text-sm"> Sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. </div>
            </div>
        </div>
    </div>
</div>
</section>
</section>
</section>
