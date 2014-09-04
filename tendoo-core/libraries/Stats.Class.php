<?php
class stats
{
	private $statsLimitation	=	5;
	public function __construct()
	{
		$this->instance	=	get_instance();
		$this->db		=	get_db();
	}
	public function addVisit()
	{
		$ts_this_month	=	$this->global_date('month_start_date');
		$te_this_month	=	$this->global_date('month_end_date');
		$query	=	$this->instance->db->where('DATE >=',$ts_this_month)->where('DATE <=',$te_this_month)->where('VISITORS_IP',$_SERVER['REMOTE_ADDR'])->get('tendoo_visit_stats');
		$result	=	$query->result_array();
		if(!$result)
		{
			$datetime	=	$this->instance->date->datetime();
			$this->instance->db->insert('tendoo_visit_stats',array(
				'DATE'					=>	$datetime,
				'VISITORS_IP'			=>	$_SERVER['REMOTE_ADDR'],
				'VISITORS_USERAGENT'	=>	$_SERVER['HTTP_USER_AGENT'],
				'GLOBAL_VISIT'			=>	1
			));
		}
		else
		{
			$datetime	=	$this->instance->date->datetime();
			$this->instance->db->where('DATE >=',$ts_this_month)
				->where('DATE <=',$te_this_month)
				->where('VISITORS_IP',$_SERVER['REMOTE_ADDR'])
				->update('tendoo_visit_stats',array(
				'DATE'					=>	$datetime,
				'VISITORS_IP'			=>	$_SERVER['REMOTE_ADDR'],
				'VISITORS_USERAGENT'	=>	$_SERVER['HTTP_USER_AGENT'],
				'GLOBAL_VISIT'			=>	(int)$result[0]['GLOBAL_VISIT'] + 1
			));
		}
	}
	public function global_date($request = NULL,$type = 'default')
	{
		$currentTime	=	$this->instance->date->datetime();
		$currentTimeTS	=	strtotime($currentTime);
		$nbrDays		=	date('t',$currentTimeTS);
		$dateArray		=	$this->instance->date->time($currentTimeTS,TRUE);
		
		$elapsedTS		=	(int)$dateArray['d'] * 86400; // 86400 seconde par jour
		$TS_start_month	=	$currentTimeTS - $elapsedTS; // timestamp for the start of this month
		$ti_start_month	=	date('c',$TS_start_month); // date "c" format for the start of this month
		$TS_end_month	=	((int)$nbrDays * 86400) + $TS_start_month;
		$ti_end_month	=	date('c',$TS_end_month); // Date "c" format fot the end of this month
		$time_start_month=	$this->instance->date->time($ti_start_month,TRUE);
		
		$time_start_month=	$time_start_month['y'].'-'.$time_start_month['M'].'-'.$time_start_month['d'].' '.$time_start_month['h'].':'.$time_start_month['i'].':'.$time_start_month['s'];
		$time_end_month	=	$this->instance->date->time($ti_end_month,TRUE);
		$time_end_month	=	$time_end_month['y'].'-'.$time_end_month['M'].'-'.$time_end_month['d'].' '.$time_end_month['h'].':'.$time_end_month['i'].':'.$time_end_month['s'];
		if($request == 'month_start_date')
		{
			if($type == 'default')
			{
				return $time_start_month;
			}
			else if($type == 'timestamp')
			{
				return $TS_start_month;
			}
		}
		if($request == 'month_end_date')
		{
			if($type == 'default')
			{
				return $time_end_month;
			}
			else if($type == 'timestamp')
			{
				return $TS_end_month;
			}
		}
		if($request	==	'current_day')
		{
			return $dateArray['d'];
		}
		if($request == 'day_this_month')
		{
			return $nbrDays;
		}
		if($request == 'month_current_date')
		{
			if($type == 'default')
			{
				return $currentTime;
			}
			else if($type == 'timestamp')
			{
				return $currentTimeTS;
			}
		}
	}
		public function getStatLimitation()
	{
		return $this->statsLimitation;
	}
	public function tendoo_visit_stats()
	{
		$month_limit	=	$this->statsLimitation;
		$currentDate	=	$this->global_date('month_current_date');
		$time			=	new DateTime($currentDate);
		$time->modify('- '.$month_limit.' months');
		$ts_global		=	$time->format('Y-m-d H:i:s');
		$te_this_month	=	$this->global_date('month_end_date');
		$uniqueVisits	=	$this->db->where('DATE >=',$ts_global)->order_by('DATE','asc')->get('tendoo_visit_stats');
		$uniqueResult	=	$uniqueVisits->result_array();
		$array			=	array();
		if(count($uniqueResult) > 0)
		{
			foreach($uniqueResult as $u)
			{
				$currentDate	=	$u['DATE'];
				$timeDecompose	=	$this->instance->date->time($currentDate,TRUE);
				if(!isset($array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']))
				{
					$array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	0;
				}
				$array['ordered'][$timeDecompose['y']][$timeDecompose['M']][]	=	$u;
				$array['listed'][]	=	$u;
				$array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	+=	(int)$u['GLOBAL_VISIT'];
				$sumQuery		=	$this->db->select('COUNT(DISTINCT VISITORS_IP) as `UNIQUE_VISIT`')->where('DATE >=',$timeDecompose['y'].'-'.$timeDecompose['M'].'-'.(1))->where('DATE <=',$timeDecompose['y'].'-'.$timeDecompose['M'].'-'.$timeDecompose['t'])->get('tendoo_visit_stats');
				$sumResult		=	$sumQuery->result_array();
				$array['statistics']['unique'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	$sumResult[0]['UNIQUE_VISIT'];
			}
		}
		else
		{
			$currentDate	=	$this->instance->date->datetime();
			$timeDecompose	=	$this->instance->date->time($currentDate,TRUE);
			$array['statistics']['global'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	0;
			$array['statistics']['unique'][$timeDecompose['y']][$timeDecompose['M']]['totalVisits']	=	0;
			$array['ordered']	=	null;
		}
		// Recupère information globales
		$overAllUniqueQuery		=	$this->db->select('COUNT(DISTINCT VISITORS_IP) as `UNIQUE_GLOBAL`')->where('DATE >=',$ts_global)->get('tendoo_visit_stats');
		$overAllUniqueResult	=	$overAllUniqueQuery->result_array();
		
		$array['statistics']['overAll']['unique']['totalVisits']	=	$overAllUniqueResult[0]['UNIQUE_GLOBAL'];
		$overAllGlobalQuery		=	$this->db->select('SUM(GLOBAL_VISIT) as `MULTIPLE_GLOBAL`')->where('DATE >=',$ts_global)->get('tendoo_visit_stats');
		$overAllGlobalResult	=	$overAllGlobalQuery->result_array();
		$array['statistics']['overAll']['global']['totalVisits']	=	$overAllGlobalResult[0]['MULTIPLE_GLOBAL'];
		return $array;
		//	$array['CURRENT_MONTH']['VISITS']['GLOBAL']	=	$visitGlobal;
	}
	
}