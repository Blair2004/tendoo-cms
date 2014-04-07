<?php
class tendoo_stats
{
	private $statsLimitation	=	5;
	public function __construct()
	{
		__extends($this);
	}
	public function getStatLimitation()
	{
		return $this->statsLimitation;
	}
	public function tendoo_visit_stats()
	{
		$month_limit	=	$this->statsLimitation;
		$currentDate	=	$this->tendoo->global_date('month_current_date');
		$time			=	new DateTime($currentDate);
		$time->modify('- '.$month_limit.' months');
		$ts_global		=	$time->format('Y-m-d H:i:s');
		$te_this_month	=	$this->tendoo->global_date('month_end_date');
		$uniqueVisits	=	$this->db->where('DATE >=',$ts_global)->order_by('DATE','asc')->get('tendoo_visit_stats');
		$uniqueResult	=	$uniqueVisits->result_array();
		$array			=	array();
		if(count($uniqueResult) > 0)
		{
			foreach($uniqueResult as $u)
			{
				$currentDate	=	$u['DATE'];
				$timeDecompose	=	$this->tendoo->time($currentDate,TRUE);
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
			$currentDate	=	$this->tendoo->datetime();
			$timeDecompose	=	$this->tendoo->time($currentDate,TRUE);
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