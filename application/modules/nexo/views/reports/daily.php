<?php
use Carbon\Carbon;

// Load Script and CSS on dashbaord header
$this->events->add_action( 'dashboard_header', function(){
	?>
	<!-- <script type="text/javascript" src="<?php echo module_url( 'nexo' );?>bower_components/jquery/dist/jquery.min.js"></script>-->
    <script type="text/javascript" src="<?php echo module_url( 'nexo' );?>bower_components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo module_url( 'nexo' );?>bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo module_url( 'nexo' );?>bower_components/underscore/underscore-min.js"></script>
    <link rel="stylesheet" href="<?php echo module_url( 'nexo' );?>bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />  
    <link rel="stylesheet" media="all" href="<?php echo module_url( 'nexo' ) . 'bower_components/bootstrap/dist/css/bootstrap.min.css';?>" />
    <?php
});

$this->events->add_filter( 'gui_page_title' , function( $title ){
	return '<section class="content-header"><h1>' . strip_tags( $title ) . ' <span class="pull-right"><a class="btn btn-primary btn-sm" href="' . current_url() . '?refresh=true">' . __( 'Vider le cache', 'nexo' ) . '</a> <a class="btn btn-default btn-sm" href="javascript:void(0)" print-item="#nexo-global-wrapper">' . __( 'Imprimer', 'nexo' ) . '</a></span></h1></section>';
});



// Load Options
global $Options;

// Set Cols Width
$this->Gui->col_width( 1, 4 );

// Add meta wrapper
$this->Gui->add_meta( array(
	'type'		=>		'unwrapped',
	'namespace'	=>		'daily_report'
) );

if( ! $Cache->get( $report_slug ) || @$_GET[ 'refresh' ] == 'true' )
{
	ob_start();
	?>

<div id="nexo-global-wrapper">

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg launch_loading" data-toggle="modal" data-target="#myModal" style="display:none;"></button>

<div class="well well-sm">

<h2 class="text-center"><?php echo @$Options[ 'site_name' ] ? $Options[ 'site_name' ] : __( 'Nom indisponible', 'nexo' );?></h2>

<h4 class="text-center"><?php echo sprintf( 
    __( 'Rapport des ventes journalières <br> du %s au %s', 'nexo' ), 
    $CarbonStart->formatLocalized('%A %d %B %Y'), 
    $CarbonEnd->formatLocalized('%A %d %B %Y')
);?></h4>

<div class="hideOnPrint">
    <div class="container">
        <div class="row">
            <div class='col-md-5'>
               <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' class="form-control" name="start" value="<?php echo $start_date;?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' class="form-control" name="end" value="<?php echo $end_date;?>" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <input class="btn btn-primary submitTime" type="submit" value="<?php _e( 'Circonscrire les résultats', 'nexo' );?>">
            </div>
        </div>
    </div>
</div>

<?php
$i = 0;
$Dates				=	array();
$CarbonStartCopy	=	$CarbonStart->copy();
// $CarbonEnd->isSameDay( $CarbonStartCopy ) == true 
while( $CarbonEnd->diffInDays( $CarbonStartCopy ) > 0 || $CarbonEnd->isSameDay( $CarbonStartCopy ) ) {
    $Dates[]		=	$CarbonStartCopy->toW3cString();			
    if( $CarbonEnd->isSameDay( $CarbonStartCopy ) ) {
        break;
    }
    $CarbonStartCopy->addDay();
}

// Looping Dates
$DatesArray			=	array();
foreach( $Dates as $date ) {
    $CurrentDate		=	Carbon::parse( $date );
    $realWeekOfMonth	=	($CurrentDate->weekOfYear - $CurrentDate->copy()->startOfMonth()->weekOfYear + 53) % 52;
    $realWeekOfMonth	=	get_instance()->Nexo_Misc->getWeeks( $CurrentDate->toDateString(), 'monday' );
    $realWeekOfMonth	=	get_instance()->Nexo_Misc->getWeek( $CurrentDate->timestamp );
    
    if( ! isset( $DatesArray[ $CurrentDate->year ] ) ) {
        $DatesArray[ $CurrentDate->year ]	=	array();
    } 
    
    if( ! isset( $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ] ) ) {
        $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ]	=	array();
    }
    
    if( ! isset( $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ][ $CurrentDate->dayOfWeek ] ) ) {
        $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ][ $CurrentDate->dayOfWeek ]	=	array();
    }
    
    if( ! isset( $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ][ $CurrentDate->dayOfWeek ][ $realWeekOfMonth ] ) ) {
        $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ][ $CurrentDate->dayOfWeek ][ $realWeekOfMonth ]	=	array();
    }
     
    $DatesArray[ $CurrentDate->year ][ $CurrentDate->month ][ $CurrentDate->dayOfWeek ][ $realWeekOfMonth ]	=	$date;
}
?>


