<!--start footer-->

<footer class="footer">
    <div class="container">
        <div class="row">
        	<?php $this->sidebar_bottom();?>
            <!--<div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>About Us</span></h4>
                </div>
                <div class="widget_content">
                    <p>Donec earum rerum hic tenetur ans sapiente delectus, ut aut reiciendise voluptat maiores alias consequaturs aut perferendis doloribus asperiores.</p>
                    <ul class="contact-details-alt">
                        <li><i class="fa fa-map-marker"></i>
                            <p><strong>Address</strong>: #2021 Lorem Ipsum</p>
                        </li>
                        <li><i class="fa fa-user"></i>
                            <p><strong>Phone</strong>:(+91) 9000-12345</p>
                        </li>
                        <li><i class="fa fa-envelope"></i>
                            <p><strong>Email</strong>: <a href="#">mail@example.com</a></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>Recent Posts</span></h4>
                </div>
                <div class="widget_content">
                    <ul class="links">
                        <li><i class="fa fa-caret-right"></i> <a href="#">Aenean commodo ligula eget dolor<span>November 07, 2014</span></a></li>
                        <li><i class="fa fa-caret-right"></i> <a href="#">Temporibus autem quibusdam <span>November 05, 2014</span></a></li>
                        <li><i class="fa fa-caret-right"></i> <a href="#">Debitis aut rerum saepe <span>November 03, 2014</span></a></li>
                        <li><i class="fa fa-caret-right"></i> <a href="#">Et voluptates repudiandae <span>November 02, 2014</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>Twitter</span></h4>
                </div>
                <div class="widget_content">
                    <ul class="tweet_list">
                        <li class="tweet_content item"> <i class="fa fa-twitter"></i>
                            <p class="tweet_link"><a href="#">@jquery_rain </a> Lorem ipsum dolor et, consectetur adipiscing eli</p>
                            <span class="time">29 September 2014</span> </li>
                        <li class="tweet_content item"> <i class="fa fa-twitter"></i>
                            <p class="tweet_link"><a href="#">@jquery_rain </a> Lorem ipsum dolor et, consectetur adipiscing eli</p>
                            <span class="time">29 September 2014</span> </li>
                        <li class="tweet_content item"> <i class="fa fa-twitter"></i>
                            <p class="tweet_link"><a href="#">@jquery_rain </a> Lorem ipsum dolor et, consectetur adipiscing eli</p>
                            <span class="time">29 September 2014</span> </li>
                    </ul>
                </div>
                <div class="widget_content">
                    <div class="tweet_go"></div>
              </div>
            <div class="col-sm-6 col-md-3 col-lg-3">
                <div class="widget_title">
                    <h4><span>Flickr Gallery</span></h4>
                </div>
                <div class="widget_content">
                    <div class="flickr">
                        <ul id="flickrFeed" class="flickr-feed">
                        </ul>
                    </div>
                </div>
            </div>-->
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