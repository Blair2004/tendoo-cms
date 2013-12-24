<?php

		$c	=&	$this->currentCartContent;
		if(count($c) == 0): return false;endif;
		?>
        <div class="basket">
            <div class="textbox basket-text float-r" style="padding-right:20px;width:200px;">
                <label><?php echo $c['TOTAL_ITEMS'];?> Produits</label>: <label class="hl-text">
                <?php
				if(is_numeric($c['TOTAL_PRICES']))
				{
					 echo $c['TOTAL_PRICES'].' '.$c['DEVISE'];
				};
				?></label>
                <a href="javascript:;" class="drop-arrow">&nbsp;</a>
            </div>
            <a href="javascript:;" class="button has-icon basket-button border float-r"><span>&nbsp;</span></a>
            <div class="clearfix"></div>
            <?php
            if(count($c['ITEM_LIST']))
            {
            ?>
            <ul class="basket-dropdown">
                <li class="dropdown-header overlay">
                    <span class="basket-arrow">&nbsp;</span>
                    <label class="item"><strong>Produit</strong></label>
                    <label class="price-each"><strong>Prix Unitaire</strong></label>
                    <label class="price"><strong>Prix total</strong></label>
                </li>
                <?php
				if(is_array($c['ITEM_LIST']))
				{
				foreach($c['ITEM_LIST'] as $i)
				{
				?>
                <li class="dropdown-line clearfix">
                    <div class="line-col media">
                        <img src="http://localhost/hub_ex/hubby_themes/d27449fc84378e9b444ed37254315173/img/basket-item-1.jpg" alt="">
                    </div>
                    <div class="line-col desc">
                        <strong><a href="details.html"><?php echo $i['TITLE'];?></a></strong><br>
                        Quantit&eacute; : <?php echo $i['QUANTITY'];?>
                    </div>
                    <div class="line-col price-each">
                        <?php echo $i['UNIQUE_PRICE'];?> <?php echo $c['DEVISE'];?>
                    </div>
                    
                    <div class="line-col price">
                        <?php echo $i['GLOBAL_PRICE'];?> <?php echo $c['DEVISE'];?>
                        <a href="<?php echo $i['REMOVE_LINK'];?>"><?php echo $i['REMOVE_TEXT'];?></a>
                    </div>
                </li>
                <?php
				}
				}
				?>
                <li class="dropdown-total">
                    <strong>Total</strong>: <span class="hl-text"><?php echo $c['TOTAL_PRICES'];?></span>
                </li>
                <li class="dropdown-footer clearfix">
                    <a href="<?php echo $c['CART_LINK'];?>" class="button dark shadow"><?php echo $c['CART_TEXT'];?></a>
                </li>
                
            </ul>
            <?php
            }
            ?>
        </div>
        <?php
	