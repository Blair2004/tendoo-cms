<div class="login-box" style="width:600px">
    <div class="login-logo">
        <a href="<?php echo get_instance()->url->main_url();?>">
        <h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h3 class="text-center" style="margin-top:0;"><?php echo get('core_version');?></h3>
        <section class="panel">
        	<form id="siteNameForm" method="post" action="<?php echo $this->instance->url->site_url(array('install','etape',4));?>">
                <div class="form-group">
                    <label class="host_name"><?php _e( 'Type the name here' );?></label>
                    <input name="site_name" id="site_name" type="text" placeholder="<?php _e( 'Example : Tendoo New Website' );?>" class="form-control">
                </div>
                <div class="line line-dashed">
                </div>
                <button type="submit" id="siteNameSubmiter" class="btn btn-info"><?php _e( 'Save Setting & Proceed' );?></button>
            </form>
            <br>
            <div class="progress" style="visibility:hidden;">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                    <span id="status_id">0</span>
                </div>
            </div>
            <div style="height:20px;">
                <p class="installText">
                </p>
            </div>
		</section>
    </div>
    <!-- /.login-box-body -->
</div>
<script>
  $(function () {
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' // optional
	});
  });
</script>
<script>
$(document).ready(function(){
	function say( msg , delay ){
		setTimeout( function(){
			$( '.installText' ).fadeOut(200, function(){
				$(this).html( msg ).fadeIn(200);
			});						
		}, delay );
	}
	function pg_bar(){
		this.set	=	function( int ){
			$( '.progress-bar' ).attr( 'aria-valuenow' , int ).css( 'width' , int + '%' );
			$( '#status_id' ).html( int );
		}
	}
	function install_process(){
		var pg		=	new pg_bar();
		$( '.progress' ).css( 'visibility' , 'visible' );
		var step	=	this.step	=	function( id , object ){
			if( id == 1 ){
				say( pseudo + "<?php echo translate( "Tendoo is installing, just wait a while." );?>" , 0 );
				$.ajax( tendoo.url.site_url( 'install/app_step/' + id ) , {
					dataType  	:	'json',
					error		:	function(){
						say( pseudo + "<?php echo translate( "An unexpected error occurred. You should consider reinstalling and delete installed tables." );?>" );
					},
					success	:	function(json){
						say( pseudo + json.response , 0 );
						pg.set( json.progress );			
						setTimeout( function(){
							step( json.step );
						} , 2000 )
					},
					type 		:	'POST',
					data		:	object
				} );
			} 
			else if( id == 2 ){
				setTimeout( function(){
					document.location	=	tendoo.url.site_url( 'login' );
				}, 2000 );
			}
		}
	}
	var pseudo	=	'<strong>Luminax : </strong>';
	$('#siteNameSubmiter').bind('click',function(){
		if( $('#site_name').val() == '' ){
			say( pseudo + "<?php echo translate( "Unfortunately, you must provide a name to your website before proceeding." );?>" , 0 );
		} else {
			$('#siteNameForm').find( '[name="site_name"]' ).attr( 'disabled' , 'disabled' );
			$('#siteNameForm').find( '#siteNameSubmiter' ).attr( 'disabled' , 'disabled' );
			new install_process().step( 1 , {
				'site_name'		:	$('#site_name').val()
			});
		}
		return false;
	});
});
									</script> 
<?php return;?>

<section class="panel">
    <?php echo $this->load->the_view( 'install/step/menu' , true );?>
    <div class="step-content">
        <div class="step-pane active" id="step3">
            <div class="row">
                <div class="col-lg-4">
                    <div class="col-lg-13">
                        <h4><i class="fa fa-check"></i> <?php echo translate( 'Connexion established' );?></h4>
                        <p>
                            <?php echo translate( 'Tendoo can now access your database. Before you proceed, we need the name of your website.' );?>
                        </p>
                    </div>
                    <?php 
									$form_response	=	validation_errors('<li>', '</li>');
									ob_start();
									output('notice');
									$query_error	=	strip_tags(ob_get_contents());
									ob_end_clean();
									if($form_response)
									{
										?>
                    <div class="col-lg-13">
                        <section class="panel">
                            <header class="panel-heading bg bg-danger text-center"><?php echo translate( 'error on the form' );?></header>
                            <div class="panel-body">
                                <?php echo $form_response;?>
                            </div>
                        </section>
                    </div>
                    <?php
									}
									else if($query_error)
									{
										?>
                    <div class="col-lg-13">
                        <section class="panel">
                            <header class="panel-heading bg bg-danger text-center"><?php echo translate( 'error on the form' );?></header>
                            <div class="panel-body">
                                <?php echo $query_error;?>
                            </div>
                        </section>
                    </div>
                    <?php
									}
									?>
                </div>
                <div class="col-lg-4" id="concerned">
                    <h4><i class="fa fa-download"></i> <?php _e( 'Your Website Name' );?></h4>
                    
                    <div class="line">
                    </div>
                    <div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