</div>

<div class="well well-sm">
    <h4><?php _e( 'Détails des expressions utilisées', 'nexo' );?></h4>
    <p>
    <?php _e( 'Ca: Chiffre d\'affaire', 'nexo' );?><br>
    <?php _e( 'Cc: Charges commerciales', 'nexo' );?><br>
    <?php _e( 'CaN: Chiffre d\'Affaire Net (sans remise, ristourne et rabais)', 'nexo' );?><br>
    <?php _e( 'Cr: Créances', 'nexo' );?><br>            
    <?php _e( 'Nc: Nombre de commandes', 'nexo' );?><br>
    <div class="hideOnPrint">
		<?php echo sprintf( __( '%s : Voir plus de détails', 'nexo' ), '<span class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-search"></i></span>' );?><br>
        <?php echo sprintf( __( '%s : Rafraichir les données pour une date', 'nexo' ), '<span class="btn btn-default btn-xs"><i class="glyphicon glyphicon-refresh"></i></span>' );?><br>
        </p>
    </div>
</div>


<!-- Modal -->
<div class="modal fade hideOnPrint" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php _e( 'Chargement en cours...', 'nexo' );?></h4>
      </div>
      <div class="modal-body">
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            <span class="progress_level">0</span>%
          </div>
        </div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<style>
