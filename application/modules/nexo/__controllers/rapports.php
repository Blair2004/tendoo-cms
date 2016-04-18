<?php
use Carbon\Carbon;

class Nexo_Reports extends CI_Model
{
	function __construct( $args )
	{
		parent::__construct();
		if( is_array( $args ) && count( $args ) > 1 ) {
			if( method_exists( $this, $args[1] ) ){
				return call_user_func_array( array( $this, $args[1] ), array_slice( $args, 2 ) );
			} else {
				return $this->index();
			}			
		}
		return $this->index();
	}
	
	function index()
	{
		$this->journalier();
	}
	
	function journalier( $start_date = null, $end_date = null )
	{
		global $Options;
		
		switch( @$Options[ 'site_language' ] ) {
			case 'fr_FR'	:	$lang	= 'fr'; break;
			default 		: 	$lang 	= 'en'; break;
		}
		
		Carbon::setLocale( $lang );
				
		$this->cache		=	new CI_Cache( array('adapter' => 'file', 'backup' => 'file', 'key_prefix'	=>	'nexo_daily_reports_' ) );
				
		if( $start_date == null && $end_date == null ) {
		
			// Start Date
			$CarbonStart	=	Carbon::parse( date_now() )->startOfMonth();
			
			// End Date
			$CarbonEnd		=	Carbon::parse( date_now() )->endOfMonth();
			
			// Is Date valid
			$DateIsValid	=	$CarbonStart->lt( $CarbonEnd );
			
			// Default date
			$start_date		=	$CarbonStart->toDateString();
			$end_date		=	$CarbonEnd->toDateString();
			
		} else {
			
			// Start Date
			$CarbonStart	=	Carbon::parse( $start_date );
			
			// End Date
			$CarbonEnd		=	Carbon::parse( $end_date );
			
			// Is Date valid
			$DateIsValid	=	$CarbonStart->lt( $CarbonEnd );

		}
		
		$data				=	array(
			'report_slug'	=>	 'from-' . $start_date . '-to-' . $end_date
		);
		
		if( ! $DateIsValid ) {
			show_error( sprintf( __( 'Le rapport ne peut être affiché, la date spécifiée est incorrecte', 'nexo' ) ) );
		}
		
		if( $CarbonStart->diffInMonths( $CarbonEnd ) > 999 ) {
			show_error( sprintf( __( 'Le rapport ne peut être affiché, l\'intervale de date ne peut excéder 3 mois.', 'nexo' ) ) );
		}
		
		$this->load->model( 'Nexo_Misc' );
		
		$this->Gui->set_title( sprintf( __( 'Rapport des ventes journalières du %s au %s &mdash; Nexo', 'nexo' ), $CarbonStart->formatLocalized('%A %d %B %Y'), $CarbonEnd->formatLocalized('%A %d %B %Y') ) );
				
		$data[ 'start_date' ] 	=	$CarbonStart->toDateString();
		$data[ 'end_date' ]		=	$CarbonEnd->toDateString();
		$data[ 'CarbonStart' ]	=	$CarbonStart;
		$data[ 'CarbonEnd' ]	=	$CarbonEnd;
		$data[ 'Cache' ]		=	$this->cache;
		
		$this->load->view( "../modules/nexo/views/reports/daily.php", $data );
	}
}

new Nexo_Reports( $this->args );