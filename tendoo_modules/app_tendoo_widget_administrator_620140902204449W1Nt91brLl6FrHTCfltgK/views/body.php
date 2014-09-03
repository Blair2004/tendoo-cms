<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        <footer class="footer bg-white b-t">
			<div class="row m-t-sm text-center-xs">
				<div class="col-sm-2" id="ajaxLoading">
                </div>
				<div class="col-sm-6 text-right text-center-xs">
					<ul class="pagination pagination-sm m-t-none m-b-none">
					</ul>
				</div>
				<div class="col-sm-4">
					<a class="btn btn-sm btn-primary pull-right" href="javascript:void(0)" id="submit_changes">Enregistrer vos modifications</a>
				</div>
			</div>

		</footer>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper"> <?php echo output('notice');?>  <?php echo fetch_error_from_url();?> <?php echo validation_errors(); ?>
					<?php echo tendoo_info('Choissisez un widget et ajoutez-le à une zone (Gauche, Droite, Pied de page). Les widgets ajoutés sont automatiquement activés.');?>
					<div class="row">
						<div class="col-lg-4">
						<section class="panel pos-rlt clearfix">
							<header class="panel-heading">
								<ul class="nav nav-pills pull-right">
									<li>
										<a class="panel-toggle text-muted active" href="javascript:void(0)">
											<i class="fa fa-caret-down text-active"></i>
											<i class="fa fa-caret-up text"></i>
										</a>
									</li>
								</ul>
								Widgets Disponibles
							</header>
							<div class="panel-body clearfix widget_item_container">
								<div class="panel widget_item" widget widget-namespace="texte" widget-modnamespace="system" widget-human_name="Widget Texte">
									<header class="panel-heading text-center">
										<ul class="nav nav-pills pull-right">
											<li><a class="panel-toggle text-muted" add_widget href="javascript:void(0)"><i class="fa fa-share"></i></a></li>
										</ul>
										<ul class="toggle-section nav nav-pills pull-left"></ul>
										Widget Texte
									</header>
									<div widget-hidden_content style="display:none">
										<div class="form-group">
											<textarea class="form-control" meta_widgetParams></textarea>
										</div>
									</div>
								</div>
								<?php 
								if(count($finalMod) > 0)
								{
									foreach($finalMod as $f)
									{
									?>
								<div class="panel widget_item" 
									widget widget-namespace="<?php echo $f['WIDGET_NAMESPACE'];?>" 
									widget-modnamespace="<?php echo $f['MODULE_NAMESPACE'];?>" 
									widget-human_name="<?php echo $f['WIDGET_HUMAN_NAME'];?>">
									<header class="panel-heading text-center">
										<ul class="nav nav-pills pull-right">
											<li><a class="panel-toggle text-muted" add_widget href="javascript:void(0)"><i class="fa fa-share"></i></a></li>
										</ul>
										<ul class="toggle-section nav nav-pills pull-left"></ul>
										<?php echo $f['WIDGET_HUMAN_NAME'];?>
									</header>
									<?php
									if(array_key_exists('WIDGET_MORE',$f))
									{
										$cur_module	=	get_modules( 'filter_active_namespace' , $f['MODULE_NAMESPACE'] );
										if($cur_module)
										{
											$module_dir	=	MODULES_DIR.$cur_module[ 'encrypted_dir' ];
											if( is_file( $module_dir . $f['WIDGET_MORE'] ) )
											{
												include_once( $module_dir . $f['WIDGET_MORE'] );
												if(class_exists( $f['WIDGET_NAMESPACE'] . '_' . $f['MODULE_NAMESPACE'] . '_moreClass' ) )
												{
													eval('$WMORE = new '.$f['WIDGET_NAMESPACE'].'_'.$f['MODULE_NAMESPACE'].'_moreClass;');
													$hidden_content	=	$WMORE->get();
													?>
													<div widget-hidden_content style="display:none">
														<?php echo $hidden_content;?>
													</div>
													<?php
												}													
											}
										}
									}
									?>
								</div>	
									<?php
									}
								}
								?>
							</div>
						</section>
						</div>
						<div class="col-lg-8">
							<div class="row">
								<form method="post" id="submitWidgets">
									<div class="col-lg-6">
										<section class="panel pos-rlt clearfix" widget-section="LEFT">
											<header class="panel-heading text-center">
												<ul class="nav nav-pills pull-right">
													<li>
														<a class="panel-toggle text-muted active" href="javascript:void(0)">
															<i class="fa fa-caret-down text-active"></i>
															<i class="fa fa-caret-up text"></i>
														</a>
													</li>
												</ul>
												<ul class="toggle-section nav nav-pills pull-left">
											</ul>
												Section Gauche 
											</header>
											<div style="min-height:50px;" class="panel-body clearfix collapse" active-widget-panel-body>
												<?php
												if($widgets_left)
												{
													$index	=	0;
													foreach($widgets_left as $w)
													{
														$lib->getWidgetHTMLCode($w,'LEFT',$index);
														$index++;
													}
												}
												?>
											</div>
										</section>
									</div>
									<div class="col-lg-6">
									<section class="panel pos-rlt clearfix" widget-section="RIGHT">
										<header class="panel-heading text-center">
											<ul class="nav nav-pills pull-right">
												<li>
													<a class="panel-toggle text-muted active" href="javascript:void(0)">
														<i class="fa fa-caret-down text-active"></i>
														<i class="fa fa-caret-up text"></i>
													</a>
												</li>
											</ul>
											Section Droite 
										</header>
										<div class="panel-body clearfix collapse" style="min-height:50px;" active-widget-panel-body>
										<?php
										if($widgets_right)
										{
											$index	=	0;
											foreach($widgets_right as $w)
											{
												$lib->getWidgetHTMLCode($w,'RIGHT',$index);
												$index++;
											}
										}
										?>
										</div>
									</section>
									</div>
									<div class="col-lg-12">
										<section class="panel pos-rlt clearfix" widget-section="BOTTOM">
											<header class="panel-heading text-center">
												<ul class="nav nav-pills pull-right">
													<li>
														<a class="panel-toggle text-muted active" href="javascript:void(0)">
															<i class="fa fa-caret-down text-active"></i>
															<i class="fa fa-caret-up text"></i>
														</a>
													</li>
												</ul>
												Section Pied de page 
											</header>
											<div class="panel-body clearfix collapse" style="min-height:50px;" active-widget-panel-body>
											<?php
												if($widgets_bottom)
												{
													$index	=	0;
													foreach($widgets_bottom as $w)
													{
														$lib->getWidgetHTMLCode($w,'BOTTOM',$index);
														$index++;
													}
												}
												?>
											</div>
										</section>
									</div>
								</form>
							</div>
						</div>
					</div>
                </section>
            </section>
        </section>
        </section>
        </section>
        <a href="javascript:void(0)" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
		<!-- ACTIVE WIDGET SAMPLE -->
		<div active-widget-sample style="display:none">
		<section class="panel pos-rlt clearfix" active-widget-sample-head>
			<header class="panel-heading text-center">
				<ul class="nav nav-pills pull-right">
					<li>
						<a class="panel-toggle text-muted active" href="javascript:void(0)">
							<i class="fa fa-caret-down text-active"></i>
							<i class="fa fa-caret-up text"></i>
						</a>
					</li>
				</ul>
				<ul class="nav nav-pills pull-left">          
					<li>
						<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i></a>
						<ul active-widget-option class="dropdown-menu" role="menu">
							<li><a class="remove_w" href="javascript:void(0)">Supprimer</a></li>
							<li><a class="goup_w" href="javascript:void(0)">Faire monter</a></li>
							<li><a class="godown_w" href="javascript:void(0)">Faire d&eacute;scendre</a></li>
						</ul>
					</li>          
				</ul>
				<span active-widget-sample-human_name>Sample</span>
			</header>
			<div class="panel-body clearfix collapse">
				<div class="form-group">
					<input type="text" active-widget-sample-title class="form-control" placeholder="Titre de votre widget" value="">
				</div>
			</div>
		</section>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#submit_changes').bind('click',function(){
				$('#submitWidgets').trigger('submit');
			});
		});
		</script>
