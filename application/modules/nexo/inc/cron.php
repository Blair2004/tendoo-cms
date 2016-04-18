<?php
! defined( 'APPPATH' ) ? die() : NULL;

use Carbon\Carbon;

class Nexo_Cron extends CI_Model
{
	private $cache_namespace					=	'nexo_daily_stats_';
	public function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'load_dashboard_home', array( $this, 'run_cron' ) );
	}
	
	/**
	 * Run Cron
	 * 
	 * @return void
	**/
	
	public function run_cron()
	{
		$this->treat_stats();
	}
	
	/**
	 * Save Stats for this day
	 *
	 * @param String Start Date
	 * @param String End Date
	 * @return array
	**/
	
	public function daily_stats_saver( $start_date = NULL, $end_date = NULL, $useCache = TRUE )
	{
		$Cstart_date							=	$start_date == NULL ? date_now() : $start_date;
		$Cend_date								=	$end_date == NULL ? date_now() : $end_date;	
			
		$CarbonStart							=	Carbon::parse( $Cstart_date )->subDays( 7 );		
		$CarbonEnd								=	Carbon::parse( $Cend_date );
		$Stats									=	array();
		
		$this->init_cache();
		
		// $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file', 'key_prefix'	=>	$this->cache_namespace ) );		
		
		if( $CarbonStart->diffInDays( $CarbonEnd ) > 1 && $CarbonStart->lt( $CarbonEnd ) ) {
			// Looping Day beetween two dates
			for( $i = 0; $i < $CarbonStart->diffInDays( $CarbonEnd ); $i++ ) {
				
				// Get from cache
				if( $useCache ) {
					$Cache									=	$this->cache->get( $CarbonStart->copy()->addDays( $i )->toDateString() );
					// if cache exist for this date
					if( ! $Cache ) {
						$Stats[ $CarbonStart->copy()->addDays( $i )->toDateString() ]	=	$this->__get_stats( $CarbonStart, $CarbonEnd, $i );
						$this->cache->save( $CarbonStart->copy()->addDays( $i )->toDateString(), $Stats[ $CarbonStart->copy()->addDays( $i )->toDateString() ], 99999999999 );
					} else {
						$Stats[ $CarbonStart->copy()->addDays( $i )->toDateString() ]	=	$Cache;
					}
				}							
			}			
		}

		return $Stats;
	}
	
	private function __get_stats( $CarbonStart, $CarbonEnd, $i )
	{
		$Stats							=	array();
		$CarbonStartCopy				=	$CarbonStart->copy()->addDays( $i );
		$CarbonStartCopy->hour			=	0;
		$CarbonStartCopy->minute		=	0;
		$CarbonStartCopy->second		=	0;
		
		$CarbonStartCopy2				=	$CarbonStartCopy->copy();
		$CarbonStartCopy->hour			=	23;
		$CarbonStartCopy->minute		=	59;
		$CarbonStartCopy->second		=	59;
		
		$this->load->model( 'Nexo_Checkout' );
		
		// Get order for this day
		
		$Orders								=	$this->Nexo_Checkout->get_order( array(
			'DATE_CREATION >=' 				=>	$CarbonStartCopy2->toDateTimeString(),
			'DATE_CREATION <=' 				=> 	$CarbonStartCopy->toDateTimeString()
		) );
		
		$TotalOrder							=	$Orders ? count ( $Orders ) : 0;		
		$Stats[ 'order_nbr' ]				=	$TotalOrder;
		$Stats[ 'chiffre_daffaire_net' ]	=	0;
		
		if( ! empty( $Orders ) ) {
		
		foreach( $Orders as $Order ) {
			$RRR								=	intval( $Order[ 'RISTOURNE' ] ) + intval( $Order[ 'RABAIS' ] ) + intval( $Order[ 'REMISE' ] );
			$Stats[ 'chiffre_daffaire_net' ]	+=	abs( intval( $Order[ 'TOTAL' ] ) - $RRR );
		}
		
		}
		
		return $Stats;		
	}
	
	/**
	 * Treat Stats
	 *
	 * @param String Start date
	 * @param String End date 
	 * @return void 
	**/
	
	public function treat_stats( $start_date = NULL, $end_date = NULL )
	{
		// Reports Data
		$Stats			=	$this->daily_stats_saver( $start_date, $end_date );
	}
	
	/**
	 * Get Stat from a specific date
	 *
	**/
	
	public function get_stats( $start_date, $end_date ) 
	{
		$CarbonStart		=	Carbon::parse( $start_date );
		$CarbonEnd			=	Carbon::parse( $end_date );		
		$CarbonStartCopy	=	$CarbonStart->copy();
		$Dates				=	array();
		
		while( $CarbonEnd->diffInDays( $CarbonStartCopy ) > 0 || $CarbonEnd->isSameDay( $CarbonStartCopy ) ) {
            $Dates[]		=	$CarbonStartCopy->toW3cString();			
            if( $CarbonEnd->isSameDay( $CarbonStartCopy ) ) {
                break;
            }
            $CarbonStartCopy->addDay();
        }
		
		$Stats				=	array();
		
		$this->init_cache();
		
		foreach( $Dates as $Date ) {
			$CurrentDate	=	Carbon::parse( $Date );
			$Cache			=	$this->cache->get( $CurrentDate->toDateString() );
			if( $Cache ) {
				$Stats[ $CurrentDate->toDateString() ]	=	$Cache;
			}			
		}
		
		return $Stats;
	}
	
	/**
	 * Init Cache
	 *
	 * @return void
	**/
	
	public function init_cache()
	{
		$this->cache	=	new CI_Cache( array('adapter' => 'file', 'backup' => 'file', 'key_prefix'	=>	$this->cache_namespace ) );
	}
}
new Nexo_Cron;