@media print {
	.hideOnPrint {
		display:none !important;
	}
}
</style>
<?php 
// Creating Calendar
foreach( $DatesArray as $DateYears ):
?>
<?php foreach( $DateYears as $MonthId => $DateMonths ):?>
	<?php
    $FakeDateMonth		=	@$DateMonths;
    $FakeDateMonth		=	reset( $FakeDateMonth );
    $FakeDateMonthFirst	=	@reset( $FakeDateMonth );
    $CurrentDate		=	Carbon::parse( $FakeDateMonthFirst );
    ?>
		<table class="table table-bordered table-striped box">
			<thead>
				<tr>
					<td colspan="7" class="text-center"><?php echo sprintf( __( 'Détails du mois : %s', 'nexo' ), $CurrentDate->format('F Y') );?></td>
				</tr>
				<tr>
					<td width="150"><?php _e( 'Lundi', 'nexo' );?></td>
					<td width="150"><?php _e( 'Mardi', 'nexo' );?></td>
					<td width="150"><?php _e( 'Mercredi', 'nexo' );?></td>
					<td width="150"><?php _e( 'Jeudi', 'nexo' );?></td>
					<td width="150"><?php _e( 'Vendredi', 'nexo' );?></td>
					<td width="150"><?php _e( 'Samedi', 'nexo' );?></td>
					<td width="150"><?php _e( 'Dimanche', 'nexo' );?></td>
				</tr>                	
			</thead>
			<tbody>
				<?php for( $weekCounter = 1; $weekCounter <= 7; $weekCounter++ ):?>
					<?php 
					// Avoid to create empty line
					if( 
					isset( $DateMonths[ 0 ][ $weekCounter ] ) ||
					isset( $DateMonths[ 1 ][ $weekCounter ] ) ||
					isset( $DateMonths[ 2 ][ $weekCounter ] ) ||
					isset( $DateMonths[ 3 ][ $weekCounter ] ) ||
					isset( $DateMonths[ 4 ][ $weekCounter ] ) ||
					isset( $DateMonths[ 5 ][ $weekCounter ] ) ||
					isset( $DateMonths[ 6 ][ $weekCounter ] ) || 
					isset( $DateMonths[ 7 ][ $weekCounter ] ) ):?>
					<tr>
					<?php for( $i = 1; $i <= 7; $i++ ):?>
						<?php $item = ( $i == 7 ) ? 0 : $i;?>
						<?php if( isset( $DateMonths[ $item ][ $weekCounter ] ) ):?>
							<?php
							$CurrentDay		=	Carbon::parse( $DateMonths[ $item ][ $weekCounter ] );
							if( $CurrentDay->lt( Carbon::parse( date_now() ) ) ) {
							?>
							<td>
								<div class="row get-reports" data-day="<?php echo $CurrentDay->toDateString();?>">
									<div class="col-lg-2"><h3 class="text-center"><?php echo $CurrentDay->day;?></h3></div>
									<div class="col-lg-9">
										<small><?php _e( 'Ca :', 'nexo' );?></small>
										<span class="total_des_commandes pull-right"><?php echo get_instance()->Nexo_Misc->display_currency( 'before' );?> 0 <?php echo get_instance()->Nexo_Misc->display_currency( 'after' );?></span>
										<br>
										<small><?php _e( 'Cc :', 'nexo' );?></small>
										<span class="total_sommes_rrr pull-right"><?php echo get_instance()->Nexo_Misc->display_currency( 'before' );?> 0 <?php echo get_instance()->Nexo_Misc->display_currency( 'after' );?></span><br>
										<small><?php _e( 'CaN :', 'nexo' );?></small>
										<span class="total_chiffre_daffaire_net pull-right"><?php echo get_instance()->Nexo_Misc->display_currency( 'before' );?> 0 <?php echo get_instance()->Nexo_Misc->display_currency( 'after' );?></span><br>
										<small><?php _e( 'Cr :', 'nexo' );?></small>
										<span class="total_sommes_due pull-right"><?php echo get_instance()->Nexo_Misc->display_currency( 'before' );?> 0 <?php echo get_instance()->Nexo_Misc->display_currency( 'after' );?></span><br>
										<small><?php _e( 'Nc :', 'nexo' );?></small> <span class="order_nbr pull-right">0</span><br><br>
										<a class="hideOnPrint btn btn-xs btn-primary" href="<?php echo get_instance()->events->apply_filters( 'nexo_daily_details_link', '', $CurrentDay->toDateString() );?>"><i class="glyphicon glyphicon-search"></i></a> 
										<!--<a class="hideOnPrint btn btn-xs btn-default btn_refresh" href="<?php echo get_instance()->events->apply_filters( 'nexo_daily_refresh_link', '', $CurrentDay->toDateString() );?>"><i class="glyphicon glyphicon-refresh"></i></a>-->
									</div>
								</div>
							</td>
							<?php
							} else {
								?>
								<td>
								<div class="row">
									<div class="col-lg-2"><h3><?php echo $CurrentDay->day;?></h3></div>
									<div class="col-lg-9">
										<small><?php _e( 'Ca :', 'nexo' );?></small><span class="total_des_commandes pull-right">--</span><br>
										<small><?php _e( 'CaN :', 'nexo' );?></small><span class="total_chiffre_daffaire_net pull-right">--</span><br>
										<small><?php _e( 'Cr :', 'nexo' );?></small><span class="total_sommes_due pull-right">--</span><br>
										<small><?php _e( 'Cc :', 'nexo' );?></small><span class="total_sommes_rrr pull-right">--</span><br>
										<small><?php _e( 'Nc :', 'nexo' );?></small> <span class="order_nbr pull-right">--</span><br><br>
									</div>
								</div>
								</td>
								<?php
							}
							?>
							
						<?php else:?>
							<td></td>
						<?php endif;?>
					<?php endfor;?>
					</tr>
					<?php endif;?>
				<?php endfor;?>
			</tbody>
		</table>
	<?php endforeach;?>
<?php endforeach;?>
</div>
<script type="text/javascript">

	"use strict";

