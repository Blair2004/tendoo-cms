<aside class="aside nav-vertical bg-primary b-r" id="nav">
    <section class="vbox">
        <header class="nav-bar"> <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="body"> <i class="icon-reorder"></i> </a> <a href="#" class="nav-brand" data-toggle="fullscreen"></a> <a class="btn btn-link visible-xs" data-toggle="class:show" data-target=".nav-user"> <i class="icon-comment-alt"></i> </a> </header>
        <footer class="footer bg-gradient hidden-xs"> <a href="modal.lockme.html" data-toggle="ajaxModal" class="btn btn-sm btn-link m-r-n-xs pull-right"> <i class="icon-off"></i> </a> <a href="#nav" data-toggle="class:nav-vertical" class="btn btn-sm btn-link m-l-n-sm"> <i class="icon-reorder"></i> </a> </footer>
        <section>
            <nav class="nav-primary hidden-xs">
                <ul class="nav">
                    <li> <a href="<?php echo $this->core->url->site_url('account');?>"> <i class="icon-home"></i> <span>Profil</span> </a> </li>
                    <li> <a href="<?php echo $this->core->url->site_url('account/messaging');?>"> <b class="badge bg-danger pull-right">3</b> <i class="icon-envelope-alt"></i> <span>Messagerie</span> </a> </li>
                    <li> <a href="<?php echo $this->core->url->site_url('account/profile_update');?>"> <i class="icon-edit"></i> <span>Modifier</span> </a> </li>
                    <?php
					if($this->core->users_global->isAdmin())
					{
					?>
                    <li> <a href="<?php echo $this->core->url->site_url('admin');?>"> <i class="icon-dashboard"></i> <span>Admin.</span> </a> </li>
                    <?php
					}
					?>
                    <li> <a href="<?php echo $this->core->url->site_url('index');?>"> <i class="icon-signout"></i> <span>Retour</span> </a> </li>
                </ul>
            </nav>
        </section>
    </section>
</aside>