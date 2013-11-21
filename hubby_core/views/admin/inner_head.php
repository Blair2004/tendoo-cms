		<header class="header bg-black navbar navbar-inverse">
            <div class="collapse navbar-collapse pull-in">
                <ul class="nav navbar-nav m-l-n">
                    <li class="active"><a href="<?php echo $this->core->url->site_url(array('admin'));?>">Administration</a></li>
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistiques <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Pages consult&eacute;s</a></li>
                            <li><a href="#">Module utilis&eacute;s</a></li>
                            <li><a href="#">Commentaires</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left m-t-sm" role="search">
                    <div class="form-group">
                        <div class="input-group input-s">
                            <input type="text" class="form-control input-sm no-border bg-dark" placeholder="Rechercher">
                            <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-success btn-icon"><i class="icon-search"></i></button>
                            </span> </div>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden-xs"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-bell-alt text-white"></i> <span class="badge up bg-info m-l-n-sm">2</span> </a>
                        <section class="dropdown-menu animated fadeInUp input-s-lg">
                            <section class="panel bg-white">
                                <header class="panel-heading"> <strong>You have <span class="count-n">2</span> notifications</strong> </header>
                                <div class="list-group"> <a href="#" class="media list-group-item"> <span class="pull-left thumb-sm"> <img src="" class="img-circle"> </span> <span class="media-body block m-b-none"> Use awesome animate.css<br>
                                    <small class="text-muted">28 Aug 13</small> </span> </a> <a href="#" class="media list-group-item"> <span class="media-body block m-b-none"> 1.0 initial released<br>
                                    <small class="text-muted">27 Aug 13</small> </span> </a> </div>
                                <footer class="panel-footer text-sm"> <a href="#" class="pull-right"><i class="icon-cog"></i></a> <a href="#">See all the notifications</a> </footer>
                            </section>
                        </section>
                    </li>
                    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left m-t-n-xs m-r-xs"> <img src="<?php echo $this->core->url->img_url('avatar_default.jpg');?>" alt="<?php echo ucwords($this->core->users_global->current('PSEUDO'));?>"> </span> <?php echo ucwords($this->core->users_global->current('PSEUDO'));?>, <?php echo $this->core->users_global->current('PRIVILEGE') == 'NADIMERPUS' ? 'Super administrateur' : 'Administrateur';?> <b class="caret"></b> </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li> <a href="<?php echo $this->core->url->site_url(array('account','profil_update'));?>">Param&ecirc;tres</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url(array('account'));?>">Profil</a> </li>
                            <?php
							$ttMessage	=	$this->core->users_global->countMessage();
							if($ttMessage == 0)
							{
							?>
                            <li> <a href="<?php echo $this->core->url->site_url(array('account','messaging','home'));?>"> Messagerie </a> </li>
                            <?php
							}
							else
							{
								?>
                            <li> <a href="<?php echo $this->core->url->site_url(array('account','messaging','home'));?>"> <span class="badge bg-danger pull-right"><?php echo $ttMessage;?></span> Messagerie </a> </li>
                            <?php
							}
							?>
                            <li> <a href="#">Aide</a> </li>
                            <li> <a href="<?php echo $this->core->url->site_url(array('logoff'));?>">Deconnexion</a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>