// Date Picker
$(function () {
	$('#datetimepicker6').datetimepicker({
		format	:	'YYYY-MM-DD'
	});
	$('#datetimepicker7').datetimepicker({
		useCurrent: false, //Important! See issue #1075
		format	:	'YYYY-MM-DD'
	});
	$("#datetimepicker6").on("dp.change", function (e) {
		$('#datetimepicker7').data("DateTimePicker").minDate(e.date);
	});
	$("#datetimepicker7").on("dp.change", function (e) {
		$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
	});
});

// Load Reports
$( document ).ready(function(e) {
	$( '.submitTime' ).bind( 'click', function(){
		if( $( '[name="start"]' ).val() != '' && $( '[name="end"]' ).val() != '' ) {
			document.location	=	'<?php echo site_url( array( 'dashboard', 'nexo', 'rapports', 'journalier' ) ) . '/';?>' + $( '[name="start"]' ).val() + '/' + $( '[name="end"]' ).val() + '?refresh=true';
		} else {
			alert( '<?php echo addslashes( __( 'Les dates ne sont pas spécifiée', 'nexo' ) );?>' );
		}
	});
});

var	Nexo_Daily_Report	=	new function(){
	// Currency
	this.CurrencyBefore	=	'<?php echo get_instance()->Nexo_Misc->display_currency( 'before' );?>';
	this.CurrencyAfter	=	'<?php echo get_instance()->Nexo_Misc->display_currency( 'after' );?>';

	// Order Types
	this.CommandeCash	=	'<?php echo $Options[ 'nexo_order_comptant' ];?>';
	this.CommandeDevis	=	'<?php echo $Options[ 'nexo_order_devis' ];?>';
	this.CommandeAvance	=	'<?php echo $Options[ 'nexo_order_advance' ];?>';

	// Storing Dates
	this.Dates			=	[];
	
	/**
	 * Start Report
	**/
	
	this.Start			=	function(){
		
		this.Reset();
		
		$( '.get-reports' ).each( function(){
			Nexo_Daily_Report.Dates.push( $(this).data( 'day' ) );
		});
		
		this.EntryLength	=	this.Dates.length;
		
		this.FetchReport();
	};
	
	/**
	 * Fetch report for all dates
	**/
	
	this.FetchReport=	function(){
		
		if( typeof this.Dates[0] == 'undefined' ) {
			this.CloseModal();
			return false;
		}
		
		this.DisplayModal();
		var tableItemId		=	this.Dates[0];
		
		$.ajax( '<?php echo site_url( array( 'dashboard', 'nexo', 'rest', 'get', 'nexo_commandes', 'DATE_CREATION', 'filter_date_interval' ) );?>', {
			data			:	_.object( [ 'key' ], [ this.Dates[0] ] ),
			type			:	'POST',
			dataType		:	'json',
			success			:	function( json ){
				if( json.length > 0 ) {	
					
					// Chiffre d'affaire net sans charges commerciales
					var ChiffreDaffaireNet	=	0;
					_.each( json, function( value, key ) {
						var RRR	=	parseInt( value.RISTOURNE ) + parseInt( value.RABAIS ) + parseInt( value.REMISE );
						if( _.contains( [ Nexo_Daily_Report.CommandeCash, Nexo_Daily_Report.CommandeDevis, Nexo_Daily_Report.CommandeAvance ], value.TYPE ) ) {
							ChiffreDaffaireNet	+=	Math.abs( parseInt( value.TOTAL ) - RRR );
						}
					});
					$( '[data-day="' + tableItemId + '"]' )
						.find( '.total_chiffre_daffaire_net' )
						.html( Nexo_Daily_Report.CurrencyBefore + ' ' + NexoAPI.Format( ChiffreDaffaireNet ) + ' ' + Nexo_Daily_Report.CurrencyAfter );
						
						
					// Total				
					var CurrentTotal		=	0;
					_.each( json, function( value, key ) {
						CurrentTotal	+=	( parseInt( value.TOTAL ) );
					});
					$( '[data-day="' + tableItemId + '"]' )
						.find( '.total_des_commandes' )
						.html( Nexo_Daily_Report.CurrencyBefore + ' ' + NexoAPI.Format( CurrentTotal ) + ' ' + Nexo_Daily_Report.CurrencyAfter );
					
					// Sommes dues
					var CurrentDues		=	0;
					_.each( json, function( value, key ) {
						var RRR	=	parseInt( value.RISTOURNE ) + parseInt( value.RABAIS ) + parseInt( value.REMISE );
						// Les sommes dues ne sont calculé que pour les avance et devis
						if( _.contains( [ Nexo_Daily_Report.CommandeAvance, Nexo_Daily_Report.CommandeDevis ], value.TYPE ) ) {
							var SommesDues	=	( parseInt( value.TOTAL ) - parseInt( value.SOMME_PERCU ) ) - RRR;								
							CurrentDues	+=	SommesDues;
						}
					});
					$( '[data-day="' + tableItemId + '"]' )
						.find( '.total_sommes_due' )
						.html( Nexo_Daily_Report.CurrencyBefore + ' ' + NexoAPI.Format( CurrentDues ) + ' ' + Nexo_Daily_Report.CurrencyAfter );
						
					// Total Commandes
					$( '[data-day="' + tableItemId + '"]' )
						.find( '.order_nbr' )
						.html( json.length );
						
					// RRR
					var CurrentRRR		=	0;
					_.each( json, function( value, key ) {
						// Les sommes dues ne sont calculé que pour les avance et devis
						if( _.contains( [ Nexo_Daily_Report.CommandeAvance, Nexo_Daily_Report.CommandeDevis ], value.TYPE ) ) {
							var RRR	=	parseInt( value.RISTOURNE ) + parseInt( value.RABAIS ) + parseInt( value.REMISE );								
							CurrentRRR	+=	RRR;
						}
					});
					$( '[data-day="' + tableItemId + '"]' )
						.find( '.total_sommes_rrr' )
						.html( Nexo_Daily_Report.CurrencyBefore + ' ' + NexoAPI.Format( CurrentRRR ) + ' ' + Nexo_Daily_Report.CurrencyAfter );
					
				}
				Nexo_Daily_Report.FetchReport();
			}
		});
		
		// Remove index
		this.Dates.shift();
	};
	
	/** 
	 * Reset the calendar 
	**/
	
	this.Reset			=	function(){
		this.__TimeCalled	=	1;
		$( '.progress_level' ).html( 1 );
		$( '.progress-bar' ).css( 'width', '1%' ).data( 'aria-valuenow', 1 );
		
	}
	
	/**
	 * Display Modal
	**/
	
	this.DisplayModal	=	function(){
		if( ! $( '.launch_loading' ).data( 'clicked' ) ) {
			$( '.launch_loading' ).trigger( 'click' );
			$( '.launch_loading' ).data( 'clicked', true );
		} else {
			var Percent	=	( this.__TimeCalled / this.EntryLength ) * 100;
			this.SetPercent( Math.ceil( Percent ) );
		}
		this.__TimeCalled++;
	};
	
	/**
	 * Progress Bar
	**/
	
	this.SetPercent		=	function( percent ) {
		$( '.progress_level' ).html( percent );
		$( '.progress-bar' ).css( 'width', percent + '%' ).data( 'aria-valuenow', percent );
	}
	
	/**
	 * Close modal
	**/
	
	this.CloseModal		=	function(){
		$( '[data-dismiss="modal"]' ).trigger( 'click' );
	}
	
}
$( document ).ready(function(e) {
	
	/**
	 * Bind report event to valid date
	**/
	
    /*$( '.get-reports .btn_refresh' ).each( function(){
		$(this).bind( 'click', function(){
			
		});
	});*/
	
	Nexo_Daily_Report.Start();
});
</script>

<?php

}

get_instance()->events->do_action( 'nexo_daily_report_footer', $CarbonStart, $CarbonEnd );

if( ! $Cache->get( $report_slug ) || @$_GET[ 'refresh' ] == 'true' ) {
	$Content	=	ob_get_clean();
	$Cache->save( $report_slug, $Content, 999999999 ); // long time
} else {
	$Content	=	$Cache->get( $report_slug );
}

$this->Gui->add_item( array(
	'type'		=>		'dom',
	'content'	=>		$Content
), 'daily_report', 1 );

$this->Gui->output();