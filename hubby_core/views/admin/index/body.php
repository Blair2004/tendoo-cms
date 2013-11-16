<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <?php
            if($options[0]['SHOW_WELCOME'] == 'TRUE')
            {
            ?>
            <section class="scrollable wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="carousel slide auto panel-body" id="c-slide" style="min-height:100px;">
                                <ol class="carousel-indicators out">
                                    <li data-target="#c-slide" data-slide-to="0" class=""></li>
                                    <li data-target="#c-slide" data-slide-to="1" class=""></li>
                                    <li data-target="#c-slide" data-slide-to="2" class="active"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="item">
                                        <p class="text-center"> <em class="h4 text-mute">Bienvenue sur <strong><?php echo $this->core->hubby->getVersion();?></strong></em><br>
                                            <small class="text-muted">Faites vos premiers pas avec le Guide du débutant</small> </p>
                                    </div>
                                    <div class="item">
                                        <p class="text-center"> <em class="h4 text-mute">B&acirc;tir une application web</em><br>
                                            <small class="text-muted">Faites vos Premiers pas en tant que <a href="#">développeurs</a> ou en tant que <a href="#">simple utilisateur</a>, vous y trouverez un manuel adapt&eacute; &agrave; vos demandes. Si c'est votre premiere connexion, vous pouvez modifier les <a href="<?php echo $this->core->url->site_url('admin/setting');?>">param&ecirc;tres</a> de votre site web. D&eacute;counvrez toujours plus d'astuces sur la cr&eacute;ation d'application web dans le manuel d'instruction.</small> </p>
                                    </div>
                                    <div class="item active">
                                        <p class="text-center"> <em class="h4 text-mute">C'est quoi Hubby ?</em><br>
                                            <small class="text-muted">Hubby vous permet de rapidement cr&eacute;er votre site web, sans avoir n&eacute;cessairement besoin d'un expert. La cr&eacute;ation et la gestion d'un site web ne pourra pas &ecirc;tre plus facile. Si vous d&eacute;butez, <a href="#">vous devez savoir ceci</a>, cependant si vous &ecirc;tes un habitu&eacute; de CMS, ce petit aperçu vous sera utile.</small> </p>
                                    </div>
                                </div>
                                <a class="left carousel-control" href="http://flatfull.com/themes/todo/components.html#c-slide" data-slide="prev"> <i class="icon-angle-left"></i> </a> <a class="right carousel-control" href="http://flatfull.com/themes/todo/components.html#c-slide" data-slide="next"> <i class="icon-angle-right"></i> </a> </div>
                        </section>
                    </div>
                </div>
            </section>
            <?php
            }
            ?>
            <section class="hbox">
                <aside class="bg-white-only">
                    <header class="bg-light">
                        <ul class="nav nav-tabs">
                        	<li class="active"><a href="#tab5" data-toggle="tab">Utilitaire syst&egrave;me</a></li>
                            <li	class=""><a href="#tab1" data-toggle="tab">Statistiques Graphiques</a></li>
                            <li class=""><a href="#tab4" data-toggle="tab">Actualit&eacute;s Hubby</a></li>
                            <li class=""><a href="#tab2" data-toggle="tab">Bloster widget</a></li>
                            <li class=""><a href="#tab3" data-toggle="tab">Upload widget</a></li>                            
                        </ul>
                    </header>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div class="wrapper">
                                <div class="row m-t-lg">
                                    <div class="col-md-6">
                                        <section class="panel">
                                            <header class="panel-heading">Composite</header>
                                            <div class="text-center clearfix">
                                                <div class="m-t-lg padder">
                                                    <div class="sparkline" data-type="line" data-resize="true" data-height="100" data-width="100%" data-line-width="1" data-line-color="#dddddd" data-spot-color="#afcf6f" data-fill-color="" data-highlight-line-color="#eee" data-spot-radius="4" data-data="[330,250,200,325,350,380,250,320,345,450,250,250]">
                                                        <canvas style="display: inline-block; width: 410px; height: 100px; vertical-align: top;" width="410" height="100"></canvas>
                                                    </div>
                                                    <div class="sparkline inline" data-type="bar" data-height="57" data-bar-width="6" data-bar-spacing="10" data-bar-color="#c5d5d5">
                                                        <canvas width="6" height="57" style="display: inline-block; width: 6px; height: 57px; vertical-align: top;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="panel-footer text-sm">Check more data</footer>
                                        </section>
                                    </div>
                                    <div class="col-md-6">
                                        <section class="panel">
                                            <header class="panel-heading">Stacked</header>
                                            <div class="panel-body text-center">
                                                <div class="sparkline inline" data-type="bar" data-height="160" data-bar-width="12" data-bar-spacing="10" data-stacked-bar-color="['#afcf6f', '#eee']">
                                                    <canvas width="12" height="160" style="display: inline-block; width: 12px; height: 160px; vertical-align: top;"></canvas>
                                                </div>
                                                <ul class="list-inline text-muted axis">
                                                    <li style="width: 12px; margin-right: 10px;">1</li>
                                                    <li style="width: 12px; margin-right: 10px;">2</li>
                                                    <li style="width: 12px; margin-right: 10px;">3</li>
                                                    <li style="width: 12px; margin-right: 10px;">4</li>
                                                    <li style="width: 12px; margin-right: 10px;">5</li>
                                                    <li style="width: 12px; margin-right: 10px;">6</li>
                                                    <li style="width: 12px; margin-right: 10px;">7</li>
                                                    <li style="width: 12px; margin-right: 10px;">8</li>
                                                    <li style="width: 12px; margin-right: 10px;">9</li>
                                                    <li style="width: 12px; margin-right: 10px;">10</li>
                                                </ul>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <ul class="list-group m-b-none m list-group-lg list-group-sp">
                                <li class="list-group-item"> <a href="#" class="thumb-sm pull-left m-r-sm"> <img src="./dash_board_1_files/avatar.jpg" class="img-circle"> </a> <a href="#" class="clear"> <small class="pull-right">3 days ago</small> <strong class="block">Morgen Kntooh</strong> <small>Mobile first web app for startup...</small> </a> </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="text-center wrapper"> <i class="icon-spinner icon-spin icon-large"></i> </div>
                        </div>
                        <div class="tab-pane" id="tab5">
                        </div>
                        <div class="tab-pane" id="tab4">
                            <ul class="list-group m-b-none m list-group-lg list-group-sp">
                                <li class="list-group-item"> <a href="#" class="thumb-sm pull-left m-r-sm"> <img src="./dash_board_1_files/avatar.jpg" class="img-circle"> </a> <a href="#" class="clear"> <small class="pull-right">3 days ago</small> <strong class="block">Morgen Kntooh</strong> <small>Mobile first web app for startup...</small> </a> </li>
                            </ul>
                        </div>
                    </div>
                </aside>
                <aside class="b-l aside-lg bg-light">
                    <section class="wrapper">
                        <section class="panel">
                            <header class="panel-heading bg-primary">Statistiques</header>
                            <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                                <li class="list-group-item">Modules install&eacute;s								
                                <span class="badge"><?php echo $ttModule;?></span></li>
                                <li class="list-group-item">Th&egrave;mes install&eacute;s	<span class="badge"><?php echo $ttTheme;?></span></li>
                                <li class="list-group-item">Pages cr&eacute;ées	<span class="badge"><?php echo $ttPages;?></span></li>
                                <li class="list-group-item">Privil&egrave;ges cr&eacute;es	<span class="badge"><?php echo $ttPrivileges;?></span></li>
                            </ul>
                        </section>
                        <!--<div class="panel-group m-b" id="accordion2">
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
                    </section>
                </aside>
            </section>
        </section>
    </section>
