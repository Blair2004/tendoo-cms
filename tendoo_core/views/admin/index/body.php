<?php echo $lmenu;?>
<section id="content">
  <section class="vbox"><?php echo $inner_head;?>
    
    <footer class="footer bg-white b-t">
      <div class="row m-t-sm text-center-xs">
        <div class="col-sm-2" id="ajaxLoading"> </div>
        <div class="col-sm-4 col-sm-offset-6 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            
          </ul>
        </div>
      </div>
    </footer>
    <section class="scrollable" id="pjax-container">
      <header>
        <div class="row b-b m-l-none m-r-none">
          <div class="col-sm-4">
            <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
            <p class="block text-muted"><?php echo $pageDescription;?></p>
          </div>
        </div>
      </header>
      <section class="scrollable wrapper"> <?php echo notice_from_url();?>
        <?php
            if($options[0]['SHOW_ADMIN_INDEX_STATS'] == "1")
            {
                    $currentTime	=	$this->core->tendoo->datetime();
                    $dateArray		=	$this->core->tendoo->time(strtotime($currentTime),TRUE);
                    $stats		=	$this->core->tendoo_admin->tendoo_visit_stats();
                    $visitLine		=	'';
                    $totalUnique	=	$stats['statistics']['unique'][$dateArray['y']][$dateArray['M']]['totalVisits'];
                    $totalGlobal	=	$stats['statistics']['global'][$dateArray['y']][$dateArray['M']]['totalVisits'];
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
                    ?>
        <!-- data-toggle="tooltip" data-placement="right" title="" data-original-title="Statistiques sur le traffic de votre site." -->
        <div class="row">
          <div class="col-lg-9"> 
            <!-- Start Here -->
            <?php
              if($options[0]['OPEN_APP_TAB'] == '0')
              {
                  $icon_1	=	'';
                  $collapse	=	'collapse';
              }
              else
              {
                  $icon_1	=	'active';
                  $collapse	=	'';
              }
              ?>
            <section class="panel pos-rlt clearfix">
              <header class="panel-heading">
                <ul class="nav nav-pills pull-right">
                  <li> <a data-requestType="silent" data-url="<?php echo $this->core->url->site_url(array('admin','ajax','toogle_app_tab'));?>" href="#" class="panel-toggle text-muted <?php echo $icon_1;?>"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                </ul>
                Applications </header>
              <div class="panel-body clearfix <?php echo $collapse;?>">
                <div class="icon-grid">
                  <?php
                if(is_array($appIconApi))
                {
                    foreach($appIconApi as $a)
                    {
                        eval($options[0]['ADMIN_ICONS']);
                        if(isset($icons))
                        {
                            foreach($icons as $i)
                            {
                                if($i	==	$a['ICON_MODULE_NAMESPACE'].'/'.$a['ICON_NAMESPACE'])
                                {
                        ?>
                        <div class="tendoo-icon-set" data-toggle="tooltip" data-placement="right" title="<?php echo $a['ICON_MODULE']['HUMAN_NAME'];?>" modal-title="<?php echo $a['ICON_MODULE']['HUMAN_NAME'];?>" data-url="<?php echo $this->core->url->site_url(array('admin','open','modules',$a['ICON_MODULE']['ID'].'?ajax=true'));?>">
                        	
                          <img class="G-icon" src="<?php echo $this->core->tendoo_admin->getAppImgIco($a['ICON_MODULE']['NAMESPACE']);?>">
                  			<p><?php echo word_limiter($a['ICON_MODULE']['HUMAN_NAME'],4);?></p>
                            <!--<span class="badge up bg-info m-l-n-sm">300</span>-->
                  		</div>
                  <?php
                                }
                            }
                        }
                    }
                }
                ?>
                </div>
              </div>
            </section>
            <!-- End Here -->
            <ul class="list-group gutter list-group-lg list-group-sp sortable">
              <?php
                if($options[0]['SHOW_ADMIN_INDEX_STATS'] == "1")
                {
                ?>
              <li class="list-group-item" draggable="true" style="padding:0px;" data-id="<?php echo $this->core->tendoo_admin->getGridId();?>">
                <header class="panel-heading bg-info lter"> <span class="pull-right"><?php echo $dateArray['month'];?></span> <span class="h4">Stats. sur <?php echo $this->core->tendoo_admin->getStatLimitation();?> mois<br>
                  <small class="text-muted"></small> </span>
                  <div class="text-center padder m-b-n-sm m-t-sm">
                    <div class="sparkline" data-type="line" data-resize="true" data-height="48" data-width="100%" data-line-width="2" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-data="
                            [<?php echo $visitLine;?>]"></div>
                    <div class="sparkline inline"></div>
                  </div>
                </header>
                <div class="panel-body" style="height:105px;">
                  <div> <span class="text-muted">Visites ce mois (uniques/globales) :</span> <span class="h3 block"><?php echo $totalUnique;?>/<small><?php echo $totalGlobal;?></small></span> </div>
                  <div><small>Visites uniques</small> : <span><?php echo $overAllUnique;?></span></div>
                  <div><small>Visites r&eacute;guli&egrave;res</small> : <span><?php echo $overAllGlobal;?></span></div>
                </div>
              </li>
              <?php
                }
                    ?>
              <li class="list-group-item" draggable="true" style="padding:0px;" data-id="<?php echo $this->core->tendoo_admin->getGridId();?>">
                <?php
                    if($options[0]['SHOW_WELCOME'] == 'TRUE')
                    {
                    ?>
                <div class="panel-body">
                  <div class="carousel slide auto" id="c-slide">
                    <ol class="carousel-indicators out" style="bottom:10px;">
                      <li data-target="#c-slide" data-slide-to="0" class=""></li>
                      <li data-target="#c-slide" data-slide-to="1" class=""></li>
                      <li data-target="#c-slide" data-slide-to="2" class="active"></li>
                    </ol>
                    <div class="carousel-inner" style="min-height:180px;" >
                      <div class="item">
                        <p class="text-center"> <em class="h4 text-mute">Premier pas sur Tendoo</em><br>
                          <br/>
                          D&eacute;couvrer comment publier votre premier article en suivant <a href="<?php echo $this->core->url->site_url(array('admin','discover','firstSteps'));?>"><strong>ces instructions</strong></a>. Vous pouvez aussi apprendre &agrave; configurer votre site web en suivant <a href="<?php echo $this->core->url->site_url(array('admin','discover','firstSettings'));?>"><strong>ces instructions</strong></a>. Apprenez &eacute;galement &agrave; g&eacute;rer le fonctionnement de votre site web dans la section <a href="<?php echo $this->core->url->site_url(array('admin','system'));?>"><strong>Syst&egrave;me</strong></a> et dans la section <a href="<?php echo $this->core->url->site_url(array('admin','discover','aboutSecurity'));?>"><strong>S&eacute;curit&eacute;</strong></a> </p>
                      </div>
                      <div class="item">
                        <p class="text-center"> <em class="h4 text-mute">C'est quoi Tendoo ?</em><br>
                          <br/>
                          <small class="text-muted">Tendoo vous permet de rapidement cr&eacute;er votre site web, sans avoir n&eacute;cessairement besoin d'un expert. La cr&eacute;ation et la gestion d'un site web ne pourra pas &ecirc;tre plus facile. Si vous d&eacute;butez, <a href="#">vous devez savoir ceci</a>, cependant si vous &ecirc;tes un habitu&eacute; de CMS, ce petit aper&ccedil;u vous sera utile.</small> </p>
                      </div>
                      <div class="item active">
                        <p class="text-center"> <em class="h4 text-mute">Bienvenue sur <strong><?php echo $this->core->tendoo->getVersion();?></strong></em><br>
                          <br/>
                          <small class="text-muted">L'&eacute;quipe vous remercie d'avoir choisi Tendoo comme application pour la cr&eacute;ation de votre site web / application web. Si vous demarrez sur Tendoo, consultez <a href="<?php echo $this->core->url->site_url(array('admin','discover'));?>">le guide d'utilisation</a> sur les premiers pas, et commercez &agrave; personnaliser tendoo.</small> </p>
                      </div>
                    </div>
                    <a class="left carousel-control" href="#c-slide" data-slide="prev"> <i class="icon-angle-left"></i> </a> <a class="right carousel-control" href="#c-slide" data-slide="next"> <i class="icon-angle-right"></i> </a> </div>
                </div>
                <?php
                    }
                    ?>
              </li>
            </ul>
          </div>
          <div class="col-lg-3">
            <section class="panel">
              <header class="panel-heading bg-info">Statistiques</header>
              <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                <li class="list-group-item">Modules install&eacute;s <span class="badge bg-info"><?php echo $ttModule;?></span></li>
                <li class="list-group-item">Th&egrave;mes install&eacute;s <span class="badge bg-info"><?php echo $ttTheme;?></span></li>
                <li class="list-group-item">Pages cr&eacute&eacute;es <span class="badge bg-info"><?php echo $ttPages;?></span></li>
                <li class="list-group-item">Privil&egrave;ges cr&eacute;es <span class="badge bg-info"><?php echo $ttPrivileges;?></span></li>
              </ul>
            </section>
<!--
            <div class="panel-group m-b" id="accordion2">
              <div class="panel">
                <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> Collapsible Group Item #1 </a> </div>
                <div id="collapseOne" class="panel-collapse in">
                  <div class="panel-body text-sm"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt. </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo"> Collapsible Group Item #2 </a> </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body text-sm"> Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                </div>
              </div>
              <div class="panel">
                <div class="panel-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"> Collapsible Group Item #3 </a> </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body text-sm"> Sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. </div>
                </div>
              </div>
            </div>-->
          </div>
        </div>
      </section>
    </section>
  </section>
</section>
