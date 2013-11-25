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
                        <form method="post">
                            <div class="col-lg-4">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <ul class="nav nav-pills pull-right">
                                            <li> <a href="#" class="panel-toggle text-muted active"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                                        </ul>
                                        <span class="icon-pushpin"></span> R&eacute;seaux sociaux </header>
                                        <section style="height:auto" class="panel-body scrollbar scroll-y m-b collapse">
                                            <article class="media"> <span class="pull-left icon-twitter thumb-sm" style="font-size:35px"></span>
                                                <div class="media-body"> <a href="#" class="h4">Twitter</a> <small class="block m-t-sm">Entrez une adresse twitter que vous aimerez sugg&eacute;rer &agrave; vos utilisateurs de suivre.</small> <br />
                                                    <div class="form-group">
                                                        <label class="label-control">
                                                            <input name="twitter" placeholder="Entrer l'adresse twitter" value="<?php echo $networking['TWITTER_ACCOUNT'];?>"type="text" class="form-control" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </article>
                                            <div class="line pull-in"></div>
                                            <input type="submit" class="btn btn-sm btn-white" value="Enregistrer les modifications" />
                                        </section>
                                </section>
                            </div>
                            <div class="col-lg-4">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <ul class="nav nav-pills pull-right">
                                            <li> <a href="#" class="panel-toggle text-muted active"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                                        </ul>
                                        <span class="icon-pushpin"></span> R&eacute;seaux sociaux </header>
                                        <section style="height:auto" class="panel-body scrollbar scroll-y m-b collapse">
                                            <article class="media"> <span class="pull-left icon-facebook thumb-sm" style="font-size:35px"></span>
                                                <div class="media-body"> <a href="#" class="h4">facebook</a> <small class="block m-t-sm">Entrez l'adresse d'une page que vous aimerez sugg&eacute;rer &agrave; vos utilisateurs</small> <br />
                                                    <div class="form-group">
                                                        <label class="label-control">
                                                            <input placeholder="Entrez le compte facebook" value="<?php echo $networking['FACEBOOK_ACCOUNT'];?>" name="facebook" type="text" class="form-control" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </article>
                                            <div class="line pull-in"></div>
                                            <input type="submit" class="btn btn-sm btn-white" value="Enregistrer les modifications" />
                                        </section>
                                </section>
                            </div>
                            <div class="col-lg-4">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <ul class="nav nav-pills pull-right">
                                            <li> <a href="#" class="panel-toggle text-muted active"><i class="icon-caret-down text-active"></i><i class="icon-caret-up text"></i></a> </li>
                                        </ul>
                                        <span class="icon-pushpin"></span> R&eacute;seaux sociaux </header>
                                        <section style="height:auto" class="panel-body scrollbar scroll-y m-b collapse">
                                            <article class="media"> <span class="pull-left icon-google-plus thumb-sm" style="font-size:35px"></span>
                                                <div class="media-body"> <a href="#" class="h4">Google+</a> <small class="block m-t-sm">Entrez l'adresse d'un cercle ou d'une page que vous aimerez sugg&eacute;rer &agrave; vos utilisateurs</small> <br />
                                                    <div class="form-group">
                                                        <label class="label-control">
                                                            <input placeholder="Entrez l'adresse du compte google plus" value="<?php echo $networking['GOOGLEPLUS_ACCOUNT'];?>" name="googleplus" type="text" class="form-control" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </article>
                                            <div class="line pull-in"></div>
                                            <input type="submit" class="btn btn-sm btn-white" value="Enregistrer les modifications" />
                                        </section>
                                </section>
                            </div>
                        </form>
                    </div>
                </section>
            </section>
        </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>
