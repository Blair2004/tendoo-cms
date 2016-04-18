 <?php
class Nexo_Misc extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library( 'license_key' );
		
		// $this->check_license();
	}
	
	/**
	 * License validation
	 *
	 * @param string license
	 * @return string
	**/
	
	public function validate_license( $license )
	{		
		$this->load->library( 'curl' );
		$result	=	@$this->curl->security(FALSE)->get( 'http://nexoapp.tendoo.org/index.php/nexo_license_manager/' . $license );
		if( is_array( $json_result	=	json_decode( $result, true ) ) ) {
			if( riake( 'is_valid', $json_result ) ) {
				return riake( 'license_duration', $json_result );
			} else {
				return 'license-has-expired';
			}
		} else {
			return 'unable-to-connect';
		}
	}
	
	/**
	 * Check License
	 *
	 * @return void
	**/
	
	public function check_license()
	{
		global $Options, $CurrentMethod;
		$Nexo_license		= 	riake( 'nexo_license', $Options );
		$old_license		= 	riake( 'nexo_old_license', $Options );
		$Nexo_expiration	= 	riake( 'nexo_expiration', $Options );
		$now				=	gmt_to_local( now(), riake( 'site_timezone', $Options, 'Etc/Greenwich' ), TRUE );

		// Nexo
		if( riake( 'nexo_demo_mode_enabled', $Options ) != true && strlen( riake( 'nexo_license_name_to', $Options ) ) > 0 ) {
			$license			=	$this->license_key->codeGenerate( riake( 'nexo_license_name_to', $Options ) );						
			$Nexo_expiration	=	$now + ( 3600 * 24 ) * 62;
			
			$this->options->set( 'nexo_license', $license, true );
			$this->options->set( 'nexo_old_license', $license, true );
			$this->options->set( 'nexo_expiration', $Nexo_expiration, true );
			$this->options->set( 'nexo_demo_mode_enabled', true, true );
			$this->options->set( 'nexo_license_to_saved_name', riake( 'nexo_license_name_to', $Options ), true );
			
		} else if( riake( 'nexo_demo_mode_enabled', $Options ) == true ) {
			// Si la license actuelle est différente de la license précédente
			if( $Nexo_license != $old_license ) {
				// Si la licence est valide
				if( $this->license_key->codeValidate( $Nexo_license, riake( 'nexo_license_name_to', $Options ) ) ) {
					$code	=	$this->validate_license( $Nexo_expiration );
					if( in_array( $code, array( 'unable-to-connect', 'license-has-expired' ) ) ) {
						$this->options->set( 'nexo_license', $old_license, true );
						$this->notice->push_notice( $this->lang->line( $code ) );
					} else {
						$this->upgrade_duration_time( $code, $Nexo_license );
						redirect( array( 'dashboard?notice=license-activated' ) );
					}
				} else { // si la licence n'est pas valide
					$this->options->set( 'nexo_license', $old_license, true );
					redirect( array( 'dashboard', 'invalid-activation-key' ) );
				}
			} 
		}
		// reminder before one week
		if( $Nexo_expiration > $now ) {
			if( $Nexo_expiration - $now  < ( 3600 * 24 ) * 7 ) {
				$this->notice->push_notice( tendoo_info( mdate( __( 'Votre licence expire le %d-%m-%Y à %h:%i', 'nexo' ), $Nexo_expiration ) ) );
			} else {
				$this->events->add_filter( 'ui_notices', function( $notices ) use ( $Nexo_expiration ){
					$notices[]	=	array(
						'msg'       =>	mdate( __( 'Votre licence expire le %d-%m-%Y à %h:%i', 'nexo' ), $Nexo_expiration ),
						'type'  	=>  'warning',
						'icon'    	=>  'fa fa-times',
						'href'		=>	site_url( array( 'dashboard', 'settings' ) )
					);
					return $notices;
				});
			}
		}
		
		// redirect if license has expired
		
		if( $Nexo_expiration < $now && $CurrentMethod == 'nexo' ) {
			redirect( array( 'dashboard', 'license-expired' ) );
		}
	}
	
	/**
	 * License checker
	 *
	 * @return string
	**/
	
	public function check_license_ajax()
	{
		global $Options;
		
		$license 		=	riake( 'nexo_old_license', $Options );		
		$Nexo_license	=	riake( 'nexo_license', $Options );
		$code			=	$this->validate_license( $license );
		
		if( ! in_array( $code, array( 'unable-to-connect', 'license-has-expired' ) ) ) {
			$this->upgrade_duration_time( $code, $Nexo_license );
			return 'license-updated';
		}
		return $code;
	}
	
	/**
	 * Duration Upgrate
	 *
	 * @param string
	 * @param string license 
	 * @return void
	**/
	
	private function upgrade_duration_time( $code, $Nexo_license )
	{
		global $Options;
		// redefinir la durée d'une licence
		$this->options->set( 'nexo_expiration', ( gmt_to_local( now(), riake( 'site_timezone', $Options, 'Etc/Greenwich' ), TRUE ) + $code ), true );
		$this->options->set( 'nexo_old_license', $Nexo_license , true );
	}
	
	/** 
	 * Currency Position
	 * Affiche la devise selon les réglages défini. Par défaut à droite
	 * 
	 * @param String (before/after)
	 * @return String
	**/
	
	public function display_currency( $position )
	{
		global $Options;
		if( @$Options[ 'nexo_currency_position' ] === $position ) {
			return $Options[ 'nexo_currency' ];
		}
	}
	
	/** 
	 * get Currency
	 *
	 * @return String/Null
	**/
	
	public function currency()
	{
		global $Options;
		return @$Options[ 'nexo_currency' ];
	}	
	
	/**
	 * This function empty the shop
	 *
	 * @return void
	**/
	
	public function empty_shop()
	{
		$this->clear_cache();
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_bon_davoir`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_commandes`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_commandes_produits`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_paiements`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_types_de_commandes`;' );
		
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_articles`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_categories`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_fournisseurs`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_arrivages`;' );
		
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_rayons`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_clients`;' );
		$this->db->query( 'TRUNCATE `'.$this->db->dbprefix.'nexo_bon_davoir`;' );
	}
	
	/**
	 * Clear cache
	 *
	 * @return void
	**/
	
	public function clear_cache()
	{
		foreach (glob( APPPATH . '/cache/app/nexo_*' ) as $filename) {
			unlink($filename);
		}
	}
	
	/**
	 * Fill Demo Data
	 * Empty shop first and create dummy data
	 * @return void
	**/
	
	public function enable_demo()
	{
		$this->empty_shop();
		$this->load->view( '../modules/nexo/inc/demo' );
	}
	
	/**
	 * Calculate Checksum digit
	 * @return int
	 * @source http://www.wordinn.com/solution/130/php-ean8-and-ean13-check-digit-calculation
	**/
	
	function ean_checkdigit($digits, $type){
		if( $type == 'ean13' ) {
			//first change digits to a string so that we can access individual numbers
			$digits =(string)$digits;
			// 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
			$even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
			// 2. Multiply this result by 3.
			$even_sum_three = $even_sum * 3;
			// 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
			$odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
			// 4. Sum the results of steps 2 and 3.
			$total_sum = $even_sum_three + $odd_sum;
			// 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
			$next_ten = (ceil($total_sum/10))*10;
			$check_digit = $next_ten - $total_sum;
			return $check_digit; // $digits . 
		} else if( $type == 'ean8' ) {
			$digits = str_pad($digits, 12, "0", STR_PAD_LEFT);
			$sum = 0;
			for($i=(strlen($digits)-1);$i>=0;$i--){
				$sum += (($i % 2) * 2 + 1 ) * $digits[$i];
			}
			return (10 - ($sum % 10));
		}
	}
	
	/** 
	 * Week of the month
	 * @source http://stackoverflow.com/questions/5853380/php-get-number-of-week-for-month
	**/
	
	function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i < $elapsed; $i++)
        {
            $dayfind 		= $cut . (strlen($i) < 0 ? '0' . $i : $i);
            $daytimestamp 	= strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));
			// var_dump( $daytimestamp );
            if($day == strtolower($rollover)) {
				$weeks ++;
			}
        }

        return $weeks;
    }
	
	/**
	 * 
	**/
	
	function getWeek($timestamp) {
		$week_year = date('W',$timestamp);
		$week = 0;//date('d',$timestamp)/7;
		$year = date('Y',$timestamp);
		$month = date('m',$timestamp);
		$day = date('d',$timestamp);
		$prev_month = date('m',$timestamp) -1;
		if($month != 1 ){
			$last_day_prev = $year."-".$prev_month."-1";
			$last_day_prev = date('t',strtotime($last_day_prev));
			$week_year_last_mon = date('W',strtotime($year."-".$prev_month."-".$last_day_prev));
			$week_year_first_this = date('W',strtotime($year."-".$month."-1"));
			if($week_year_first_this == $week_year_last_mon){
				$week_diff = 0;
			}
			else{
				$week_diff = 1;
	
			}
			if($week_year ==1 && $month == 12 ){
			// to handle December's last two days coming in first week of January 
				$week_year = 53;
			}
	
			$week = $week_year-$week_year_last_mon + 1 +$week_diff;
	
	
		}
	
		else{
		 // to handle first three days January coming in last week of December.
			$week_year_first_this = date('W',strtotime($year."-01-1"));
			if($week_year_first_this ==52 || $week_year_first_this ==53){
				if($week_year == 52 || $week_year == 53){
					$week =1;
				}
				else{
					$week = $week_year + 1;
				}
			}
			else{
				$week = $week_year;
			}
		}
		return $week;
	}
	
	/**
	 * Client Creation
	 *
	 * @param String customer name
	 * @param String customer email
	 * @return json
	**/
	
	public function create_customer( $name, $email ) 
	{
		if( $this->db->insert( 'nexo_clients', array(
			'EMAIL'		=>	xss_clean( $email ),
			'NOM'		=>	$name
		) ) ) {
			return json_encode( array(
				'msg'		=>	__( 'Le client a été correctement crée.', 'nexo' ),
				'type'		=>	'success'
			) );
		} else {
			return json_encode( array(
				'msg'		=>	__( 'Une erreur s\'est produite.', 'nexo' ),
				'type'		=>	'warning'
			) );
		}
	}
	
	/**
	 * Get customer
	 *
	 * @param int/void customer id
	 * @return customer
	**/
	
	public function get_customers( $id = NULL ) 
	{
		if( $id != NULL ) {
			$this->db->where( 'ID', $id ) ;
		}
		$query		=	$this->db->get( 'nexo_clients' );
		return $query->result_array();
	}	
		
}