<?php
	
	$currentTime	=	$this->core->tendoo->datetime();
	$dateArray		=	$this->core->tendoo->time(strtotime($currentTime),TRUE);
	$stats			=	$this->core->tendoo_admin->tendoo_visit_stats();
	$visitLine		=	'';
	//echo '<pre>';
	//echo print_r($stats,TRUE);
	//echo '</pre>';
	if(array_key_exists($dateArray['M'],$stats['statistics']['unique'][$dateArray['y']]))
	{
		$totalUnique	=	$stats['statistics']['unique'][$dateArray['y']][$dateArray['M']]['totalVisits'];
		$totalGlobal	=	$stats['statistics']['global'][$dateArray['y']][$dateArray['M']]['totalVisits'];
	}
	else
	{
		$totalUnique	=	0;
		$totalGlobal	=	0;
		$this->core->notice->push_notice(tendoo_info('Aucune visite n\'a &eacute;t&eacute; &eacute;ffectu&eacute;e ce mois'));
	}
	
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
 ?>
<?php echo $lmenu;?>

<section id="content">
  <section class="vbox">
    <?php echo $inner_head;?>
    <section class="scrollable" id="pjax-container">
      <header>
      <div class="row b-b m-l-none m-r-none">
        <div class="col-sm-4">
          <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
          <p class="block text-muted">
            <?php echo $pageDescription;?>
          </p>
        </div>
      </div>
      </header>
      <section class="scrollable">
        <div class="wrapper">
          <div class="row">
			<div class="col-lg-12">
			<?php
			if($priv_stats == FALSE || count($stats['ordered']) <= 1)
			{
				echo tendoo_warning('Si aucun graphisme ne s\'affiche, c\'est certainement parce qu\'il n\'y a pas beaucoup de donn&eacute;e &agrave; traiter');
			}
			$this->core->notice->parse_notice();
			?>
			</div>
          	<div class="col-lg-4">
            <section class="panel">
              <header class="panel-heading">Statistiques sur les utilisateurs</header>
              <div class="panel-body text-center">
                <div class="sparkline inline" data-type="pie" data-height="250" data-slice-colors="[<?php
				if(is_array($priv_stats))
				{
					array('#cafa5d','#c159e2','#a7404a','#011a89','#af198b','#549fbc'); // aborded
					$array	=	array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f');
					for($i=0; $i < count($priv_stats);$i++)
					{
						$color	=	"'#".$array[rand(0,count($array)-1)].$array[rand(0,count($array)-1)].$array[rand(0,count($array)-1)].$array[rand(0,count($array)-1)].$array[rand(0,count($array)-1)].$array[rand(0,count($array)-1)]."'";
						if(isset($priv_stats[(int)$i+1]))
						{
							echo $color.',';
						}
						else
						{
							echo $color;
						}
						$priv_stats[$i]['COLOR']	=	$color;
					}
				}
				?>]"><?php
				if(is_array($priv_stats) && $priv_stats == TRUE)
				{
					for($i=0; $i < count($priv_stats);$i++)
					{
						if(isset($priv_stats[(int)$i+1]))
						{
							echo $priv_stats[$i]['POURCENTAGE'].',';
						}
						else
						{
							echo $priv_stats[$i]['POURCENTAGE'];
						}
					}
				}
				?></div>
                <div class="line pull-in"></div>
                <div class="text-xs">
                <?php
				if(is_array($priv_stats) && $priv_stats	== TRUE)
				{
					foreach($priv_stats as $p)
					{
						$color	=	substr($p['COLOR'],1);
						$color	=	substr($color,0,-1);
						?>
                        <i class="fa fa-circle" style="color:<?php echo $color;?>"></i> <?php echo $p['PRIV_NAME'];?>
                        <?Php
					}
				}
				else
				{
				?>
				Statistique indisponible, aucun privil&egrave;ge ne semble avoir &eacute;t&eacute; cr&eacute;e.
				<?php
				}
				?>
                </div>
              </div>
            </section>
            </div>
            <div class="col-lg-8">
            	<div class="panel">
                	<header class="panel-heading <?php echo theme_class();?> lter"> <span class="pull-right"><?php echo $dateArray['month'];?></span> <span class="h4">Stats. sur <?php echo $this->core->tendoo_admin->getStatLimitation();?> mois<br>
                  <small class="text-muted"></small> </span>
                  <div class="text-center padder m-b-n-sm m-t-sm">
                    <div class="sparkline" data-type="line" data-resize="true" data-height="190" data-width="100%" data-line-width="2" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-data="[<?php echo $visitLine;?>]"></div>
                    <div class="sparkline inline"></div>
                  </div>
                </header>
                <div class="panel-body" style="height:105px;">
                  <div> <span class="text-muted">Visites ce mois (uniques/globales) :</span> <span class="h3 block"><?php echo $totalUnique;?>/<small><?php echo $totalGlobal;?></small></span> </div>
                  <div><small>Visites uniques</small> : <span><?php echo $overAllUnique;?></span></div>
                  <div><small>Visites r&eacute;guli&egrave;res</small> : <span><?php echo $overAllGlobal;?></span></div>
                </div>
                </div>
            </div>
          </div>
        </div>
      </section>
    </section>
  </section>
</section>
