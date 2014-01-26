<?php
		?>
        <div id="social-bar">
		<?php
        if($this->data['netWorking']['FACEBOOK_ACCOUNT'] != '' || $this->data['netWorking']['TWITTER_ACCOUNT'] != '' || $this->data['netWorking']['GOOGLEPLUS_ACCOUNT'] != '')
        {
            ?>
            <ul>
            <?php
            if($this->data['netWorking']['FACEBOOK_ACCOUNT'] != '')
            {
                ?>
                <li><a href="<?php echo $this->data['netWorking']['FACEBOOK_ACCOUNT'];?>"  title="Become a fan"><img src="<?php echo $this->core->url->main_url().THEMES_DIR.$this->themeEncrypted_dir.'/img/social/facebook_32.png';?>"  alt="Facebook" /></a></li>
            <?php
            }
            else if($this->data['netWorking']['TWITTER_ACCOUNT'] != '')
            {
                ?>
                <li><a href="<?php echo $this->data['netWorking']['TWITTER_ACCOUNT'];?>"  title="Become a fan"><img src="<?php echo $this->core->url->main_url().THEMES_DIR.$this->themeEncrypted_dir.'/img/social/twitter_32.png';?>"  alt="Twitter" /></a></li>
            <?php
            }
            else if($this->data['netWorking']['GOOGLEPLUS_ACCOUNT'] != '')
            {
                ?>
                <li><a href="<?php echo $this->data['netWorking']['GOOGLEPLUS_ACCOUNT'];?>"  title="Become a fan"><img src="<?php echo $this->core->url->main_url().THEMES_DIR.$this->themeEncrypted_dir.'/img/social/google_plus_32.png';?>"  alt="googleplus" /></a></li>
            <?php
            }
            ?>
            </ul>
            <?php
        }
        ?>
        </div>
        <?php
