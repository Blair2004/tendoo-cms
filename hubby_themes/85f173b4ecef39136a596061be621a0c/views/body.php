<?php echo $lmenu;?>
<section id="content">
    <section class="vbox"><?php echo $inner_head;?>
        
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->hubby->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> <?php echo $this->core->notice->parse_notice();?> <?php echo $success;?>
                	<div class="grid">
                    	<div class="col-lg-4">
							<section class="panel">
                            <header class="panel-heading">
                                <ul class="nav nav-pills pull-right">
                                    <li> <a href="#" class="panel-toggle text-muted active"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                                </ul>
                                <span class="icon-pushpin"></span> R&eacute;seaux sociaux </header>
							<form method="post">
                            <section style="height:auto" class="panel-body scrollbar scroll-y m-b collapse">
                                <article class="media"> <span class="pull-left icon-facebook thumb-sm" style="font-size:35px"></span>
                                    <div class="media-body">
                                        <a href="#" class="h4">facebook</a>
                                        <small class="block m-t-sm">Entrez l'adresse d'une page que vous aimerez sugg&eacute;rer &agrave; vos utilisateurs</small> 
                                        	<br />
                                        	<div class="form-group">
                                                <label class="label-control">
                                                    <input type="text" class="form-control" />
                                                </label>
                                            </div>
									</div>
                                </article>
                                <div class="line pull-in"></div>
                                <article class="media"> <span class="pull-left icon-google-plus thumb-sm" style="font-size:35px"></span>
                                    <div class="media-body">
                                        <a href="#" class="h4">Google+</a>
                                        <small class="block m-t-sm">Entrez l'adresse d'un cercle ou d'une page que vous aimerez sugg&eacute;rer &agrave; vos utilisateurs</small> 
                                        	<br />
                                        	<div class="form-group">
                                                <label class="label-control">
                                                    <input type="text" class="form-control" />
                                                </label>
                                            </div>
									</div>
                                </article>
                                <div class="line pull-in"></div>
                                <article class="media"> <span class="pull-left icon-twitter thumb-sm" style="font-size:35px"></span>
                                    <div class="media-body">
                                        <a href="#" class="h4">Twitter</a>
                                        <small class="block m-t-sm">Entrez une adresse twitter que vous aimerez sugg&eacute;rer &agrave; vos utilisateurs de suivre.</small> 
                                        	<br />
                                        	<div class="form-group">
                                                <label class="label-control">
                                                    <input type="text" class="form-control" />
                                                </label>
                                            </div>
									</div>
                                </article>
                                <div class="line pull-in"></div>
                                <input type="submit" class="btn btn-sm btn-white" value="Enregistrer les modifications" />
                            </section>
                            </form>
                        </section>
                        </div>
                        <div class="col-lg-4">
					<section class="panel">
                            <header class="panel-heading">
                                <ul class="nav nav-pills pull-right">
                                    <li> <a href="#" class="panel-toggle text-muted active"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                                </ul>
                                <span class="label bg-dark">15</span> Inbox </header>
                            <section style="height:180px" class="panel-body scrollbar scroll-y m-b collapse">
                                <article class="media"> <span class="pull-left thumb-sm"><img src="images/avatar.jpg" alt="John said" class="img-circle"></span>
                                    <div class="media-body">
                                        <div class="pull-right media-xs text-center text-muted"> <strong class="h4">12:18</strong><br>
                                            <small class="label bg-light">pm</small> </div>
                                        <a href="#" class="h4">Bootstrap 3.0 is comming</a> <small class="block"><a href="#" class="">John Smith</a> <span class="label label-success">Circle</span></small> <small class="block m-t-sm">Sleek, intuitive, and powerful mobile-first front-end framework for faster and easier web development.</small> </div>
                                </article>
                                <div class="line pull-in"></div>
                                <article class="media"> <span class="pull-left thumb-sm"><i class="icon-user icon-2x text-muted"></i></span>
                                    <div class="media-body">
                                        <div class="pull-right media-xs text-center text-muted"> <strong class="h4">17</strong><br>
                                            <small class="label bg-light">feb</small> </div>
                                        <a href="#" class="h4">Bootstrap documents</a> <small class="block"><a href="#" class="">John Smith</a> <span class="label label-info">Friends</span></small> <small class="block m-t-sm">There are a few easy ways to quickly get started with Bootstrap, each one appealing to a different skill level and use case. Read through to see what suits your particular needs.</small> </div>
                                </article>
                                <div class="line pull-in"></div>
                                <article class="media">
                                    <div class="media-body">
                                        <div class="pull-right media-xs text-center text-muted"> <strong class="h4">09</strong><br>
                                            <small class="label bg-light">jan</small> </div>
                                        <a href="#" class="h4 text-success">Mobile first html/css framework</a> <small class="block m-t-sm">Bootstrap, Ratchet</small> </div>
                                </article>
                            </section>
                        </section>
                        </div>
                        <div class="col-lg-4">
					<section class="panel">
                            <header class="panel-heading">
                                <ul class="nav nav-pills pull-right">
                                    <li> <a href="#" class="panel-toggle text-muted active"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                                </ul>
                                <span class="label bg-dark">15</span> Inbox </header>
                            <section style="height:180px" class="panel-body scrollbar scroll-y m-b collapse">
                                <article class="media"> <span class="pull-left thumb-sm"><img src="images/avatar.jpg" alt="John said" class="img-circle"></span>
                                    <div class="media-body">
                                        <div class="pull-right media-xs text-center text-muted"> <strong class="h4">12:18</strong><br>
                                            <small class="label bg-light">pm</small> </div>
                                        <a href="#" class="h4">Bootstrap 3.0 is comming</a> <small class="block"><a href="#" class="">John Smith</a> <span class="label label-success">Circle</span></small> <small class="block m-t-sm">Sleek, intuitive, and powerful mobile-first front-end framework for faster and easier web development.</small> </div>
                                </article>
                                <div class="line pull-in"></div>
                                <article class="media"> <span class="pull-left thumb-sm"><i class="icon-user icon-2x text-muted"></i></span>
                                    <div class="media-body">
                                        <div class="pull-right media-xs text-center text-muted"> <strong class="h4">17</strong><br>
                                            <small class="label bg-light">feb</small> </div>
                                        <a href="#" class="h4">Bootstrap documents</a> <small class="block"><a href="#" class="">John Smith</a> <span class="label label-info">Friends</span></small> <small class="block m-t-sm">There are a few easy ways to quickly get started with Bootstrap, each one appealing to a different skill level and use case. Read through to see what suits your particular needs.</small> </div>
                                </article>
                                <div class="line pull-in"></div>
                                <article class="media">
                                    <div class="media-body">
                                        <div class="pull-right media-xs text-center text-muted"> <strong class="h4">09</strong><br>
                                            <small class="label bg-light">jan</small> </div>
                                        <a href="#" class="h4 text-success">Mobile first html/css framework</a> <small class="block m-t-sm">Bootstrap, Ratchet</small> </div>
                                </article>
                            </section>
                        </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
	</section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
