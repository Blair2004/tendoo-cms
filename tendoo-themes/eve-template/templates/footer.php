<!--start footer-->

<footer class="footer">
    <div class="container">
        <div class="row">
        	<?php $this->sidebar_bottom();?>            
        </div>
    </div>
</footer>
<!--end footer-->
<section class="footer_bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ">
                <p class="copyright">&copy; Conçu pour <?php echo get('core_version');?> | Copyright 2014 Eve | Powered by <a href="http://www.jqueryrain.com/">jQuery Rain</a></p>
            </div>
            <div class="col-lg-6 ">
                <div class="footer_social">
                	<?php get_items( 'footer_social_feeds' );?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_items( 'google_analytic_javascript_footer' );?>