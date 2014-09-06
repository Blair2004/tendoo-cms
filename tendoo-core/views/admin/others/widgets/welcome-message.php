<div class="panel">
    <div class="panel-body">
        <h2 style="margin:0;"><?php echo translate( 'Welcome on tendoo' );?></h2>
        <hr class="line" />
        <p><?php echo translate( "We're glad to see you trust in our services. Let's us introduce a new version of tendoo, with more flexibility and excelling performance. With tutorials, you'll be able to create easilly a very professionnal website.") ;?>
		<h4><?php echo translate( "As start task, you can : " );?></h4>
		<ul>
			<li><a href="<?php echo get_instance()->url->site_url( array( 'admin' , 'open' , 'modules' , 'blogster' , 'publish' ) );?>"><?php echo translate( "Publish new blog post, to share something with the world." );?></a></li>
            <li><a href="<?php echo get_instance()->url->site_url( array( 'admin' , 'setting' ) );?>"><?php echo translate( "Editing your website setting. You can enable registration there." );?></a></li>
		</ul>
        <hr class="line" />
        <p><?php echo translate( "To remove this widget, get to settings and disable \"Welcome Widget\". You can either disable and enable every widget you want. Some widgets won't be visible due to user permission, as admin only you can allow widget access using permission management interface." );?></p>
    </div>
</div>
