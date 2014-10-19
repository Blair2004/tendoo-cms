<?php
if($this->users_global->isSuperAdmin() || $this->tendoo_admin->adminAccess('system','toolsAccess',$this->users_global->current('PRIVILEGE')) != FALSE)
{
	if($this->users_global->current('SHOW_ADMIN_INDEX_STATS') == "1")
	{
		$currentTime	=	$this->instance->date->datetime();
		$dateArray		=	$this->instance->date->time(strtotime($currentTime),TRUE);
		$stats			=	$this->instance->stats->tendoo_visit_stats();
		$visitLine		=	'';
		if(array_key_exists($dateArray['M'],$stats['statistics']['unique'][$dateArray['y']]))
		{
			$totalUnique	=	$stats['statistics']['unique'][$dateArray['y']][$dateArray['M']]['totalVisits'];
			$totalGlobal	=	$stats['statistics']['global'][$dateArray['y']][$dateArray['M']]['totalVisits'];
		}
		else
		{
			$totalUnique	=	0;
			$totalGlobal	=	0;
			notice('push',tendoo_info('Aucune visite n\'a &eacute;t&eacute; &eacute;ffectu&eacute;e ce mois'));
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
	}
	if((int)$this->users_global->current('SHOW_ADMIN_INDEX_STATS') == 1)
	{
	?>
    <div class="panel">
        <header class="panel-heading <?php echo theme_class();?> lter"> <span class="pull-right"><?php echo $dateArray['month'];?></span> <span class="h4">Stats. sur <?php echo $this->instance->stats->getStatLimitation();?> mois<br>
            <small class="text-muted"></small> </span>
            <div class="text-center padder m-b-n-sm m-t-sm">
                <div class="sparkline" data-type="line" data-resize="true" data-height="48" data-width="100%" data-line-width="2" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-data="[<?php echo $visitLine;?>]"></div>
                <div class="sparkline inline"></div>
            </div>
        </header>
        <div class="panel-body" style="height:105px;">
            <div> <span class="text-muted"><?php _e( 'All visits this month (unique/global)' );?> :</span> <span class="h3 block"><?php echo $totalUnique;?>/<small><?php echo $totalGlobal;?></small></span> </div>
            <div><small><?php _e( 'Unique visits' );?></small> : <span><?php echo $overAllUnique;?></span></div>
            <div><small><?php _e( 'Regular visits' );?></small> : <span><?php echo $overAllGlobal;?></span></div>
        </div>
    </div>
    <?php
	}
}