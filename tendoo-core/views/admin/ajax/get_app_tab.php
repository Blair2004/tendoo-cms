 <div class="wrapper">
 <div class="icon icon-grid">
                  <?php
                if($appIconApi)
                {
                    foreach($appIconApi as $a)
                    {
                        eval( riake( 'admin_icons' , $options) );
                        if(isset($icons) && count($icons) > 1)
                        {
                            foreach($icons as $i)
                            {
                                if($i	==	$a['ICON_MODULE_NAMESPACE'].'/'.$a['ICON_NAMESPACE'])
                                {
									// .'?ajax=true' we're no more accessing ajax content, but directly app.
                        ?>
                        <div class="tendoo-icon-set" data-toggle="tooltip" data-placement="right" title="<?php echo $a['ICON_MODULE']['name'];?>" modal-title="<?php echo $a['ICON_MODULE']['name'];?>" data-url="<?php echo $this->instance->url->site_url(array('admin','open','modules',$a['ICON_MODULE']['namespace']));?>">
                        	
                          <img class="G-icon" src="<?php echo $this->instance->tendoo_admin->getAppImgIco($a['ICON_MODULE']['namespace']);?>">
                  			<p><?php echo word_limiter($a['ICON_MODULE']['name'],4);?></p>
                            <!--<span class="badge up bg-info m-l-n-sm">300</span>-->
                  		</div>
                  <?php
                                }
                            }
                        }
						else
						{
							echo tendoo_info( 'No icon is availble. You can enable it throught <a href="'.$this->instance->url->site_url(array('admin','setting')).'"><strong>settings</strong></a>.');
						}
                    }
                }
				else
				{
					echo tendoo_info( 'No icon is availble. You can enable it throught <a href="'.$this->instance->url->site_url(array('admin','setting')).'"><strong>settings</strong></a>.');
				}
                ?>
                </div>
              </div>