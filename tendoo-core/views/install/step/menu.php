<div class="wizard clearfix"> 
    <ul class="steps"> 
        <li data-target="#step1" <?php echo $step == 1 ? 'class="active"' : '' ;?>><span class="badge <?php echo $step == 1 ? 'badge-info' : '' ;?>">1</span><?php echo translate('Home');?></li> 
        <li data-target="#step2" <?php echo $step == 2 ? 'class="active"' : '' ;?>><span class="badge <?php echo $step == 2 ? 'badge-info' : '' ;?>">2</span><?php echo translate('Connecting to Database');?></li> 
        <li data-target="#step3" <?php echo $step == 3 ? 'class="active"' : '' ;?>><span class="badge <?php echo $step == 3 ? 'badge-info' : '' ;?>">3</span><?php echo translate('Options');?></li> 
        <li data-target="#step4" <?php echo $step == 4 ? 'class="active"' : '' ;?>><span class="badge <?php echo $step == 4 ? 'badge-info' : '' ;?>">4</span><?php echo translate('Finishing Installation');?></li> 
    </ul>
    <div class="actions"> 
        <a href="<?php echo $this->instance->url->main_url();?>"><img style="height:32px;vertical-align:middle;margin-top:-3px;" src="<?php echo $this->instance->url->img_url("logo_4.png");?>"> <?php echo get('core_version');?></a>
    </div> 
</div> 