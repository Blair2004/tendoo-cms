<div id="main">
    <!-- social -->
    <?php $this->socialBar();?>
    <!-- ENDS social -->
    <!-- Content -->
    <div id="content">
        <!-- slider -->
        <?php $this->parseCaroussel();?>
		<?php $this->parseProductListingCaroussel();?>
        <!-- ENDS slider -->
        <!-- Headline -->
		<?php $this->parseIndexAboutUs();?>
        <!-- ENDS Headline -->
        <!-- featured -->
        <?php $this->parseOnTopContent();?>
        <!-- ENDS featured -->
        <!-- Features Products -->
        <?php $this->parseFeaturedProducts();?>
        <?php $this->parseLastestElements();?>
        <!-- ENDS Features Products -->
        <?php $this->parseTabShowCase();?>
        <!-- text-posts -->
        <?php $this->parseTextList();?>
        <!-- ENDS text-posts -->
        <!-- home-gallery -->
        <?php $this->parseGalleryShowCase();?>
        <!-- ENDS home-gallery -->
    </div>
    <!-- ENDS content -->
    <div class="clearfix"></div>
    <div class="shadow-main"></div>
</div>
