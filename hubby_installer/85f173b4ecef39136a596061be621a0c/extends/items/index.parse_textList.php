<?php
if(count($this->listText) > 0)
		{
		?>
<h1 class="home-block-heading"><?php echo $this->textListTitle;?></h1>
        <ul class="text-posts">
<?php
			foreach($this->listText as $t)
			{
?>
            <li>
                <a href="<?php echo $t['LINK'];?>" class="heading"><?php echo $t['TITLE'];?></a>
                <?php echo word_limiter($t['CONTENT'],200);?>
            </li>
		<?php
			}
			?>
        </ul>
            <?php
		}