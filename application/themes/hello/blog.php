<?php global $Options;?>
<?php $theme_uri    =    base_url() . 'public/themes/hello/';?>
<?php
// Blog
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo $theme_uri;?>css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="<?php echo $theme_uri;?>css/style.css"> <!-- Resource style -->
    <script src="<?php echo $theme_uri;?>js/modernizr.js"></script> <!-- Modernizr -->
    <title><?php echo xss_clean($Options[ 'site_name' ]);?></title>
</head>

<body>
	<header>
		<h1><?php echo xss_clean($Options[ 'site_name' ]);?> - Blog</h1>
	</header>
    <section id="cd-timeline" class="cd-container">
    	<?php
        $Posts        =    get_instance()->blog->get();
        if (count($Posts) > 0) {
            foreach ($Posts as $post) {
                ?>
		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-picture">
				<img src="<?php echo $theme_uri;
                ?>img/cd-icon-picture.svg" alt="Picture">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content">
				<h2><?php echo xss_clean($post[ 'TITLE' ]);
                ?></h2>
				<p><?php echo word_limiter(xss_clean($post[ 'CONTENT' ]), 30);
                ?></p>
				<a href="<?php echo site_url(array( 'blog', $post[ 'POST_SLUG' ] ));
                ?>" class="cd-read-more"><?php _e('Read More', 'hello');
                ?></a>
				<!-- <span class="cd-date">Jan 14</span> -->
			</div> <!-- cd-timeline-content -->
		</div> <!-- cd-timeline-block -->
        	<?php 
            }
            ?>
        <?php 
        } else {
            ?>
        <div class="cd-timeline-block">
			<div class="cd-timeline-img cd-picture">
				<img src="<?php echo $theme_uri;
            ?>img/cd-icon-picture.svg" alt="Picture">
			</div> <!-- cd-timeline-img -->

			<div class="cd-timeline-content">
				<h2><?php echo __('No Posts', 'hello');
            ?></h2>
				<p><?php echo sprintf(
                    __('No posts yet. Get to dashboard and <a href="%s">start writing</a>', 'hello'),
                    site_url(array( 'dashboard', 'posttype', 'blog', 'new' ))
                );
            ?></p>
				<a href="<?php echo site_url(array( 'dashboard', 'posttype', 'blog', 'new' ));
            ?>" class="cd-read-more"><?php _e('Start Writing', 'hello');
            ?></a>
				<!-- <span class="cd-date">Jan 14</span> -->
			</div> <!-- cd-timeline-content -->
		</div>
		<?php 
        }?>
        <a href="<?php echo site_url(array( 'dashboard' ));?>" style="padding:8px 10px;background:#333;border-radius:10px;"><?php _e('Get To dashboard');?></a>
        <a href="<?php echo site_url();?>" style="padding:8px 10px;background:#333;border-radius:10px;"><?php _e('Get To Home');?></a>
	</section>
</body>
</html>
